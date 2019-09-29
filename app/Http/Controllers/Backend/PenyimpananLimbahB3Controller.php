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
use Excel;
use DB;
use Date;
// use App\User;
use App\penyimpananLimbah;
use App\pengangkutanLimbah;



class PenyimpananLimbahB3Controller extends Controller{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    // public $routePath = "gerbang::permohonan";
    public $routePath = "backend::penyimpananLimbahB3";
    public $prefix = "backend.penyimpananLimbahB3";

    function __construct(){
        $this->themeBack = config('larakuy.theme_back');
        
        $this->prefix = 'backend.'.$this->themeBack.'.penyimpananLimbahB3';
    }

    public function index(){
        $data['page_name'] = "Penyimpanan Data Limbah B3";
        $data['page_description'] = "Tabel Data";
        // $model = penyimpananLimbah::get()->paginate(10);
        $model = penyimpananLimbah::paginate(2);
        $data['data'] = $model;
        $data['allData'] = penyimpananLimbah::get();

        // return $data;
        return view('backend.PenyimpananLimbahB3.index', $data);
    }

    public function logbook(){
        $data['page_name'] = "Penyimpanan Data Limbah B3";
        $data['page_description'] = "Tabel Data";
        // $model = penyimpananLimbah::get()->paginate(10);
        $model = penyimpananLimbah::orderBy('id_penyimpanan', 'desc')->get();
        $data['data'] = $model;
        $data['allData'] = penyimpananLimbah::get();

        // return $data;
        return view('backend.PenyimpananLimbahB3.index', $data);
    }

    public function add(){
        $data['page_name'] = "Penyimpanan Limbah B3";
        $data['page_description'] = "Penambahan Data";
        $data['jenis_limbah'] = ['Majun atau Sarung Tangan Terkontaminasi B3 (B110d)', 
                                 'Electronic Waste (B107d)', 'Gram Besi (A345-2)',
                                 'Gram Aluminium (A345-2)', 'Aki Bekas (A110d)',
                                 'Limbah Medis (A337-1)', 'Kemasan Bekas Terkontaminasi B3 (B104d)',
                                 'Slope Oil (A323-3)', 'Toner Bekas (B353-1)',
                                 'Filter Bekas (B110d)', 'Coolant Bekas (A345-1)'];
        $data['satuan'] = ['KG', 'Drum', 'Pcs'];
        return view('backend.PenyimpananLimbahB3.add', $data);
    }

    public function save(Request $request){
        
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
        $penyimpananLimbah->tanggal_expired = Date('Y-m-d', strtotime('+'.$request->masa_simpan.' day', strtotime($request->tanggal_penyimpanan)));
        $penyimpananLimbah->sumber_limbah = $request->sumber_limbah;
        $penyimpananLimbah->total_penyimpanan = $request->total_penyimpanan;
        // $penyimpananLimbah->satuan = $request->satuan;
        // $penyimpananLimbah->status = $request->status;
        // $penyimpananLimbah->user()->associate($user);
        // return $penyimpananLimbah;
        $penyimpananLimbah->save();

        return redirect()->route($this->routePath)->with('success', "Data berhasil di simpan.");
        
        // return $penyimpananLimbah;
        // return $jenis_limbah[$request->jenis_limbah];
        
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
        $data['data'] = penyimpananLimbah::findOrFail($id);
        $start_date = strtotime($data['data']->tanggal_penyimpanan); 
        $end_date = strtotime($data['data']->tanggal_expired);
        // $date1=date_create(strval($data['data']->tanggal_penyimpanan));
        // $date2=date_create(strval($data['data']->tanggal_expired));
        // $diff=date_diff($date1,$date2);
        $data['data']->masa_simpan = ($end_date - $start_date)/60/60/24;

        // return ($end_date - $start_date)/60/60/24;

        return view('backend.PenyimpananLimbahB3.edit', $data); 
    }

    public function update($id, Request $request){
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

        $penyimpananLimbah = penyimpananLimbah::findOrFail($id);
        $penyimpananLimbah->jenis_limbah = $jenis_limbah[$request->jenis_limbah];
        $penyimpananLimbah->tanggal_penyimpanan = $request->tanggal_penyimpanan;
        $penyimpananLimbah->tanggal_expired = Date('Y-m-d', strtotime('+'.$request->masa_simpan.' day', strtotime($request->tanggal_penyimpanan)));
        $penyimpananLimbah->sumber_limbah = $request->sumber_limbah;
        $penyimpananLimbah->total_penyimpanan = $request->total_penyimpanan;
        $penyimpananLimbah->save();

        return redirect()->route($this->routePath)->with('success', "Data berhasil diupdate.");
    }

