<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AgentController extends Controller
{
    public function postAgentCheckLogin(Request $request){
        if(Auth::guard('agent')->attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'approve'=> 'Y'])){
            return redirect()->route('getHome');
        }
        else{
            dd('wrong');
        }
    }
    public function AgentLogOut(){
        Auth::guard('agent')->logout();
        return redirect()->route('getHome');
    }
}
