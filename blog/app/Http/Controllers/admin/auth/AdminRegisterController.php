<?php

namespace App\Http\Controllers\admin\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminRegisterController extends Controller
{
    public function register()
    {
        return view('admin.auth.register');
    }

    public function store( Request $request)   
    {
        $adminKey = 'adminKey1';
        if ($request->admin_key == $adminKey) {
$request->validate([
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
    'password' => ['required', 'string', 'min:8', 'confirmed'],
    'password_confirmation'=>['required','string'],
    'admin_key'=>['required', 'string'],

]);
$data=$request->except('password_confirmation','_token','admin_key');
    $data['password']=Hash::make($request->password);
// dd($data);
Admin::create($data);
return redirect()->route('admin.dashboard.login');


        } else {
            return redirect()->back()->with('errorResponse', 'something  went wrong ! please try again later');
        }
    }

}
