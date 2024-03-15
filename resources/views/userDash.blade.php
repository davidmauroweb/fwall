<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ZeroTrust DNS - Dashboard</title>
  <!-- Enlace al archivo CSS de Tailwind CSS -->
  <link rel="stylesheet" href="{{$rt}}output.css">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <!-- Enlace a las fuentes tipograficas -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
  <!-- Enlace a iconografia FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Enlace a ChartsJS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  <link rel="stylesheet" href="{{$rt}}style.css">

<script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
 
<script type="text/javascript">
$(document).ready(function(){
    $("#tbodybp").ready(function(){
        $(".b").show();
        $(".bs").hide();
        $(".bp").hide();
      });
      $("#b").click(function(){
        $(".b").show();
        $(".bs").hide();
        $(".bp").hide();
      });
      $("#bs").click(function(){
        $(".b").hide();
        $(".bs").show();
        $(".bp").hide();
      });
      $("#bp").click(function(){
        $(".b").hide();
        $(".bs").hide();
        $(".bp").show();
      });
    });
</script>
</head>


<body>
  <script src="{{$rt}}code.js"></script>
  <div class="flex h-screen">
    <!-- Sidebar -->
    <div class="flex lg:w-80 w-20 bg-blanco text-negro90 border-l-grismedio flex-col h-screen lg:m-auto">
      <div class="p-4 mb-8">
        <img src="{{$rt}}imgs/OrigZeroTrustDNS.png" alt="logo ZeroTrust DNS" class=" h-auto lg:p-5 p-0 w-fit hidden lg:block">
        <img src="{{$rt}}imgs/SimbOrigZeroTrustDNS.png" alt="logo ZeroTrust DNS" class=" h-auto p-0 w-fit lg:hidden block">

      </div>
      <div class="p-4 flex flex-row items-center space-x-4">
        <img src="{{$rt}}imgs/profile.jpg" alt="Foto de perfil" class="rounded-full pcassi-profilepic w-full lg:w-1/4 object-contain">
        <div class="flex flex-col w-2/3">
          <h4 class="username text-negro90 font-bold text-m overflow-ellipsis font-inter pcassi-empresa">{{$us->name}}</h4>
          <h5 class="usermail text-grisoscuro text-sm overflow-ellipsis font-inter pcassi-email">{{$us->email}}
          </h5>
        </div>
      </div>
      <ul class="p-4">
        <li class="mb-2 flex items-center font-inter px-4 rounded-md hover:bg-grisclaro cursor-pointer"
            onclick="mostrarContenido('incidentes')">
            <a href="#" class="block lg:py-1 py-3" title="Incidentes">
                <i class="fa-solid fa-circle-exclamation lg:text-sm text-xl"></i>
                <span class="hidden lg:inline text-sm">Incidentes</span>
            </a>
            <i class=" fa-solid fa-angle-right text-grisoscuro ml-auto"></i>
        </li>
        <li class="mb-2 flex items-center font-inter px-4 rounded-md hover:bg-grisclaro cursor-pointer"
            onclick="mostrarContenido('regIP')">
            <a href="#" class="block lg:py-1 py-3" title="Regsitros por IP">
                <i class="fa-solid fa-location-crosshairs lg:text-sm text-xl"></i>
                <span class="hidden lg:inline text-sm">Bloqueos Registrador</span>
            </a>
            <i class="fa-solid fa-angle-right text-grisoscuro ml-auto"></i>
        </li>
        <li class="mb-2 flex items-center font-inter px-4 rounded-md hover:bg-grisclaro cursor-pointer"
            onclick="mostrarContenido('regServ')">
            <a href="#" class="block lg:py-1 py-3" title="Regsitros por Servicio">
                <i class="fa-solid fa-shield-halved lg:text-sm text-xl"></i>
                <span class="hidden lg:inline text-sm">Registros por Servicio</span>
            </a>
            <i class="fa-solid fa-angle-right text-grisoscuro ml-auto"></i>
        </li>
        @if(Auth::user()->adm)
        <li class="mb-2 flex items-center font-inter px-4 rounded-md hover:bg-grisclaro">
            <a href="{{ url('/lista') }}" class="block lg:py-1 py-3" title="Contactar a Soporte">
                <i class="fa-solid fa-users lg:text-sm text-xl"></i>
                <span class="hidden lg:inline text-sm">Volver a la lista</span>
            </a>
            <i class="fa-solid fa-angle-right text-grisoscuro ml-auto"></i>
        </li>
        @else
        <li class="mb-2 flex items-center font-inter px-4 rounded-md hover:bg-grisclaro">
            <a href="mailto:ciberseguridad@pcassi.com " class="block lg:py-1 py-3" title="Contactar a Soporte">
                <i class="fa-solid fa-envelope lg:text-sm text-xl"></i>
                <span class="hidden lg:inline text-sm">Soporte</span>
            </a>
            <i class="fa-solid fa-angle-right text-grisoscuro ml-auto"></i>
        </li>
        @endif
        <li class="mb-2 flex items-center font-inter px-4 rounded-md hover:bg-grisclaro">
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                                     class="block lg:py-1 py-3" title="Contactar a Soporte">
                <i class="fa-solid fa-right-to-bracket lg:text-sm text-xl"></i>
                <span class="hidden lg:inline text-sm">{{ __('Logout') }}</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
            <i class="fa-solid fa-angle-right text-grisoscuro ml-auto"></i>
        </li>
    </ul>
    
      <!-- Pie -->
      <div class="flex justify-center items-center  border-t-1 border-grisoscuro text-grisoscuro text-xs mt-auto mb-3">
        <p class="hidden lg:inline">Desarrollado y mantenido por </p> <img src="{{$rt}}imgs/PCASSI-cs-OPNG.png" alt="PCASSI Ciberseguridad" class="w-1/4 object-contain hidden lg:block">
        <img src="{{$rt}}imgs/Simbolo-PCAC.png" alt="PCASSI Ciberseguridad" class="w-2/4 object-contain block lg:hidden" title="PC ASSI CIBERSEGURIDAD">
      </div>
    </div>
    <!-- Contenido Principal -->
    <div class="flex-1 p-4 bg-grisclaro lg:py-20 lg:px-10 py-10 h-fit overflow-y-scroll">
      <!-- Panel Incidentes -->
      <div class="contenido mostrar" id="incidentes">
        <h1 class="text-3xl font-semibold font-inter mb-4">Incidentes 14 días</h1>
        <div class="linea-tarjetas flex lg:flex-row lg:space-x-3 w-full lg:w-9/12 flex-col lg:space-y-0 space-y-4">

          <div class="lg:w-1/3 pcassi-tarjetainfo-1 flex flex-col rounded-md px-6 py-7 bg-blanco drop-shadow-md w-full">
            <div class="flex items-center justify-between">
              <h4 class="text-sm font-semibold font-inter text-negro90">Actividad Bloqueos</h4>
              <i class="fa-solid fa-chart-column text-grismedio text-sm"></i>
            </div>
            <div>
              <h1 class="text-4xl font-semibold font-inter text-negro90 pcassi-totaln">{{$tb}}</h1>
            </div>
          </div>

          <div class="lg:w-1/3 pcassi-tarjetainfo-2 flex flex-col rounded-md px-6 py-7 bg-blanco drop-shadow-md w-full">
            <div class="flex items-center justify-between">
              <h4 class="text-sm font-semibold font-inter text-negro90">IPs con Bloqueos</h4>
              <i class="fa-solid fa-laptop text-grismedio text-sm"></i>
            </div>
            <div>
              <h1 class="text-4xl font-semibold font-inter text-negro90 pcassi-totaln">{{$qip}}</h1>
            </div>
          </div>

          <div class="lg:w-1/3 pcassi-tarjetainfo-3 flex flex-col rounded-md px-6 py-7 bg-blanco drop-shadow-md w-full">
            <div class="flex items-center justify-between">
              <h4 class="text-sm font-semibold font-inter text-negro90">Sitios Bloqueados</h4>
              <i class="fa-solid fa-circle-xmark text-grismedio text-sm"></i>
            </div>
            <div>
              <h1 class="text-4xl font-semibold font-inter text-negro90 pcassi-totaln">{{$sites}}</h1>
            </div>
          </div>

          <!-- <div class="lg:w-1/4 pcassi-tarjetainfo-4 flex flex-col rounded-md px-6 py-7 bg-blanco drop-shadow-md w-full">
            <div class="flex items-center justify-between">
              <h4 class="text-sm font-semibold font-inter text-negro90">IPs con bloqueos</h4>
              <i class="fa-solid fa-bullseye text-grismedio text-sm"></i>
            </div>
            <div>
              <h1 class="text-4xl font-semibold font-inter text-negro90 pcassi-totaln">3</h1>
            </div>
          </div>-->
        </div> 
        <!-- Grafico 1-->
        <div
          class="pcassi-tarjetagraph-1 flex space-x-3 w-full lg:w-9/12 bg-blanco drop-shadow-md mt-4 rounded-md px-6 py-7 flex-wrap">
          <h3 class="text-xl text-negro90 font-inter font-semibold w-full mb-3">Histórico 14 días</h3>
          <div class="pcassi-graphrefes flex justify-start flex-wrap">

          </div>
          <div id="grafico" style="height: auto; width: 100%;">
            <canvas id="Semanal" class=" mt-4" style="width: 100%; height: 100%;"></canvas>
          </div>
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
                                    borderColor: "#277bc1",
                                    lineTension: 0,
                                    fill: false
                                },
                                {
                                    label: "Malware",
                                    data: valuesbs,
                                    borderColor: "#a44242",
                                    lineTension: 0,
                                    fill: false
                                },
                                {
                                    label: "Parental",
                                    data: valuesbp,
                                    borderColor: "#deb3b3",
                                    lineTension: 0,
                                    fill: false
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
        </div>

        <!-- Grafico 2-->
        <div
          class="pcassi-tarjetagraph-2 flex space-x-3 w-full lg:w-9/12 bg-blanco drop-shadow-md mt-4 rounded-md px-6 py-7 flex-wrap">
          <h3 class="text-xl text-negro90 font-inter font-semibold w-full mb-3">Actividad por IP</h3>

          <div id="grafico2" style="height: auto; width: 100%;">
            <canvas id="SemanalIp" class=" mt-4" style="width: 100%; height: 100%;"></canvas>
          </div>
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
                                "#277bc1",
                                "#86bcea",
                                "#a44242",
                                "#d87d7d",
                                "#deb3b3",
                                "#bababa"
                                ],
                                borderColor: [
                                "#277bc1",
                                "#86bcea",
                                "#a44242",
                                "#d87d7d",
                                "#deb3b3",
                                "#bababa"
                                ],
                                borderWidth: 1
                                }]
                            };
                    var SemanalIp = new Chart(ctxip, {
                            type: 'bar',
                            data: dataIp,
                            options: {
                                indexAxis: 'y',
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                        precision: 0,
                                        beginAtZero: true,
                                        stepSize: 20
                                        }
                                    }]
                                    }    
                            }

                            }
                        );
                </script>
        </div>

      </div>
      <!--Fin Panel incidentes-->
      <!-- Panel Bloq x IP -->
      <div class="contenido" id="regIP">
        <h2 class="text-3xl font-semibold font-inter mb-4">Top 4 Sitios 14 días</h2>
        <div class="linea-tarjetas flex lg:flex-row lg:space-x-3 w-full lg:w-9/12 flex-col lg:space-y-0 space-y-4">
