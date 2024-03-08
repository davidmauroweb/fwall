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
        //ProgressBar-maximos
        $tgb=DB::table('fwalls')->select('site', DB::raw('count(*) as total'))->where('userId', $fwall)->where('block','b')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->groupBy('site')->orderBy('total', 'desc')->first();
        $tgbs=DB::table('fwalls')->select('site', DB::raw('count(*) as total'))->where('userId', $fwall)->where('block','bs')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->groupBy('site')->orderBy('total', 'desc')->first();
        $tgbp=DB::table('fwalls')->select('site', DB::raw('count(*) as total'))->where('userId', $fwall)->where('block','bp')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->groupBy('site')->orderBy('total', 'desc')->first();
        //ProgreeBar-cantidad por sitio, top 6
        $gb=DB::table('fwalls')->select('site', DB::raw('count(*) as total'))->where('userId', $fwall)->where('block','b')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->groupBy('site')->orderBy('total', 'desc')->take(6)->get();
        $gbs=DB::table('fwalls')->select('site', DB::raw('count(*) as total'))->where('userId', $fwall)->where('block','bs')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->groupBy('site')->orderBy('total', 'desc')->take(6)->get();
        $gbp=DB::table('fwalls')->select('site', DB::raw('count(*) as total'))->where('userId', $fwall)->where('block','bp')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->groupBy('site')->orderBy('total', 'desc')->take(6)->get();
        //Lista de sitios
        $lb=fwall::where('userId', $fwall)->where('block','b')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->orderByDesc('id')->get();
        $lbs=fwall::where('userId', $fwall)->where('block','bs')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->orderByDesc('id')->get();
        $lbp=fwall::where('userId', $fwall)->where('block','bp')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->orderByDesc('id')->get();
        //Cantidad total de bloqueos por categoría
        $b=fwall::where('userId', $fwall)->where('block','b')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->get()->count();
        $bs=fwall::where('userId', $fwall)->where('block','bs')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->get()->count();
        $bp=fwall::where('userId', $fwall)->where('block','bp')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->get()->count();
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
        $inicio=\Carbon\Carbon::now()->subWeek()->format('Y-m-d');
        $ahora=\Carbon\Carbon::now()->format('Y-m-d');
        $d=diario::all()->where('userId', $fwall)->whereBetween('dia', array($inicio,$ahora))->sortBy('dia');
        //Grupo por IPs de la semana
        $ips=DB::table('fwalls')->select('ipClient',DB::raw('count(*) as total'))->where('userId', $fwall)->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->groupBy('ipClient')->get();
        return view('userDash', ['lb'=>$lb,'lbs'=>$lbs, 'lbp'=>$lbp, 'd'=>$d, 'gb'=>$gb, 'gbs'=>$gbs, 'gbp'=>$gbp, 'ips'=>$ips])
            ->with('userId', $fwall)
            ->with('b', $b)
            ->with('bs', $bs)
            ->with('bp', $bp)
            ->with('tb', $tb)
            ->with('br', $br)
            ->with('bsr', $bsr)
            ->with('bpr', $bpr)
            ->with('tgb', $tgb)
            ->with('tgbs', $tgbs)
            ->with('tgbp', $tgbp);
    }

    public function show2(Request $request)
    {
        $fwall = $request->clientId;
        //ProgressBar-maximos
        $tgb=DB::table('fwalls')->select('site', DB::raw('count(*) as total'))->where('userId', $fwall)->where('block','b')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->groupBy('site')->orderBy('total', 'desc')->first();
        $tgbs=DB::table('fwalls')->select('site', DB::raw('count(*) as total'))->where('userId', $fwall)->where('block','bs')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->groupBy('site')->orderBy('total', 'desc')->first();
        $tgbp=DB::table('fwalls')->select('site', DB::raw('count(*) as total'))->where('userId', $fwall)->where('block','bp')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->groupBy('site')->orderBy('total', 'desc')->first();
        //ProgreeBar-cantidad por sitio, top 6
        $gb=DB::table('fwalls')->select('site', DB::raw('count(*) as total'))->where('userId', $fwall)->where('block','b')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->groupBy('site')->orderBy('total', 'desc')->take(6)->get();
        $gbs=DB::table('fwalls')->select('site', DB::raw('count(*) as total'))->where('userId', $fwall)->where('block','bs')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->groupBy('site')->orderBy('total', 'desc')->take(6)->get();
        $gbp=DB::table('fwalls')->select('site', DB::raw('count(*) as total'))->where('userId', $fwall)->where('block','bp')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->groupBy('site')->orderBy('total', 'desc')->take(6)->get();
        //Lista de sitios
        $lb=fwall::where('userId', $fwall)->where('block','b')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->orderByDesc('id')->get();
        $lbs=fwall::where('userId', $fwall)->where('block','bs')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->orderByDesc('id')->get();
        $lbp=fwall::where('userId', $fwall)->where('block','bp')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->orderByDesc('id')->get();
        //Cantidad total de bloqueos por categoría
        $b=fwall::where('userId', $fwall)->where('block','b')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->get()->count();
        $bs=fwall::where('userId', $fwall)->where('block','bs')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->get()->count();
        $bp=fwall::where('userId', $fwall)->where('block','bp')->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->get()->count();
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
        $inicio=\Carbon\Carbon::now()->subWeek()->format('Y-m-d');
        $ahora=\Carbon\Carbon::now()->format('Y-m-d');
        $d=diario::all()->where('userId', $fwall)->whereBetween('dia', array($inicio,$ahora))->sortBy('dia');
        //Grupo por IPs de la semana
        $ips=DB::table('fwalls')->select('ipClient',DB::raw('count(*) as total'))->where('userId', $fwall)->where('time', '>', DB::raw('DATE_SUB(NOW(),INTERVAL 24 HOUR)'))->groupBy('ipClient')->get();
        return view('userDash', ['lb'=>$lb,'lbs'=>$lbs, 'lbp'=>$lbp, 'd'=>$d, 'gb'=>$gb, 'gbs'=>$gbs, 'gbp'=>$gbp, 'ips'=>$ips])
            ->with('userId', $fwall)
            ->with('b', $b)
            ->with('bs', $bs)
            ->with('bp', $bp)
            ->with('tb', $tb)
            ->with('br', $br)
            ->with('bsr', $bsr)
            ->with('bpr', $bpr)
            ->with('tgb', $tgb)
            ->with('tgbs', $tgbs)
            ->with('tgbp', $tgbp);
    }
}
