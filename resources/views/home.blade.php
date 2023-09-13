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
    <div class="row">
        <div class="col-lg-12 col-xl-4 mb-5">
            <div class="chart__block card p-4 h-100">
                <div class="d-flex flex-column align-items-center">
                    <h3 class="d-flex align-self-start mb-5">Календарь</h3>
                    <div class="d-flex flex-xl-column flex-lg-row">
                        <div class="calendar-wrapper py-0">
                            <button id="btnPrev" type="button">ПРЕДЫДУЩИЙ</button>
                            <button id="btnNext" type="button">СЛЕДУЮЩИЙ</button>
                            <div id="divCal"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="chart__block card p-4 h-100 h-100">
                <div class="d-flex justify-content-between flex-column mb-5">
                    <h3>Оборудования</h3>
                    <div class="d-flex flex-xl-column flex-lg-row">
                        <div class="d-flex align-items-center bg-white" style="border:1px solid #d2ddec;border-radius: 0.375rem;padding: 0.5rem 0.75rem;">
                            <input value="{{date('Y')}}-01" id="tex_start_date" type="month" class="month_input bg-transparent border-0" style="width:120px">
                            <span class="mx-3">-</span>
                            <input value="{{date('Y')}}-12" id="tex_end_date" type="month" class="month_input bg-transparent border-0" style="width:120px">
                        </div>
                    </div>
                </div>
                <div>
                    <canvas id="tex_chart"></canvas>
                </div>
                <div>
                    <small><span style="width: 16px;height: 16px;background-color: #9BD0F5;display: inline-block;border-radius: 50%;"></span> Запланировано</small>
                    <br>
                    <small><span style="width: 16px;height: 16px;background-color: #FFB1C1;display: inline-block;border-radius: 50%;"></span> Фактически проведенные</small>
                </div>
                <button class="btn btn-info mt-5" data-bs-toggle="modal" data-bs-target="#diagnostikaModal">Подробно</button>
                <!-- Modal -->
                <!-- zdes bil modal -->
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
                        if(today >= currentDate) {
                            d_day.classList.add('bg-danger');
                        } else {
                            d_day.classList.add('bg-warning');
                        }
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

            console.log(day.currentTarget.innerText);

            $currentDate = day.currentTarget.innerText + ' - ' + $('#this_month_and_year').text();
            $('#exampleModalLabel').text($currentDate);

            axios({
             method: 'get',
             url: '/calendar?date=' + $currentDate
            })
                .then(function (response) {
                    let result = '';

                    response.data.res.forEach((element, index) => {
                        result = result + '<h2>' + element.name + '</h2>';
                        result = result + '<table class="table table-striped">' +
                                              '<thead>' +
                                                '<tr>' +
                                                  '<th scope="col">#</th>' +
                                                  '<th scope="col">НАЗВАНИЕ</th>' +
                                                  '<th scope="col">Плановая дата</th>' +
                                                  '<th scope="col">Фактическая дата</th>' +
                                                  '<th scope="col">До слд. Тех. Обслужования</th>' +
                                                '</tr>' +
                                              '</thead>' +
                                              '<tbody>';

                        element.details.forEach((element1, index1) => {
                            result = result + '<tr>' +
                                                      '<th scope="row">' + Number(index1 + 1) + '</th>' +
                                                      '<td>' + (element1.name ?? '--') + '</td>' +
                                                      '<td>' + (element1.planned ?? '--') + '</td>' +
                                                      '<td>' + ((element1.technical_inspections && element1.technical_inspections[0]) ? element1.technical_inspections[0].now : '--') + '</td>' +
                                                      '<td>' + (element1.days ? element1.days + ' дней' : '--') + '</td>' +
                                                    '</tr>';
                        });


                        result = result + '</tbody>' +
                         '</table>';
                    });


                    $('#modal_tbody').append(result);
                    $('.modal-loader').addClass('d-none');
                });

        });

    });

</script>
<!-- calendar scripts end -->

@endsection