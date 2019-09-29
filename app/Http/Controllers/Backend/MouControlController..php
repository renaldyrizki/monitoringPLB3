<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\MessageBag;
use App\PermitsControl;
// use App\Filters\PermitsControlFilters;
use App\mouControl;

class MouControlController extends Controller{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    // public $routePath = "gerbang::permohonan";
    public $routePath = "backend::mouControl";
    public $prefix = "backend.mouControl";

    function __construct(){
        $this->themeBack = config('larakuy.theme_back');
        
        $this->prefix = 'backend.'.$this->themeBack.'.mouControl';
    }

    public function index(Request $request){
        $data['page_name'] = "Mou Control";
        $data['page_description'] = "Tabel Data";
        $data['tipe_pengelolaan'] = ['Eksternal - Diolah', 
                                    'Eksternal - Dimanfaatkan', 'Eksternal - Ditimbun',
                                    'Eksternal - Pengumpulan', 'Penghasil ke Pihak Pengumpul',
                                    'Menerima dari Penghasil', 'Menerima dari Pengumpul', 
                                    'Menerima dari Pengolah', 'Menyerahkan ke Penimbun',
                                    'Menyerahkan ke Pengolah', 'Menerima ke Pemanfaat',
                                    'Menerima dari Pemanfaat', 'Menyerahkan ke Pengumpul'];

        $data['jenis_limbah'] = ['Majun atau Sarung Tangan Terkontaminasi B3 (B110d)', 
                                 'Electronic Waste (B107d)', 'Gram Besi (A345-2)',
                                 'Gram Aluminium (A345-2)', 'Aki Bekas (A110d)',
                                 'Limbah Medis (A337-1)', 'Kemasan Bekas Terkontaminasi B3 (B104d)',
                                 'Slope Oil (A323-3)', 'Toner Bekas (B353-1)',
                                 'Filter Bekas (B110d)', 'Coolant Bekas (A345-1)'];
        $data['status'] = ['Sudah Tidak Berlaku', 'Masih Berlaku'];
        $data['sort_by'] = ['Tipe Pengelolaan', 'Perusahaan Pengelola Lanjut', 'Nomor Kontrak', 'Tanggal Terbit Kontrak', 'Tanggal Habis Berlaku Kontrak'];
        // return ($data);
        $mou = new mouControl;
        $queries = [];
        if($request->has('kata_kunci')){
            $mou = $mou->where('perusahaan_pengelola_lanjut','like', "%".$request->kata_kunci."%");
            
            $queries['perusahaan_pengelola_lanjut'] = $request->cari;
        }
        if($request->has('nomor_kontrak')){
            $mou = $mou->where('nomor_kontrak', $request->nomor_kontrak);
            
            $queries['nomor_kontrak'] = $request->nomor_kontrak;
        }
        
        if($request->has('status')){
            $mou = $mou->where('status_kontrak', $request->status);
            $queries['status'] = $request->status;
        }

        if($request->has('sort_by')){
            $sort = $request->sort_by;
        }else{
            $sort = 'tanggal_habis_berlaku_kontrak';
        }

        if($request->has('sort')){
            $queries['sort'] = $request->sort;
        }else{
            $queries['sort'] = 'asc';
        }
        $mou = $mou->orderBy($sort, $request->sort);
        $model = $mou->paginate(2)->appends($queries);
        
        $data['data'] = $model;
        $data['filter'] = $queries; 

        return view('backend.MouControl.index', $data);
    }

