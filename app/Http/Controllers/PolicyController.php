<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Policy;

class PolicyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getManageReturnPolicy(){
        if(auth()->user()->role == 'A'){
        $data =[
            'return'=> Policy::where('page', 'Return')->limit(1)->first(),
            'privacy'=> Policy::where('page', 'Privacy')->limit(1)->first(),
            'terms'=> Policy::where('page', 'Terms')->limit(1)->first()
        ];
        
        return view('admin.policy.manage', $data);
    }
    else{
        dd('Access denied you are not allowed to access this page.');
    }

    }
    public function getEditPolicy(Policy $policy, Request $request){
        if(auth()->user()->role == 'A'){
        
        $policy->content = $request->input('detail');
        $policy->save();
        return redirect()->back()->with('status', 'Policy Edited Success');
    }
    else{
        dd('Access denied you are not allowed to access this page.');
    }
    }
}
