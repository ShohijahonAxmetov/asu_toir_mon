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
                    <div class="col-auto">

                        <!-- Button -->
                        <!-- <a href="{{ route($route_name.'.create') }}" class="btn btn-primary lift">
                            Добавить
                        </a> -->

                    </div>
                </div> <!-- / .row -->
            </div> <!-- / .header-body -->
            @include('app.components.breadcrumb', [
            'datas' => [
            [
            'active' => true,
            'url' => '',
            'name' => $title,
            'disabled' => false
            ]
            ]
            ])
        </div>
    </div> <!-- / .header -->

    <!-- filter -->
    <div class="container-fluid">
        <div class="card mt-4">
            <!-- <div class="card-header">
                <h3 class="mb-0">Фильтр</h3>
            </div> -->
            <div class="card-body">
                <form action="{{route($route_name.'.index')}}">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="equipment_id" class="form-label">Оборудование</label>
                                <select class="form-control @error('equipment_id') is-invalid @enderror" name="equipment_id" data-choices>
                                    <option value="">Выберите из списка</option>
                                    @foreach ($equipments as $key => $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $equipment_id ? 'selected' : '' }}>{{ $item->garage_number.' ('.$item->department->name.')' }}</option>
                                    @endforeach
                                </select>
                                @error('equipment_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="plan_remont_id" class="form-label">Ремонт</label>
                                <select class="form-control @error('plan_remont_id') is-invalid @enderror" name="plan_remont_id" data-choices>
                                    <option value="">Выберите из списка</option>
                                    @foreach ($plan_remonts as $key => $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $plan_remont_id ? 'selected' : '' }}>{{ $item->remont_begin.' - '.$item->remont_end.' ('.$item->equipment->garage_number.')' }}</option>
                                    @endforeach
                                </select>
                                @error('plan_remont_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary lift">
                                Фильтр
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CARDS -->
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-body">
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Наименование каталожное</th>
                            <th scope="col">Каталожный №</th>
                            <th scope="col">Наименование номенклатурное</th>
                            <th scope="col">Номенклатурный №</th>
                            <th scope="col">Потребное кол-во</th>
                            <th scope="col">На складе (дата)</th>
                            <th scope="col">На складе (кол-во)</th>
                            <th scope="col">Вид заявки</th>
                            <th scope="col">Дата заявки</th>
                            <th scope="col">Заявлено</th>
                            <th scope="col">Дата поставки (план)</th>
                            <th scope="col">Дата начала ремонта</th>
                            <th scope="col">Время поставки (время, необходимое для выполнения заказа)</th>
                            <th scope="col">Время поставки (время доставки)</th>
                            <th scope="col">Заказ (№)</th>
                            <th scope="col">Заказ (дата)</th>
                            <th scope="col">Заказ (кол-во)</th>
                            <th scope="col">Договор (№)</th>
                            <th scope="col">Договор (дата)</th>
                            <th scope="col">Договор (местный/зарубежный)</th>
                            <th scope="col">Дата изготовления (по договору)</th>
                            <th scope="col">Дата изготовления (по факту)</th>
                            <th scope="col">Таможня (дата поступления)</th>
                            <th scope="col">Таможня (дата выхода)</th>
                            <th scope="col">Дата доставки на объект</th>
                            <th scope="col">Статус исполнения</th>
                            <th scope="col">Осталось дней до ремонта</th>
                            <th scope="col">Просрочено дней</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($applications as $key => $item)
                            <tr>
                                <th scope="row" style="width: 100px">{{ $applications->firstItem() + $key }}</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $item->technicalResource->catalog_name }}
                                    </div>
                                </td>
                                <td>{{ $item->technicalResource->catalog_number ?? '--' }}</td>
                                <td>{{ $item->technicalResource->nomen_name ?? '--' }}</td>
                                <td>{{ $item->technicalResource->nomen_number ?? '--' }}</td>
                                <td>{{ $item->required_quantity ?? '--' }}</td>
                                <td>{{ $item->warehouse_date ?? '--' }}</td>
                                <td>{{ $item->warehouse_quantity ?? '--' }}</td>
                                <td>{{ $item->type_application ?? '--' }}</td>
                                <td>{{ isset($item->application_date) ? date('d-m-Y', strtotime($item->application_date)) : '--' }}</td>
                                <td>{{ $item->declared_quantity ?? '--' }}</td>
                                <td>{{ $item->delivery_date ? date('d-m-Y', strtotime($item->delivery_date)) : '--' }}</td>
                                <td>{{ $item->remont_begin ? date('d-m-Y', strtotime($item->remont_begin)) : '--' }}</td>
                                <td>{{ $item->technicalResource->time_complete_order ?? '--' }}</td>
                                <td>{{ $item->technicalResource->delivery_time ?? '--' }}</td>
                                @php
                                    if (isset($item->orderResource->order_date)) {
                                        $flag_order = false;
                                    } else {
                                        $add_days = $item->technicalResource->time_complete_order;
                                        $date1 = date('d-m-Y',strtotime($item->application_date) + (24*3600*$add_days));
                                        $date2 = date('d-m-Y');
                                        $dateTimestamp1 = strtotime($date1);
                                        $dateTimestamp2 = strtotime($date2);
                                        $flag_order = true;
                                        if ($dateTimestamp1 > $dateTimestamp2) {
                                            $flag_order = false;
                                        } else {
                                            $flag_order = true;
                                        }
                                            
                                    } 
                                    /// ;
                                @endphp
                                <td class="{{ $flag_order ? 'bg-danger' : '' }}">{{ $item->orderResource->order_number ?? '--' }}</td>
                                <td class="{{ $flag_order ? 'bg-danger' : '' }}">{{ $item->orderResource->order_date ?? '--' }}</td>
                                <td class="{{ $flag_order ? 'bg-danger' : '' }}">{{ $item->orderResource->order_quantity ?? '--' }}</td>
                                @php
                                    if (isset($item->orderResource->order_date)) {
                                        if (isset($item->orderResource->contract_date)) {
                                            $flag_contact = false;
                                        } else {
                                            $add_days = $item->technicalResource->time_complete_order;
                                            $date1 = date('d-m-Y', strtotime($item->orderResource->order_date) + (24*3600*$add_days));
                                            $date2 = date('d-m-Y', strtotime($item->delivery_date));
                                            $dateTimestamp1 = strtotime($date1);
                                            $dateTimestamp2 = strtotime($date2);

                                            if ($dateTimestamp1 > $dateTimestamp2) {
                                                $flag_contact = true;
                                            } else {
                                                $flag_contact = false;
                                            }
                                        } 
                                    } else {
                                        $flag_contact = false;
                                    }  // 
                                @endphp
                                <td class="{{ $flag_contact ? 'bg-danger' : '' }}">{{ $item->orderResource->contract_number ?? '--' }}</td>
                                <td class="{{ $flag_contact ? 'bg-danger' : '' }}">{{ $item->orderResource->contract_date ?? '--' }}</td>
                                <td class="{{ $flag_contact ? 'bg-danger' : '' }}">{{ isset($item->orderResource->local_foreign) ?( $item->orderResource->local_foreign != null ? ($item->orderResource->local_foreign == 1 ? 'местный' : 'зарубежный') : '--') : '--' }}</td>

                                @php
                                    if (isset($item->orderResource->date_manufacture_contract)) {
                                        if (isset($item->orderResource->date_manufacture_fact)) {
                                            $flag_manufacture = false;
                                        } else {
                                            $date1 = date('d-m-Y', strtotime($item->orderResource->date_manufacture_contract));
                                            $date2 = date('d-m-Y');
                                            $dateTimestamp1 = strtotime($date1);
                                            $dateTimestamp2 = strtotime($date2);
                                            if ($dateTimestamp1 > $dateTimestamp2) {
                                                $flag_manufacture = false;
                                            } else {
                                                $flag_manufacture = true;
                                            }
                                        }  
                                    } else {
                                        $flag_manufacture = false;
                                    }  // 
                                @endphp
                                <td class="{{ $flag_manufacture ? 'bg-danger' : '' }}">{{ $item->orderResource->date_manufacture_contract ?? '--' }}</td>
                                <td>{{ $item->orderResource->date_manufacture_fact ?? '--' }}</td>

                                <td>{{ $item->orderResource->customs_date_receipt ?? '--' }}</td>
                                <td>{{ $item->orderResource->customs_date_exit ?? '--' }}</td>

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
                                <td class="{{ $flag_delivery ? 'bg-danger' : '' }}">{{ isset($item->orderResource->date_delivery_object) ? date('d-m-Y', strtotime($item->orderResource->date_delivery_object)) : '--' }}</td>
                                <td>{{ $item->orderResource->executionStatuse->name ?? App\Models\ExecutionStatus::first()->name }}</td>
                                <td>
                                    {{
                                        isset($item->planRemont->remont_begin)
                                            ? ((strtotime($item->planRemont->remont_begin) - strtotime(date('Y-m-d'))) / 86400 > 0
                                                ? (strtotime($item->planRemont->remont_begin) - strtotime(date('Y-m-d'))) / 86400
                                                : '--')
                                            : '--'
                                    }}
                                </td>
                                @php
                                    $model = null;
                                    if($item->type_application == 1) $model = 'App\Models\RequirementYearApplication';
                                    if($item->type_application == 2) $model = 'App\Models\RequirementRepairApplication';
                                    if($item->type_application == 3) $model = 'App\Models\RequirementEmergencyApplication';

                                    $data_postavki = null;
                                    if($model) {
                                        $selected_model = $model::find($item->requirement_id);
                                        if($selected_model) $data_postavki = $selected_model->delivery_date;
                                    }
                                @endphp
                                <td>
                                    {{
                                        isset($item->planRemont->remont_begin)
                                            ? ((strtotime($item->planRemont->remont_begin) - strtotime(date('Y-m-d'))) / 86400) > 0
                                                ? '--'
                                                : ((strtotime(date('Y-m-d')) - strtotime($item->planRemont->remont_begin)) / 86400)
                                            : '--'
                                    }}
                                </td>
                                <td style="width: 200px">
                                    <div class="d-flex justify-content-end">
                                        @php
                                            $filter = null;
                                            if(isset($equipment_id)) $filter['equipment_id'] = $equipment_id;
                                            if(isset($plan_remont_id)) $filter['plan_remont_id'] = $plan_remont_id;
                                        @endphp
                                        @if(is_null($item->orderResource))
                                        <a href="{{ route($route_name.'.create', ['application_id' => $item->id, 'filter' => $filter]) }}" class="btn btn-sm btn-info"><i class="fe fe-edit-2"></i></a>
                                        @else
                                        <a href="{{ route($route_name.'.edit', [$route_parameter => $item->orderResource, 'application_id' => $item->id, 'filter' => $filter]) }}" class="btn btn-sm btn-info"><i class="fe fe-edit-2"></i></a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $applications->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
