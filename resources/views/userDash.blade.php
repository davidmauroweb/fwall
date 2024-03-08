@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/fonts/simple-line-icons/style.min.css">
<link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/colors.min.css">
<link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header bg-info text-black">Usuario <h3>{{$userId}}</h3></div>
                <div class="card-body">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
                <div class="row"><div class="col">Ip del Usuario con Bloqueos registrados</div><div class="col">Acumulado diario de la ultima semana</div></div>
                <div class="row"><div class="col"><canvas  id="SemanalIp"></canvas></div><div class="col"><canvas  id="Semanal"></canvas></div></div>
                <script>
                    var ctxip = document.getElementById('SemanalIp').getContext('2d');
                    var dataIp = {
                            labels: [
                                @foreach($ips as $ip)
                                    "{{$ip->ipClient}}" ,
                                    @endforeach
                            ],
                            datasets: [{
                                axis: 'y',
                                label: 'Ips Match',
                                data: [@foreach($ips as $ip)
                                    "{{$ip->total}}" ,
                                    @endforeach
                                ],
                                fill: false,
                                backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 205, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(201, 203, 207, 0.2)'
                                ],
                                borderColor: [
                                'rgb(255, 99, 132)',
                                'rgb(255, 159, 64)',
                                'rgb(255, 205, 86)',
                                'rgb(75, 192, 192)',
                                'rgb(54, 162, 235)',
                                'rgb(153, 102, 255)',
                                'rgb(201, 203, 207)'
                                ],
                                borderWidth: 1
                                }]
                            };
                    var SemanalIp = new Chart(ctxip, {
                            type: 'bar',
                            data: dataIp,
                            options: {
                                indexAxis: 'y',
                                }
                            }
                        );
                </script>
                
                <script>
                    
                        var ctx = document.getElementById('Semanal').getContext('2d');
                        var labels = [
                            @foreach($d as $dato)
                            {{date('d', strtotime($dato->dia))}} ,
                            @endforeach
                        ];
                        var valuesb = [
                            @foreach($d as $dato)
                                {{$dato->b}}, 
                            @endforeach
                        ];
                        var valuesbs = [
                            @foreach($d as $dato)
                                {{$dato->bs}}, 
                            @endforeach
                        ];
                        var valuesbp = [
                            @foreach($d as $dato)
                                {{$dato->bp}}, 
                            @endforeach
                        ];
                        var Semanal = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: "Bloqueos/Filtros",
                                    data: valuesb,
                                    borderColor: 'rgba(75, 192, 192, 0.7)',
                                    backgroundColor:'rgba(75, 192, 192, 0.5)',
                                },
                                {
                                    label: "Malware",
                                    data: valuesbs,
                                    borderColor: 'rgba(192, 75, 192, 0.7)',
                                    backgroundColor:'rgba(192, 75, 192, 0.5)',
                                },
                                {
                                    label: "Parental",
                                    data: valuesbp,
                                    borderColor: 'rgba(192, 192, 75, 0.7)',
                                    backgroundColor:'rgba(192, 192, 75, 0.5)',
                                }]
                            },
                            options: {
                                scales: {
                                    xAxes: [{
                                        type: 'category',
                                        ticks: {
                                            beginAtZero: true,
                                            autoSkip: false,
                                            maxTicksLimit: 7,
                                            maxRotation: 0,
                                            minRotation: 0
                                        }
                                    }],
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                },
                            }
                        });
                </script>


            <div>
                <div class="row">Registro de las ultimas 24 Horas</div>
                <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="b-tab" data-bs-toggle="tab" data-bs-target="#b" type="button" role="tab" aria-controls="b" aria-selected="true">
                                <div class="media d-flex col">
                                    <div class="media-body text-left">
                                        <h3 class="warning">{{$b}}</h3>
                                        Filtro/Servicio
                                        <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: {{$br}}%" aria-valuenow="{{$br}}" aria-valuemin="0" aria-valuemax="100">{{number_format($br, 2)}} %</div>
                                        </div>
                                    </div>
                                </div>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="bs-tab" data-bs-toggle="tab" data-bs-target="#bs" type="button" role="tab" aria-controls="bs" aria-selected="false">
                        
                                <div class="media d-flex col">
                                    <div class="media-body text-left">
                                        <h3 class="warning">{{$bs}}</h3>
                                        Malware/Fishing
                                        <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: {{$bsr}}%;" aria-valuenow="{{$bsr}}" aria-valuemin="0" aria-valuemax="100">{{number_format($bsr, 2)}} %</div>
                                        </div>
                                    </div>
                                </div>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="bp-tab" data-bs-toggle="tab" data-bs-target="#bp" type="button" role="tab" aria-controls="bp" aria-selected="false">
                                <div class="media d-flex col">
                                    <div class="media-body text-left">
                                        <h3 class="warning">{{$bp}}</h3>
                                        Contro Parental
                                        <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: {{$bpr}}%;" aria-valuenow="{{$bpr}}" aria-valuemin="0" aria-valuemax="100">{{number_format($bpr, 2)}} %</div>
                                        </div>
                                    </div>
                                </div>
                    </button>
                </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="b" role="tabpanel" aria-labelledby="b-tab">
                    <table class="table table-sn table-hover">
                        <thead><th>Top 6</th></thead>
                        <tbody>
                            @foreach($gb as $lab)
                            <tr>
                                <td>{{$lab->site}}: {{$lab->total}} [{{number_format(($lab->total * 100)/$b, 2)}}%]
                                <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{($lab->total * 100)/$tgb->total}}%;" aria-valuenow="{{($lab->total * 100)/$tgb->total}}" aria-valuemin="0" aria-valuemax="100%">{{$lab->total}}</div>
                                </div>   
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                        <table class="table table-sn table-hover">
                        <thead>
                            <th><i class="bi bi-calendar-week"></i> Fecha</th>
                            <th><i class="bi bi-pc-display-horizontal"></i> IP</th>
                            <th><i class="bi bi-globe2"></i> Sitio</th>
                        </thead>
                        <tbody>
                        @foreach ($lb as $l)
                            <tr>
                                <td>{{date('d/m/y H:i', strtotime($l->time))}}</td>
                                <td>{{$l->ipClient}}</td>
                                <td>{{$l->site}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="bs" role="tabpanel" aria-labelledby="bs-tab">
                    <table class="table table-sn table-hover">
                    <thead><th>Top 6</th></thead>
                    <tbody>
                        @foreach($gbs as $labs)
                        <tr>
                            <td>{{$labs->site}}: {{$labs->total}} [{{number_format(($labs->total * 100)/$bs, 2)}}%]
                            <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{($labs->total * 100)/$tgbs->total}}%;" aria-valuenow="{{($labs->total * 100)/$tgbs->total}}" aria-valuemin="0" aria-valuemax="100%">{{$labs->total}}</div>
                            </div>   
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                        <table class="table table-sn table-hover">
                        <thead>
                            <th><i class="bi bi-calendar-week"></i> Fecha</th>
                            <th><i class="bi bi-pc-display-horizontal"></i> IP</th>
                            <th><i class="bi bi-globe2"></i> Sitio</th>
                        </thead>
                        <tbody>
                        @foreach ($lbs as $l)
                            <tr>
                                <td>{{date('d/m/y H:i', strtotime($l->time))}}</td>
                                <td>{{$l->ipClient}}</td>
                                <td>{{$l->site}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                    <div class="tab-pane fade" id="bp" role="tabpanel" aria-labelledby="bp-tab">
                    <table class="table table-sn table-hover">
                        <thead><th>Top 6</th></thead>
                        <tbody>
                            @foreach($gbp as $labp)
                            <tr>
                                <td>{{$labp->site}}: {{$labp->total}} [{{number_format(($labp->total * 100)/$bp, 2)}}%]
                                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{($labp->total * 100)/$tgbp->total}}%;" aria-valuenow="{{($labp->total * 100)/$tgbp->total}}" aria-valuemin="0" aria-valuemax="100%">{{$labp->total}}</div>
                    </div>   
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <table class="table table-sn table-hover">
                        <thead>
                            <th><i class="bi bi-calendar-week"></i> Fecha</th>
                            <th><i class="bi bi-pc-display-horizontal"></i> IP</th>
                            <th><i class="bi bi-globe2"></i> Sitio</th>
                        </thead>
                        <tbody>
                        @foreach ($lbp as $l)
                            <tr>
                                <td>{{date('d/m/y H:i', strtotime($l->time))}}</td>
                                <td>{{$l->ipClient}}</td>
                                <td>{{$l->site}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>   
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
