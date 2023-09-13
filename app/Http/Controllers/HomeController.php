<?php

namespace App\Http\Controllers;

use App\Models\TypeTechnicalInspection;
use App\Models\Equipment;
use App\Models\Detail;
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

        return view('home');
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

    public function get_days(Request $request)
    {
        $data = $request->all();

        $date_arr = explode("-", $request->date);
        $year = $date_arr[0];
        $month = intval($date_arr[1]) + 1;

        $month_days = [];
        for($i=1; $i<32; $i++) {
            $month_days[] = $i;
        }
        $days = [];
        foreach($month_days as $day) {
            $item = Detail::where(function($q) use ($year, $month, $day) {
                    $q->where('planned', $year . '-' . $month . '-' . $day);
                })
                ->exists();
            if($item) {
                $days[] = $day;
                continue;
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

        $data = $request->all();

        $date_arr = explode(" ", $request->date);
        $year = $date_arr[3];
        $month = $month[$date_arr[2]];
        $day = $date_arr[0];

        $equipments = Equipment::latest()
            ->get();
        $res = [];
        foreach($equipments as $equipment) {
            $res1 = $equipment->where('id', $equipment->id)
                ->whereHas('details', function($q) use ($year, $month, $day) {
                    $q->where('planned', $year . '-' . $month . '-' . $day);
                })
                ->with(['details' => function ($q) use ($year, $month, $day) {
                    $q->where('planned', $year . '-' . $month . '-' . $day);
                }, 'details.technical_inspections'])
                ->first();

            if($res1) $res[] = $res1;
        }

        return response([
            'res' => $res
        ]);
    }
}
