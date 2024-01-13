<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profit;
use App\Models\Doctor;
use App\Models\Patient;
use Carbon\Carbon;
use DB;
use Super;

class DashboardController extends Controller
{
    public function index(){
        $year = date("Y");  
        $profits = Profit::whereYear('created_at', $year)->select(
                              DB::raw("(sum(price)) as price"),
                              DB::raw("(DATE_FORMAT(created_at, '%b')) as month"))
                              ->orderBy('created_at')
                              ->groupBy(DB::raw("DATE_FORMAT(created_at, '%b')"))->get(); 
        $maxprice = Profit::whereYear('created_at', $year)->select(
                                DB::raw("(sum(price)) as price"))
                                  ->orderBy('price', 'desc')
                                 ->groupBy(DB::raw("DATE_FORMAT(created_at, '%b')"))->first();
        $res = [
          "profits" =>$profits,
          "maxprice" => $maxprice
        ];                          
        return Super::sendResponse($res);
      }// end of index
  
      public function get_profits(Request $request){
         $profits = Profit::whereYear('created_at', $request->datepicker)->select(
                              DB::raw("(sum(price)) as price"),
                              DB::raw("(DATE_FORMAT(created_at, '%b')) as month"))
                              ->orderBy('created_at')
                              ->groupBy(DB::raw("DATE_FORMAT(created_at, '%b')"))->get(); 
        return view('partials._chart',compact('profits'));
      }// end of index
  
  
      public function top_counter(Request $request){
        $doctors_count = number_format(Doctor::whereStatus('active')->count(),1);
        $patients_count = number_format(Patient::count(),1);
        $month_profits = number_format(Profit::whereYear('created_at',Carbon::now()->year)
                                              ->whereMonth('created_at',Carbon::now()->month)
                                              ->sum('price'),1);
        return response()->json([
          'doctors_count' => $doctors_count,
          'patients_count' => $patients_count,
          'month_profits' => $month_profits
        ]);
     }// end of index
    
}//end of contro
