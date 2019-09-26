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
use App\Truck;
use ZipArchive;


class TruckPermitsController extends Controller{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    // public $routePath = "gerbang::permohonan";

    public $routePath = "backend::truckPermits";
    public $prefix = "backend.truckPermits";

    function __construct(){
        $this->themeBack = config('larakuy.theme_back');
        
        $this->prefix = 'backend.'.$this->themeBack.'.truckPermits';
    }

    public function index(){
        $data['page_name'] = "Truck Permits Control";
        $data['page_description'] = "Tabel Data";

        // $model = penyimpananLimbah::get()->paginate(10);
        $model = Truck::paginate(2);
        $data['data'] = $model;
        // $data['allData'] = Truck::paginate(2);

        return view('backend.TruckPermits.index', $data);
    }

    public function add(){
        $data['jk_limbah'] = ['Majun atau Sarung Tangan Terkontaminasi B3 (B110d)', 
                                 'Electronic Waste (B107d)', 'Gram Besi (A345-2)',
                                 'Gram Aluminium (A345-2)', 'Aki Bekas (A110d)',
                                 'Limbah Medis (A337-1)', 'Kemasan Bekas Terkontaminasi B3 (B104d)',
                                 'Slope Oil (A323-3)', 'Toner Bekas (B353-1)',
                                 'Filter Bekas (B110d)', 'Coolant Bekas (A345-1)'];
        $data['page_name'] = "Truck Permits Control";
        $data['page_description'] = "Tambah Data";
        return view('backend.TruckPermits.add', $data);
    }

    public function save(Request $request){
        // dd($request->jk_limbah);
        // return $request->jk_limbah;
        $jk_limbah = ['Majun atau Sarung Tangan Terkontaminasi B3 (B110d)', 
                    'Electronic Waste (B107d)', 'Gram Besi (A345-2)',
                    'Gram Aluminium (A345-2)', 'Aki Bekas (A110d)',
                    'Limbah Medis (A337-1)', 'Kemasan Bekas Terkontaminasi B3 (B104d)',
                    'Slope Oil (A323-3)', 'Toner Bekas (B353-1)',
                    'Filter Bekas (B110d)', 'Coolant Bekas (A345-1)'];
        $this->validate($request, [
            "jenis_kendaraan" => 'required|int',
            "no_polisi" => 'required|string',
            "perusahaan_transporter" => 'required|string',
            "jk_limbah" => 'required',
            "berat_maksimum_kendaraan" => 'required|int',
            "berat_limbah_dapat_diangkut" => 'required|int',

            "izin_pengangkutan" => 'string|nullable',
            "izin_pengangkutan_tanggal_terbit"=> 'date|nullable',
            "izin_pengangkutan_tanggal_habis"=> 'date|nullable',
            "izin_pengangkutan_file" => 'mimes:pdf|nullable',

            "dokumen_lingkungan" => 'string|nullable',
            "dokumen_lingkungan_tanggal_terbit"=> 'date|nullable',
            "dokumen_lingkungan_tanggal_habis"=> 'date|nullable',
            "dokumen_lingkungan_file" => 'mimes:pdf|nullable',

            "mou" => 'string|nullable',
            "mou_tanggal_terbit"=> 'date|nullable',
            "mou_tanggal_habis"=> 'date|nullable',
            "mou_file" => 'mimes:pdf|nullable',

            "kartu_pengawasan" => 'string|nullable',
            "kartu_pengawasan_tanggal_terbit"=> 'date|nullable',
            "kartu_pengawasan_tanggal_habis"=> 'date|nullable',
            "kartu_pengawasan_file" => 'mimes:pdf|nullable',
        ]);
        
        $TruckPermits = new Truck;
        $TruckPermits->no_polisi = $request->no_polisi;
        $ListFile = array("izin_pengangkutan_file", "dokumen_lingkungan_file", "mou_file", "kartu_pengawasan_file");
        
        // return $TruckPermits;

        foreach ($ListFile as $File) {
            if($request->file($File)){
                $lampiran = $request->file($File);
                $nama_lampiran = $request->no_polisi."_".$File."_".str_replace(" ","_",$lampiran->getClientOriginalName());
                $lampiran->move(public_path("uploads/TruckPermitsControl/"), $nama_lampiran);
                $request->request->add([
                    "nama_".$File => 'uploads/TruckPermitsControl/'.$nama_lampiran
                ]);
                $TruckPermits[$File] = $request["nama_".$File];
            }
        }

        $jenis_limbah = "";
        foreach($request->jk_limbah as $jk){
            $jenis_limbah = $jenis_limbah."_".$jk_limbah[$jk];
        }
        $TruckPermits->jenis_kendaraan = $request->jenis_kendaraan;
        $TruckPermits->perusahaan_transporter = $request->perusahaan_transporter;
        $TruckPermits->jenis_kode_limbah = $jenis_limbah;
        $TruckPermits->berat_maksimum_kendaraan = $request->berat_maksimum_kendaraan;
        $TruckPermits->berat_limbah_dapat_diangkut = $request->berat_limbah_dapat_diangkut;
        //izinpengangkutan
        $TruckPermits->izin_pengangkutan_nomor = $request->izin_pengangkutan;
        $TruckPermits->izin_pengangkutan_tanggal_terbit = $request->izin_pengangkutan_tanggal_terbit;
        $TruckPermits->izin_pengangkutan_tanggal_habis = $request->izin_pengangkutan_tanggal_habis;
        //dokumen_lingkungan
        $TruckPermits->dokumen_lingkungan_nomor = $request->izin_pengangkutan;
        $TruckPermits->dokumen_lingkungan_tanggal_terbit = $request->dokumen_lingkungan_tanggal_terbit;
        $TruckPermits->dokumen_lingkungan_tanggal_habis = $request->dokumen_lingkungan_tanggal_habis;
        //mou
        $TruckPermits->mou_nomor = $request->mou;
        $TruckPermits->mou_tanggal_terbit = $request->mou_tanggal_terbit;
        $TruckPermits->mou_tanggal_habis = $request->mou_tanggal_habis;
        // kartu_pengawasan
        $TruckPermits->kartu_pengawasan_nomor = $request->kartu_pengawasan;
        $TruckPermits->kartu_pengawasan_tanggal_terbit = $request->kartu_pengawasan_tanggal_terbit;
        $TruckPermits->kartu_pengawasan_tanggal_habis = $request->kartu_pengawasan_tanggal_habis;

        $TruckPermits->save();

        return redirect()->route($this->routePath)->with('success', "Data berhasil di simpan.");
    }

