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
use Illuminate\Support\Facades\File;
use Illuminate\Support\MessageBag;
use App\PermitsControl;
// use App\Filters\PermitsControlFilters;
// use App\User;

class PermitsControlController extends Controller{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    // public $routePath = "gerbang::permohonan";
    public $routePath = "backend::permitsControl";
    public $prefix = "backend.permitsControl";

    function __construct(){
        $this->themeBack = config('larakuy.theme_back');
        
        $this->prefix = 'backend.'.$this->themeBack.'.permitsControl';
    }

    public function index(Request $request){
        $data['page_name'] = "Permits Control";
        $data['page_description'] = "Tabel Data";
        $data['jenis_perizinan'] = ['Penyimpanan Limbah B3', 'Pengangkutan Limbah B3',
        'Pengolahan Limbah B3', 'Pengumpulan Limbah B3', 'Pemanfaatan Limbah B3',
        'Penimbunan Limbah B3', 'Dumping (Pembuangan Limbah B3)', 'Export'];
        $data['status'] = ['Sudah Tidak Berlaku', 'Masih Berlaku'];
        $data['sort_by'] = ['No Surat Keputusan', 'Tanggal Terbit', 'Tanggal Habis Berlaku', 'Jenis Perizinan'];
        $permits = new PermitsControl;
        $queries = [];
        if($request->has('cari')){
            $permits = $permits->where('nama_perusahaan','like', "%".$request->cari."%");
            
            $queries['nama_perusahaan'] = $request->cari;
        }
        if($request->has('jenis_perizinan')){
            $permits = $permits->where('jenis_perizinan', $data['jenis_perizinan'][$request->jenis_perizinan]);
            
            $queries['jenis_perizinan'] = $data['jenis_perizinan'][$request->jenis_perizinan];
        }
        
        if($request->has('status')){
            $permits = $permits->where('status_izin', $request->status);
            $queries['status'] = $request->status;
        }

        if($request->has('sort_by')){
            $sort = $request->sort_by;
        }else{
            $sort = 'tanggal_habis_berlaku';
        }

        if($request->has('sort')){
            $queries['sort'] = $request->sort;
        }else{
            $queries['sort'] = 'asc';
        }
        $permits = $permits->orderBy($sort, $request->sort);
        if(Auth::user()->isAdmin == 1){
            $model = $permits->where('plant_id', Auth::user()->plant_id)->paginate(10)->appends($queries);
        }else{
            $model = $permits->paginate(10)->appends($queries);
        }
        // $model = $permits->paginate(2)->appends($queries);
        
        // $model = PermitsControl::orderBy('id_permits', 'desc')->get();
        $data['data'] = $model;
        $data['filter'] = $queries; 
        // $data['allData'] = PermitsControl::filter($filters)->get();

        return view('backend.PermitsControl.index', $data);
    }

    public function add(){
        $data['page_name'] = "Permits Control B3";
        $data['page_description'] = "Penambahan Data";
        $data['jenis_perizinan'] = ['Penyimpanan Limbah B3', 'Pengangkutan Limbah B3',
        'Pengolahan Limbah B3', 'Pengumpulan Limbah B3', 'Pemanfaatan Limbah B3',
        'Penimbunan Limbah B3', 'Dumping (Pembuangan Limbah B3)', 'Export'];
        $data['dikeluarkan_oleh'] = ['Pusat', 'Provinsi', 'Kabupaten/Kota', 'OSS'];
        return view('backend.PermitsControl.add', $data);
    }

    public function save(Request $request){
        $jenis_perizinan = ['Penyimpanan Limbah B3', 'Pengangkutan Limbah B3',
        'Pengolahan Limbah B3', 'Pengumpulan Limbah B3', 'Pemanfaatan Limbah B3',
        'Penimbunan Limbah B3', 'Dumping (Pembuangan Limbah B3)', 'Export'];
        $dikeluarkan_oleh = ['Pusat', 'Provinsi', 'Kabupaten/Kota', 'OSS'];
        // return $request->status_izin;
        $this->validate($request, [
            "jenis_perizinan" => 'required|int',
            "nama_perusahaan" => 'required|string',
            "status_izin" => 'required',
            "dikeluarkan_oleh" => 'required|int',
            "no_surat_keputusan" => 'required|string',
            "tanggal_terbit_izin" => 'required|date',
            "tanggal_habis_izin" => 'required|date',
            "lampiran_dokumen" => 'required|mimes:pdf',
        ]);

        $lampiran = $request->file('lampiran_dokumen');
        $nama_lampiran = str_replace(array(".","/"),"",$request->no_surat_keputusan)."_".str_replace(" ","_",$lampiran->getClientOriginalName());
        $lampiran->move(public_path("uploads/LampiranPermitsControl/"), $nama_lampiran);
        $request->request->add([
            'nama_lampiran_dokumen' => 'uploads/LampiranPermitsControl/'.$nama_lampiran
        ]);

        $PermitsControl = new PermitsControl;
        $PermitsControl->jenis_perizinan = $jenis_perizinan[$request->jenis_perizinan];
        $PermitsControl->nama_perusahaan = $request->nama_perusahaan;
        $PermitsControl->status_izin = $request->status_izin;
        $PermitsControl->dikeluarkan_oleh = $dikeluarkan_oleh[$request->dikeluarkan_oleh];
        $PermitsControl->no_surat_keputusan = $request->no_surat_keputusan;
        $PermitsControl->tanggal_terbit = $request->tanggal_terbit_izin;
        $PermitsControl->tanggal_habis_berlaku = $request->tanggal_habis_izin;
        $PermitsControl->lampiran_dokumen = $request->nama_lampiran_dokumen;
        $PermitsControl->plant_id = Auth::user()->plant_id;
        // return $PermitsControl;
        $PermitsControl->save();

        return redirect()->route($this->routePath)->with('success', "Data berhasil di simpan.");
    }

