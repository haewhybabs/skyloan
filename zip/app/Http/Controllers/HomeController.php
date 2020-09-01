<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function emailVerification($token){
        $user = DB::table('users')->where('remember_token',$token)->first();
        $data['status']=false;
        $status =422;
        if($user and $user->email_verified_at==null){
            $dataTime = date('Y-m-d H:i:s');
            DB::table('users')->where('remember_token',$token)->update(['email_verified_at'=>$dataTime]);
            $data['status']=true;
            $data['message']='Email is successfully verified';
            
            $status =200;
        }
        return response()->json($data,$status)->header('content-Type','application/json');
    }
}
