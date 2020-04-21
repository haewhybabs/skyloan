<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\traits\BaseController;
use App\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use BaseController;

    public function index()
    {
        $states = DB::table('states')->get();
        $lgs = DB::table('lgs')->get();

        $data=array(
            'states'=>$states,
            'lgs'=>$lgs
        );
        return response($data,200)->header('content-Type','application/json');
    }

    public function register(Request $request)
    {
        $validatedData= $request->validate([

            'email'=>'email|required|unique:users',
            'password'=>'required|confirmed',
            'fullname'=>'required',
            'address'=>'required',
            'phone_number'=>'required',
            'sex'=>'required',
            'marital_status'=>'required',
            'dob'=>'required',
            'lg_id'=>'required',
            'state_id'=>'required'
        ]);

        $validatedData['password']=bcrypt($request->password);
        $validatedData['role_id']=2;
        $validatedData['status']=1;
        
        $user=User::create($validatedData);
        $loginData = array(
            'email'=>$request->email,
            'password'=>$request->password
        );

        if(!auth()->attempt($loginData)){
            return response(['message'=>'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        $userData = array(
            'fullname'=>$user->fullname,
            'idusers'=>$user->id,
            'email'=>$user->email,
            'role_id'=>$user->role_id,
            'token'=>$accessToken,
            'status'=>true,
        );

        $task=$userData['fullname'].' just created account with Skyloan';
        $this->audit($task,$user->id);
        return response()->json($userData,200)->header('content-Type','application/json');

       
    }

    public function login(Request $request)
    {
        $loginData= $request->validate([

            'email'=>'email|required',
            'password'=>'required'
        ]);

        if(!auth()->attempt($loginData)){
            return response(['message'=>'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        $userData = array(
            'fullname'=>auth()->user()->fullname,
            'idusers'=>auth()->user()->idusers,
            'email'=>auth()->user()->email,
            'role_id'=>auth()->user()->role_id,
            'token'=>$accessToken
        );

        $task=$userData['fullname'].' just logged in with user account on Skyloan';
        $this->audit($task,$userData->idusers);

        return response()->json($userData,200)->header('content-Type','application/json');
        $current_date = date('Y-m-d H:i:s');


    }
}