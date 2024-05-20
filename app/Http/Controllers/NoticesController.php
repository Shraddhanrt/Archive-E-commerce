<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Notice;
use DB;

class NoticesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getPopUpBanner(){
        $data =[
        'banner' => Banner::limit(1)->first()
        ];
        return view('admin.notice.managepopupbanner', $data);
    }
    public function postPopUpBanner(Request $request, $banner){
       
        if($banner == 0){
            $photo = $request->file('photo');
    		$getuniquename_photo = sha1($photo->getClientOriginalName().time());
            $getextension_photo = $photo->getClientOriginalExtension();
            $getrealname_photo = $getuniquename_photo.'.'.$getextension_photo;
            $photo->move('site/uploads/notice/', $getrealname_photo);
            
            $bannersave = New Banner;
            $bannersave->banner = $getrealname_photo;
            $bannersave->save();
            return redirect()->back()->with('message', 'New Notice Banner Added.');

        }
        else{
            
            $photo = $request->file('photo');
    		$getuniquename_photo = sha1($photo->getClientOriginalName().time());
            $getextension_photo = $photo->getClientOriginalExtension();
            $getrealname_photo = $getuniquename_photo.'.'.$getextension_photo;
            $photo->move('site/uploads/notice/', $getrealname_photo);
            DB::table('banners')
			->where('id', $banner)
			->update([
				'banner' => $getrealname_photo,
                ]);
            return redirect()->back()->with('message', 'Notice Banner Replaced.');
        }
    }
    public function getRemoveBanner(Banner $banner){
        $banner->delete();
        return redirect()->back()->with('message', ' Banner Removed.');
    }
    public function getManageNotices(){
        $data =[
            'notices' => Notice::all()
        ];
        return view('admin.notice.managenotics', $data);
    }
    public function postAddNotice(Request $request){

        $notice = New Notice;
        $notice->title = $request->input('detail');
        $notice->save();
        return redirect()->back()->with('message', 'Notice added.');
    }
    public function getDeleteNotice(Notice $notice){
        $notice->delete();
        return redirect()->back()->with('message', 'Notice Deleted.');
    }
}
