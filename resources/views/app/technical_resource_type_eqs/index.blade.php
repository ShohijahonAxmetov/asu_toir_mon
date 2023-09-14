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
                        <a href="{{ route($route_name.'.create') }}" class="btn btn-primary lift">
                            Добавить
                        </a>

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
                        <div class="col-12">
{{--                            <div class="form-group">--}}
{{--                                <label for="type_equipment_id" class="form-label">Тип оборудования</label>--}}
{{--                                <select class="form-control @error('categories') is-invalid @enderror" name="type_equipment_id" data-choices>--}}
{{--                                    <option value="">Выберите из списка</option>--}}
{{--                                    @foreach ($type_equipments as $key => $item)--}}
{{--                                        <option value="{{ $item->id }}" {{ $item->id == $search ? 'selected' : '' }}>{{ $item->name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                                @error('type_equipment_id')--}}
{{--                                <span class="invalid-feedback" role="alert">--}}
{{--                                    <strong>{{ $message }}</strong>--}}
{{--                                </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary lift">
                                    Фильтр
                                </button>
                            </div>
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
                            <th scope="col">Гаражный номер</th>
                            <th scope="col">Тип оборудования</th>
                            <th scope="col">Дата добавления</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($equipments as $key => $item)
                            <tr>
                                <th scope="row" style="width: 100px">{{ $equipments->firstItem() + $key }}</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $item->garage_number }}
                                    </div>
                                </td>
                                <td>{{ $item->typeEquipment->name }}</td>
                                <td>{{ isset($item->created_at) ? date('d-m-Y', strtotime($item->created_at)) : '--' }}</td>
                                <td style="width: 200px">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route($route_name.'.edit', [$route_parameter => $item]) }}" class="btn btn-sm btn-info"><i class="fe fe-edit-2"></i></a>
                                        <a class="btn btn-sm btn-danger ms-3" onclick="var result = confirm('Want to delete?');if (result){event.preventDefault();document.getElementById('delete-form{{ $item->id }}').submit();}"><i class="fe fe-trash"></i></a>
                                        <form action="{{ route($route_name.'.destroy', [$route_parameter => $item]) }}" id="delete-form{{ $item->id }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $equipments->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
