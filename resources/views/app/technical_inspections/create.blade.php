@extends('layouts.app')

@section('links')
    
@endsection

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
            'name' => 'Добавление',
            'disabled' => true
            ],
            ]
            ])
        </div>
    </div> <!-- / .header -->

    <!-- CARDS -->
    <div class="container-fluid">
        <form method="post" action="{{ route($route_name . '.store') }}" enctype="multipart/form-data" id="add">
            <div class="row">
                <div class="col-8">
                    <div class="card mw-50">
                        <div class="card-body">
                            <form method="post" action="{{ route($route_name . '.store') }}" enctype="multipart/form-data" id="add">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="type_technical_inspection_id" class="form-label required">Тип технического обслуживания</label>
                                            <select class="form-control required mb-4 @error('type_technical_inspection_id') is-invalid @enderror" name="type_technical_inspection_id" id="type_technical_inspection_id">
                                                @foreach ($type_technical_inspections as $key => $item)
                                                    <option value="{{ $item->id }}" {{ (old('type_technical_inspection_id') ? in_array($item->id, old('type_technical_inspection_id')) : '') ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('type_technical_inspection_id')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="who_conducted" class="form-label required">Кто проводил</label>
                                            <input type="text" required class="form-control @error('who_conducted') is-invalid @enderror" name="who_conducted" value="{{ old('who_conducted') }}" id="who_conducted" placeholder="Кто проводил...">
                                            @error('who_conducted')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="now" class="form-label required">Фактическая дата</label>
                                            <input type="date" required class="form-control @error('now') is-invalid @enderror" name="now" value="{{ old('now') }}" id="now" placeholder="Кто проводил...">
                                            @error('now')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="required">
                                                    <label for="desc" class="form-label">Описание</label>
                                                </div>
                                                <div class="c">
                                                    <textarea id="desc" required cols="4" rows="4" class="form-control @error('desc') is-invalid @enderror" name="desc">{{ old('desc') ?? $product->desc ?? null }}</textarea>
                                                    @error('desc')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="next" class="form-label required">Плановая дата</label>
                                            <input type="date" required class="form-control @error('next') is-invalid @enderror" name="next" value="{{ old('next') }}" id="next" placeholder="Кто проводил...">
                                            @error('next')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- Button -->
                                <div class="model-btns d-flex justify-content-end">
                                    <a href="{{ route($route_name.'.index') }}" type="button" class="btn btn-secondary">Отмена</a>
                                    <button type="submit" class="btn btn-primary ms-2">Сохранить</button>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card mw-50">
                        <div class="card-body">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="equipment_id" class="form-label">Оборудование</label>
                                        <select class="form-control @error('equipment_id') is-invalid @enderror" name="equipment_id" id="equipment_id" data-choices>
                                            @foreach ($equipments as $key => $item)
                                                <option value="{{ $item->id }}" {{ (old('equipment_id') ? in_array($item->id, old('equipment_id')) : '') ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('equipment_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="details" class="form-label required">Детали</label>
                                        <select class="form-control @error('details') is-invalid @enderror" required multiple name="details[]" id="details">
                                            @foreach ($details as $key => $item)
                                                <option value="{{ $item->id }}" {{ (old('details') ? in_array($item->id, old('details')) : '') ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('details')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        // let details = document.getElementById('details');
        // let details_choices = new Choices(details, {
        //     removeItems: true,
        // });

    </script>
    <script>
        const equipment_id = document.getElementById('equipment_id');
        const type_technical_inspection_id = document.getElementById('type_technical_inspection_id');

        equipment_id.addEventListener('change', (value) => {
           // console.log(value.target.value);

           axios.get('/equipments/' + value.target.value + '/getDetails?type_technical_inspection_id=' + type_technical_inspection_id.value)
               .then(function (response) {
                   let details = document.getElementById('details');
                   details.innerHTML = '';
                   response.data.details.forEach(e => {
                       let option = document.createElement('option');
                       option.setAttribute('value', e.id);
                       option.innerHTML = e.name;
                       details.appendChild(option);
                   });
               })
               .catch(function (error) {
                   // handle error
                   console.log(error);
               })
               .finally(function () {
                   // always executed
               });
        });

        type_technical_inspection_id.addEventListener('change', (value) => {
           // console.log(value.target.value);

           axios.get('/equipments/' + equipment_id.value + '/getDetails?type_technical_inspection_id=' + value.target.value)
               .then(function (response) {
                   let details = document.getElementById('details');
                   details.innerHTML = '';
                   response.data.details.forEach(e => {
                       let option = document.createElement('option');
                       option.setAttribute('value', e.id);
                       option.innerHTML = e.name;
                       details.appendChild(option);
                   });
               })
               .catch(function (error) {
                   // handle error
                   console.log(error);
               })
               .finally(function () {
                   // always executed
               });
        });
    </script>
@endsection