    public function add(){
        $data['page_name'] = "Mou Control";
        $data['page_description'] = "Penambahan Data";
        $data['tipe_pengelolaan'] = ['Eksternal - Diolah', 
                                    'Eksternal - Dimanfaatkan', 'Eksternal - Ditimbun',
                                    'Eksternal - Pengumpulan', 'Penghasil ke Pihak Pengumpul',
                                    'Menerima dari Penghasil', 'Menerima dari Pengumpul', 
                                    'Menerima dari Pengolah', 'Menyerahkan ke Penimbun',
                                    'Menyerahkan ke Pengolah', 'Menerima ke Pemanfaat',
                                    'Menerima dari Pemanfaat', 'Menyerahkan ke Pengumpul'];

        $data['jenis_limbah'] = ['Majun atau Sarung Tangan Terkontaminasi B3 (B110d)', 
                                 'Electronic Waste (B107d)', 'Gram Besi (A345-2)',
                                 'Gram Aluminium (A345-2)', 'Aki Bekas (A110d)',
                                 'Limbah Medis (A337-1)', 'Kemasan Bekas Terkontaminasi B3 (B104d)',
                                 'Slope Oil (A323-3)', 'Toner Bekas (B353-1)',
                                 'Filter Bekas (B110d)', 'Coolant Bekas (A345-1)'];
        return view('backend.MouControl.add', $data);
    }

    public function save(Request $request){
        $data['tipe_pengelolaan'] = ['Eksternal - Diolah', 
                                    'Eksternal - Dimanfaatkan', 'Eksternal - Ditimbun',
                                    'Eksternal - Pengumpulan', 'Penghasil ke Pihak Pengumpul',
                                    'Menerima dari Penghasil', 'Menerima dari Pengumpul', 
                                    'Menerima dari Pengolah', 'Menyerahkan ke Penimbun',
                                    'Menyerahkan ke Pengolah', 'Menerima ke Pemanfaat',
                                    'Menerima dari Pemanfaat', 'Menyerahkan ke Pengumpul'];

        $data['jenis_limbah'] = ['Majun atau Sarung Tangan Terkontaminasi B3 (B110d)', 
                                    'Electronic Waste (B107d)', 'Gram Besi (A345-2)',
                                    'Gram Aluminium (A345-2)', 'Aki Bekas (A110d)',
                                    'Limbah Medis (A337-1)', 'Kemasan Bekas Terkontaminasi B3 (B104d)',
                                    'Slope Oil (A323-3)', 'Toner Bekas (B353-1)',
                                    'Filter Bekas (B110d)', 'Coolant Bekas (A345-1)'];
        // return $request->status_izin;
        $this->validate($request, [
            "tipe_pengelolaan" => 'required|int',
            "perusahaan_pengelola_lanjut" => 'required|string',
            "status_kontrak" => 'required|int',
            "jenis_limbah" => 'required',
            "surat_pernyataan_tidak_masalah" => 'required|mimes:pdf',

            "nomor_izin_perusahaan" => 'string|required',
            "tanggal_kontrak_perusahaan"=> 'date|required',
            "tanggal_habis_berlaku_perusahaan"=> 'date|required',
            "lampiran_perusahaan" => 'mimes:pdf|required',

            "nomor_kontrak" => 'string|required',
            "tanggal_terbit_kontrak"=> 'date|required',
            "tanggal_habis_berlaku_kontrak"=> 'date|required',
            "lampiran_kontrak" => 'mimes:pdf|required',
        ]);
        
        $MouControl = new MouControl;
        $MouControl->nomor_kontrak = $request->nomor_kontrak;
        $ListFile = array("surat_pernyataan_tidak_masalah", "lampiran_perusahaan", "lampiran_kontrak");
        
        foreach ($ListFile as $File) {
            if($request->file($File)){
                $lampiran = $request->file($File);
                $nama_lampiran = $request->nomor_kontrak."_".$File."_".str_replace(" ","_",$lampiran->getClientOriginalName());
                $lampiran->move(public_path("uploads/LampiranMouControl/"), $nama_lampiran);
                $request->request->add([
                    "nama_".$File => 'uploads/LampiranMouControl/'.$nama_lampiran
                ]);
                $MouControl[$File] = $request["nama_".$File];
            }
        }
        $jenis_limbah = "";
            foreach($request->jenis_limbah as $jl){
                $jenis_limbah = $jenis_limbah."_".$data['jenis_limbah'][$jl];
        }
        $MouControl->tipe_pengelolaan = $data['tipe_pengelolaan'][$request->tipe_pengelolaan];
        $MouControl->perusahaan_pengelola_lanjut = $request->perusahaan_pengelola_lanjut;
        $MouControl->status_kontrak = $request->status_kontrak;
        $MouControl->jenis_limbah = $jenis_limbah;
        $MouControl->nomor_izin_perusahaan = $request->nomor_izin_perusahaan;
        $MouControl->tanggal_kontrak_perusahaan = $request->tanggal_kontrak_perusahaan;
        $MouControl->tanggal_habis_berlaku_perusahaan = $request->tanggal_habis_berlaku_perusahaan;
        $MouControl->nomor_kontrak = $request->nomor_kontrak;
        $MouControl->tanggal_terbit_kontrak = $request->tanggal_terbit_kontrak;
        $MouControl->tanggal_habis_berlaku_kontrak = $request->tanggal_habis_berlaku_kontrak;
        $MouControl->save();

        return redirect()->route($this->routePath)->with('success', "Data berhasil di simpan.");
    }

