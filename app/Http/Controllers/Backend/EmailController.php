<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\ReportEmail;
use Illuminate\Support\Facades\Mail;
use App\PermitsControl;
use App\Truck;
use App\mouControl;
use Auth;
 
class EmailController extends Controller{
	// public $emailto = "renaldy.rizki.tif415@polban.ac.id";
	
	public function index(){
		$data['link'] = route('backend::dashboard');
		$data['contact_email'] = "frein.diana@daihatsu.astra.co.id";
		$data['contact_name'] = 'Frein Diana';
		$data['item'] = 'P2K3';
		$data['nomor_izin'] = 'SK/2019';
		$data['expired_date'] = Date('d-m-Y');
		$data['status'] = '56 Hari';
		$data['jenis_izin'] = 'Mou';
		$data['area'] = 'Plant 2';
		$data['subject'] = 'LCS Information [NO REPLY]';
		
		// return view('backend.Email.viewEmail', $data); 
		Mail::to("renaldy.rizki.tif415@polban.ac.id")->send(new ReportEmail($data));
		return redirect()->route('backend::dashboard');
	}

	public function permitsReport(){
		$plant = [
            'P2 - Engine Plant',
            'P3 - Casting Plant',
            'P5 - Karawang Assembly Plant'
        ];
		// $data['nama'] = 'renaldy';
		$data['link'] = route('backend::permitsControl');
		$data['contact_email'] = "frein.diana@daihatsu.astra.co.id";
		$data['contact_name'] = 'Frein Diana';
		$data['jenis_izin'] = 'Permits';
		$data['area'] = $plant[Auth::user()->plant_id];
		$data['subject'] = 'LCS Information [NO REPLY]';
		$now = strtotime("Y-m-d");
		$outdate = date("Y-m-d", strtotime("+2 month", $now));
		$model = PermitsControl::where('plant_id', Auth::user()->plant_id)->where('tanggal_habis_berlaku', '<=', $outdate)->get();
		$data['data'] = $model;
		if($model->isEmpty()){
			// return view('backend.Email.viewEmail', $data); 
			// return $data['data'];
			Mail::to("renaldy.rizki.tif415@polban.ac.id")->send(new ReportEmail($data));
			return redirect()->route('backend::truckPermits')->with('success', "Report Telah Dikirim.");
		}else{
			// return view('backend.Email.viewEmail', $data);
			return redirect()->route('backend::truckPermits')->with('success', "Tidak ada data Warning atau Expired Hari ini");
		}
	}

	public function mouReport(){
		$plant = [
            'P2 - Engine Plant',
            'P3 - Casting Plant',
            'P5 - Karawang Assembly Plant'
        ];
		// $data['nama'] = 'renaldy';
		$data['link'] = route('backend::mouControl');
		$data['contact_email'] = "frein.diana@daihatsu.astra.co.id";
		$data['contact_name'] = 'Frein Diana';
		$data['jenis_izin'] = 'Mou';
		$data['area'] = $plant[Auth::user()->plant_id];
		$data['subject'] = 'LCS Information [NO REPLY]';
		$now = strtotime("Y-m-d");
		$outdate = date("Y-m-d", strtotime("+2 month", $now));
		$model = mouControl::where('plant_id', Auth::user()->plant_id)->where('tanggal_habis_berlaku_kontrak', '<=', $outdate)->get();
		$data['data'] = $model;
		// return view('backend.Email.viewEmail', $data); 
		if($model->isEmpty()){
			// return view('backend.Email.viewEmail', $data); 
			// return $data['data'];
			Mail::to("renaldy.rizki.tif415@polban.ac.id")->send(new ReportEmail($data));
			return redirect()->route('backend::truckPermits')->with('success', "Report Telah Dikirim.");
		}else{
			// return view('backend.Email.viewEmail', $data);
			return redirect()->route('backend::truckPermits')->with('success', "Tidak ada data Warning atau Expired Hari ini");
		}
	}

