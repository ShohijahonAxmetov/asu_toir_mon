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
            'applications' => json_encode($this->applications()),
            'badRemonts' => $this->getBadRemonts()
        ]);
    }

    // public function chart()
    // {
    //     $type_technical_inspections = TypeTechnicalInspection::all();
    //     $result_plan = [];
    //     $result_fact = [];
    //     foreach($type_technical_inspections as $key => $item) {
    //         $result_plan[$key] = Equipment::whereHas('details', function ($q) use ($key, $item) {
    //             $q->where('type_technical_inspection_id', $item->id)
    //                 ->whereBetween('planned', [date('Y-m-d', strtotime($_GET['start'])), date('Y-m', strtotime($_GET['end'])).'-'.date('t', strtotime($_GET['end']))]);
    //         })->count();

    //         $result_fact[$key] = Equipment::whereHas('details', function ($q) use ($key, $item) {
    //             $q->where('type_technical_inspection_id', $item->id)
    //                 ->whereHas('technical_inspections', function ($qi) {
    //                     $qi->whereBetween('now', [date('Y-m-d', strtotime($_GET['start'])), date('Y-m', strtotime($_GET['end'])).'-'.date('t', strtotime($_GET['end']))]);
    //                 });
    //         })
    //         ->count();
    //     }


    //     /*
    //         dannie dlya modali
    //     */
    //     $zaplanirovannie = Equipment::whereHas('details', function($q) {
    //         $q->whereBetween('planned', [date('Y-m-d', strtotime($_GET['start'])), date('Y-m', strtotime($_GET['end'])).'-'.date('t', strtotime($_GET['end']))]);
    //         })
    //         ->with(['details' => function ($q) {
    //             $q->whereBetween('planned', [date('Y-m-d', strtotime($_GET['start'])), date('Y-m', strtotime($_GET['end'])).'-'.date('t', strtotime($_GET['end']))]);
    //         }, 'details.technical_inspections'])
    //         ->get();
    //     $provedennie = Equipment::whereHas('details', function($q) {
    //         $q->whereHas('technical_inspections', function ($qi) {
    //             $qi->whereBetween('now', [date('Y-m-d', strtotime($_GET['start'])), date('Y-m', strtotime($_GET['end'])).'-'.date('t', strtotime($_GET['end']))]);
    //         });
    //         })
    //         ->with(['details' => function ($q) {
    //             $q->whereHas('technical_inspections', function ($qi) {
    //                 $qi->whereBetween('now', [date('Y-m-d', strtotime($_GET['start'])), date('Y-m', strtotime($_GET['end'])).'-'.date('t', strtotime($_GET['end']))]);
    //             });
    //         }, 'details.technical_inspections'])
    //         ->get();


    //     return response([
    //         'result_plan' => $result_plan,
    //         'result_fact' => $result_fact,

    //         'zaplanirovannie' => $zaplanirovannie,
    //         'provedennie' => $provedennie,
    //     ]);
    // }


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
                }, 'planRemonts.applications', 'planRemonts.applications.orderResource.executionStatuse', 'planRemonts.remontType', 'planRemonts.applications.orderResource', 'planRemonts.applications.technicalResource', 'typeEquipment', 'department'])
                ->first();

            if($item) {
                $applications = $item->planRemonts[0]->applications;
                $doned_count = 0;
                foreach ($applications as $key => $value) {
                    if(!is_null($value->orderResource) && $value->orderResource->execution_statuse_id == 7) $doned_count ++;
                }

                $item->percent = (round($doned_count/count($item->planRemonts[0]->applications)*100, 2)).'% ('.$doned_count.'/'.count($item->planRemonts[0]->applications).')';
            }

            if($item) $res[] = $item;
        }

        return response([
            'res' => $res
        ]);
    }

    public function applications(): array
    {
        $applications = [];
        $applications[0] = Application::whereDoesntHave('orderResource')
            ->count();

        foreach ([2,3,4,5,6,7,8] as $key => $value) {
            $applications[] = Application::whereHas('orderResource', function($q) use ($value) {
                $q->where('execution_statuse_id', $value);
            })
            ->count();
        }

        return $applications;
    }

    public function getBadRemonts(): \Illuminate\Database\Eloquent\Collection
    {
        $remonts = PlanRemont::where('remont_begin', '>', date('Y-m-d'))
            ->has('applications', '>', 5)
            ->whereHas('applications', function($q) {
                $q->where(function($qi) {
                    $qi->whereHas('orderResource', function($qi2) {
                        $qi2->where('execution_statuse_id', '!=', 8);
                    })->orWhereDoesntHave('orderResource');
                });
            })
            ->with('applications', 'applications.technicalResource')
            ->get();

        foreach ($remonts as $key => $remont) {
            // $prosrocheno_dney = 0;
            // chislo ispolnennix zakazov
            $doned_count = 0;
            foreach ($remont->applications as $key => $application) {
                // vremya vipolneniya v dnyax
                $vremya_vipolneniya = $application->technicalResource->time_complete_order + $application->technicalResource->delivery_time;
                $data_vipolneniya = date('Y-m-d', strtotime($application->application_date. ' + '.$vremya_vipolneniya.' days'));
                // $prosrocheno_dney = ((strtotime(date('Y-m-d')) - strtotime(date('Y-m-d', strtotime($data_vipolneniya)))) / 86400) > $prosrocheno_dney ? ((strtotime(date('Y-m-d')) - strtotime(date('Y-m-d', strtotime($data_vipolneniya)))) / 86400) : $prosrocheno_dney;

                // chislo ispolnennix zakazov
                if(!is_null($application->orderResource) && $application->orderResource->execution_statuse_id == 8) $doned_count ++;
            }
            // $remont->prosrocheno_dney = $prosrocheno_dney == 0 ? '--' : $prosrocheno_dney;

            // procent ispolnennix zakazov
            $percent = $doned_count/count($remont->applications)*100;
            $remont->percent = $percent.'% ('.$doned_count.'/'.count($remont->applications).')';

            // data posledney zayavki
            $remont->latest_application_date = $remont->applications[count($remont->applications)-1]->application_date ?? '--';
        }

        $remonts = $remonts->sortBy('percent')
            ->take(5);

        return $remonts;
    }
}