    public function delete($id, Request $request){
        $data = penyimpananLimbah::findOrFail($id);

        // delete datanya smentara
        $data->delete();        

        return redirect()->route($this->routePath)->with('success', "Data berhasil di hapus.");
    }

    public function logbookDownload(){
        $first_day_this_month = date('Y-m-01');
        $last_day_this_month  = date('Y-m-t');
        $data = pengangkutanLimbah::whereBetween('tanggal_pengangkutan', [$first_day_this_month, $last_day_this_month])->orderBy('jenis_limbah', 'ASC')->orderBy('tanggal_pengangkutan', 'ASC')->get();
        $data = penyimpananLimbah::whereBetween('tanggal_expired', [$first_day_this_month, $last_day_this_month])->orderBy('jenis_limbah', 'ASC')->orderBy('tanggal_expired', 'ASC')->get();
        

        $date = 'Jun-19';
        $dummy = [7, 'Alumunium', '03-Jan-19', 'Produksi', 3.701, '03-Apr-19', '03-Jan-19', 3.701, 'PT AAA', 'AFW 000 8599', 0];
       
        
        Excel::create('Logbook Lembar Kegiatan Penyimpanan Limbah B3', function($excel) use ($date, $dummy){
            // Set the title
            $excel->setTitle('Logbook Lembar Kegiatan Penyimpanan Limbah B3')
                  ->setCreator('Renaldy Aldy')
                  ->setCompany('Merah Muda')
                  ->setDescription('Lembar Kegiatan Penyimpanan Limbah B3');
            
                  
                  
            $excel->sheet($date, function($sheet) use ($date, $dummy){
                $sheet->appendRow(['LEMBAR KEGIATAN PENYIMPANAN LIMBAH BAHAN BERBAHAYA DAN BERACUN']);
                $sheet->appendRow(['PT. ASTRA DAIHATSU MOTOR - ENGINE PLANT']);
                $sheet->appendRow([$date]);
                $sheet->appendRow([
                    'MASUKNYA LIMBAH B3 KE TPS',
                    '',
                    '',
                    '',
                    '',
                    '',
                    'KELUARNYA LIMBAH B3 DARI TPS',
                    '',
                    '',
                    '',
                    'SISA'
                ]);
                $sheet->appendRow([
                    'No.',
                    'Jenis Limbah B3 Masuk',
                    'Tanggal Masuk Limbah B3',
                    'Sumber limbah B3',
                    'Jumlah Limbah B3 Masuk (drum)',
                    'Maksimal Penyimpanan s/d Tanggal; (t=0 + 90hr, 180hr)',
                    'Tanggal Keluar Limbah B3',
                    'Jumlah Limbah B3 (drum)',
                    'Tujuan Penyerahan',
                    'Bukti Nomor Dokumen',
                    'Sisa Limbah B3 yang ada di TPS (drum)',
                ]);
                $sheet->appendRow(['(A)','(B)','(C)','(D)','(E)','(F)','(G)','(H)','(I)','(J)','(K)']);
                $sheet->setAllBorders('thin');


                $sheet->mergeCells('A1:K1');
                $sheet->cells('A1:K1', function($cells) {
                    $cells->setBackground('#B5B5B5');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->mergeCells('A2:K2');
                $sheet->cells('A2:K2', function($cells) {
                    $cells->setAlignment('center');
                });
                $sheet->mergeCells('A3:K3');
                $sheet->cells('A3:K3', function($cells) {
                    $cells->setAlignment('center');
                });
    
                $sheet->mergeCells('A4:F4');
                $sheet->mergeCells('G4:J4');
                $sheet->cells('A4:K4', function($cells) {
                    $cells->setBackground('#B5B5B5');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });

                // INSERT DATA HERE
                $sheet->appendRow($dummy);
                $sheet->appendRow($dummy);
                $sheet->appendRow($dummy);
                $sheet->appendRow($dummy);
                $sheet->appendRow($dummy);
                $sheet->appendRow($dummy);
                $sheet->appendRow($dummy);
            });
            
            
        })->download('xls');

        return $data;
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