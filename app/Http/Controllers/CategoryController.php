<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Catagory;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    

    public function getManageCategory(){
        if(auth()->user()->name == 'A'){
        $data =[
            'catagories' =>Catagory::all()
        ];
        return view('admin.catagory.manage', $data);
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
    }

    public function postAddCatagory(Request $request){
        if(auth()->user()->name == 'A'){
        $title = $request->input('name');
        $detail = $request->input('detail');
        $photo = $request->file('photo');
        $slug = Str::slug($title);

        $checkslug = Catagory::where('slug', $slug)->count();
        
            if($checkslug == 0){
                if($photo){
                    $getuniquename = sha1($photo->getClientOriginalName().time());
                $getextension = $photo->getClientOriginalExtension();
                $getrealname = $getuniquename.'.'.$getextension;
                $photo->move('site/uploads/catagories/', $getrealname);
                }
                else{
                    $getrealname =null;
                }

                $catagory = New Catagory;
                $catagory->name = $title;
                $catagory->slug = $slug;
                $catagory->detail = $detail;
                $catagory->photo = $getrealname;
                $catagory->save();

                return redirect()->back()->with('status', 'Catagory Added Success');
                
            }
            else{
                return redirect()->back()->with('status', 'Unable to add. due to dublicate catagory title. Please change your title, which is unique from other catagory'); 
            }
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }


    }
}
