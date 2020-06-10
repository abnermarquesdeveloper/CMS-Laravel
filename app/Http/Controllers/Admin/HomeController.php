<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Visitor;
use App\User;
use App\Page;

class HomeController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }


    public function index(Request $request){
        $visitsCount = 0;
        $onlineCount = 0;
        $pageCount = 0;
        $userCount = 0;

        $interval = intval($request->input('interval', 30));
        if($interval > 120){
            $interval = 120;
        }

        //Contagem de visitantes
        $dateInterval = date('Y-m-d H:i:s', strtotime('-'.$interval.'days'));
        $visitsCount = Visitor::where('date_access', '>=', $dateInterval)->count();

        //Contagens de usuários online
        $datelimit = date('Y-m-d H:i:s', strtotime('-5 minutes'));
        $onlineList = Visitor::select('ip')->where('date_access','>=', $datelimit)->groupBy('ip')->get(); //gruupBy para saber quantos usuários distintos estão online no momento e/ou até pelo menos 5 minutos atrás
        $onlineCount = count($onlineList);

        //Contagem de páginas
        $pageCount = Page::count();


        //Contagem de usuários
        $userCount = User::count();

        //Fazendo a contagem e pegando os dados e gerando um "Json_Encode" para preencher o gráfico "pie (pizza)" na view
        $pagepie = [];
        $visitsAll = Visitor::selectRaw('page, count(page) as c')
                        ->where('date_access', '>=', $dateInterval)
                        ->groupBy('page')->get();
       
        foreach($visitsAll as $visit){
            $pagepie[$visit['page']] = intval($visit['c']);
        }

        //Gera um array Json com apenas as Chaves de $pagepie
        $pageLabels = json_encode(array_keys($pagepie));

        //Gera um array Json com apenas os valores de $pagepie
        $pagesValues = json_encode(array_values($pagepie));
        
        return view ('admin.home', [
            'visitsCount' => $visitsCount,
            'onlineCount' => $onlineCount,
            'pageCount'   => $pageCount,
            'userCount'   => $userCount,
            'pageLabels'  => $pageLabels,
            'pageValues'  => $pagesValues,
            'dateInterval'=> $interval
        ]);
    }
}
