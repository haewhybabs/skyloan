<?php

namespace App\Http\Controllers\traits;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Customer;

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

        DB::table('audit_trails')->insert($data_audit);
    }

}

?>