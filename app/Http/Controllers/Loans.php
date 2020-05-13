<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\traits\BaseController;
use App\User;
use Illuminate\Support\Facades\DB;

class Loans extends Controller
{
    use BaseController;

    public function index(Request $request)
    {
        $loanPlans = DB::table('loan_range')->get();
        $loanDuration = DB::table('loan_duration')->first();
        
        $data = array(
            'status'=>true,
            'loanPlans'=>$loanPlans,
            'loanDuration'=>$loanDuration
        );

        return response()->json($data,200)->header('content-Type','application/json');
    }

    public function loanRequest(Request $request)
    {
        $userId=auth()->user()->idusers;

        $userCheck = DB::table('users')->where('idusers',$userId)->first();

        $profileComplete=$this->profileCompletePercentage();

        if($profileComplete<100 or $userCheck->email_verified_at==null){
            
            return response()->json(
                [
                    'status'=>false,
                    'message'=>'Kindly complete your Account information and activate your account on your e-mail if you have not.'
                ]
                ,200)->header('content-Type','application/json');
        }

        $validatedData = $request->validate([

            'amount'=>'required',
            'loan_range_id'=>'required',
            'loan_info'=>'required',
        ]);
        

        $loanCheck=DB::table('loans')->where('user_id',$userId)->where('loan_status',2)->orwhere('loan_status',3)->first();

        if($loanCheck){

            return response()->json(
                [
                    'status'=>false,
                    'message'=>'You currently have an active loan'
                ]
                ,200)->header('content-Type','application/json');
        }

        $loanDuration = DB::table('loan_duration')->first();

        $validatedData['user_id']=$userId;
        $validatedData['created_at']=date('Y-m-d H:i:s');
        $validatedData['loan_status']=1;
        $validatedData['loan_duration_id']=$loanDuration->idloanduration;
        $validatedData['loan_start_date']=date('Y-m-d');

        DB::table('loans')->insert($validatedData);

        $task=auth()->user()->fullname.' request for a loan. Kindly check it up';
        $this->audit($task,auth()->user()->idusers);

        return response()->json(
            [
                'status'=>true,
                'message'=>'Your loan request is successful'
            ]
            ,200)->header('content-Type','application/json');
            
    }

    public function loanHistory()
    {
        $loanDuration = DB::table('loan_duration')->first();

        $userId = auth()->user()->idusers;
        $activeLoan = DB::table('loans')->join('loan_range','loan_range.idloanrange','=','loans.loan_range_id')
        ->where('loans.user_id',$userId)->where('loans.loan_status',2)->first();
        $currentLoan = DB::table('loans')->where('user_id',$userId)->where('loan_status',2)->orwhere('loan_status',3)->first();
        $endDate = null;
        $activePaymentDetails = null;
        $overdueLoan = DB::table('loans')->join('loan_range','loan_range.idloanrange','=','loans.loan_range_id')
        ->where('loans.user_id',$userId)->where('loans.loan_status',3)->first();

        if($currentLoan){

            $end = strtotime("+".$loanDuration->duration." days",strtotime($currentLoan->loan_start_date));
            $endDate = date('Y-m-d',$end);
            $activePaymentDetails =  $this->LoanPaymentAmount();
        }

        $pendingLoan = DB::table('loans')->join('loan_range','loan_range.idloanrange','=','loans.loan_range_id')
        ->where('loans.user_id',$userId)->where('loans.loan_status',1)->first();

        $maturedLoan = DB::table('loans')->join('loan_range','loan_range.idloanrange','=','loans.loan_range_id')
        ->where('loans.user_id',$userId)->where('loans.loan_status',4)->first();
        $rejectedLoan = DB::table('loans')->join('loan_range','loan_range.idloanrange','=','loans.loan_range_id')
        ->where('loans.user_id',$userId)->where('loans.loan_status',5)->first();


        $data = array(
            'activeLoan'=>$activeLoan,
            'endDate'=>$endDate,
            'activePaymentDetails'=>$activePaymentDetails,
            'pendingLoans'=>$pendingLoan,
            'maturedLoan'=>$maturedLoan,
            'rejectedLoan'=>$rejectedLoan,
            'overdueLoan'=>$overdueLoan
        );

        return response()->json($data,200)->header('content-Type','application/json');

    }
    
}
