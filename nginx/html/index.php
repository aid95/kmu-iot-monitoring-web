<?php
    include_once("db/mysql.php");
    $mysql = new MySql("localhost", "root", "root", "iotadmin_db");
?>

<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1280, initial-scale=1.0">
    <title>FLORA :: 스마트 IoT 화분 관리</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.css">
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
                            <span class="align-font-txt-center" style="font-size: 3rem;">FLORA MONITOR 🌼</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-md-5 align-v-center">
                                <div class="card">
                                    <div class="card-header">
                                        최근 1시간 평균 데이터
                                        <span style="float: right;">🔋 <span id="info-battery">-</span>%</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <p class="align-font-txt-center">Temp</p>
                                                <h2 id="avg-temperature" class="align-font-txt-center">-</h2>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="align-font-txt-center">Moisture</p>
                                                <h2 id="avg-moisture" class="align-font-txt-center">-</h2>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="align-font-txt-center">Conductivity</p>
                                                <h2 id="avg-conductivity" class="align-font-txt-center">-</h2>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="align-font-txt-center">Light</p>
                                                <h2 id="avg-light" class="align-font-txt-center">-</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7 align-v-center">
                                <div class="card">
                                    <div class="card-header">최근 1시간 데이터 그래프</div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row d-table">
                                                    <div class="col-xs-12">
                                                        <canvas id="chart-temperature"></canvas>
                                                    </div>
                                                    <div class="col-xs-12">
                                                        <canvas id="chart-moisture"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <canvas id="chart-conductivity"></canvas>
                                                    </div>
                                                    <div class="col-xs-12">
                                                        <canvas id="chart-light"></canvas>
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
        </main>
        <footer>
        </footer>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
    <script src="js/ktiot.js""></script>
    <script>
    const DATA_COUNT = 100;
    const REQ_PERIOD = 60;
    const ATTR_NAME_LIST = ['light', 'temperature', 'moisture', 'conductivity'];
    const CHART_CTX_LIST = ATTR_NAME_LIST.map((s) => {
        let datasets = [{
            label: '# of ' + s,
            fill: false,
            data: ktiot.get_tag_stream_period(100, 9999).data.reverse().map((elem) => { return elem.attributes[s] }),
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }];

        let ctx = document.getElementById(`chart-${s}`).getContext('2d');
        let myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ktiot.get_tag_stream_period(DATA_COUNT, REQ_PERIOD).data.reverse().map((elem) => { return elem['occDt'] }),
                datasets,
            },
            options: {
                legend: {
                    display: false
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

    setInterval(() => {
        let period_datas = ktiot.get_tag_stream_period(DATA_COUNT, REQ_PERIOD).data;
        let average_data = period_datas.reduce((acc_data, cur_data, index) => {
            ATTR_NAME_LIST.map((s) => {
                if (acc_data.hasOwnProperty(s)) {
                    acc_data[s] += cur_data.attributes[s];
                } else {
                    acc_data[s] = 0.0;
                }
            });
            return acc_data;
        }, {});

        ATTR_NAME_LIST.map((name) => {
            average_data[name] /= period_datas.length;
            $(`#avg-${name}`).html(average_data[name].toFixed(1))
        });

        let last_data = ktiot.get_last_tag_stream().data[0].attributes;
        $("#info-battery").html(last_data['battery']);
        CHART_CTX_LIST.map((chart, index) => {
            chart.data.datasets[0].data.push(last_data[ATTR_NAME_LIST[index]]);
            if (chart.data.datasets[0].data.length > 60) {
                chart.data.datasets[0].data.shift();
            }
            chart.update();
        });
    }, 3000);
    </script>
</body>
</html>
