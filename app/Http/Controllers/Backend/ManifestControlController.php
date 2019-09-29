<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\pengangkutanLimbah;

class ManifestControlController extends Controller{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    // public $routePath = "gerbang::permohonan";

    public $routePath = "backend::manifestControl";
    public $prefix = "backend.manifestControl";

    function __construct(){
        $this->themeBack = config('larakuy.theme_back');
        
        $this->prefix = 'backend.'.$this->themeBack.'.manifestControl';
    }

    public function index(Request $request){
        $data['page_name'] = "Manifest Control";
        $data['page_description'] = "List Manifest";
        $data['status'] = ['Diterima', 'Belum Diterima'];
        $data['sort_by'] = ['Tanggal Pengangkutan', 'Jenis Limbah', 'Perusahaan Pemanfaat'];
        $pengangkutan = new pengangkutanLimbah;
        $queries = [];
        // return "hai";
        if($request->has('kata_kunci')){
            $pengangkutan = $pengangkutan->where('perusahaan_pengangkut','like', "%".$request->kata_kunci."%");
            
            $queries['kata_kunci'] = $request->kata_kunci;
        }
        if($request->has('nomor_manifest')){
            $pengangkutan = $pengangkutan->where('nomor_manifest','like', "%".$request->nomor_manifest."%");
            
            $queries['nomor_manifest'] = $request->cari;
        }
        if($request->has('status')){
            $pengangkutan = $pengangkutan->where('status_pengangkutan', $request->status);
            $queries['status'] = $request->status;
        }

        if($request->has('sort_by')){
            if($request->sort_by == 'perusahaan_pemanfaat'){
                $request->sort_by = 'perusahaan_pengangkut';
            }
            $sort = $request->sort_by;
        }else{
            $sort = 'tanggal_pengangkutan';
        }

        if($request->has('sort')){
            $queries['sort'] = $request->sort;
        }else{
            $queries['sort'] = 'asc';
        }
        $pengangkutan = $pengangkutan->orderBy($sort, $request->sort);
        if(Auth::user()->isAdmin == 1){
            $model = $pengangkutan->where('plant_id', Auth::user()->plant_id)->paginate(10)->appends($queries);
        }else{
            $model = $pengangkutan->paginate(10)->appends($queries);
        }
        
        $data['data'] = $model;
        $data['queries'] = $queries; 
        
        // return $queries;
        return view('backend.ManifestControl.index', $data);
    }

    public function edit($id){
        $data['page_name'] = "Manifest Control";
        $data['page_description'] = "Update Data";
        $data['jenis_limbah'] = ['Majun atau Sarung Tangan Terkontaminasi B3 (B110d)', 
                                 'Electronic Waste (B107d)', 'Gram Besi (A345-2)',
                                 'Gram Aluminium (A345-2)', 'Aki Bekas (A110d)',
                                 'Limbah Medis (A337-1)', 'Kemasan Bekas Terkontaminasi B3 (B104d)',
                                 'Slope Oil (A323-3)', 'Toner Bekas (B353-1)',
                                 'Filter Bekas (B110d)', 'Coolant Bekas (A345-1)'];
        $data['satuan'] = ['KG', 'Drum', 'Pcs'];
        $data['data'] = pengangkutanLimbah::findOrFail($id);
        // return $data;
        return view('backend.ManifestControl.edit', $data); 
    }

    public function update($id, Request $request){
        $jenis_limbah = ['Majun atau Sarung Tangan Terkontaminasi B3 (B110d)', 
        'Electronic Waste (B107d)', 'Gram Besi (A345-2)',
        'Gram Aluminium (A345-2)', 'Aki Bekas (A110d)',
        'Limbah Medis (A337-1)', 'Kemasan Bekas Terkontaminasi B3 (B104d)',
        'Slope Oil (A323-3)', 'Toner Bekas (B353-1)',
        'Filter Bekas (B110d)', 'Coolant Bekas (A345-1)'];
        $cek = $this->validate($request, [
            // "jenis_limbah" => 'required',
            // "tanggal_pengangkutan" => 'required|date',
            // "total_pengangkutan" => 'required|int',
            // "nomor_manifest" => 'required|string',
            // "perusahaan_pengangkut" => 'required|string',
            // "tujuan_pemanfaatan" => 'required|string',
            "status_pengangkutan" => 'required|string',
            // "satuan" => 'required|in:' . implode(',', ['KG', 'Drum', 'Pcs']),
        ]);
        
        // return $request->jenis_limbah;

        $pengangkutanLimbah = pengangkutanLimbah::findOrFail($id);
        // $pengangkutanLimbah->jenis_limbah = $jenis_limbah[$request->jenis_limbah];
        // $pengangkutanLimbah->tanggal_pengangkutan = $request->tanggal_pengangkutan;
        // $pengangkutanLimbah->total_pengangkutan = $request->total_pengangkutan;
        // $pengangkutanLimbah->nomor_manifest = $request->nomor_manifest;
        // $pengangkutanLimbah->perusahaan_pengangkut = $request->perusahaan_pengangkut;
        // $pengangkutanLimbah->tujuan_pemanfaatan = $request->tujuan_pemanfaatan;
        if($request->status_pengangkutan == 'Diterima'){
            $pengangkutanLimbah->status_pengangkutan = TRUE;
        } else {
            $pengangkutanLimbah->status_pengangkutan = FALSE;
        }

        // return $pengangkutanLimbah;
        
        $pengangkutanLimbah->save();

        return redirect()->route($this->routePath)->with('success', "Data berhasil diupdate.");
    }

    public function delete($id, Request $request){
        $data = pengangkutanLimbah::findOrFail($id);

        // delete datanya smentara
        $data->delete();

        return redirect()->route($this->routePath)->with('success', "Data berhasil di hapus.");
    }
}