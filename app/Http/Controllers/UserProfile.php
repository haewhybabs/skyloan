<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\traits\BaseController;

class UserProfile extends Controller
{
    use BaseController;

    public function index()
    {
        $userId=auth()->user()->idusers;
        $employmentType = DB::table('employment_type')->get();
        $salaryRange = DB::table('salary_range')->get();
        $banks = DB::table('banks')->get();
        $states = DB::table('states')->get();
        $lgs =DB::table('lgs')->get();
        $relationship =DB::table('relationship')->get();

        $userInfo = DB::table('users')->join('users_employment_info','users_employment_info.user_id','=','users.idusers')
        ->where('users.idusers',$userId)
        ->first();

        $nextOfKinInfo = DB::table('next_of_kin')->join('users','next_of_kin.user_id','=','users.idusers')->where('next_of_kin.user_id',$userId)->first();

        $employmentInfo =  DB::table('users_employment_info')->
        join('employment_type','employment_type.idemploymenttype','=','users_employment_info.employment_type_id')
        ->join('lgs','lgs.idlgs','=','users_employment_info.employer_lg_id')
        ->join('salary_range','salary_range.idsalaryrange','=','users_employment_info.salary_range_id')
        ->where('users_employment_info.user_id',$userId)
        ->first();

        $bankInfo = DB::table('bank_information')
        ->join('banks','banks.idbanks','=','bank_information.bank_id')
        ->where('bank_information.user_id',$userId)
        ->first();

        $percentage = $this->profileCompletePercentage();

        $data = array(

            'userInfo'=>$userInfo,
            'nextOfKin'=>$nextOfKinInfo,
            'employmentInfo'=>$employmentInfo,
            'bankInfo'=>$bankInfo,
            'employmentType'=>$employmentType,
            'salaryRange'=>$salaryRange,
            'banks'=>$banks,
            'states'=>$states,
            'lgs'=>$lgs,
            'relationship'=>$relationship,
            'status'=>true,
            'percentage'=>$percentage,

        );

        return response()->json($data,200)->header('content-Type','application/json');


    }

    public function employmentInfo(Request $request)
    {
        $validatedData = $request->validate([

            'employment_type_id'=>'required',
            'employer_name'=>'required',
            'employer_lg_id'=>'required',
            'employer_address'=>'required',
            'salary_range_id'=>'required',
            'nature_of_job'=>'required',
        ]);

        $validatedData['created_at']=date('Y-m-d H:i:s');
        $validatedData['user_id']=auth()->user()->idusers;

        DB::table('users_employment_info')->insert($validatedData);

        $data=array(
            'status'=>true,
        );

        return response()->json($data,200)->header('content-Type','application/json');
    }

    public function nextOfKinInfo(Request $request)
    {
        $validatedData = $request->validate([
            'phone_number'=>'required',
            'email'=>'required',
            'state_id'=>'required',
            'lg_id'=>'required',
            'relationship_id'=>'required',
            'address'=>'required',
        ]);

        $validatedData['created_at']=date('Y-m-d H:i:s');
        $validatedData['user_id']=auth()->user()->idusers;

        DB::table('next_of_kin')->insert($validatedData);

        $data=array(
            'status'=>true,
        );

        return response()->json($data,200)->header('content-Type','application/json');
    }

    public function bankInfo(Request $request)
    {
        $validatedData = $request->validate([
            'bank_id'=>'required',
            'account_number'=>'required',
            'bvn'=>'required',
        ]);

        $validatedData['created_at']=date('Y-m-d H:i:s');

        $validatedData['user_id']=auth()->user()->idusers;

        DB::table('bank_information')->insert($validatedData);

        $data=array(
            'status'=>true,
        );

        return response()->json($data,200)->header('content-Type','application/json');
    }

    
}
