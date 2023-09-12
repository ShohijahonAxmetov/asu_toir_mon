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

    <div class="container-fluid">
        <div class="card mt-4">
            <!-- <div class="card-header">
                <h3 class="mb-0">Фильтр</h3>
            </div> -->
            <div class="card-body">
                <form action="{{route($route_name.'.index')}}">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="equipment_id" class="form-label">Оборудование</label>
                                <select class="form-control @error('categories') is-invalid @enderror" name="equipment_id" data-choices>
                                    <option value="">Выберите из списка</option>
                                    @foreach ($equipments as $key => $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $search ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('equipment_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
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
                            <th scope="col">Название детали</th>
                            <th scope="col">Техническое обслужование</th>
                            <th scope="col">Кто проводил</th>
                            <th scope="col">Описание</th>
                            <th scope="col">Фактическая дата</th>
                            <th scope="col">Плановая дата</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($technical_inspections as $key => $item)
                            <tr>
                                <th scope="row" style="width: 100px">{{ $technical_inspections->firstItem() + $key }}</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $item->detail->name }}
                                    </div>
                                </td>
                                <td>{{ $item->type_technical_inspection->name }}</td>
                                <td>{{ $item->who_conducted }}</td>
                                <td>{{ $item->desc }}</td>
                                <td>{{ isset($item->now) ? date('d-m-Y', strtotime($item->now)) : '--' }}</td>
                                <td>{{ isset($item->next) ? date('d-m-Y', strtotime($item->next)) : '--' }}</td>
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
                    {{ $technical_inspections->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