	public function truckPermitsReport(){
		$plant = [
            'P2 - Engine Plant',
            'P3 - Casting Plant',
            'P5 - Karawang Assembly Plant'
        ];
		// $data['nama'] = 'renaldy';
		$data['link'] = route('backend::truckPermits');
		$data['contact_email'] = "frein.diana@daihatsu.astra.co.id";
		$data['contact_name'] = 'Frein Diana';
		$data['jenis_izin'] = 'Truck Permits';
		$data['area'] = $plant[Auth::user()->plant_id];
		$data['subject'] = 'LCS Information [NO REPLY]';
		$now = strtotime("Y-m-d");
		$outdate = date("Y-m-d", strtotime("+2 month", $now));
        $model = Truck::where('plant_id', Auth::user()->plant_id)->where('izin_pengangkutan_tanggal_habis', '<=', $outdate)->get();
		$data['data'] = $model;
		if($model->isEmpty()){
			// return view('backend.Email.viewEmail', $data); 
			// return $data['data'];
			Mail::to("renaldy.rizki.tif415@polban.ac.id")->send(new ReportEmail($data));
			return redirect()->route('backend::truckPermits')->with('success', "Report Telah Dikirim.");
		}else{
			// return view('backend.Email.viewEmail', $data);
			return redirect()->route('backend::truckPermits')->with('success', "Tidak ada data Warning atau Expired Hari ini");
		}
	}

	public function permitsReportAutomatic(){
		$plant = [
            'P2 - Engine Plant',
            'P3 - Casting Plant',
            'P5 - Karawang Assembly Plant'
        ];
		// $data['nama'] = 'renaldy';
		$data['link'] = route('backend::permitsControl');
		$data['contact_email'] = "frein.diana@daihatsu.astra.co.id";
		$data['contact_name'] = 'Frein Diana';
		$data['jenis_izin'] = 'Permits';
		$data['area'] = $plant[Auth::user()->plant_id];
		$data['subject'] = 'LCS Information [NO REPLY]';
		$now = strtotime("Y-m-d");
		$outdate = date("Y-m-d", strtotime("+2 month", $now));
		$model = PermitsControl::where('plant_id', Auth::user()->plant_id)->where('tanggal_habis_berlaku', '<=', $outdate)->get();
		$data['data'] = $model;
		if($model->isEmpty()){
			Mail::to("renaldy.rizki.tif415@polban.ac.id")->send(new ReportEmail($data));
			return "Report Telah Dikirim.";
		}else{
			return "Tidak ada data Warning atau Expired Hari ini";
		}
	}

	public function mouReportAutomatic(){
		$plant = [
            'P2 - Engine Plant',
            'P3 - Casting Plant',
            'P5 - Karawang Assembly Plant'
        ];
		// $data['nama'] = 'renaldy';
		$data['link'] = route('backend::mouControl');
		$data['contact_email'] = "frein.diana@daihatsu.astra.co.id";
		$data['contact_name'] = 'Frein Diana';
		$data['jenis_izin'] = 'Mou';
		$data['area'] = $plant[Auth::user()->plant_id];
		$data['subject'] = 'LCS Information [NO REPLY]';
		$now = strtotime("Y-m-d");
		$outdate = date("Y-m-d", strtotime("+2 month", $now));
		$model = mouControl::where('plant_id', Auth::user()->plant_id)->where('tanggal_habis_berlaku_kontrak', '<=', $outdate)->get();
		$data['data'] = $model;
		// return view('backend.Email.viewEmail', $data); 
		if($model->isEmpty()){
			Mail::to("renaldy.rizki.tif415@polban.ac.id")->send(new ReportEmail($data));
			return "Report Telah Dikirim.";
		}else{
			return "Tidak ada data Warning atau Expired Hari ini";
		}
	}

	public function truckPermitsReportAutomatic(){
		$plant = [
            'P2 - Engine Plant',
            'P3 - Casting Plant',
            'P5 - Karawang Assembly Plant'
        ];
		// $data['nama'] = 'renaldy';
		$data['link'] = route('backend::truckPermits');
		$data['contact_email'] = "frein.diana@daihatsu.astra.co.id";
		$data['contact_name'] = 'Frein Diana';
		$data['jenis_izin'] = 'Truck Permits';
		$data['area'] = $plant[Auth::user()->plant_id];
		$data['subject'] = 'LCS Information [NO REPLY]';
		$now = strtotime("Y-m-d");
		$outdate = date("Y-m-d", strtotime("+2 month", $now));
        $model = Truck::where('plant_id', Auth::user()->plant_id)->where('izin_pengangkutan_tanggal_habis', '<=', $outdate)->get();
		$data['data'] = $model;
		if($model->isEmpty()){
			Mail::to("renaldy.rizki.tif415@polban.ac.id")->send(new ReportEmail($data));
			return "Report Telah Dikirim.";
		}else{
			return "Tidak ada data Warning atau Expired Hari ini";
		}
	}
 
}