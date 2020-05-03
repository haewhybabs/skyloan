<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\traits\BaseController;
use App\User;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{
    use BaseController;

    public function index()
    {
        $userId = auth()->user()->idusers;
        $loanCheck = DB::table('loans')->where('user_id',$userId)->where('loan_status',2)->first();

        if($loanCheck){
            $loanDuration = DB::table('loan_duration')->first();
            $loanMonthlyPercentage = DB::table('loan_rate')->where('idloanrate',1)->first();
            $loanOverduePercentage = DB::table('loan_rate')->where('idloanrate',2)->first();

            $loanPayment = 0;
            $loanObtain = $loanCheck->amount;
            $duration = $loanDuration->duration;


            $loanStartDate = strtotime($loanCheck->loan_start_date);
            $end = strtotime("+".$duration." days",$loanStartDate);
            $today = strtotime("now");
            if($today>$end){

                $percentage = $loanOverduePercentage->rate;
                
                
                $timeDifference = $today-$loanStartDate;

                $dayDifference = round($timeDifference/(60 *60 *24));

                $noOfMonth = floor($dayDifference/$duration);

                $percentageAmount =  ($percentage/100 * $loanObtain) * $noOfMonth;

                $loanPayment = $percentageAmount + $loanObtain;


            }

            else{
                
                $percentage =$loanMonthlyPercentage->rate;
                $percentageAmount = $percentage/100 * $loanObtain;

                $loanPayment = $percentageAmount + $loanObtain;

            }

            $data = array(
                'data'=>$end,
                'd'=>$loanPayment
            );

            return response()->json($data,200)->header('content-Type','application/json');
        }
    }

}