    public function edit($id){
        $data['page_name'] = "Penyimpanan Limbah B3";
        $data['page_description'] = "Penambahan Data";
        $data['jenis_perizinan'] = ['Penyimpanan Limbah B3', 'Pengangkutan Limbah B3',
        'Pengolahan Limbah B3', 'Pengumpulan Limbah B3', 'Pemanfaatan Limbah B3',
        'Penimbunan Limbah B3', 'Dumping (Pembuangan Limbah B3)', 'Export'];
        $data['dikeluarkan_oleh'] = ['Pusat', 'Provinsi', 'Kabupaten/Kota', 'OSS'];
        $data['data'] = PermitsControl::findOrFail($id);

        // return $data;

        return view('backend.PermitsControl.edit', $data); 
    }

    public function update($id, Request $request){
        $jenis_perizinan = ['Penyimpanan Limbah B3', 'Pengangkutan Limbah B3',
        'Pengolahan Limbah B3', 'Pengumpulan Limbah B3', 'Pemanfaatan Limbah B3',
        'Penimbunan Limbah B3', 'Dumping (Pembuangan Limbah B3)', 'Export'];
        $dikeluarkan_oleh = ['Pusat', 'Provinsi', 'Kabupaten/Kota', 'OSS'];
        $this->validate($request, [
            "jenis_perizinan" => 'required|int',
            "nama_perusahaan" => 'required|string',
            "status_izin" => 'required',
            "dikeluarkan_oleh" => 'required|int',
            "no_surat_keputusan" => 'required|string',
            "tanggal_terbit_izin" => 'required|date',
            "tanggal_habis_izin" => 'required|date',
            "lampiran_dokumen" => 'mimes:pdf',
        ]);

        $PermitsControl = PermitsControl::findOrFail($id);

        if($request->lampiran_dokumen_baru){
            $lampiran = $request->file('lampiran_dokumen');
            $nama_lampiran = str_replace(array(".","/"),"",$request->no_surat_keputusan)."_".str_replace(" ","_",$lampiran->getClientOriginalName());
            $lampiran->move(public_path("uploads/LampiranPermitsControl/"), $nama_lampiran);
            $request->request->add([
                'nama_lampiran_dokumen' => 'uploads/LampiranPermitsControl/'.$nama_lampiran
            ]);
            $PermitsControl->lampiran_dokumen = $request->nama_lampiran_dokumen;
        }

        $PermitsControl->jenis_perizinan = $jenis_perizinan[$request->jenis_perizinan];
        $PermitsControl->nama_perusahaan = $request->nama_perusahaan;
        $PermitsControl->status_izin = $request->status_izin;
        $PermitsControl->dikeluarkan_oleh = $dikeluarkan_oleh[$request->dikeluarkan_oleh];
        $PermitsControl->no_surat_keputusan = $request->no_surat_keputusan;
        $PermitsControl->tanggal_terbit = $request->tanggal_terbit_izin;
        $PermitsControl->tanggal_habis_berlaku = $request->tanggal_habis_izin;
        // return $PermitsControl;
        $PermitsControl->save();
        return redirect()->route($this->routePath)->with('success', "Data berhasil diupdate.");
    }

    public function delete($id, Request $request){
        $data = PermitsControl::findOrFail($id);

        // delete datanya smentara
        $files = $data->laporan_dokumen;
        if(File::exists($files)){
            File::delete($files);
        }
        
        $data->delete();        

        return redirect()->route($this->routePath)->with('success', "Data berhasil di hapus.");
    }

    public function download($id){
        $data = PermitsControl::findOrFail($id);

        if($data->lampiran_dokumen){
            $headers = array(
                'Content-Type: application/pdf',
            );
            return response()->download($data->lampiran_dokumen, $data->no_surat_keputusan.".pdf", $headers);
        }else{
            return redirect($data->lampiran_dokumen);
        }  
    }
}