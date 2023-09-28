@extends('layouts.app')

@section('links')

<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'>
<link rel="stylesheet" href="/assets/css/home.css">

@endsection

@section('content')

<div class="header mb-0">
    <div class="container-fluid">
        <!-- Body -->
        <div class="header-body border-0">
            <div class="row align-items-end">
                <div class="col">

                    <!-- Title -->
                    <h1 class="header-title">
                        Дашбоард
                    </h1>

                </div>
                <div class="col-auto">
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .header-body -->
    </div>
</div> <!-- / .header -->

<div class="container-fluid">
    <img src="/result.png">
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 col-xl-4 mb-5">
            <div class="chart__block card h-100">
                <div class="card-header">

                    <!-- Title -->
                    <h4 class="card-header-title">
                        Календарь
                    </h4>

                </div>
                <div class="d-flex flex-column align-items-center">
                    <div class="d-flex flex-xl-column flex-lg-row py-3">
                        <div class="calendar-wrapper py-0">
                            <button id="btnPrev" type="button">ПРЕДЫДУЩИЙ</button>
                            <button id="btnNext" type="button">СЛЕДУЮЩИЙ</button>
                            <div id="divCal"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xl-4 mb-5">
            <!-- Traffic -->
            <div class="card">
                <div class="card-header">

                    <!-- Title -->
                    <h4 class="card-header-title">
                        Заявки
                    </h4>

                </div>
                <div class="card-body">

                    <!-- Chart -->
                    <div class="chart chart-appended">
                        <canvas id="applicationChart" class="chart-canvas" data-toggle="legend" data-target="#trafficChartLegend"></canvas>
                    </div>

                    <!-- Legend -->
                    <div id="trafficChartLegend" class="chart-legend"></div>

                    <div>

                        <ul class="d-flex flex-wrap">
                            <li style="list-style-type: none;color: #718597;font-size: 12px;" class="me-3 d-flex align-items-center"><span class="me-2" style="width: 8px;height: 8px;border-radius: 50%;background-color: #0a8b65"></span>исполнен ({{json_decode($applications)[0]}})</li>
                            <li style="list-style-type: none;color: #718597;font-size: 12px;" class="me-3 d-flex align-items-center"><span class="me-2" style="width: 8px;height: 8px;border-radius: 50%;background-color: #bd1200"></span>оформляется заказ ({{json_decode($applications)[1]}})</li>
                            <li style="list-style-type: none;color: #718597;font-size: 12px;" class="me-3 d-flex align-items-center"><span class="me-2" style="width: 8px;height: 8px;border-radius: 50%;background-color: #e74c3c"></span>оформляется договор ({{json_decode($applications)[2]}})</li>
                            <li style="list-style-type: none;color: #718597;font-size: 12px;" class="me-3 d-flex align-items-center"><span class="me-2" style="width: 8px;height: 8px;border-radius: 50%;background-color: #eb54e1"></span>договор неоплачен ({{json_decode($applications)[3]}})</li>
                            <li style="list-style-type: none;color: #718597;font-size: 12px;" class="me-3 d-flex align-items-center"><span class="me-2" style="width: 8px;height: 8px;border-radius: 50%;background-color: #ffc3bd"></span>договор исполняется ({{json_decode($applications)[4]}})</li>
                            <li style="list-style-type: none;color: #718597;font-size: 12px;" class="me-3 d-flex align-items-center"><span class="me-2" style="width: 8px;height: 8px;border-radius: 50%;background-color: lightblue"></span>оборудование изготовлено, находится у исполнителя ({{json_decode($applications)[5]}})</li>
                            <li style="list-style-type: none;color: #718597;font-size: 12px;" class="me-3 d-flex align-items-center"><span class="me-2" style="width: 8px;height: 8px;border-radius: 50%;background-color: blue"></span>в пути ({{json_decode($applications)[6]}})</li>
                            <li style="list-style-type: none;color: #718597;font-size: 12px;" class="me-3 d-flex align-items-center"><span class="me-2" style="width: 8px;height: 8px;border-radius: 50%;background-color: #b0fe15"></span>на таможне ({{json_decode($applications)[7]}})</li>
                            <li style="list-style-type: none;color: #718597;font-size: 12px;" class="me-3 d-flex align-items-center"><span class="me-2" style="width: 8px;height: 8px;border-radius: 50%;background-color: #20c997"></span>в пути после таможни ({{json_decode($applications)[8]}})</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            
            <div class="card">
                <div class="card-header">

                    <!-- Title -->
                    <h4 class="card-header-title">
                        Заявки с наименьшим процентом выполнения
                    </h4>

                </div>
                <div class="card-body">

                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">ОБОРУДОВАНИЕ</th>
                          <th scope="col">ТИП ОБОРУДОВАНИЯ</th>
                          <th scope="col">ТИП РЕМОНТА</th>
                          <th scope="col">ДАТА РЕМОНТА</th>
                          <th scope="col">ПРОЦЕНТ ВЫПОЛНЕНИЯ</th>
                          <!-- <th scope="col">Просрочено дней</th> -->
                          <th scope="col">ДАТА последней заявки</th>
                          <th scope="col"></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($badRemonts as $key => $remont)
                        <tr>
                          <th scope="row">{{$loop->iteration}}</th>
                          <td>{{$remont->equipment->garage_number.' ('.$remont->equipment->department->name.')'}}</td>
                          <td>{{$remont->equipment->typeEquipment->name}}</td>
                          <td>{{$remont->remontType->name}}</td>
                          <td>{{$remont->remont_begin}}</td>
                          <td>{{$remont->percent}}</td>
                          <!-- <td>{{$remont->prosrocheno_dney}}</td> -->
                          <td>{{$remont->latest_application_date}}</td>
                          <td>
                              <a href="{{ route('monitoring', ['equipment_id' => $remont->equipment, 'plan_remont_id' => $remont->id]) }}" class="btn btn-sm btn-info"><i class="fe fe-eye"></i></a>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
