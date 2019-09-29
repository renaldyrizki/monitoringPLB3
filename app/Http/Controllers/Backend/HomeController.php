<?php
namespace App\Http\Controllers\Backend;

/*
 * @Author      : Ferdhika Yudira 
 * @Date        : 2017-07-18 14:17:32 
 * @Web         : http://dika.web.id
 * @FileName    : HomeController.php
 */

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\PermitsControl;
use App\Truck;
use App\mouControl;
class HomeController extends Controller{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    // public $routePath = "gerbang::permohonan";

    public function index(){
        $data['page_name'] = "Dashboard";
        $data['page_description'] = "Control panel";
        $truck = [];
        $permits = [];
        $mou = [];
        $data = mouControl::get();
        $mou['ok'] = 0;
        $mou['warning'] = 0;
        $mou['expired'] = 0;
        foreach ($data as $key => $value) {
            $habis = date("Y-m-d", strtotime($value->tanggal_habis_berlaku_kontrak));
            $batas = date("Y-m-d", strtotime("-2 month", strtotime($value->tanggal_habis_berlaku_kontrak)));
            $hariIni = date("Y-m-d", strtotime("now"));
            if( ($hariIni > $batas) and ($hariIni <= $habis)){
                $mou['warning'] = $mou['warning'] + 1;
            }elseif($hariIni > $habis){
                $mou['expired'] = $mou['expired'] + 1;
            }elseif($hariIni <= $batas){
                $mou['ok'] = $mou['ok'] + 1;
            }
        }
        if(count($data) > 0){
            $mou['total'] = $key+1;
        }else{
            $mou['total'] = 0;
        }

        $data = PermitsControl::get();
        $permits['ok'] = 0;
        $permits['warning'] = 0;
        $permits['expired'] = 0;
        foreach ($data as $key => $value) {
            $habis = date("Y-m-d", strtotime($value->tanggal_habis_berlaku));
            $batas = date("Y-m-d", strtotime("-2 month", strtotime($value->tanggal_habis_berlaku)));
            $hariIni = date("Y-m-d", strtotime("now"));
            if( ($hariIni > $batas) and ($hariIni <= $habis)){
                $permits['warning'] = $permits['warning'] + 1;
            }elseif($hariIni > $habis){
                $permits['expired'] = $permits['expired'] + 1;
            }elseif($hariIni <= $batas){
                $permits['ok'] = $permits['ok'] + 1;
            }
        }
        if(count($data) > 0){
            $permits['total'] = $key+1;
        }else{
            $permits['total'] = 0;
        }
        
        $data = Truck::get();
        $truck['ok'] = 0;
        $truck['warning'] = 0;
        $truck['expired'] = 0;
        $truck['notsubmitted'] = 0;
        foreach ($data as $key => $value) {
            if ($value->kartu_pengawasan_tanggal_habis and $value->kartu_pengawasan_tanggal_terbit) {
                $habis = date("Y-m-d", strtotime($value->kartu_pengawasan_tanggal_habis));
                $batas = date("Y-m-d", strtotime("-2 month", strtotime($value->kartu_pengawasan_tanggal_habis)));
                $hariIni = date("Y-m-d", strtotime("now"));
                if( ($hariIni > $batas) and ($hariIni <= $habis)){
                    $truck['warning'] = $truck['warning'] + 1;
                }elseif($hariIni > $habis){
                    $truck['expired'] = $truck['expired'] + 1;
                }elseif($hariIni <= $batas){
                    $truck['ok'] = $truck['ok'] + 1;
                }
            } else {
                $truck['notsubmitted'] = $truck['notsubmitted']+1;
            }
        }
        if(count($data) > 0){
            $truck['total'] = $key+1;
        }else{
            $truck['total'] = 0;
        }
        $data = [];
        $data['truck'] = $truck;
        $data['permits'] = $permits;
        $data['mou'] = $mou;

        // return $data['permits'];

        return view('backend.dashboard', $data);
    }

    public function about(){
        $data['page_name'] = "About";
        $data['page_description'] = "About panel";

        return view('backend.about', $data);
    }

    public function permitsControl(){
        $data['page_name'] = "Permits Control";
        $data['page_description'] = "About panel";

        return view('backend.permitsControl', $data);
    }

    public function mouControl(){
        $data['page_name'] = "Mou Control";
        $data['page_description'] = "About panel";

        return view('backend.mouControl', $data);
    }

    public function truckPermits(){
        $data['page_name'] = "Truck Permits";
        $data['page_description'] = "About panel";
        $data['jenis_kendaraan'] = ["jenis1", "jenis2"];

        return view('backend.TruckPermits.form', ['data' => $data]);
    }
}