    public function edit($id){
        $data['page_name'] = "Penyimpanan Limbah B3";
        $data['page_description'] = "Penambahan Data";
        $data['tipe_pengelolaan'] = ['Eksternal - Diolah', 
                                    'Eksternal - Dimanfaatkan', 'Eksternal - Ditimbun',
                                    'Eksternal - Pengumpulan', 'Penghasil ke Pihak Pengumpul',
                                    'Menerima dari Penghasil', 'Menerima dari Pengumpul', 
                                    'Menerima dari Pengolah', 'Menyerahkan ke Penimbun',
                                    'Menyerahkan ke Pengolah', 'Menerima ke Pemanfaat',
                                    'Menerima dari Pemanfaat', 'Menyerahkan ke Pengumpul'];

        $data['jenis_limbah'] = ['Majun atau Sarung Tangan Terkontaminasi B3 (B110d)', 
                                 'Electronic Waste (B107d)', 'Gram Besi (A345-2)',
                                 'Gram Aluminium (A345-2)', 'Aki Bekas (A110d)',
                                 'Limbah Medis (A337-1)', 'Kemasan Bekas Terkontaminasi B3 (B104d)',
                                 'Slope Oil (A323-3)', 'Toner Bekas (B353-1)',
                                 'Filter Bekas (B110d)', 'Coolant Bekas (A345-1)'];
        $data['data'] = mouControl::findOrFail($id);

        return view('backend.MouControl.edit', $data); 
    }

