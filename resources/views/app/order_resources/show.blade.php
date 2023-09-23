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
                            <td class="">{{$item->equipment->commissioning_date ?? '--'}}</td>
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
                            <td class="">{{ $item->warehouse_date ?? '--'}}</td>
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
                            <td class="">{{ $item->orderResource->order_date ?? '--'}}</td>
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
                            <td class="">{{ $item->orderResource->contract_date ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Договор (местный/зарубежный)</th>
                            <td class="">{{ isset($item->orderResource->local_foreign) ?( $item->orderResource->local_foreign != null ? ($item->orderResource->local_foreign == 1 ? 'местный' : 'зарубежный') : '--') : '--'}}</td>
                        </tr>

                        <tr>
                            <th scope="row">Дата изготовления</th>
                            <td class="">{{ $item->orderResource->exit_date ?? '--'}}</td>
                        </tr>

                        <tr>
                            <th scope="row">Таможня (дата поступления)</th>
                            <td class="">{{ $item->orderResource->customs_date_receipt ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Таможня (дата выхода)</th>
                            <td class="">{{ $item->orderResource->customs_date_exit ?? '--'}}</td>
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
                            <td class="{{(is_null($item->orderResource) || $item->orderResource->executionStatuse->id < 7) ? ((strtotime($item->delivery_date) - strtotime(date('Y-m-d')))/86400 < 0 ? 'bg-danger' : '') : ''}}">{{ ($item->orderResource && $item->orderResource->executionStatuse->id >= 7) ? '--' : ($item->delivery_date ? (strtotime($item->delivery_date) - strtotime(date('Y-m-d')))/86400 : '--')}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Дата начала ремонта по плану</th>
                            <td class="">{{ $item->remont_begin ? date('d-m-Y', strtotime($item->remont_begin)) : '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Осталось дней до начала ремонта</th>
                            <td class="{{(is_null($item->orderResource) || $item->orderResource->executionStatuse->id < 7) ? ((strtotime($item->remont_begin) - strtotime(date('Y-m-d')))/86400 < 0 ? 'bg-danger' : '') : ''}}">{{ ($item->orderResource && $item->orderResource->executionStatuse->id >= 7) ? '--' : ($item->remont_begin ? (strtotime($item->remont_begin) - strtotime(date('Y-m-d')))/86400 : '--')}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Ход исполнения на {{date('d-m-Y')}}</th>
                            <td class="">{{ $item->orderResource ? $item->orderResource->executionStatuse->name : 'оформляется заказ' }}</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
