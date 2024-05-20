<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
    public function getManageSlider(){
        
        if(auth()->user()->role == 'A'){
        $data =[
            'sliders' => Slider::all()
        ];
        return view('admin.slider.manage', $data);
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
    }
    public function getAddSlider(){
        return view('admin.slider.add');
    }
    public function postSliderAdd(Request $request){
        $photo = $request->file('photo');
        $getuniquename_photo = sha1($photo->getClientOriginalName().time());
            $getextension_photo = $photo->getClientOriginalExtension();
            $getrealname_photo = $getuniquename_photo.'.'.$getextension_photo;
            $photo->move('site/uploads/sliders/', $getrealname_photo);

        $slider = New Slider;
        $slider->photo = $getrealname_photo;
        $slider->btnvalue = $request->input('value');
        $slider->btnlink = $request->input('link');
        $slider->save();
        return redirect()->route('getManageSlider')->with('status', 'Slider added successfuly');

    }
    public function getDeleteSlider(Slider $slider){
        $slider->delete();
        return redirect()->route('getManageSlider')->with('status', 'Slider deleted successfuly');
    }
}
