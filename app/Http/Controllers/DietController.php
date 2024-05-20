<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dietplan;

class DietController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getManageDiet(){
        if(auth()->user()->role == 'A'){
        $data =[
            'diets' => Dietplan::all()
        ];
        return view('admin.diet.manage', $data);
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
    }
    public function getAddDiet(){
        if(auth()->user()->role == 'A'){
        return view('admin.diet.add');
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
    }
    public function postDietAdd(Request $request){
        if(auth()->user()->role == 'A'){
                $photo = $request->file('photo');
                $getuniquename = sha1($photo->getClientOriginalName().time());
                $getextension = $photo->getClientOriginalExtension();
                $getrealname = $getuniquename.'.'.$getextension;
                $photo->move('site/uploads/diets/', $getrealname);

        $diet = New Dietplan;
        $diet->title = $request->input('title');
        $diet->detail = $request->input('detail');
        $diet->photo = $getrealname;
        $diet->save();
        return redirect()->back()->with('status', 'Diet Plan Added Success');
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
               
        
    }
    public function getDietEdit(Dietplan $dietplan){
        if(auth()->user()->role == 'A'){
        $data = [
            'dietplan' => $dietplan
        ];
        return view('admin.diet.edit', $data);
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
    }
    public function postDietEdit(Dietplan $dietplan, Request $request){
        if(auth()->user()->role == 'A'){   
                    if($request->file('photo')){
                        $photo = $request->file('photo');
                            // unlink('site/uploads/blogs/'.$testimonial->photo);
                            $getuniquename = sha1($photo->getClientOriginalName().time());
                            $getextension = $photo->getClientOriginalExtension();
                            $getrealname = $getuniquename.'.'.$getextension;
                            $photo->move('site/uploads/diets/', $getrealname);

                            
                            $dietplan->title = $request->input('title');
                            $dietplan->detail = $request->input('detail');
                            $dietplan->photo = $getrealname;
                            $dietplan->save();
                    }
                    else{
                        $dietplan->title = $request->input('title');
                            $dietplan->detail = $request->input('detail');
                            $dietplan->save();
                    }
                return redirect()->back()->with('status', 'Diet Plan Edited Success');
                }
                else{
                    dd('Access denied you are not allowed to access this page.');
                }
    
    }

    public function getDeleteDiet(Dietplan $dietplan){
        // unlink('site/uploads/blogs/'.$dietplan->photo);
        if(auth()->user()->role == 'A'){  
        $dietplan->delete();
        return redirect()->back()->with('status', 'Diet Plan Deleted Success');
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
    }
}
