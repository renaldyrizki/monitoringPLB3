<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\ReportEmail;
use Illuminate\Support\Facades\Mail;
 
class EmailController extends Controller{
	
	public function index(){
		Mail::to("renaldy.rizki.tif415@polban.ac.id")->send(new ReportEmail());

		return "Email telah dikirim";
 
	}
 
}