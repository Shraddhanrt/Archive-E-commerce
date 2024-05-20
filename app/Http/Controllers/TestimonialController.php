<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getManageTestimonial(){
        if(auth()->user()->role == 'A'){
        $data =[
            'testimonials' => Testimonial::all()
        ];
        return view('admin.testimonial.manage', $data);
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
    }
    public function getAddTestimonial(){
        if(auth()->user()->role == 'A'){
        return view('admin.testimonial.add');
    }
    else{
        dd('Access denied you are not allowed to access this page.');
    }
    }
    public function postTestimonialAdd(Request $request){
        if(auth()->user()->role == 'A'){
        $photo = $request->file('photo');
                $getuniquename = sha1($photo->getClientOriginalName().time());
                $getextension = $photo->getClientOriginalExtension();
                $getrealname = $getuniquename.'.'.$getextension;
                $photo->move('site/uploads/testimonials/', $getrealname);

        $testimonial = New Testimonial;
        $testimonial->name = $request->input('name');
        $testimonial->title = $request->input('title');
        $testimonial->detail = $request->input('detail');
        $testimonial->photo = $getrealname;
        $testimonial->save();
        return redirect()->back()->with('status', 'Testimonial Added Success');
    }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
        
    }
    public function getTestimonialEdit(Testimonial $testimonial){
        if(auth()->user()->role == 'A'){
        $data = [
            'testimonial' => $testimonial
        ];
        return view('admin.testimonial.edit', $data);
    }
    else{
        dd('Access denied you are not allowed to access this page.');
    }
    }
    public function postTestimonialEdit(Testimonial $testimonial, Request $request){
        if(auth()->user()->role == 'A'){
        if($request->file('photo')){
            $photo = $request->file('photo');
                unlink('site/uploads/testimonials/'.$testimonial->photo);
                $getuniquename = sha1($photo->getClientOriginalName().time());
                $getextension = $photo->getClientOriginalExtension();
                $getrealname = $getuniquename.'.'.$getextension;
                $photo->move('site/uploads/testimonials/', $getrealname);

            $testimonial->title = $request->input('title');
            $testimonial->name = $request->input('name');
            $testimonial->detail = $request->input('detail');
            $testimonial->photo = $getrealname;
            $testimonial->save();
        }
        else{
            $testimonial->title = $request->input('title');
            $testimonial->name = $request->input('name');
            $testimonial->detail = $request->input('detail');
            $testimonial->save();
        }
        return redirect()->back()->with('status', 'Testimonial Edited Success');
    }
    else{
        dd('Access denied you are not allowed to access this page.');
    }
    }

    public function getDeleteTestimonial(Testimonial $testimonial){
        if(auth()->user()->role == 'A'){
        unlink('site/uploads/testimonials/'.$testimonial->photo);
        $testimonial->delete();
        return redirect()->back()->with('status', 'Testimonial Deleted Success');
    }
    else{
        dd('Access denied you are not allowed to access this page.');
    }
    }
}