</div>


<!-- calendar -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" id="draggable__calendar_modal">
            <div class="modal-header" id="draggable__calendar_modalheader">
                <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body position-relative" id="modal_tbody">
                <!-- table -->
            </div>
            <div class="modal-loader position-absolute d-flex align-items-center justify-content-center w-100 h-100">
                <div class="lds-ring">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
<!-- calendar end -->

@endsection

@section('scripts')

<!-- calendar scripts -->
<script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    var Cal = function(divId) {

        //Сохраняем идентификатор div
        this.divId = divId;

        // Дни недели с понедельника
        this.DaysOfWeek = [
            "Пн",
            "Вт",
            "Ср",
            "Чтв",
            "Птн",
            "Суб",
            "Вск"
        ];

        // Месяцы начиная с января
        this.Months =["ЯНВАРЬ", "ФЕВРАЛЬ", "МАРТ", "АПРЕЛЬ", "МАЙ", "ИЮНЬ", "ИЮЛЬ", "АВГУСТ", "СЕНТЯБРЬ", "ОКТЯБРЬ", "НОЯБРЬ", "ДЕКАБРЬ"];

        //Устанавливаем текущий месяц, год
        var d = new Date();

        this.currMonth = d.getMonth('9');
        this.currYear = d.getFullYear('22');
        this.currDay = d.getDate('3');
    };

    // Переход к следующему месяцу
    Cal.prototype.nextMonth = function() {
        if ( this.currMonth == 11 ) {
        this.currMonth = 0;
        this.currYear = this.currYear + 1;
        }
        else {
        this.currMonth = this.currMonth + 1;
        }
        this.showcurr();
    };

    // Переход к предыдущему месяцу
    Cal.prototype.previousMonth = function() {
        if ( this.currMonth == 0 ) {
            this.currMonth = 11;
            this.currYear = this.currYear - 1;
        }
        else {
            this.currMonth = this.currMonth - 1;
        }
        this.showcurr();
    };

    // Показать текущий месяц
    Cal.prototype.showcurr = function() {
        this.showMonth(this.currYear, this.currMonth);
    };



    // Показать месяц (год, месяц)
    Cal.prototype.showMonth = function(y, m) {

        // get days for paint
        var response = axios({
             method: 'get',
             url: '/calendar/get_days?date=' + y + '-' + m
            });
        response.then(function(data) {
            data.data.forEach(element => {
                var d_days = document.querySelectorAll('.day.normal');
                d_days.forEach(d_day => {
                    if(d_day.innerText == element && document.getElementById('this_month_and_year').dataset.month == m) {
                        var now = new Date();
                        var today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                        var currentDate = new Date(y, m, element)
                        d_day.classList.add('bg-warning');
                    }
                });
            });
        });

        var d = new Date()
        // Первый день недели в выбранном месяце
        , firstDayOfMonth = new Date(y, m, 7).getDay()
        // Последний день выбранного месяца
        , lastDateOfMonth =  new Date(y, m+1, 0).getDate()
        // Последний день предыдущего месяца
        , lastDayOfLastMonth = m == 0 ? new Date(y-1, 11, 0).getDate() : new Date(y, m, 0).getDate();


        var html = '<table>';

        // Запись выбранного месяца и года
        html += '<thead><tr>';
        html += '<td colspan="7" id="this_month_and_year" data-month="' + m + '">' + this.Months[m] + ' ' + y + '</td>';
        html += '</tr></thead>';


        // заголовок дней недели
        html += '<tr class="days">';
        for(var i=0; i < this.DaysOfWeek.length;i++) {
            html += '<td>' + this.DaysOfWeek[i] + '</td>';
        }
        html += '</tr>';

        // Записываем дни
        var i=1;
        do {

        var dow = new Date(y, m, i).getDay();

        // Начать новую строку в понедельник
        if ( dow == 1 ) {
          html += '<tr>';
        }

        // Если первый день недели не понедельник показать последние дни предидущего месяца
        else if ( i == 1 ) {
          html += '<tr>';
          var k = lastDayOfLastMonth - firstDayOfMonth+1;
          for(var j=0; j < firstDayOfMonth; j++) {
            html += '<td class="day not-current">' + k + '</td>';
            k++;
          }
        }

        // Записываем текущий день в цикл
        var chk = new Date();
        var chkY = chk.getFullYear();
        var chkM = chk.getMonth();
        if (chkY == this.currYear && chkM == this.currMonth && i == this.currDay) {
          html += '<td class="day normal today" data-bs-toggle="modal" data-bs-target="#exampleModal">' + i + '</td>';
        } else {
          html += '<td class="day normal" data-bs-toggle="modal" data-bs-target="#exampleModal">' + i + '</td>';
        }
        // закрыть строку в воскресенье
        if ( dow == 0 ) {
          html += '</tr>';
        }
        // Если последний день месяца не воскресенье, показать первые дни следующего месяца
        else if ( i == lastDateOfMonth ) {
          var k=1;
          for(dow; dow < 7; dow++) {
            html += '<td class="day not-current">' + k + '</td>';
            k++;
          }
        }

        i++;
        }while(i <= lastDateOfMonth);

        // Конец таблицы
        html += '</table>';

        // Записываем HTML в div
        document.getElementById(this.divId).innerHTML = html;
    };

    // Начать календарь
    var c = new Cal("divCal");
    c.showcurr();

    // Привязываем кнопки «Следующий» и «Предыдущий»
    getId('btnNext').onclick = function() {
        c.nextMonth();
    };
    getId('btnPrev').onclick = function() {
        c.previousMonth();
    };

    // Получить элемент по id
    function getId(id) {
        return document.getElementById(id);
    }

