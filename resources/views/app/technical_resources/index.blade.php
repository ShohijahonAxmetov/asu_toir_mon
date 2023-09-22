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
                            <th scope="col">Время, необходимое для выполнения заказа</th>
                            <th scope="col">Время доставки</th>
                            <th scope="col">Ед. изм.</th>
                            <th scope="col">Дата добавления</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($technical_resources as $key => $item)
                            <tr>
                                <th scope="row" style="width: 100px">{{ $technical_resources->firstItem() + $key }}</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $item->catalog_name }}
                                    </div>
                                </td>
                                <td>{{ $item->catalog_number }}</td>
                                <td>{{ $item->nomen_name }}</td>
                                <td>{{ $item->nomen_number }}</td>
                                <td>{{ $item->time_complete_order }}</td>
                                <td>{{ $item->delivery_time }}</td>
                                <td>{{ $item->unit->name ?? '--' }}</td>
                                <td>{{ isset($item->created_at) ? date('d-m-Y', strtotime($item->created_at)) : '--' }}</td>
                                <td style="width: 200px">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route($route_name.'.edit', [$route_parameter => $item]) }}" class="btn btn-sm btn-success me-3"><i class="fe fe-edit-2"></i></a>
                                        <a href="{{ route($route_name.'.show', [$route_parameter => $item]) }}" class="btn btn-sm btn-info"><i class="fe fe-eye"></i></a>
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
                    {{ $technical_resources->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
