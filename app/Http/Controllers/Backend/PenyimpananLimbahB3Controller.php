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
        
        Excel::create('Filename', function($excel) {
            $excel->sheet('Sheet 1',function($sheet){
                $sheet->fromArray([['A','B'],['C','D']]);
            });
            // Set the title
            $excel->setTitle('Our new awesome title');
            
            // Chain the setters
            $excel->setCreator('Maatwebsite')
                  ->setCompany('Maatwebsite');
            
              // Call them separately
              $excel->setDescription('A demonstration to change the file properties');
            })->download('xls');
        // return $data;
        // MaatExcel::create('Filename', function($excel) {
        //     $excel->setTitle("ThisTitle")->setCreator("siGanteng");
        //     $excel->sheet('Sheetname', function($sheet) {
        //         // return $sheet;
        //         $sheet->fromArray(array(
        //             array('data1', 'data2'),
        //             array('data3', 'data4')
        //         ));
        //     });
        // })->export('xls');
        // MaatExcel::download(['a','b'],'hitut.xlsx');
        // MaatExcel::create("Customers", function ($excel){
        //     $excel->setTitle("Example Sheet");
        //     $excel->sheet("Sheet 1", function ($sheet){
        //           $sheet->row(1, array("NO.","NAME","DATE", "ADDRESS"));
        //       });
        //     })->download('xls');
        // $users = $data;
        // MaatExcel::create('user-export', function ($excel) use ($users) {
        //     $excel->sheet('Users', function ($sheet) use ($users) {
        //         $sheet->loadView('xls.users', [
        //             'users' => $users
        //         ]);
        //     });
        // })->download();
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