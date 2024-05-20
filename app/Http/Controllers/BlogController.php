<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Blog;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getManageBlog(){
        
        if(auth()->user()->role == 'A'){
        $data =[
            'blogs' => Blog::all()
        ];
        return view('admin.blog.manage', $data);
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
    }
    public function getAddBlog(){
        if(auth()->user()->role == 'A'){
        return view('admin.blog.add');
        }
        else{
            dd('Access denied you are not allowed to access this page.'); 
        }
    }
    public function postBlogAdd(Request $request){
        if(auth()->user()->role == 'A'){
                $title = $request->input('title');
                $slug = Str::slug($title);
                $check = Blog::where('slug', $slug)->count();
                if($check == 0){
                $photo = $request->file('photo');
                $getuniquename = sha1($photo->getClientOriginalName().time());
                $getextension = $photo->getClientOriginalExtension();
                $getrealname = $getuniquename.'.'.$getextension;
                $photo->move('site/uploads/blogs/', $getrealname);

        $blog = New Blog;
        $blog->type = $request->input('type');
        $blog->title = $request->input('title');
        $blog->slug = $slug;
        $blog->detail = $request->input('detail');
        $blog->photo = $getrealname;
        $blog->link = $request->input('video');
        $blog->save();
        return redirect()->back()->with('status', 'Blog Added Success');
                }
                else{
                    return redirect()->back()->with('status', 'Unable to add due to dublicate Blog title');
                }
            }
            else{
                dd('Access denied you are not allowed to access this page.');
            }
        
    }
    public function getBlogEdit(Blog $blog){
        if(auth()->user()->role == 'A'){
        $data = [
            'blog' => $blog
        ];
        return view('admin.blog.edit', $data);
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
    }
    public function postBlogEdit(Blog $blog, Request $request){
        if(auth()->user()->role == 'A'){
                $title = $request->input('title');
                $slug = Str::slug($title);
                $check = Blog::where('slug', $slug)->where('id', '!=', $blog->id)->count();
                if($check == 0){
                    if($request->file('photo')){
                        $photo = $request->file('photo');
                            // unlink('site/uploads/blogs/'.$testimonial->photo);
                            $getuniquename = sha1($photo->getClientOriginalName().time());
                            $getextension = $photo->getClientOriginalExtension();
                            $getrealname = $getuniquename.'.'.$getextension;
                            $photo->move('site/uploads/blogs/', $getrealname);

                            $blog->type = $request->input('type');
                            $blog->title = $request->input('title');
                            $blog->slug = $slug;
                            $blog->detail = $request->input('detail');
                            $blog->photo = $getrealname;
                            $blog->link = $request->input('video');
                            $blog->save();
                    }
                    else{
                        $blog->type = $request->input('type');
                        $blog->title = $request->input('title');
                        $blog->slug = $slug;
                        $blog->detail = $request->input('detail');
                        $blog->link = $request->input('video');
                        $blog->save();
                    }
                return redirect()->back()->with('status', 'Testimonial Edited Success');
    }
    else{
        return redirect()->back()->with('status', 'Unable to add due to dublicate Blog title');
    }
}
else{
    dd('Access denied you are not allowed to access this page.');
}
    
    }

    public function getDeleteBlog(Blog $blog){
        if(auth()->user()->role == 'A'){
        unlink('site/uploads/blogs/'.$blog->photo);
        $blog->delete();
        return redirect()->back()->with('status', 'Blog Deleted Success');
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
    }
}
