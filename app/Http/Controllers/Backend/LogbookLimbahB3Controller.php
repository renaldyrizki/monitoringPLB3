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
use DB;
// use App\User;
use App\penyimpananLimbah;
use App\pengangkutanLimbah;

class LogbookLimbahB3Controller extends Controller{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    // public $routePath = "gerbang::permohonan";
    public $routePath = "gerbang::logbookLimbahB3";
    public $prefix = "backend.logbookLimbahB3";

    function __construct(){
        $this->themeBack = config('larakuy.theme_back');
        
        $this->prefix = 'backend.'.$this->themeBack.'.logbookLimbahB3';
    }

    public function index(){
        $data['page_name'] = "Manifest Control";
        $data['page_description'] = "List Manifest";

        // return view('backend.TruckPermits.form', ['data' => $data]);
        return view('backend.ManifestControl.list', $data);
    }

    public function penyimpanan(){
        $data['page_name'] = "Penyimpanan Limbah B3";
        $data['page_description'] = "Penambahan Data";
        $data['jenis_limbah'] = ['Majun atau Sarung Tangan Terkontaminasi B3 (B110d)', 
                                 'Electronic Waste (B107d)', 'Gram Besi (A345-2)',
                                 'Gram Aluminium (A345-2)', 'Aki Bekas (A110d)',
                                 'Limbah Medis (A337-1)', 'Kemasan Bekas Terkontaminasi B3 (B104d)',
                                 'Slope Oil (A323-3)', 'Toner Bekas (B353-1)',
                                 'Filter Bekas (B110d)', 'Coolant Bekas (A345-1)'];
        $data['satuan'] = ['KG', 'Drum', 'Pcs'];
        return view('backend.LogBookData.PenyimpananLimbah.new', $data);
    }

    public function pengangkutan(){
        $data['page_name'] = "Limbah B3 yang Diangkut";
        $data['page_description'] = "Penambahan Data";
        $data['jenis_limbah'] = ['Majun atau Sarung Tangan Terkontaminasi B3 (B110d)', 
                                 'Electronic Waste (B107d)', 'Gram Besi (A345-2)',
                                 'Gram Aluminium (A345-2)', 'Aki Bekas (A110d)',
                                 'Limbah Medis (A337-1)', 'Kemasan Bekas Terkontaminasi B3 (B104d)',
                                 'Slope Oil (A323-3)', 'Toner Bekas (B353-1)',
                                 'Filter Bekas (B110d)', 'Coolant Bekas (A345-1)'];
        $data['satuan'] = ['KG', 'Drum', 'Pcs'];
        return view('backend.LogBookData.PengangkutanLimbah.new', $data);
    }

    public function penyimpanan_simpan(Request $request){
        
        $jenis_limbah = ['Majun atau Sarung Tangan Terkontaminasi B3 (B110d)', 
        'Electronic Waste (B107d)', 'Gram Besi (A345-2)',
        'Gram Aluminium (A345-2)', 'Aki Bekas (A110d)',
        'Limbah Medis (A337-1)', 'Kemasan Bekas Terkontaminasi B3 (B104d)',
        'Slope Oil (A323-3)', 'Toner Bekas (B353-1)',
        'Filter Bekas (B110d)', 'Coolant Bekas (A345-1)'];
        
        $this->validate($request, [
            "jenis_limbah" => 'required',
            "tanggal_penyimpanan" => 'required|date',
            "masa_simpan" => 'required|int',
            "sumber_limbah" => 'required|string',
            "total_penyimpanan" => 'required|int',
            "satuan" => 'required|in:' . implode(',', ['KG', 'Drum', 'Pcs']),
        ]);
        
        // $user = User::findOrFail(Auth::user()->id);

        $penyimpananLimbah = new penyimpananLimbah;
        $penyimpananLimbah->jenis_limbah = $jenis_limbah[$request->jenis_limbah];
        $penyimpananLimbah->tanggal_penyimpanan = $request->tanggal_penyimpanan;
        $penyimpananLimbah->masa_simpan = $request->masa_simpan;
        $penyimpananLimbah->sumber_limbah = $request->sumber_limbah;
        $penyimpananLimbah->total_penyimpanan = $request->total_penyimpanan;
        // $penyimpananLimbah->satuan = $request->satuan;
        // $penyimpananLimbah->status = $request->status;
        // $penyimpananLimbah->user()->associate($user);
        $penyimpananLimbah->save();

        return redirect()->route($this->routePath. ".index")->with('success', "Data berhasil di simpan.");
        
        // return $penyimpananLimbah;
        // return $jenis_limbah[$request->jenis_limbah];
        
        // return $request->all();
    }
}