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
							<a href="{{ route($route_name . '.edit', [$route_parameter => $detail]) }}" class="btn btn-primary lift">Редактировать</a>
							<a class="btn btn-danger lift ms-3" onclick="var result = confirm('Вы уверены?');if (result){event.preventDefault();document.getElementById('delete2-form{{ $detail->id }}').submit();}"> Удалить</a>
							<form action="{{ route($route_name . '.destroy', [$route_parameter => $detail]) }}" id="delete2-form{{ $detail->id }}" method="POST" style="display: none;">
								@csrf
								@method('DELETE')
							</form>
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
                'url' => route($route_name.'.index'),
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
                            <th scope="row">Тип оборудования</th>
                            <td class="">{{$detail->typeEquipment->name}}</td>
                        </tr>
                        <tr>
                            <th scope="row">МТР</th>
                            <td class="">{{$detail->technicalResource->catalog_name}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Родительский узел</th>
                            <td class="">{{$detail->parent->technicalResource->catalog_name ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Дата добавления</th>
                            <td class="">{{date('Y-m-d', strtotime($detail->created_at))}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- HEADER -->
    <div class="header">
        <div class="container-fluid">

            <!-- Body -->
            <div class="header-body">
                <div class="row align-items-end">
                    <div class="col d-flex justify-content-between">

                        <!-- Title -->
                        <h1 class="header-title">
                            Детали
                        </h1>

                        <a href="{{ route($route_name.'.create', ['parent_id' => $detail->id]) }}" class="btn btn-primary">Добавить</a>

                    </div>
                </div> <!-- / .row -->
            </div> <!-- / .header-body -->
        </div>
    </div> <!-- / .header -->

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
                            <th scope="col">Тип оборудования</th>
                            <th scope="col">МТР</th>
                            <th scope="col">Родительский узел</th>
                            <th scope="col">Дата добавления</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($detail->children as $key => $item)
                            <tr>
                                <th scope="row" style="width: 100px">{{ $loop->iteration }}</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $item->typeEquipment->name ?? '--' }}
                                    </div>
                                </td>
                                <td>{{ $item->technicalResource->catalog_name }}</td>
                                <td>{{ $item->parent->technicalResource->catalog_name ?? '--' }}</td>
                                <td>{{ isset($item->created_at) ? date('d-m-Y', strtotime($item->created_at)) : '--' }}</td>
                                <td style="width: 200px">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route($route_name . '.edit', [$route_parameter => $item]) }}" class="btn btn-sm btn-success ms-3"><i class="fe fe-edit-2"></i></a>
                                        <a href="{{ route($route_name . '.show', [$route_parameter => $item]) }}" class="btn btn-sm btn-info ms-3"><i class="fe fe-eye"></i></a>
                                        <a class="btn btn-sm btn-danger ms-3" onclick="var result = confirm('Want to delete?');if (result){event.preventDefault();document.getElementById('delete2-form{{ $item->id }}').submit();}"><i class="fe fe-trash"></i></a>
                                        <form action="{{ route('requirements_year_applications.destroy', ['requirements_year_application' => $item]) }}" id="delete2-form{{ $item->id }}" method="POST" style="display: none;">
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
            </div>
        </div>
    </div>

@endsection
