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
        $loanData = $this->loanPaymentAmount();
        $loanPlans = DB::table('loan_range')->get();
        $monthlyPercentage = DB::table('loan_rate')->where('idloanrate',1)->first();
        $overduePercentage = DB::table('loan_rate')->where('idloanrate',2)->first();


        $data=array(
            'loanPaymentData'=>$loanData,
            'loanPlans'=>$loanPlans,
            'monthlyPercentage'=>$monthlyPercentage->rate,
            'overduePercentage'=>$overduePercentage->rate
        );

        return response()->json($data,200)->header('content-Type','application/json');
        
    }

}
