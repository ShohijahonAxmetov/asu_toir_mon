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
                            <th scope="col">Группа</th>
                            <th scope="col">Наименование</th>
                            <th scope="col">Код</th>
                            <th scope="col">Продолжительность</th>
                            <th scope="col">Действующий документ</th>
                            <th scope="col">Дата согласования</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach (${$route_name} as $key => $item)
                            <tr>
                                <th scope="row" style="width: 100px">{{ ${$route_name}->firstItem() + $key }}</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $item->techMapGroup->title }}
                                    </div>
                                </td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->hours.' ч '.$item->minutes.' мин' }}</td>
                                <td>{{ $item->agreed_at ? '✅' : '🔄' }}</td>
                                <td>{{ $item->agreed_at ? date('d-m-Y', strtotime($item->agreed_at)) : '-' }}</td>
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
                    {{ ${$route_name}->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