@foreach($toplb as $t)
        <div class="lg:w-1/4 w-full pcassi-tarjetainfo-1 flex flex-col rounded-md px-6 py-7 bg-blanco drop-shadow-md">
            <div class="flex items-center justify-between">
              <a class="text-sm">{{$t->site}}</a>
            </div>
            <div>
              <h1 class="text-4xl font-semibold font-inter text-negro90 pcassi-totaln">{{$t->total}}</h1>
            </div>
          </div>
@endforeach
        </div>
        
        <div class="pcassi-tarjetatablaxip flex space-x-3 w-full lg:w-9/12 bg-blanco drop-shadow-md mt-4 rounded-md px-6 py-7 flex-wrap">
         <div class="font-semibold font-inter mb-4">Últimos 200 Registros</div>
         <div class="w-3/4 p-2"></div>
          <div class="w-max">
            <table class="table-fixed w-full border-grismedio border rounded-md font-inter font-normal text-sm">
              <thead>
                <tr class="w-full text-left border-b text-grisoscuro">
                  <th class="w-3/12 py-2 px-4 font-normal">Fecha</th>
                  <th class="w-3/12 py-2 px-4 font-normal">IP</th>
                  <th class="w-6/12 py-2 px-4 font-normal">Sitio</th>
                </tr>
              </thead>
              <tbody class="text-negro90 text-xs">
                @foreach ($lb as $l)
                            <tr class="border-b hover:bg-blue">
                            <td class="w-2/12 p-4 hover:bg-azulassi">{{date('d/m/y H:i', strtotime($l->time))}}</td>
                            <td class="w-2/12 p-4">{{$l->ipClient}}</td>
                            <td class="w-8/12 p-4 font-semibold">{{$l->site}}</td>
                            </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>


      </div>

      <!--Fin Panel Bloq x IP-->
      <!-- Panel Regist x serv -->
      <div class="contenido" id="regServ">
        <h1 class="text-3xl font-semibold font-inter mb-4">Registros por servicio</h1>
        <div class="linea-tarjetas flex lg:flex-row lg:space-x-3 w-full lg:w-9/12 flex-col lg:space-y-0 space-y-4">
          <div class="w-full lg:w-1/3 pcassi-tarjetainfo-1 flex flex-col rounded-md px-6 py-7 bg-blanco drop-shadow-md">
            <div class="flex items-center justify-between">
              <h4 class="text-sm font-semibold font-inter text-negro90 btnb"><button id="b">Filtro/Servicio</button></h4>
            </div>
            <div>
              <h1 class="text-4xl font-semibold font-inter text-negro90 pcassi-totaln">{{$b}}</h1>
              <div class="progress-container w-full bg-grisclaro rounded-full h-1.5 dark:bg-gray-700">
                <div class="progress-content bg-azulassi h-1.5 rounded-full" style="width: {{$br}}%"></div>
              </div>
            </div>
