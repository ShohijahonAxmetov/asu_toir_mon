@extends('layouts.app')

@section('links')

<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'>
<link rel="stylesheet" href="/assets/css/home.css">

@endsection

@section('content')

<div class="header mb-0">
    <div class="container-fluid">
        <!-- Body -->
        <div class="header-body border-0">
            <div class="row align-items-end">
                <div class="col">

                    <!-- Title -->
                    <h1 class="header-title">
                        Анализ
                    </h1>

                </div>
                <div class="col-auto">
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .header-body -->
    </div>
</div> <!-- / .header -->

<!-- <div class="container-fluid" id="for_graph"></div> -->

<div class="container-fluid">

    <div class="row">
        <div class="col-12 col-xl-12">
            <!-- Convertions -->
            <div class="card">
                <div class="card-header">
                    <!-- Title -->
                    <h4 class="card-header-title"> Среднее время выполнения ремонтов по техкартам </h4>
                </div>
                <div class="card-body">
                    <!-- Chart -->
                    <div class="chart">
                        <canvas id="tech_maps_bar" class="chart-canvas mw-100 mh-100"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-12 col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-header-title"> Traffic Channels </h4>
                    <ul class="nav nav-tabs nav-tabs-sm card-header-tabs">
                        <li class="nav-item" data-toggle="chart" data-target="#trafficChart" data-trigger="click" data-action="toggle" data-dataset="0">
                            <a href="#" class="nav-link active" data-bs-toggle="tab"> All </a>
                        </li>
                        <li class="nav-item" data-toggle="chart" data-target="#trafficChart" data-trigger="click" data-action="toggle" data-dataset="1">
                            <a href="#" class="nav-link" data-bs-toggle="tab"> Direct </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="chart chart-appended">
                        <canvas id="trafficChart" class="chart-canvas" data-toggle="legend" data-target="#trafficChartLegend"></canvas>
                    </div>
                    <div id="trafficChartLegend" class="chart-legend"></div>
                </div>
            </div>
        </div> -->
    </div>
    <!-- / .row -->

    <div class="row">
        <div class="col-12 col-xl-12">
            <!-- Convertions -->
            <div class="card">
                <div class="card-header">
                    <!-- Title -->
                    <h4 class="card-header-title"> Затраты на ремонты по техкартам </h4>
                </div>
                <div class="card-body">
                    <!-- Chart -->
                    <div class="chart">
                        <canvas id="tech_maps_bar_for_amount" class="chart-canvas mw-100 mh-100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / .row -->

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">

                    <!-- Title -->
                    <h4 class="card-header-title">
                        Технологические карты
                    </h4>

                </div>
                <div class="card-body">
                    <table class="table" style="table-layout: fixed;">
                      <thead>
                        <tr>
                          <th>#</th>
                            <th>Наименование</th>
                            <th>Код</th>
                            <th>Продолжительность</th>
                            <th>Среднее время выполнения ремонтов</th>
                            <th>Плановые затраты, тыс. сум</th>
                            <th>Фактические затраты, тыс. сум</th>
                            <th>Использован</th>
                            <th>Дата согласования</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($tech_maps as $item)
                        <tr>
                          <th scope="row">{{($item->agreed_at ? '✅' : '🔄').' '.$loop->iteration}}</th>
                            <td>
                                <div class="d-flex align-items-center">
                                    {{ $item->title.' ('.$item->techMapGroup->title.')' }}
                                </div>
                            </td>
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->hours.' ч '.$item->minutes.' мин' }}</td>
                            <td>{{ floor($item->avg_time_in_minutes).' ч '.round(($item->avg_time_in_minutes - floor($item->avg_time_in_minutes))*60).' м' }}</td>
                            <td>{{ $item->amount/1000 }}</td>
                            <td>{{ round($item->avg_amount/1000) }}</td>
                            <td>{{ $item->used }}</td>
                            <td>{{ $item->agreed_at ? date('d-m-Y', strtotime($item->agreed_at)) : '-' }}</td>
                            <td>
                              <a href="{{ route('analysis.show', ['tech_map' => $item->id]) }}" class="btn btn-sm btn-info"><i class="fe fe-eye"></i></a>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- calendar -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" id="draggable__calendar_modal">
            <div class="modal-header" id="draggable__calendar_modalheader">
                <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body position-relative" id="modal_tbody">
                <!-- table -->
            </div>
            <div class="modal-loader position-absolute d-flex align-items-center justify-content-center w-100 h-100">
                <div class="lds-ring">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
<!-- calendar end -->

@endsection

@section('scripts')
<!-- calendar scripts -->
<script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script>
    const ctx = document.getElementById('tech_maps_bar');

    new Chart(ctx, {
        plugins: [ChartDataLabels],
        type: 'bar',
        options: {
            scales: {
                y: {
                    ticks: {
                        callback: function(e) {
                            return e + " ч."
                        }
                    }
                }
            },
            plugins: {
                // Change options for ALL labels of THIS CHART
                datalabels: {
                    color: 'white'
                }
            }
        },
        data: {
            labels: [@foreach($tech_map_data_for_bar as $item) "{{$item}}", @endforeach],
            datasets: [{
                label: "Норматив, ч.",
                data: {{json_encode($tech_maps->pluck('normativeInHours')->toArray())}},
                backgroundColor: "#0de68b",
            }, {
                label: "Ср. продолж., ч.",
                data: {{json_encode($tech_maps->map(function ($techMap) { $techMap->avg_time_in_minutes = round($techMap->avg_time_in_minutes, 1); return $techMap;})->pluck('avg_time_in_minutes')->toArray())}},
                backgroundColor: "#0d86b5",
            }]
        }
    });


    const ctxAmount = document.getElementById('tech_maps_bar_for_amount');

    new Chart(ctxAmount, {
        plugins: [ChartDataLabels],
        type: 'bar',
        options: {
            scales: {
                y: {
                    ticks: {
                        callback: function(e) {
                            return e + " тыс. cум"
                        }
                    }
                }
            },
            plugins: {
                // Change options for ALL labels of THIS CHART
                datalabels: {
                    color: 'white'
                }
            }
        },
        data: {
            labels: [@foreach($tech_map_data_for_bar as $item) "{{$item}}", @endforeach],
            datasets: [{
                label: "Плановые затраты, тыс. cум",
                data: {{json_encode($tech_maps->map(function ($techMap) { $techMap->other_amount = round($techMap->amount/1000); return $techMap;})->pluck('other_amount')->toArray())}},
                backgroundColor: "#0de68b",
            }, {
                label: "Фактические затраты, тыс. cум",
                data: {{json_encode($tech_maps->map(function ($techMap) { $techMap->avg_amount = round($techMap->avg_amount/1000); return $techMap;})->pluck('avg_amount')->toArray())}},
                backgroundColor: "#0d86b5",
            }]
        }
    });
</script>
@endsection
