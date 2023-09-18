<?php

namespace App\Http\Controllers;

use App\Models\PlanRemont;
use App\Models\TypeTechnicalInspection;
use App\Models\Equipment;
use App\Models\Application;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /*
            dannie dlya modali
        */
        // $zaplanirovannie = Equipment::whereHas('details', function($q) {
        //     $q->whereBetween('planned', [date('Y-m-d', strtotime(date('Y').'-01')), date('Y-m-d', strtotime(date('Y').'-12-31'))]);
        //     })
        //     ->with(['details' => function ($q) {
        //         $q->whereBetween('planned', [date('Y-m-d', strtotime(date('Y').'-01')), date('Y-m-d', strtotime(date('Y').'-12-31'))]);
        //     }])
        //     ->get();
        // $provedennie = Equipment::whereHas('details', function($q) {
        //     $q->whereHas('technical_inspections', function ($qi) {
        //         $qi->whereBetween('now', [date('Y-m-d', strtotime(date('Y').'-01')), date('Y-m-d', strtotime(date('Y').'-12-31'))]);
        //     });
        //     })
        //     ->with(['details' => function ($q) {
        //         $q->whereHas('technical_inspections', function ($qi) {
        //             $qi->whereBetween('now', [date('Y-m-d', strtotime(date('Y').'-01')), date('Y-m-d', strtotime(date('Y').'-12-31'))]);
        //         });
        //     }])
        //     ->get();


        // $type_technical_inspections = TypeTechnicalInspection::all();
        // $result_plan = [];
        // $result_fact = [];
        // foreach($type_technical_inspections as $key => $item) {
        //     $result_plan[$key] = Equipment::whereHas('details', function ($q) use ($key, $item) {
        //         $q->where('type_technical_inspection_id', $item->id)
        //             ->whereBetween('planned', [date('Y-m-d', strtotime(date('Y').'-01')), date('Y-m-d', strtotime(date('Y').'-12-31'))]);
        //     })
        //     ->count();

        //     $result_fact[$key] = Equipment::whereHas('details', function ($q) use ($key, $item) {
        //         $q->where('type_technical_inspection_id', $item->id)
        //             ->whereHas('technical_inspections', function ($qi) {
        //                 $qi->whereBetween('now', [date('Y-m-d', strtotime(date('Y').'-01')), date('Y-m-d', strtotime(date('Y').'-12-31'))]);
        //             });
        //     })
        //     ->count();
        // }


        // return view('home', [
        //     'result_plan' => $result_plan,
        //     'result_fact' => $result_fact,

        //     'zaplanirovannie' => $zaplanirovannie,
        //     'provedennie' => $provedennie,
        // ]);

        $remonts = PlanRemont::whereBetween('remont_begin', [date('Y-m-').'01', date('Y-m-').date( 't', time())])
            ->get();

        return view('home', [
            'remonts' => $remonts,
            'applications' => json_encode($this->applications())
        ]);
    }

    public function chart()
    {
        $type_technical_inspections = TypeTechnicalInspection::all();
        $result_plan = [];
        $result_fact = [];
        foreach($type_technical_inspections as $key => $item) {
            $result_plan[$key] = Equipment::whereHas('details', function ($q) use ($key, $item) {
                $q->where('type_technical_inspection_id', $item->id)
                    ->whereBetween('planned', [date('Y-m-d', strtotime($_GET['start'])), date('Y-m', strtotime($_GET['end'])).'-'.date('t', strtotime($_GET['end']))]);
            })->count();

            $result_fact[$key] = Equipment::whereHas('details', function ($q) use ($key, $item) {
                $q->where('type_technical_inspection_id', $item->id)
                    ->whereHas('technical_inspections', function ($qi) {
                        $qi->whereBetween('now', [date('Y-m-d', strtotime($_GET['start'])), date('Y-m', strtotime($_GET['end'])).'-'.date('t', strtotime($_GET['end']))]);
                    });
            })
            ->count();
        }


        /*
            dannie dlya modali
        */
        $zaplanirovannie = Equipment::whereHas('details', function($q) {
            $q->whereBetween('planned', [date('Y-m-d', strtotime($_GET['start'])), date('Y-m', strtotime($_GET['end'])).'-'.date('t', strtotime($_GET['end']))]);
            })
            ->with(['details' => function ($q) {
                $q->whereBetween('planned', [date('Y-m-d', strtotime($_GET['start'])), date('Y-m', strtotime($_GET['end'])).'-'.date('t', strtotime($_GET['end']))]);
            }, 'details.technical_inspections'])
            ->get();
        $provedennie = Equipment::whereHas('details', function($q) {
            $q->whereHas('technical_inspections', function ($qi) {
                $qi->whereBetween('now', [date('Y-m-d', strtotime($_GET['start'])), date('Y-m', strtotime($_GET['end'])).'-'.date('t', strtotime($_GET['end']))]);
            });
            })
            ->with(['details' => function ($q) {
                $q->whereHas('technical_inspections', function ($qi) {
                    $qi->whereBetween('now', [date('Y-m-d', strtotime($_GET['start'])), date('Y-m', strtotime($_GET['end'])).'-'.date('t', strtotime($_GET['end']))]);
                });
            }, 'details.technical_inspections'])
            ->get();


        return response([
            'result_plan' => $result_plan,
            'result_fact' => $result_fact,

            'zaplanirovannie' => $zaplanirovannie,
            'provedennie' => $provedennie,
        ]);
    }


    // calendar functions
    public function get_days(Request $request)
    {
        $date_arr = explode("-", $request->date);
        $year = $date_arr[0];
        $month = intval($date_arr[1]) + 1;

        $month_days = [];
        for($i=1; $i<32; $i++) {
            $month_days[] = $i;
        }
        $days = [];
        foreach($month_days as $day) {
            $item = PlanRemont::where('remont_begin', $year . '-' . $month . '-' . $day) // [date('Y-m-').'01', date('Y-m-').date( 't', time())]
                ->exists();

            if($item) {
                $days[] = $day;
            }
        }

        return response($days);
    }

    public function calendar(Request $request)
    {
        $month = [
            'ЯНВАРЬ' => 1,
            'ФЕВРАЛЬ' => 2,
            'МАРТ' => 3,
            'АПРЕЛЬ' => 4,
            'МАЙ' => 5,
            'ИЮНЬ' => 6,
            'ИЮЛЬ' => 7,
            'АВГУСТ' => 8,
            'СЕНТЯБРЬ' => 9,
            'ОКТЯБРЬ' => 10,
            'НОЯБРЬ' => 11,
            'ДЕКАБРЬ' => 12
        ];

        $date_arr = explode(" ", $request->date);
        $year = $date_arr[3];
        $month = $month[$date_arr[2]];
        $day = $date_arr[0];

        $equipments = Equipment::latest()
            ->get();
        $res = [];
        foreach($equipments as $equipment) {
            $item = $equipment->where('id', $equipment->id)
                ->whereHas('planRemonts', function($q) use ($year, $month, $day) {
                    $q->where('remont_begin', $year . '-' . $month . '-' . $day);
                })
                ->with(['planRemonts' => function ($q) use ($year, $month, $day) {
                    $q->where('remont_begin', $year . '-' . $month . '-' . $day);
                }, 'planRemonts.applications', 'planRemonts.remontType', 'planRemonts.applications.orderResource', 'planRemonts.applications.technicalResource', 'typeEquipment', 'department'])
                ->first();

            if($item) $res[] = $item;
        }

        return response([
            'res' => $res
        ]);
    }

    public function applications(): array
    {
        $applications = [];

        // $applications_from_db = Application::latest()
        //     ->with('orderResource')
        //     ->get();

        foreach ([2,3,4,5,6,7] as $key => $value) {
            $applications[] = Application::whereHas('orderResource', function($q) use ($value) {
                $q->where('execution_statuse_id', $value);
            })
            ->count();
        }

        return $applications;
    }
}
