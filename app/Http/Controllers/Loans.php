<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\traits\BaseController;
use App\User;
use Illuminate\Support\Facades\DB;

class Loans extends Controller
{
    use BaseController;

    public function index()
    {
        
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
                    'message'=>'Kindly complete your Account information and activate your account if you have not.'
                ]
                ,200)->header('content-Type','application/json');
        }

        $validatedData = $request->validate([

            'amount'=>'required',
            'loan_range_id'=>'required',
            'loan_info'=>'required',
        ]);
        

        $loanCheck=DB::table('loans')->where('user_id',$userId)->where('laon_status',2)->first();

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

        return response()->json(
            [
                'status'=>true,
                'message'=>'Your loan request is successful'
            ]
            ,200)->header('content-Type','application/json');



    }

    public function loanHistory()
    {

    }


    //
}
