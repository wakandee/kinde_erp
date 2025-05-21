<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\Auth;
use App\Helpers\SessionHelper;
use App\Models\ActivityTask;

class HomeController extends Controller
{
    public function __construct()
    {
        Auth::handle();      // ensure user is authenticated
        parent::__construct();
    }

    public function index()
    {
        $userId = SessionHelper::get('user_id');

        // // 1) Read dashboard filters from GET or scoped session
        // $interval    = $_GET['dashboard_interval']
        //              ?? SessionHelper::get('dashboard_interval')
        //              ?? 'weekly';
        // $pickerValue = $_GET['dashboard_picker']
        //              ?? SessionHelper::get('dashboard_picker')
        //              ?? date('o') . '-W' . date('W');

        // // Persist filters in session
        // SessionHelper::set('dashboard_interval', $interval);
        // SessionHelper::set('dashboard_picker',   $pickerValue);

        
        // 1) Read dashboard filters from GET or scoped session
        // 1) Read dashboard interval from GET or session (fallback to 'weekly')
        $interval = $_GET['dashboard_interval']
                 ?? SessionHelper::get('dashboard_interval')
                 ?? 'weekly';

        // Define session key for the picker based on the interval
        $pickerSessionKey = 'dashboard_picker_' . $interval;

        // Determine picker value from GET, specific session key, or default
        if (isset($_GET['dashboard_picker'])) {
            $pickerValue = $_GET['dashboard_picker'];
        } elseif (SessionHelper::get($pickerSessionKey)) {
            $pickerValue = SessionHelper::get($pickerSessionKey);
        } else {
            // Fallback to current value based on interval
            switch ($interval) {
                case 'daily':
                    $pickerValue = date('Y-m-d');
                    break;

                case 'monthly':
                    $pickerValue = date('Y-m');
                    break;

                default: // weekly
                    $pickerValue = date('o') . '-W' . date('W');
            }
        }

        // Persist interval and interval-specific picker in session
        SessionHelper::set('dashboard_interval', $interval);
        SessionHelper::set($pickerSessionKey, $pickerValue);




            // 2) Compute date range// Persist filters in session

            // var_dump($interval);

            // 2) Compute date range
            switch ($interval) {
                case 'daily':
                    $start = $end = $pickerValue;
                    break;

                case 'monthly':
                    list($y, $m) = explode('-', $pickerValue);
                    $start = sprintf('%04d-%02d-01', $y, $m);
                    $end   = (new \DateTime($start))
                             ->modify('last day of this month')
                             ->format('Y-m-d');
                    break;

                default: // weekly
                // var_dump($pickerValue);
                    list($y, $w) = explode('-W', $pickerValue);
                    $dt = new \DateTime();
                    $dt->setISODate((int)$y, (int)$w);
                    $start = $dt->format('Y-m-d');
                    $end   = $dt->modify('+6 days')->format('Y-m-d');
            }


        // 3) Summary metrics
        $totalTasks     = ActivityTask::countByUserAndDateRange(
                              $userId, $start, $end
                          );
        $statusCounts   = ActivityTask::countByStatusAndDateRange(
                              $userId, $start, $end
                          );
        $overdueTasks   = ActivityTask::countOverdueInRange(
                              $userId, $start, $end
                          );

        $doneCount      = $statusCounts['Done'] ?? 0;
        $completionRate = $totalTasks
                        ? round(($doneCount / $totalTasks) * 100)
                        : 0;

        // 4) Build chart labels
        if ($interval === 'monthly') {
            $daysInMonth = (int)(new \DateTime($start))->format('t');
            $labels = range(1, $daysInMonth);
        } else {
            $labels = [];
            $dt = new \DateTime($start);
            $endDt = new \DateTime($end);
            while ($dt <= $endDt) {
                $labels[] = $interval === 'weekly'
                          ? $dt->format('D')
                          : $dt->format('Y-m-d');
                $dt->modify('+1 day');
            }
        }

        // 5) Status series data
        $statuses = ['Not Started','In Progress','Done','Postponed','Cancelled'];
        $statusSeries = [];
        foreach ($statuses as $st) {
            $statusSeries[$st] = array_fill(0, count($labels), 0);
        }

        $raw = ActivityTask::getByUserAndDateRangeRaw(
                   $userId, $start, $end
               );
        foreach ($raw as $r) {
            $key = $interval === 'weekly'
                 ? (new \DateTime($r->activity_date))->format('D')
                 : $r->activity_date;
            $idx = array_search($key, $labels, true);
            if ($idx !== false && isset($statusSeries[$r->status])) {
                $statusSeries[$r->status][$idx]++;
            }
        }

        // 6) Pie chart data
        $completedTasks = $doneCount;
        $pendingTasks   = $totalTasks - $doneCount;

        // 7) Overdue trend data
        $overdueCounts = [];
        foreach ($labels as $i => $lab) {
            $date = $interval === 'monthly'
                  ? (new \DateTime($start))->modify("+{$i} days")->format('Y-m-d')
                  : ($interval === 'weekly' ?
                        (new \DateTime($start))->modify("+{$i} days")->format('Y-m-d')
                        : $lab);
            $overdueCounts[] = ActivityTask::countOverdueByDate(
                                   $userId,
                                   $date
                               );
        }

        $overdueLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $overdueLabels[] = (new \DateTime())->modify("-{$i} days")->format('D');
        }

        // 8) Render view
        $this->view('home', [
            'dashboard_interval' => $interval,
            'dashboard_picker'   => $pickerValue,
            'startDate'          => $start,
            'endDate'            => $end,
            'totalTasks'         => $totalTasks,
            'statusCounts'       => $statusCounts,
            'overdueTasks'       => $overdueTasks,
            'completionRate'     => $completionRate,
            'weeklyLabels'       => $labels,
            'weeklyStatusData'   => $statusSeries,
            'completedTasks'     => $completedTasks,
            'pendingTasks'       => $pendingTasks,
            'overdueLabels'     => $overdueLabels,
            'overdueCounts'      => $overdueCounts,
        ]);
    }
}
