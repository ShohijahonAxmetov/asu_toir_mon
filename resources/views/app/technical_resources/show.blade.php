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

							<a href="{{ route($route_name . '.edit', [$route_parameter => $item]) }}" class="btn btn-primary lift">Редактировать</a>
							<a class="btn btn-danger lift ms-3" onclick="var result = confirm('Вы уверены?');if (result){event.preventDefault();document.getElementById('delete-form{{ $item->id }}').submit();}"> Удалить</a>
							<form action="{{ route($route_name . '.destroy', [$route_parameter => $item]) }}" id="delete-form{{ $item->id }}" method="POST" style="display: none;">
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
                            <th scope="row">Наименование каталожное</th>
                            <td class="">{{$item->catalog_name}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Каталожный №</th>
                            <td class="">{{$item->catalog_number}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Наименование номенклатурное</th>
                            <td class="">{{$item->nomen_name ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Номенклатурный №</th>
                            <td class="">{{$item->nomen_number ?? '--'}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Время, необходимое для выполнения заказа</th>
                            <td class="">{{ $item->time_complete_order}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Время доставки</th>
                            <td class="">{{ $item->delivery_time}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Ед. изм.</th>
                            <td class="">{{ $item->unit->name}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Дата добавления</th>
                            <td class="">{{ isset($item->created_at) ? date('d-m-Y', strtotime($item->created_at)) : '--' }}</td>
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
                            Прикрепленные файлы
                        </h1>

                    </div>
                </div> <!-- / .row -->
            </div> <!-- / .header-body -->
        </div>
    </div> <!-- / .header -->

    <!-- CARDS -->
    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Наименование</th>
                            <th scope="col">Файл</th>
                            <th scope="col">Дата добавления</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($files as $key => $file)
                            <tr>
                                <th scope="row" style="width: 100px">{{ $loop->iteration }}</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $file->original_name }}
                                    </div>
                                </td>
                                <td>
                                    @if(in_array($file->ext, ['png','jpeg','jpg']))
                                    <img src="/storage/{{$file->name}}" height="200">
                                    @else
                                    Документ
                                    @endif
                                </td>
                                <td>{{ isset($file->created_at) ? date('d-m-Y', strtotime($file->created_at)) : '--' }}</td>
                                <td style="width: 200px">
                                    <div class="d-flex justify-content-end">
                                        <a href="/storage/{{$file->name}}" download="{{$file->original_name}}" class="btn btn-sm btn-info"><i class="fe fe-download"></i></a>
                                        <a class="btn btn-sm btn-danger ms-3" onclick="var result = confirm('Want to delete?');if (result){event.preventDefault();document.getElementById('delete11-form{{ $file->id }}').submit();}"><i class="fe fe-trash"></i></a>
                                        <form action="{{ route('files.destroy', ['file' => $file]) }}" id="delete11-form{{ $file->id }}" method="POST" style="display: none;">
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
