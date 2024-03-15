<?php

namespace App\Http\Controllers;
use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{fwall,User,diario};

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //return view('home');
        
        $adm=Auth::user()->adm;
        $us=Auth::user()->name;
        if($adm=='1'){
            return redirect()->route('lista.index');
        }else{
        return redirect()->route('home.show', $us);
        }
    }

    public function show($us)
    {
        $fwall = $us;
    //Lista de sitios
    $lb=fwall::where('userId', $fwall)->orderByDesc('id')->take(200)->get();
    $toplb=DB::table('fwalls')->select('site', DB::raw('count(*) as total'))->where('userId', $fwall)->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 2 week)'))->groupBy('site')->orderBy('total', 'desc')->take(4)->get();
    //Cantidad total de bloqueos por categoría
    $b=fwall::where('userId', $fwall)->where('block','b')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 2 week)'))->get()->count();
    $bs=fwall::where('userId', $fwall)->where('block','bs')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 2 week)'))->get()->count();
    $bp=fwall::where('userId', $fwall)->where('block','bp')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 2 week)'))->get()->count();
    //ProgreeBar-cantidad por sitio
    $gb=DB::table('fwalls')->select('site', DB::raw('count(*) as total'))->where('userId', $fwall)->where('block','b')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 2 week)'))->groupBy('site')->orderBy('total', 'desc')->get();
    $gbs=DB::table('fwalls')->select('site', DB::raw('count(*) as total'))->where('userId', $fwall)->where('block','bs')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 2 week)'))->groupBy('site')->orderBy('total', 'desc')->get();
    $gbp=DB::table('fwalls')->select('site', DB::raw('count(*) as total'))->where('userId', $fwall)->where('block','bp')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 2 week)'))->groupBy('site')->orderBy('total', 'desc')->get();
    //Porcentaje de cada categoría de bloqueo sobre el total, si no hay bloqueos no se puede dividir por 0
    $tb=$b+$bs+$bp;
    if ($tb==0){
        $br=0;
        $bsr=0;
        $bpr=0;
    }else{
        $br=$b*100/$tb;
        $bsr=$bs*100/$tb;
        $bpr=$bp*100/$tb;
    }
    //Grafico Semanal
    $inicio=\Carbon\Carbon::now()->subWeek(2)->format('Y-m-d');
    $ahora=\Carbon\Carbon::now()->format('Y-m-d');
    $d=diario::all()->where('userId', $fwall)->whereBetween('dia', array($inicio,$ahora))->sortBy('dia');
    //Grupo por IPs de la semana
    $ips=DB::table('fwalls')->select('ipClient',DB::raw('count(*) as total'))->where('userId', $fwall)->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 2 week)'))->groupBy('ipClient')->get();
    //totales de ips filtrada por usuario
    $qip=DB::table('fwalls')->select('ipClient')->where('userId', $fwall)->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 2 week)'))->groupBy('ipClient')->distinct()->get()->count();
    //info del usuario del dash
    $us=DB::table('users')->select('name', 'email')->where('name',$fwall)->first();
    //Sitios bloqueados en 24 Hs
    $sites=DB::table('fwalls')->select('site')->where('userId', $fwall)->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 2 week)'))->groupBy('site')->distinct()->get()->count();
    return view('userDash', ['lb'=>$lb,'toplb'=>$toplb, 'd'=>$d, 'gb'=>$gb, 'gbs'=>$gbs, 'gbp'=>$gbp, 'ips'=>$ips])
        ->with('us', $us) // Info del usuario
        ->with('tb', $tb) // Total de bloqueos
        ->with('qip', $qip) // Total de ip de los usuarios
        ->with('sites', $sites) // Total Sitios Bloqueados
        ->with('b', $b) // Total de Bloqueo/Servicio
        ->with('bs', $bs) // Total Malware
        ->with('bp', $bp) // Total Parental
        ->with('br', $br) // Relativo Bloqueo/Servicio
        ->with('bsr', $bsr) // Relativo Malware
        ->with('bpr', $bpr) // Relativo Parental
        ->with('rt', "../")
        ;
    }

    public function show2(Request $request)
    {
        $fwall = $request->clientId;
        //Lista de sitios
        $lb=fwall::where('userId', $fwall)->orderByDesc('id')->take(200)->get();
        $toplb=DB::table('fwalls')->select('site', DB::raw('count(*) as total'))->where('userId', $fwall)->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 2 week)'))->groupBy('site')->orderBy('total', 'desc')->take(4)->get();
        //Cantidad total de bloqueos por categoría
        $b=fwall::where('userId', $fwall)->where('block','b')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 2 week)'))->get()->count();
        $bs=fwall::where('userId', $fwall)->where('block','bs')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 2 week)'))->get()->count();
        $bp=fwall::where('userId', $fwall)->where('block','bp')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 2 week)'))->get()->count();
        //ProgreeBar-cantidad por sitio
        $gb=DB::table('fwalls')->select('site', DB::raw('count(*) as total'))->where('userId', $fwall)->where('block','b')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 2 week)'))->groupBy('site')->orderBy('total', 'desc')->get();
        $gbs=DB::table('fwalls')->select('site', DB::raw('count(*) as total'))->where('userId', $fwall)->where('block','bs')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 2 week)'))->groupBy('site')->orderBy('total', 'desc')->get();
        $gbp=DB::table('fwalls')->select('site', DB::raw('count(*) as total'))->where('userId', $fwall)->where('block','bp')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 2 week)'))->groupBy('site')->orderBy('total', 'desc')->get();
        //Porcentaje de cada categoría de bloqueo sobre el total, si no hay bloqueos no se puede dividir por 0
        $tb=$b+$bs+$bp;
        if ($tb==0){
            $br=0;
            $bsr=0;
            $bpr=0;
        }else{
            $br=$b*100/$tb;
            $bsr=$bs*100/$tb;
            $bpr=$bp*100/$tb;
        }
        //Grafico Semanal
        $inicio=\Carbon\Carbon::now()->subWeek(2)->format('Y-m-d');
        $ahora=\Carbon\Carbon::now()->format('Y-m-d');
        $d=diario::all()->where('userId', $fwall)->whereBetween('dia', array($inicio,$ahora))->sortBy('dia');
        //Grupo por IPs de la semana
        $ips=DB::table('fwalls')->select('ipClient',DB::raw('count(*) as total'))->where('userId', $fwall)->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 2 week)'))->groupBy('ipClient')->get();
        //totales de ips filtrada por usuario
        $qip=DB::table('fwalls')->select('ipClient')->where('userId', $fwall)->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 2 week)'))->groupBy('ipClient')->distinct()->get()->count();
        //info del usuario del dash
        $us=DB::table('users')->select('name', 'email')->where('name',$fwall)->first();
        //Sitios bloqueados en 24 Hs
        $sites=DB::table('fwalls')->select('site')->where('userId', $fwall)->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 2 week)'))->groupBy('site')->distinct()->get()->count();
        return view('userDash', ['lb'=>$lb,'toplb'=>$toplb, 'd'=>$d, 'gb'=>$gb, 'gbs'=>$gbs, 'gbp'=>$gbp, 'ips'=>$ips])
            ->with('us', $us) // Info del usuario
            ->with('tb', $tb) // Total de bloqueos
            ->with('qip', $qip) // Total de ip de los usuarios
            ->with('sites', $sites) // Total Sitios Bloqueados
            ->with('b', $b) // Total de Bloqueo/Servicio
            ->with('bs', $bs) // Total Malware
            ->with('bp', $bp) // Total Parental
            ->with('br', $br) // Relativo Bloqueo/Servicio
            ->with('bsr', $bsr) // Relativo Malware
            ->with('bpr', $bpr) // Relativo Parental
            ->with('rt', "")
            ;
    }
}
