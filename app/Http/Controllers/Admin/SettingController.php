<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Setting;


class SettingController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $settings = [];
        $dbsettings = Setting::get();

        //Organiza todas as propriedades do banco em $settings para enviar para a view no Return abaixo
        foreach($dbsettings as $dbsetting){
            $settings[$dbsetting['name']] = $dbsetting['content'];
        }
       
        return view('admin.settings.index', [
            'settings' => $settings
        ]);
    }

    public function save(Request $request){
        $data = $request->only([
            'title', 'subtitle', 'email', 'bgcolor', 'textcolor'
        ]);

        $validator = $this->validator($data);

        if($validator->fails()){
            return redirect()->route('settings')
                ->withErrors($validator);
        }

        // Por se tratar de um array tem que salvar um por um
        foreach($data as $item => $value){
            Setting::where('name', $item)->update([
                'content' => $value
            ]);
        }

        return redirect()->route('settings')
            ->with('warning', 'Alteração realizada com sucesso!');
    }

    protected function validator($data){
        return Validator::make($data, [
            'title'    => ['string', 'max:100'],
            'subtitle' => ['string', 'max:100'],
            'email'    => ['string', 'email'],
            'bgcolor'  => ['string', 'regex:/#[A-Z0-9]{6}/i'],//regex validador para valor de cor em hexadecimal
            'textcolor'=> ['string', 'regex:/#[A-Z0-9]{6}/i']
        ]);
    }
}