    public function edit($id){
        $data['page_name'] = "Truck Permits Control";
        $data['page_description'] = "Edit Data";
        $data['jk_limbah'] = ['Majun atau Sarung Tangan Terkontaminasi B3 (B110d)', 
                    'Electronic Waste (B107d)', 'Gram Besi (A345-2)',
                    'Gram Aluminium (A345-2)', 'Aki Bekas (A110d)',
                    'Limbah Medis (A337-1)', 'Kemasan Bekas Terkontaminasi B3 (B104d)',
                    'Slope Oil (A323-3)', 'Toner Bekas (B353-1)',
                    'Filter Bekas (B110d)', 'Coolant Bekas (A345-1)'];
        $data['data'] = Truck::findOrFail($id);

        // return $data;

        return view('backend.TruckPermits.edit', $data); 
    }

    public function update($id, Request $request){
        $jk_limbah = ['Majun atau Sarung Tangan Terkontaminasi B3 (B110d)', 
                    'Electronic Waste (B107d)', 'Gram Besi (A345-2)',
                    'Gram Aluminium (A345-2)', 'Aki Bekas (A110d)',
                    'Limbah Medis (A337-1)', 'Kemasan Bekas Terkontaminasi B3 (B104d)',
                    'Slope Oil (A323-3)', 'Toner Bekas (B353-1)',
                    'Filter Bekas (B110d)', 'Coolant Bekas (A345-1)'];
        $this->validate($request, [
            "jenis_kendaraan" => 'required|int',
            "no_polisi" => 'required|string',
            "perusahaan_transporter" => 'required|string',
            "jk_limbah" => 'required',
            "berat_maksimum_kendaraan" => 'required|int',
            "berat_limbah_dapat_diangkut" => 'required|int',

            "izin_pengangkutan" => 'string|nullable',
            "izin_pengangkutan_tanggal_terbit"=> 'date|nullable',
            "izin_pengangkutan_tanggal_habis"=> 'date|nullable',
            "izin_pengangkutan_file" => 'mimes:pdf|nullable',

            "dokumen_lingkungan" => 'string|nullable',
            "dokumen_lingkungan_tanggal_terbit"=> 'date|nullable',
            "dokumen_lingkungan_tanggal_habis"=> 'date|nullable',
            "dokumen_lingkungan_file" => 'mimes:pdf|nullable',

            "mou" => 'string|nullable',
            "mou_tanggal_terbit"=> 'date|nullable',
            "mou_tanggal_habis"=> 'date|nullable',
            "mou_file" => 'mimes:pdf|nullable',

            "kartu_pengawasan" => 'string|nullable',
            "kartu_pengawasan_tanggal_terbit"=> 'date|nullable',
            "kartu_pengawasan_tanggal_habis"=> 'date|nullable',
            "kartu_pengawasan_file" => 'mimes:pdf|nullable',
        ]);
        $TruckPermits = Truck::findOrFail($id);
        $TruckPermits->no_polisi = $request->no_polisi;
        $ListFile = array("izin_pengangkutan_file", "dokumen_lingkungan_file", "mou_file", "kartu_pengawasan_file");
        foreach ($ListFile as $File) {
            if($request->file($File)){
                $lampiran = $request->file($File);
                $nama_lampiran = $request->no_polisi."_".$File."_".str_replace(" ","_",$lampiran->getClientOriginalName());
                $lampiran->move(public_path("uploads/TruckPermitsControl/"), $nama_lampiran);
                $request->request->add([
                    "nama_".$File => 'uploads/TruckPermitsControl/'.$nama_lampiran
                ]);
                $TruckPermits[$File] = $request["nama_".$File];
            }
        }

        $jenis_limbah = "";
        foreach($request->jk_limbah as $jk){
            $jenis_limbah = $jenis_limbah."_".$jk_limbah[$jk];
        }
        $TruckPermits->jenis_kendaraan = $request->jenis_kendaraan;
        $TruckPermits->perusahaan_transporter = $request->perusahaan_transporter;
        $TruckPermits->jenis_kode_limbah = $jenis_limbah;
        $TruckPermits->berat_maksimum_kendaraan = $request->berat_maksimum_kendaraan;
        $TruckPermits->berat_limbah_dapat_diangkut = $request->berat_limbah_dapat_diangkut;
        //izinpengangkutan
        $TruckPermits->izin_pengangkutan_nomor = $request->izin_pengangkutan;
        $TruckPermits->izin_pengangkutan_tanggal_terbit = $request->izin_pengangkutan_tanggal_terbit;
        $TruckPermits->izin_pengangkutan_tanggal_habis = $request->izin_pengangkutan_tanggal_habis;
        //dokumen_lingkungan
        $TruckPermits->dokumen_lingkungan_nomor = $request->izin_pengangkutan;
        $TruckPermits->dokumen_lingkungan_tanggal_terbit = $request->dokumen_lingkungan_tanggal_terbit;
        $TruckPermits->dokumen_lingkungan_tanggal_habis = $request->dokumen_lingkungan_tanggal_habis;
        //mou
        $TruckPermits->mou_nomor = $request->mou;
        $TruckPermits->mou_tanggal_terbit = $request->mou_tanggal_terbit;
        $TruckPermits->mou_tanggal_habis = $request->mou_tanggal_habis;
        // kartu_pengawasan
        $TruckPermits->kartu_pengawasan_nomor = $request->kartu_pengawasan;
        $TruckPermits->kartu_pengawasan_tanggal_terbit = $request->kartu_pengawasan_tanggal_terbit;
        $TruckPermits->kartu_pengawasan_tanggal_habis = $request->kartu_pengawasan_tanggal_habis;
        // return $PermitsControl;
        $TruckPermits->save();
        return redirect()->route($this->routePath)->with('success', "Data berhasil diupdate.");
    }

    public function delete($id, Request $request){
        $data = Truck::findOrFail($id);
        $ListFile = array("izin_pengangkutan_file", "dokumen_lingkungan_file", "mou_file", "kartu_pengawasan_file");

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
        $data = Truck::findOrFail($id);

        if($data[$lampiran]){
            $headers = array(
                'Content-Type: application/pdf',
            );
            return response()->download($data->$lampiran, $lampiran."_".$data->no_polisi.".pdf", $headers);
        }else{
            return redirect($data->lampiran);
        }  
    }

    public function downloads($id){
        $data = Truck::findOrFail($id);
        $ListFile = array("izin_pengangkutan_file", "dokumen_lingkungan_file", "mou_file", "kartu_pengawasan_file");
        $zip = new ZipArchive();
        $zip_name = "uploads/Lampiran_TruckPermits_".$data->no_polisi.".zip"; // Zip name
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