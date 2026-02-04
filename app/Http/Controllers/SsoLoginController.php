<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SsoLogin;


class SsoLoginController extends Controller
{
    public function __construct()
    {
    }
    //
    public function Listlogs()
    { 
        $ssologin_logs = SsoLogin::orderBy('created_at', 'desc')->paginate(50);
        
        return view('sslogin-logs', compact('ssologin_logs'));
    }

    public function deleteAll(){
        SsoLogin::truncate();
        return  redirect()->back()->withStatus('Logs deleted successfully');
    }
}