</script>

<!-- modal in click -->
<script>

    $(document).ready(function() {

        $(document).on("click",".day",function(day) {
            $('#modal_tbody').html('');
            $('.modal-loader').removeClass('d-none');

            $currentDate = day.currentTarget.innerText + ' - ' + $('#this_month_and_year').text();
            $('#exampleModalLabel').text($currentDate);

            axios({
             method: 'get',
             url: '/calendar?date=' + $currentDate
            })
                .then(function (response) {
                    let result = '';
                    console.log(response)

                    result = result + '<h2>Оборудования</h2>';
                    result = result + '<table class="table table-striped">' +
                                          '<thead>' +
                                            '<tr>' +
                                              '<th scope="col">#</th>' +
                                              '<th scope="col">Оборудование</th>' +
                                              '<th scope="col">Тип оборудования</th>' +
                                              '<th scope="col">Тип ремонта</th>' +
                                              '<th scope="col">Дата ремонта</th>' +
                                              '<th scope="col">Процент выполнения</th>' +
                                              '<th scope="col"></th>' +
                                            '</tr>' +
                                          '</thead>' +
                                          '<tbody>';
                    response.data.res.forEach((element, index) => {
                        result = result +  '<tr>' +
                                                '<th scope="row">' + Number(index + 1) + '</th>' +
                                                '<td>' + (element.garage_number + ' (' + element.department.name + ')') + '</td>' +
                                                '<td>' + (element.type_equipment.name ?? '--') + '</td>' +
                                                '<td>' + (element.plan_remonts[0].remont_type.name) + '</td>' +
                                                '<td>' + (element.plan_remonts[0].remont_begin + ' - ' + element.plan_remonts[0].remont_end) + '</td>' +
                                                '<td>' + (element.percent) + '</td>' +
                                                '<td><a href="' + '/monitoring?equipment_id=' + element.id + '&plan_remont_id=' + element.plan_remonts[0].id + '' + '" class="btn btn-sm btn-info ms-3"><i class="fe fe-eye"></i></a></td>' +
                                            '</tr>';
                    });
                    result = result + '</tbody>' +
                        '</table>';


                    $('#modal_tbody').append(result);
                    $('.modal-loader').addClass('d-none');
                });

        });

    });

</script>
<!-- calendar scripts end -->
<script>
    const ctx = document.getElementById('applicationChart');

    new Chart(ctx, {
        type: 'pie',
        data: {
            // labels: [
            //     'исполнен',
            //     'оформляется заказ',
            //     'оформляется договор',
            //     'договор исполняется',
            //     'оборудования изготовлены, находится у исполнителя',
            //     'в пути',
            //     'на таможне',
            //     'в пути после таможни'
            // ],
            datasets: [{
                label: 'Учет заявок',
                data: {{$applications}},
                backgroundColor: [
                    '#0a8b65',
                    '#bd1200',
                    '#e74c3c',
                    '#eb54e1',
                    '#ffc3bd',
                    'lightblue',
                    'blue',
                    '#b0fe15',
                    '#20c997',
                ],
                // borderWidth: 2,
                // hoverOffset: 4,
                // offset: 0,
                // weight: 50
            }],
        },
        // options: {
            // responsive: true,
            // plugins: {
            //   legend: {
            //     position: 'top',
            //   },
            //   title: {
            //     display: true,
            //     // text: 'Chart.js Pie Chart'
            //   }
            // }
        // }
    });
</script>
@endsection
