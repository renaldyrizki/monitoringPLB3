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
use App\pengangkutanLimbah;

class PengangkutanLimbahB3Controller extends Controller{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    // public $routePath = "gerbang::permohonan";
    public $routePath = "backend::pengangkutanLimbahB3";
    public $prefix = "backend.pengangkutanLimbahB3";

    function __construct(){
        $this->themeBack = config('larakuy.theme_back');
        
        $this->prefix = 'backend.'.$this->themeBack.'.pengangkutanLimbahB3';
    }

    public function index(){
        $data['page_name'] = "Pengangkutan Limbah B3";
        $data['page_description'] = "Tabel Data";
        $model = pengangkutanLimbah::paginate(2);
        $data['data'] = $model;
        $data['allData'] = pengangkutanLimbah::get();

        // return view('backend.TruckPermits.form', ['data' => $data]);
        return view('backend.PengangkutanLimbahB3.index', $data);
    }

    public function add(){
        $data['page_name'] = "Pengangkutan Limbah B3";
        $data['page_description'] = "Pengangkutan Data";
        $data['jenis_limbah'] = ['Majun atau Sarung Tangan Terkontaminasi B3 (B110d)', 
                                 'Electronic Waste (B107d)', 'Gram Besi (A345-2)',
                                 'Gram Aluminium (A345-2)', 'Aki Bekas (A110d)',
                                 'Limbah Medis (A337-1)', 'Kemasan Bekas Terkontaminasi B3 (B104d)',
                                 'Slope Oil (A323-3)', 'Toner Bekas (B353-1)',
                                 'Filter Bekas (B110d)', 'Coolant Bekas (A345-1)'];
        $data['satuan'] = ['KG', 'Drum', 'Pcs'];
        return view('backend.PengangkutanLimbahB3.add', $data);
    }

    public function save(Request $request){
        $jenis_limbah = ['Majun atau Sarung Tangan Terkontaminasi B3 (B110d)', 
        'Electronic Waste (B107d)', 'Gram Besi (A345-2)',
        'Gram Aluminium (A345-2)', 'Aki Bekas (A110d)',
        'Limbah Medis (A337-1)', 'Kemasan Bekas Terkontaminasi B3 (B104d)',
        'Slope Oil (A323-3)', 'Toner Bekas (B353-1)',
        'Filter Bekas (B110d)', 'Coolant Bekas (A345-1)'];
        
        // return $request;
        $cek = $this->validate($request, [
            "jenis_limbah" => 'required',
            "tanggal_pengangkutan" => 'required|date',
            "total_pengangkutan" => 'required|int',
            "nomor_manifest" => 'required|string',
            "perusahaan_pengangkut" => 'required|string',
            "tujuan_pemanfaatan" => 'required|string',
            // "status_pengangkutan" => 'required|int',
            // "satuan" => 'required|in:' . implode(',', ['KG', 'Drum', 'Pcs']),
        ]);

        // return $cek;
        
        // $user = User::findOrFail(Auth::user()->id);

        $pengangkutanLimbah = new pengangkutanLimbah;
        $pengangkutanLimbah->jenis_limbah = $jenis_limbah[$request->jenis_limbah];
        $pengangkutanLimbah->tanggal_pengangkutan = $request->tanggal_pengangkutan;
        $pengangkutanLimbah->total_pengangkutan = $request->total_pengangkutan;
        $pengangkutanLimbah->nomor_manifest = $request->nomor_manifest;
        $pengangkutanLimbah->perusahaan_pengangkut = $request->perusahaan_pengangkut;
        $pengangkutanLimbah->tujuan_pemanfaatan = $request->tujuan_pemanfaatan;
        $pengangkutanLimbah->status_pengangkutan = FALSE;
        
        // return $penyimpananLimbah;
        $cek1 = $pengangkutanLimbah->save();
        // return [$cek, $cek1];

        return redirect()->route($this->routePath)->with('success', "Data berhasil di simpan.");
        
        // return $pengangkutanLimbah;
        // return $pengangkutanLimbah[$request->jenis_limbah];
        
        // return $request->all();
    }

