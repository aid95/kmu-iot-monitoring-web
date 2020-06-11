<!--
               @TEAM.MAKERS
     _._     _,-'""`-._
    (,-.`._,'(       |\`-/|
        `-.-' \ )-`( , o o)
            `-    \`_`"'-
     2020y6m Keimyung UNIV.
    webmaster@mail.gomi.land
-->
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1280, initial-scale=1.0">
    <title>FLORA :: 스마트 IoT 화분 관리</title>

    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
    @font-face { font-family: 'silgothic'; src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_eight@1.0/silgothic.woff') format('woff'); font-weight: normal; font-style: normal; }
    body {
        margin: 0;
        padding: 0;
        background-color: #F7F9F9;
    }

    .wrap {
        width: 100%;
        height: 100%;
    }

    .align-font-txt-center {
        text-align: center;
        font-family: 'silgothic';
    }

    .align-v-center {
        margin-top: auto;
        margin-bottom: auto;
    }
    </style>
</head>
<body>
    <div class="wrap">
        <nav>
        </nav>
        <main>
            <div class="content-logo">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 pt-4 pb-4" style="margin: 0 auto;">
                            <span class="align-font-txt-center" style="font-size: 3rem;">FLORA 🌺 MONITOR</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- START: 센서 정보 -->
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-md-5 pt-2 pb-2">
                                <div class="card h-100">
                                    <div class="card-header" style="background-color: rgba(0,0,0,0); border-bottom: none;">
                                        최근 평균 데이터
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <p class="align-font-txt-center">🌡</p>
                                                <h2 id="avg-temperature" class="align-font-txt-center">-</h2>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="align-font-txt-center">☀️</p>
                                                <h2 id="avg-light" class="align-font-txt-center">-</h2>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="align-font-txt-center">💩</p>
                                                <h2 id="avg-conductivity" class="align-font-txt-center">-</h2>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="align-font-txt-center">💦</p>
                                                <h2 id="avg-moisture" class="align-font-txt-center">-</h2>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-header" style="border-top: 1px solid rgba(0,0,0,.125); background-color: rgba(0,0,0,0); border-bottom: none;">
                                        최저/최대 데이터
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <p class="align-font-txt-center">🌡</p>
                                                <h3 id="min-temperature" class="align-font-txt-center">-</h2>
                                                <h3 id="max-temperature" class="align-font-txt-center">-</h2>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="align-font-txt-center">☀️</p>
                                                <h3 id="min-light" class="align-font-txt-center">-</h2>
                                                <h3 id="max-light" class="align-font-txt-center">-</h2>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="align-font-txt-center">💩</p>
                                                <h3 id="min-conductivity" class="align-font-txt-center">-</h2>
                                                <h3 id="max-conductivity" class="align-font-txt-center">-</h2>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="align-font-txt-center">💦</p>
                                                <h3 id="min-moisture" class="align-font-txt-center">-</h2>
                                                <h3 id="max-moisture" class="align-font-txt-center">-</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7 align-v-center pt-2 pb-2">
                                <div class="card">
                                    <div class="card-header" style="background-color: rgba(0,0,0,0); border-bottom: none;">
                                        최근 데이터 그래프
                                        <span style="float: right;">🔋 <span id="info-battery">-</span>%</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-xs-12" style="margin: 0 auto; width: 100%">
                                                        <canvas id="chart-temperature"></canvas>
                                                    </div>
                                                    <div class="col-xs-12" style="margin: 0 auto; width: 100%">
                                                        <canvas id="chart-light"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-xs-12" style="margin: 0 auto; width: 100%">
                                                        <canvas id="chart-conductivity"></canvas>
                                                    </div>
                                                    <div class="col-xs-12" style="margin: 0 auto; width: 100%">
                                                        <canvas id="chart-moisture"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: 센서 정보 -->

            <!-- START: 날씨 정보 -->
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-md-12 pt-2 pb-2" style="padding: 0;">
                                <div class="card h-100">
                                    <div class="card-header" style="background-color: rgba(0,0,0,0); border-bottom: none;">
                                        날씨 정보 <a href="https://openweathermap.org/" style="decoration: none;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></a>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <!-- START:  현재 날씨 -->
                                            <div class="col-md-4">
                                                <div class="card h-100" style="border: none;">
                                                    <div class="card-header" style="background-color: rgba(0,0,0,0); border-bottom: none;">
                                                        현재 날씨
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <!-- START: 주간 날씨 -->
                                                            <div class="col-md-12" id="cur-weather">
                                                            </div>
                                                            <!-- END: 주간 날씨 -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END:  현재 날씨 -->

                                            <!-- START: 주간 날씨 정보 -->
                                            <div class="col-md-8">
                                                <div class="card h-100" style="border: none;">
                                                    <div class="card-header" style="background-color: rgba(0,0,0,0); border-bottom: none;">
                                                        주간 평균 날씨
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <!-- START: 주간 평균 날씨 -->
                                                            <div class="col-md-12 align-font-txt-center" style="font-size: 1.8rem;" id="week-avg-weather">
                                                            </div>
                                                            <!-- END: 주간 평균 날씨 -->
                                                        </div>
                                                    </div>
                                                    <div class="card-header" style="border-top: 1px solid rgba(0,0,0,.125); background-color: rgba(0,0,0,0); border-bottom: none;">
                                                        주간 날씨
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <!-- START: 주간 날씨 -->
                                                            <div class="col-md-12" id="week-weather">
                                                            </div>
                                                            <!-- END: 주간 날씨 -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END: 주간 날씨 정보 -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: 날씨 정보 -->

            <!-- START: 이벤트&SNS 정보 -->
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-md-12 pt-2 pb-2" style="padding: 0;">
                                <div class="card h-100">
                                    <div class="card-header" style="background-color: rgba(0,0,0,0); border-bottom: none;">
                                        식물 관리
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <!-- START:  이벤트 로그 -->
                                            <div class="col-md-4">
                                                <div class="card h-100" style="border: none;">
                                                    <div class="card-header" style="background-color: rgba(0,0,0,0); border-bottom: none;">
                                                        이벤트 로그
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <!-- START: 이벤트 로그 -->
                                                            <div class="col-md-12">
                                                                <div class="row" id="event-log-viewer" style="height: 400px;overflow: scroll;">
                                                                </div>
                                                            </div>
                                                            <!-- END: 이벤트 로그 -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END:  이벤트 로그 -->

                                            <!-- START: 식물 SNS -->
                                            <div class="col-md-8">
                                                <div class="card h-100" style="border: none;">
                                                    <div class="card-header" style="background-color: rgba(0,0,0,0); border-bottom: none;">
                                                        SNS
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <!-- START: SNS -->
                                                            <div class="col-md-12" id="flora-sns-viewer">
                                                            </div>
                                                            <!-- END: SNS -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END: 식물 SNS -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: 이벤트&SNS 정보 -->
        </main>
        <footer>
            <p class="align-font-txt-center">Copyright 2020 FLORA 🌺 MONITORING DASHBOARD</p>
        </footer>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
    <script src="js/flowtype.js"></script>

    <script src="js/ktiot.js"></script>
    <script src="js/weather.js"></script>
    <script>

<?php
session_start();
if (!isset($_SESSION["kakao"])) {
    echo "<script> window.location.href='https://kauth.kakao.com/oauth/authorize?client_id=e88dc6e8a3c14d8a611dbb9d511d4cf9&redirect_uri=http://flora.gomi.land/oauth&response_type=code'</script>";
}
?>

    /**
     *  DOM 업데이트와 태그 스트림 데이터 가공하기 위한 작업 작성
     * 
     *  @author: 
     *      - 신병주(webmaster@mail.gomi.land)
     *      - 김규동
     */
    // START:   KT IoTMakers에 필요한 전역 변수들
    const CUR_DATE_YYYY_MM_DD = new Date().toJSON().split('T')[0];
    const DATA_COUNT = 100;
    const MAX_DATA_COUNT = 9999;
    const REQ_PERIOD = 60;
    const ATTR_NAME_LIST = ['light', 'temperature', 'moisture', 'conductivity'];
    // END:     KT IoTMakers에 필요한 전역 변수들

    // START:   KT iotmakers 데이터 그래프 표시
    let tag_stream_datas = ktiot.get_tag_stream_period(DATA_COUNT, REQ_PERIOD).data.reverse();
    const CHART_CTX_LIST = ATTR_NAME_LIST.map((s) => {
        let datasets = [{
            label: '# of ' + s,
            data: tag_stream_datas.map((elem) => { return elem.attributes[s]; }),
            fill: false,
            borderWidth: 1
        }];

        // 데이터 종류별 추가할 데이터 분기를 위한 SWITCH
        switch (s) {
            case 'light':
                // #F5B041
                datasets[0]['borderColor'] = "#F5B041";
                break;
            
            case 'temperature':
                // #E74C3C
                datasets[0]['borderColor'] = "#E74C3C";
                break;
            
            case 'moisture':
                // #5DADE2
                datasets[0]['borderColor'] = "#5DADE2";
                break;

            case 'conductivity':
                // #7B241C
                datasets[0]['borderColor'] = "#7B241C";
                break;
        
            default:
                break;
        }

        let ctx = document.getElementById(`chart-${s}`).getContext('2d');
        let myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: tag_stream_datas.map((elem) => { return elem['occDt'] }),
                datasets,
            },
            options: {
                legend: {
                    // display: false
                    display: true
                },
                elements: {
                    point:{
                        radius: 0
                    }
                },
                responsive: true, 
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        display: true,
                        ticks: {
                            display: false
                        },
                        gridLines: {
                            display:false
                        }
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                        },
                        gridLines: {
                            display:false
                        }
                    }]
                }
            }
        });
        return myChart;
    });
    // END:   KT iotmakers 데이터 그래프 표시

    // START:   주기적인 KT IOTmakers 통신을 위한 타이머 함수
    setInterval(() => {
        // REQ_PERIOD분 동안의 DATA_COUNT개의 데이터의 평균을 구함.
        let period_datas = ktiot.get_tag_stream_period(DATA_COUNT, REQ_PERIOD).data;
        let average_data = period_datas.reduce((acc_data, cur_data, index) => {
            ATTR_NAME_LIST.map((s) => {
                if (!acc_data.hasOwnProperty(s)) {
                    acc_data[s] = 0.0;
                }
                acc_data[s] += cur_data.attributes[s];
            });
            return acc_data;
        }, {});

        // 평균 데이터를 요소에 반영
        ATTR_NAME_LIST.map((name) => {
            average_data[name] /= period_datas.length;
            if (name == 'temperature') {
                $(`#avg-${name}`).html(average_data[name].toFixed(1));
            } else {
                $(`#avg-${name}`).html(Math.round(average_data[name]));
            }
        });

        // 가장 최근 추가된 데이터를 그래프에 반영.
        let last_data = ktiot.get_last_tag_stream().data[0].attributes;
        $("#info-battery").html(last_data['battery']);
        CHART_CTX_LIST.map((chart, index) => {
            chart.data.datasets[0].data.push(last_data[ATTR_NAME_LIST[index]]);
            if (chart.data.datasets[0].data.length > DATA_COUNT) {
                chart.data.datasets[0].data.shift();
            }
            // FIX: 배열에 100개의 값이 없는 경우 업데이트가 제대로 안됨.
            chart.update();
        });
    }, 3100);
    // END:     주기적인 KT IOTmakers 통신을 위한 콜백함수

    // START: 센서 최대/최소값 업데이트 (단 데이터가 많아 1분에 한번씩)
    function updateMinMaxSensorData() {
        let daily_datas = ktiot.get_tag_stream_until(MAX_DATA_COUNT, `${CUR_DATE_YYYY_MM_DD} 00:00`, `${CUR_DATE_YYYY_MM_DD} 23:59`).data;
        let split_daily_datas = ktiot.split_dict_array(daily_datas);
        CHART_CTX_LIST.map((chart, index) => {
            $(`#min-${ATTR_NAME_LIST[index]}`).html(Math.min.apply(null, split_daily_datas[ATTR_NAME_LIST[index]]));
            $(`#max-${ATTR_NAME_LIST[index]}`).html(Math.max.apply(null, split_daily_datas[ATTR_NAME_LIST[index]]));
        });
    }
    updateMinMaxSensorData();
    setInterval(() => {
        updateMinMaxSensorData();
    }, 100000);
    // END: 센서 최대/최소값 업데이트 (단 데이터가 많아 1분에 한번씩)

    $( document ).ready(function() {
        // START:   레이아웃이 깨지는걸 막기 위한 flowtype 라이브러리 설정
        const DISPLAY_AVG_ELEM_NAME_LIST = ['temperature', 'light', 'conductivity', 'moisture'];
        DISPLAY_AVG_ELEM_NAME_LIST.map((s) => {
            $(`#avg-${s}`).flowtype({
                minimum   : 110,
                maximum   : 111,
                minFont   : 27,
                maxFont   : 28,
                fontRatio : 30
            });
            $(`#min-${s}`).flowtype({
                minimum   : 110,
                maximum   : 111,
                minFont   : 25,
                maxFont   : 26,
                fontRatio : 30
            });
            $(`#max-${s}`).flowtype({
                minimum   : 110,
                maximum   : 111,
                minFont   : 25,
                maxFont   : 26,
                fontRatio : 30
            });
        });
        // END:     레이아웃이 깨지는걸 막기 위한 flowtype 라이브러리 설정

        // START: 날씨 정보 초기화
        owmapi.one_call_weather('cur-weather', 'week-weather', 'week-avg-weather');
        // END: 날씨 정보 초기화

        // START: KT IoTMakers 이벤트 리스트
        ktiot.get_event_logs('event-log-viewer');
        // END: KT IoTMakers 이벤트 리스트
    });
    </script>
</body>
</html>
