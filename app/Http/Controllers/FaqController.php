<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\Product;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getManageFaq(){
        if(auth()->user()->role == 'A'){
        $data =[
            'faqs' => Faq::all()
        ];
        return view('admin.faq.manage', $data);
    }
    else{
        dd('Access denied you are not allowed to access this page.');
    }
    }
    public function getAddFaq(){
        if(auth()->user()->role == 'A'){
        $data =[
            'products'=>Product::all()
        ];
        return view('admin.faq.add', $data);
    }
    else{
        dd('Access denied you are not allowed to access this page.');
    }
    }
    public function postFaqAdd(Request $request){
        if(auth()->user()->role == 'A'){
        $faq = New Faq;
        $faq->product_id = $request->input('product_id');
        $faq->catagory = $request->input('catagory');
        $faq->question = $request->input('question');
        $faq->answer = $request->input('answer');
        $faq->save();
        return redirect()->back()->with('status', 'Faq Added Success');
    }
    else{
        dd('Access denied you are not allowed to access this page.');
    }
        
    }
    public function getFaqEdit(Faq $faq){
        if(auth()->user()->role == 'A'){
        $data = [
            'faq' => $faq,
            'products'=>Product::all()
        ];
        return view('admin.faq.edit', $data);
    }
    else{
        dd('Access denied you are not allowed to access this page.');
    }
    }
    public function postFaqEdit(Faq $faq, Request $request){
        if(auth()->user()->role == 'A'){
        $faq->product_id = $request->input('product_id');
        $faq->catagory = $request->input('catagory');
        $faq->question = $request->input('question');
        $faq->answer = $request->input('answer');
        $faq->save();
        return redirect()->back()->with('status', 'Faq Edited Success');
    }
    else{
        dd('Access denied you are not allowed to access this page.');
    }
    }

    public function getDeleteFaq(Faq $faq){
        if(auth()->user()->role == 'A'){
        $faq->delete();
        return redirect()->back()->with('status', 'Faq Deleted Success');
    }
    else{
        dd('Access denied you are not allowed to access this page.');
    }
    }
}
