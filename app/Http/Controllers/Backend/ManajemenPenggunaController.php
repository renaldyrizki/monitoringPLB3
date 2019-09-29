<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\user;

class ManajemenPenggunaController extends Controller{
    public $routePath = "backend::manajemenPengguna";
    public $prefix = "backend.ManajemenPengguna";

    function __construct(){
        $this->themeBack = config('larakuy.theme_back');
        
        $this->prefix = 'backend.'.$this->themeBack.'.manajemenPengguna';
    }

    public function index(Request $request){
        $data['page_name'] = "Manajemen Pengguna";
        $data['page_description'] = "List Pengguna";

        $data['plant'] = [
            'P2 - Engine Plant',
            'P3 - Casting Plant',
            'P5 - Karawang Assembly Plant'
        ];

        $model = User::where('name', 'like' , "%".$request->kata_kunci."%")->orWhere('name', 'like' , "%".$request->kata_kunci."%")->paginate(2);
        $data['data'] = $model;
        
        // return $queries;
        return view($this->prefix.'.index', $data);
    }

    public function add(){
        $data['page_name'] = "Manajemen Pengguna";
        $data['page_description'] = "Penambahan Data";
        $data['plant'] = [
            'P2 - Engine Plant',
            'P3 - Casting Plant',
            'P5 - Karawang Assembly Plant'
        ];

        return view($this->prefix.'.add', $data);
    }

    public function save(Request $request){
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'npk' => 'required|string',
            'password' => 'required|string|min:6',
            "isAdmin" => 'required',
            "plant_id" => 'required'
        ]);
        
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->npk = $request->npk;
        $user->password = bcrypt($request->password);
        $user->isAdmin = $request->isAdmin;
        $user->plant_id = $request->plant_id;
        $user->save();

        return redirect()->route($this->routePath)->with('success', "Data berhasil di simpan.");
    }

    public function edit($id){
        $data['page_name'] = "Manajemen Pengguna";
        $data['page_description'] = "Ubah Data";

        $data['plant'] = [
            'P2 - Engine Plant',
            'P3 - Casting Plant',
            'P5 - Karawang Assembly Plant'
        ];

        $data['data'] = User::findOrFail($id);

        return view($this->prefix.'.edit', $data);
    }

    public function update($id, Request $request){
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'npk' =>  'required|string',
            "isAdmin" => 'required',
            "plant_id" => 'required'
        ]);
        
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->npk = $request->npk;
        $user->isAdmin = $request->isAdmin;
        $user->plant_id = $request->plant_id;
        $user->save();

        return redirect()->route($this->routePath)->with('success', "Data berhasil di ubah.");
    }

    public function delete($id, Request $request){
        $data = User::findOrFail($id);

        // delete datanya smentara
        $data->delete();

        return redirect()->route($this->routePath)->with('success', "Data berhasil di hapus.");
    }
}