    public function edit($id){
        $data['page_name'] = "Penyimpanan Limbah B3";
        $data['page_description'] = "Penambahan Data";
        $data['jenis_limbah'] = ['Majun atau Sarung Tangan Terkontaminasi B3 (B110d)', 
                                 'Electronic Waste (B107d)', 'Gram Besi (A345-2)',
                                 'Gram Aluminium (A345-2)', 'Aki Bekas (A110d)',
                                 'Limbah Medis (A337-1)', 'Kemasan Bekas Terkontaminasi B3 (B104d)',
                                 'Slope Oil (A323-3)', 'Toner Bekas (B353-1)',
                                 'Filter Bekas (B110d)', 'Coolant Bekas (A345-1)'];
        $data['satuan'] = ['KG', 'Drum', 'Pcs'];
        $data['data'] = pengangkutanLimbah::findOrFail($id);
        // return $data;

        return view('backend.PengangkutanLimbahB3.edit', $data); 
    }

    public function update($id, Request $request){
        $jenis_limbah = ['Majun atau Sarung Tangan Terkontaminasi B3 (B110d)', 
        'Electronic Waste (B107d)', 'Gram Besi (A345-2)',
        'Gram Aluminium (A345-2)', 'Aki Bekas (A110d)',
        'Limbah Medis (A337-1)', 'Kemasan Bekas Terkontaminasi B3 (B104d)',
        'Slope Oil (A323-3)', 'Toner Bekas (B353-1)',
        'Filter Bekas (B110d)', 'Coolant Bekas (A345-1)'];
        
        $cek = $this->validate($request, [
            "jenis_limbah" => 'required',
            "tanggal_pengangkutan" => 'required|date',
            "total_pengangkutan" => 'required|int',
            "nomor_manifest" => 'required|string',
            "perusahaan_pengangkut" => 'required|string',
            "tujuan_pemanfaatan" => 'required|string',
            "status_pengangkutan" => 'required|string',
            // "satuan" => 'required|in:' . implode(',', ['KG', 'Drum', 'Pcs']),
        ]);

        $pengangkutanLimbah = pengangkutanLimbah::findOrFail($id);
        $pengangkutanLimbah->jenis_limbah = $jenis_limbah[$request->jenis_limbah];
        $pengangkutanLimbah->tanggal_pengangkutan = $request->tanggal_pengangkutan;
        $pengangkutanLimbah->total_pengangkutan = $request->total_pengangkutan;
        $pengangkutanLimbah->nomor_manifest = $request->nomor_manifest;
        $pengangkutanLimbah->perusahaan_pengangkut = $request->perusahaan_pengangkut;
        $pengangkutanLimbah->tujuan_pemanfaatan = $request->tujuan_pemanfaatan;
        if($request->status_pengangkutan == 'Diterima'){
            $pengangkutanLimbah->status_pengangkutan = TRUE;
        } else {
            $pengangkutanLimbah->status_pengangkutan = FALSE;
        }
        
        $pengangkutanLimbah->save();

        return redirect()->route($this->routePath)->with('success', "Data berhasil diupdate.");
    }

    public function delete($id, Request $request){
        $data = pengangkutanLimbah::findOrFail($id);

        // delete datanya smentara
        $data->delete();

        return redirect()->route($this->routePath)->with('success', "Data berhasil di hapus.");
    }

    public function logbookDownload(){
        $first_day_this_month = date('Y-m-01');
        $last_day_this_month  = date('Y-m-t');
        $data = pengangkutanLimbah::whereBetween('tanggal_pengangkutan', [$first_day_this_month, $last_day_this_month])->orderBy('jenis_limbah', 'ASC')->orderBy('tanggal_pengangkutan', 'ASC')->get();
        return $data;
    }
}