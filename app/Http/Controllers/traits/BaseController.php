<?php

namespace App\Http\Controllers\traits;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;

trait BaseController
{
    public $secret="FLWSECK-a69efe1a1b4af5d37673a67088b1693e-X";
    public $public="FLWPUBK-2bd9bd3d2f1e0250715973e476561a47-X";
    public $currency="NGN";
   


    public function audit($task,$user_id){
        $current_date = date('Y-m-d H:i:s');

        $data_audit=array(
            'user_id'=>$user_id,
            'actions'=>$task,
            'created_at'=>$current_date
        );

        DB::table('audit_trail')->insert($data_audit);
    }


    public function profileCompletePercentage()
    {
        $userId = auth()->user()->idusers;

        $previousPercentage = 40;
        $count=0;

        $bankInfo=DB::table('bank_information')->where('user_id',$userId)->first();

        $nextOfKinInfo = DB::table('next_of_kin')->where('user_id',$userId)->first();

        $employmentInfo = DB::table('users_employment_info')->where('user_id',$userId)->first();

        if($bankInfo){
            $count=$count+1;
        }

        if($nextOfKinInfo){
            $count=$count+1;
        }

        if($employmentInfo){

            $count=$count+1;
        }

        $percentage = 20 * $count;

        $totalPercentage = $previousPercentage + $percentage;

        return $totalPercentage;
    }

}

?>