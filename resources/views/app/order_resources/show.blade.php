@extends('layouts.app')

@section('content')
    <!-- HEADER -->
    <div class="header">
        <div class="container-fluid">

            <!-- Body -->
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col">

                        <!-- Title -->
                        <h1 class="header-title">
                            {{ $title }}
                        </h1>

                    </div>
                </div> <!-- / .row -->
            </div> <!-- / .header-body -->
        </div>
    </div> <!-- / .header -->

    <!-- CARDS -->
    <div class="container-fluid">
    @include('app.components.breadcrumb', [
            'datas' => [
                [
                'active' => false,
                'url' => route('monitoring'),
                'name' => $title,
                'disabled' => false
                ],
                [
                'active' => true,
                'url' => '',
                'name' => 'Просмотр',
                'disabled' => true
                ],
            ]
            ])
        <div class="card mw-50">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th scope="row">Тип оборудование и гар. №</th>
                            <td class="">{{$item->equipment->typeEquipment->name.' № '.$item->equipment->garage_number.' ('.$item->equipment->department->name.')'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Дата ввода</th>
                            <td class="">{{isset($item->equipment->commissioning_date) ? date('d-m-Y', strtotime($item->equipment->commissioning_date)) : '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Состояние</th>
                            <td class="">{{$item->equipment->eq_condition ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Номенклатурный №</th>
                            <td class="">{{$item->technicalResource->nomen_number ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Наименование номенклатурное</th>
                            <td class="">{{$item->technicalResource->nomen_name ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Наименования запчастей</th>
                            <td class="">{{$item->technicalResource->catalog_name ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Каталожный №</th>
                            <td class="">{{ $item->technicalResource->catalog_number ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Потребное количество</th>
                            <td class="">{{ $item->required_quantity ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">На складе (дата)</th>
                            <td class="">{{ isset($item->warehouse_date) ? date('d-m-Y', strtotime($item->warehouse_date)) : '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">На складе (кол-во)</th>
                            <td class="">{{ $item->warehouse_quantity ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Кол-во поставки</th>
                            <td class="">{{ $item->declared_quantity ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Ед. изм.</th>
                            <td class="">{{ $item->technicalResource->unit->name ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Срок поставки</th>
                            <td class="">{{ $item->delivery_date ? date('d-m-Y', strtotime($item->delivery_date)) : '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Дата заявки</th>
                            <td class="">{{isset($item->application_date) ? date('d-m-Y', strtotime($item->application_date)) : '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Вид заявки</th>
                            <td class="">
                                @if($item->type_application == 1) Годовая заявка @endif
                                @if($item->type_application == 2) Заявка на ремонт @endif
                                @if($item->type_application == 3) Аварийная заявка @endif
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">Заказ (№)</th>
                            <td class="">{{ $item->orderResource->order_number ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Заказ (дата)</th>
                            <td class="">{{ isset($item->orderResource->order_date) ? date('d-m-Y', strtotime($item->orderResource->order_date)) : '--'}}</td>
                        </tr>

                        <tr>
                            <th scope="row">Заказ (кол-во)</th>
                            <td class="">{{ $item->orderResource->order_quantity ?? '--'}}</td>
                        </tr>

                        <tr>
                            <th scope="row">Договор (№)</th>
                            <td class="">{{ $item->orderResource->contract_number ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Договор (дата)</th>
                            <td class="">{{ isset($item->orderResource->contract_date) ? date('d-m-Y', strtotime($item->orderResource->contract_date)) : '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Договор (местный/зарубежный)</th>
                            <td class="">{{ isset($item->orderResource->local_foreign) ?( $item->orderResource->local_foreign != null ? ($item->orderResource->local_foreign == 1 ? 'местный' : 'зарубежный') : '--') : '--'}}</td>
                        </tr>

                        <tr>
                            <th scope="row">Дата изготовления (по договору)</th>
                            <td class="">{{ isset($item->orderResource->date_manufacture_contract) ? date('d-m-Y', strtotime($item->orderResource->date_manufacture_contract)) : '--'}}</td>
                        </tr>

                        <tr>
                            <th scope="row">Дата оплаты договора</th>
                            <td class="">{{ isset($item->orderResource->payment_date) ? date('d-m-Y', strtotime($item->orderResource->payment_date)) : '--'}}</td>
                        </tr>

                        <tr>
                            <th scope="row">Дата изготовления (по факту)</th>
                            <td class="">{{ isset($item->orderResource->date_manufacture_fact) ? date('d-m-Y', strtotime($item->orderResource->date_manufacture_fact)) : '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Покинул завод (дата)</th>
                            <td class="">{{ isset($item->orderResource->exit_date) ? date('d-m-Y', strtotime($item->orderResource->exit_date)) : '--'}}</td>
                        </tr>

                        <tr>
                            <th scope="row">Таможня (дата поступления)</th>
                            <td class="">{{ isset($item->orderResource->customs_date_receipt) ? date('d-m-Y', strtotime($item->orderResource->customs_date_receipt)) : '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Таможня (дата выхода)</th>
                            <td class="">{{ isset($item->orderResource->customs_date_exit) ? date('d-m-Y', strtotime($item->orderResource->customs_date_exit)) : '--'}}</td>
                        </tr>

                        <tr>
                            <th scope="row">Время поставки (время, необходимое для выполнения заказа)</th>
                            <td class="">{{ $item->technicalResource->time_complete_order ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Время поставки (время доставки)</th>
                            <td class="">{{ $item->technicalResource->delivery_time ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Осталось время на поставку</th>
                            <td style="{{(is_null($item->orderResource) || $item->orderResource->executionStatuse->id < 71) ? ((strtotime($item->delivery_date) - strtotime(date('Y-m-d')))/86400 < 0 ? '--bs-table-accent-bg:#e63757' : '') : ''}}">{{ ($item->orderResource && $item->orderResource->executionStatuse->id >= 71) ? '--' : ($item->delivery_date ? (strtotime($item->delivery_date) - strtotime(date('Y-m-d')))/86400 : '--')}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Дата начала ремонта по плану</th>
                            <td class="">{{ $item->remont_begin ? date('d-m-Y', strtotime($item->remont_begin)) : '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Осталось дней до начала ремонта</th>
                            <td style="{{(is_null($item->orderResource) || $item->orderResource->executionStatuse->id < 71) ? ((strtotime($item->remont_begin) - strtotime(date('Y-m-d')))/86400 < 0 ? '--bs-table-accent-bg:#e63757' : '') : ''}}">{{ ($item->orderResource && $item->orderResource->executionStatuse->id >= 71) ? '--' : ($item->remont_begin ? (strtotime($item->remont_begin) - strtotime(date('Y-m-d')))/86400 : '--')}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Ход исполнения на {{date('d-m-Y')}}</th>
                            <td class="">{{ $item->orderResource ? $item->orderResource->executionStatuse->name : 'оформляется заказ' }}</td>
                        </tr>
                        @php
                            // 4

                            if (isset($item->orderResource->date_manufacture_fact)) {
                                if (!isset($item->orderResource->customs_date_receipt) and !isset($item->orderResource->date_delivery_object)) {
                                    $add_days = $item->technicalResource->delivery_time;
                                    $date1 = date('d-m-Y', strtotime($item->orderResource->date_manufacture_fact) + (24*3600*$add_days));
                                    $date2 = date('d-m-Y', strtotime($item->delivery_date));
                                    $dateTimestamp1 = strtotime($date1);
                                    $dateTimestamp2 = strtotime($date2);

                                    if ($dateTimestamp1 > $dateTimestamp2) {
                                        $flag_delivery = true;
                                    } else {
                                        $flag_delivery = false;
                                    }
                                } else {
                                    $flag_delivery = false;
                                }
                            } else {
                                $flag_delivery = false;
                            }   // 
                        @endphp
                        <tr>
                            <th scope="row">Дата доставки на объект</th>
                            <td style="{{ $flag_delivery ? '--bs-table-accent-bg:#e63757' : '' }}">{{ isset($item->orderResource->date_delivery_object) ? date('d-m-Y', strtotime($item->orderResource->date_delivery_object)) : '--' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Опоздали с поставкой (дней)</th>
                            <td class="">
                                @if(isset($item->orderResource->date_delivery_object) && strtotime($item->orderResource->date_delivery_object) > strtotime($item->delivery_date))
                                {{ (strtotime($item->orderResource->date_delivery_object) - strtotime($item->delivery_date)) / (24*3600) }}
                                @else
                                --
                                @endif
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