    public function update($id, Request $request){
        $data['tipe_pengelolaan'] = ['Eksternal - Diolah', 
                                    'Eksternal - Dimanfaatkan', 'Eksternal - Ditimbun',
                                    'Eksternal - Pengumpulan', 'Penghasil ke Pihak Pengumpul',
                                    'Menerima dari Penghasil', 'Menerima dari Pengumpul', 
                                    'Menerima dari Pengolah', 'Menyerahkan ke Penimbun',
                                    'Menyerahkan ke Pengolah', 'Menerima ke Pemanfaat',
                                    'Menerima dari Pemanfaat', 'Menyerahkan ke Pengumpul'];

        $data['jenis_limbah'] = ['Majun atau Sarung Tangan Terkontaminasi B3 (B110d)', 
                                 'Electronic Waste (B107d)', 'Gram Besi (A345-2)',
                                 'Gram Aluminium (A345-2)', 'Aki Bekas (A110d)',
                                 'Limbah Medis (A337-1)', 'Kemasan Bekas Terkontaminasi B3 (B104d)',
                                 'Slope Oil (A323-3)', 'Toner Bekas (B353-1)',
                                 'Filter Bekas (B110d)', 'Coolant Bekas (A345-1)'];
        $this->validate($request, [
            "tipe_pengelolaan" => 'required|int',
            "perusahaan_pengelola_lanjut" => 'required|string',
            "status_kontrak" => 'required|int',
            "jenis_limbah" => 'required',
            "surat_pernyataan_tidak_masalah" => 'nuallable|mimes:pdf',

            "nomor_izin_perusahaan" => 'string|required',
            "tanggal_kontrak_perusahaan"=> 'date|required',
            "tanggal_habis_berlaku_perusahaan"=> 'date|required',
            "lampiran_perusahaan" => 'mimes:pdf|nuallable',

            "nomor_kontrak" => 'string|required',
            "tanggal_terbit_kontrak"=> 'date|required',
            "tanggal_habis_berlaku_kontrak"=> 'date|required',
            "lampiran_kontrak" => 'mimes:pdf|nuallable',
        ]);
        $MouControl = mouControl::findOrFail($id);
        $MouControl->nomor_kontrak = $request->nomor_kontrak;
        // return $MouControl;
        $ListFile = array("surat_pernyataan_tidak_masalah", "lampiran_perusahaan", "lampiran_kontrak");
        
        foreach ($ListFile as $File) {
            if($request->file($File)){
                $lampiran = $request->file($File);
                $nama_lampiran = $request->nomor_kontrak."_".$File."_".str_replace(" ","_",$lampiran->getClientOriginalName());
                $lampiran->move(public_path("uploads/LampiranMouControl/"), $nama_lampiran);
                $request->request->add([
                    "nama_".$File => 'uploads/LampiranMouControl/'.$nama_lampiran
                ]);
                $MouControl[$File] = $request["nama_".$File];
            }
        }

        $jenis_limbah = "";
            foreach($request->jenis_limbah as $jl){
                $jenis_limbah = $jenis_limbah."_".$data['jenis_limbah'][$jl];
        }
        $MouControl->tipe_pengelolaan = $data['tipe_pengelolaan'][$request->tipe_pengelolaan];
        $MouControl->perusahaan_pengelola_lanjut = $request->perusahaan_pengelola_lanjut;
        $MouControl->status_kontrak = $request->status_kontrak;
        $MouControl->jenis_limbah = $jenis_limbah;
        $MouControl->nomor_izin_perusahaan = $request->nomor_izin_perusahaan;
        $MouControl->tanggal_kontrak_perusahaan = $request->tanggal_kontrak_perusahaan;
        $MouControl->tanggal_habis_berlaku_perusahaan = $request->tanggal_habis_berlaku_perusahaan;
        $MouControl->nomor_kontrak = $request->nomor_kontrak;
        $MouControl->tanggal_terbit_kontrak = $request->tanggal_terbit_kontrak;
        $MouControl->tanggal_habis_berlaku_kontrak = $request->tanggal_habis_berlaku_kontrak;
        $MouControl->save();
        return redirect()->route($this->routePath)->with('success', "Data berhasil diupdate.");
    }

    public function delete($id, Request $request){
        $data = mouControl::findOrFail($id);
        $ListFile = array("lampiran_perusahaan", "lampiran_kontrak");

        foreach ($ListFile as $File) {
            $files = $data[$File];
            if(File::exists($files)){
                File::delete($files);
            }
        }
        
        $data->delete();        

        return redirect()->route($this->routePath)->with('success', "Data berhasil di hapus.");
    }

    public function download($lampiran, $id){
        $data = mouControl::findOrFail($id);
        if($data[$lampiran]){
            $headers = array(
                'Content-Type: application/pdf',
            );
            return response()->download($data->$lampiran, $lampiran."_".$data->no_kontrak.".pdf", $headers);
        }else{
            return redirect($data->lampiran);
        }  
    }

    public function downloads($id){
        $data = mouControl::findOrFail($id);
        $ListFile = array("surat_pernyataan_tidak_masalah", "lampiran_perusahaan", "lampiran_kontrak");
        $zip = new ZipArchive();
        $zip_name = "uploads/Lampiran_MouControl_".$data->no_polisi.".zip"; // Zip name
        $zip->open($zip_name,  ZipArchive::CREATE);
        foreach ($ListFile as $file) {
            if(file_exists($data[$file])){
                $zip->addFile($data[$file], $data[$file]);
            }
        }
        if($zip->close()){
            // $headers = array(
            //     'Content-Type: application/zip',
            // );
            return response()->download(public_path($zip_name));
        }else{
            return redirect()->back();
        }
    }
}