</div>

          <div class="w-full lg:w-1/3 pcassi-tarjetainfo-2 flex flex-col rounded-md px-6 py-7 bg-blanco drop-shadow-md">
            <div class="flex items-center justify-between">
              <h4 class="text-sm font-semibold font-inter text-negro90 btnbs"><button id="bs">Malware/Phishing</button></h4>

            </div>
            <div>
              <h1 class="text-4xl font-semibold font-inter text-negro90 pcassi-totaln">{{$bs}}</h1>
              <div class="progress-container w-full bg-grisclaro rounded-full h-1.5">
                <div class="progress-content bg-azulassi h-1.5 rounded-full" style="width: {{$bsr}}%"></div>
              </div>
            </div>
          </div>

          <div class="w-full lg:w-1/3 pcassi-tarjetainfo-3 flex flex-col rounded-md px-6 py-7 bg-blanco drop-shadow-md">
            <div class="flex items-center justify-between">
              <h4 class="text-sm font-semibold font-inter text-negro90 btnbp"><button id="bp">Control parental</button></h4>

            </div>
            <div>
              <h1 class="text-4xl font-semibold font-inter text-negro90 pcassi-totaln">{{$bp}}</h1>
              <div class="progress-container w-full bg-grisclaro rounded-full h-1.5 ">
                <div class="progress-content bg-azulassi h-1.5 rounded-full" style="width: {{$bpr}}%"></div>
              </div>
            </div>
          </div>

        </div>

        <div
          class="pcassi-tarjetatablaxip flex space-x-3 w-full lg:w-9/12 bg-blanco drop-shadow-md mt-4 rounded-md px-6 py-7 flex-wrap">
          <div class="w-3/4 p-2"></div>
          <div class="w-max">
            <table class="table-fixed w-full border-grismedio border rounded-md font-inter font-normal text-sm">
              <thead>
                <tr class="w-full text-left border-b text-grisoscuro">
                  <th class="w-3/12 py-2 px-4 font-normal">Sitio</th>
                  <th class="w-3/12 py-2 px-4 font-normal">Inicidencias</th>
                </tr>
              </thead>

              <tbody class="text-negro90 text-xs b">
                @foreach($gb as $l)
                <tr class="border-b hover:bg-blue">
                  <td class="w-1/2 p-4">{{$l->site}}</td>
                  <td class="w-1/2 p-4">
                    <div><span class="pcassi-cant font-inter">{{$l->total}}</span> <span class="pcassi-porcent font-inte">{{number_format(($l->total * 100)/$b, 2)}}%</span></div>
                    <div class="progress-container w-full lg:w-72 bg-grisclaro rounded-full h-1.5 dark:bg-gray-700">
                      <div class="progress-content bg-azulassi h-1.5 rounded-full" style="width: {{($l->total * 100)/$b}}%"></div>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>

              <tbody class="text-negro90 text-xs bs">
                @foreach($gbs as $l)
                <tr class="border-b hover:bg-blue">
                  <td class="w-1/2 p-4">{{$l->site}}</td>
                  <td class="w-1/2 p-4">
                    <div><span class="pcassi-cant font-inter">{{$l->total}}</span> <span class="pcassi-porcent font-inte">{{number_format(($l->total * 100)/$bs, 2)}}%</span></div>
                    <div class="progress-container w-full lg:w-72 bg-grisclaro rounded-full h-1.5 dark:bg-gray-700">
                      <div class="progress-content bg-azulassi h-1.5 rounded-full" style="width: {{($l->total * 100)/$bs}}%"></div>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>

              <tbody class="text-negro90 text-xs bp" id="tbodybp">
                @foreach($gbp as $l)
                <tr class="border-b hover:bg-blue">
                  <td class="w-1/2 p-4">{{$l->site}}</td>
                  <td class="w-1/2 p-4">
                    <div><span class="pcassi-cant font-inter">{{$l->total}}</span> <span class="pcassi-porcent font-inte">{{number_format(($l->total * 100)/$bp, 2)}}%</span></div>
                    <div class="progress-container w-full lg:w-72 bg-grisclaro rounded-full h-1.5 dark:bg-gray-700">
                      <div class="progress-content bg-azulassi h-1.5 rounded-full" style="width: {{($l->total * 100)/$bp}}%"></div>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>


      </div>

      <!--Fin Panel Regist x serv-->

    </div>

  </div>
  </div>

</body>

</html>