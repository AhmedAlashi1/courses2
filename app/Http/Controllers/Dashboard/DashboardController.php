<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
//use App\Models\SideMenu;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
//
//    function __construct()
//    {
//        $this->middleware('permission:display dashboard', ['only' => ['index']]);
//    }
    //
    public function index(){
        $lastWeek = $this->getLastWeekLabels();
        $datasets = $this->generateDatasets($lastWeek);
//        return $datasets;

        $chartOptions = [
            'responsive' => true,
            'legend' => [
                'display' => true,
                'labels' => [
                    'fontColor' => '#333',
                    'fontSize' => 14,
                ],
            ],
            'scales' => [
                'xAxes' => [[
                    'ticks' => [
                        'fontColor' => '#333',
                    ],
                ]],
                'yAxes' => [[
                    'ticks' => [
                        'beginAtZero' => true,
                        'fontColor' => '#333',
                    ],
                ]],
            ],
            'animation' => [
                'duration' => 2500,
            ],
            'elements' => [
                'line' => [
                    'borderWidth' => 2, // Adjust the thickness of the lines
                ],
                'point' => [
                    'radius' => 4, // Adjust the size of the data points
                    'hoverRadius' => 6,
                ],
            ],
            'cubicInterpolationMode' => 'default', // Use 'default' or 'monotone'
        ];


        $lineChart = $this->createChart('lineChart', 'line', $lastWeek, $datasets, $chartOptions);
//        return $lineChart;

//        $menu = SideMenu::where('side_id',null)->with('side')->get();
//        $sequences =SideMenu::where('side_id', null)->lazy();

        return view('dashboard.dashboard',compact( 'lineChart'));
    }

    private function createChart($name, $type, $labels, $datasets, $options)
    {
        return app()->chartjs
            ->name($name)
            ->type($type)
            ->size(['width' => 800, 'height' => 400])
            ->labels($labels)
            ->datasets($datasets)
            ->options($options);
    }

    private function getLastWeekLabels()
    {
        $lastWeek = collect([]);
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i);
            $lastWeek->push($day->format('l'));
            $labels[] = $day->format('F j');
        }

        return $labels;
    }

    private function generateDatasets($labels)
    {
        $datasets = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i);
            $startDate = $day->copy()->startOfDay();
            $endDate = $day->copy()->endOfDay();

            $usersCount = DB::table('watching_video_user')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $usersDataset[] = $usersCount;
//
//            $ordersCount =DB::table('users')
//                ->whereBetween('created_at', [$startDate, $endDate])
//                ->count();
//
//            $ordersDataset[] = $ordersCount;
        }

        $datasets[] = [
            "label" => __('Watching Video User'),
            'backgroundColor' => "#0162e8",
            'borderColor' => "#0162e8",
            "pointBorderColor" => "#0162e8",
            "pointBackgroundColor" => "#fff",
            "pointHoverBackgroundColor" => "#fff",
            "pointHoverBorderColor" => "#0162e8",
            'data' => $usersDataset,
            'fill'=> false,
            'tension'=> 0.3
        ];

//        $datasets[] = [
//            "label" => __('messages.Orders'),
//            'backgroundColor' => "#f95374",
//            'borderColor' => "#f95374",
//            "pointBorderColor" => "#f95374",
//            "pointBackgroundColor" => "#fff",
//            "pointHoverBackgroundColor" => "#fff",
//            "pointHoverBorderColor" => "#f95374",
//            'data' => $ordersDataset,
//            'fill'=> false,
//            'tension'=> 0.3
//        ];

        return $datasets;
    }

}
