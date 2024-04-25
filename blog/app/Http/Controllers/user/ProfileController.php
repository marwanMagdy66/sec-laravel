<?php

namespace App\Http\Controllers\user;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ProfileController extends Controller
{

    public function profileInfo(Request $request) {
        $data=Auth::user();

     $name=$data->name;
     $email=$data->email;
     $address= Crypt::decryptString($data->address);
     $phoneNumber=Crypt::decryptString($data->phone);


        return view('user.profile',['user'=>$data ,'address'=>$address,'phonNum'=> $phoneNumber]);
    }
 



}
