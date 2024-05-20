<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Catagory;
use App\Models\Productphoto;
use App\Models\Cart;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getProductManage(){
        if(auth()->user()->role == 'A'){
    	$data =[
    		'products'=>Product::orderby('id','desc')->where('active', 'Y')->get(),
            'unactiveproducts'=>Product::orderby('id','desc')->where('active', 'N')->get(),
    		'catagories'=>Catagory::all(),
    	];
    	return view('admin.product.manage', $data);
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
    }
    public function getProductToogle(Product $product){
        if($product->active == 'Y'){
            $product->active = 'N';
            $product->save();
            return redirect()->back()->with('status', 'Product Hide Success');
        }
        else{
            $product->active = 'Y';
            $product->save();
            return redirect()->back()->with('status', 'Product Active Success');
        }

    }
    public function getAddProduct(){
        if(auth()->user()->role == 'A'){
        $data=[
            'catagories'=>Catagory::all(),
        ];
    	return view('admin.product.add', $data);
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
    }
    public function postProductAdd(Request $request){
        if(auth()->user()->role == 'A'){
    	$title = $request->input('name');
    	$slug = Str::slug($title);
        $code = Str::random(4);
        $changeslug = $slug.'-'.$code;
    	$catagory_id = $request->input('catagory_id');
    	$detail = $request->input('detail');
    	$benefit = $request->input('benefit');
    	$acost = $request->input('acost');
    	$dcost = $request->input('dcost');
    	$ingredient = $request->input('ingredient');
    	$weight = $request->input('weight');
        $shippingfree = $request->input('shippingfree');
    	$photo = $request->file('photo');
        if($shippingfree == 'on'){
            $freeshipping = 'Y';
        }
        else{
            $freeshipping = 'N';
        }
    	

    		$getuniquename_photo = sha1($photo->getClientOriginalName().time());
            $getextension_photo = $photo->getClientOriginalExtension();
            $getrealname_photo = $getuniquename_photo.'.'.$getextension_photo;
            $photo->move('site/uploads/products/', $getrealname_photo);

            $product = New Product;
            $product->name = $title;
            $product->slug = $changeslug;
            $product->catagory_id = $catagory_id;
            $product->detail = $detail;
            $product->benefit = $benefit;
            $product->acost = $acost;
            $product->dcost = $dcost;
            $product->ingredient = $ingredient;
            $product->weight = $weight;
            $product->shippingfree = $freeshipping;
            $product->photo = $getrealname_photo;
            $product->code = $code;
            $product->save();
            return redirect()->back()->with('message', 'Product Added Success');
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }

    }

    public function getProductPhotoAdd(Product $product){
        if(auth()->user()->role == 'A'){
    	$data =[
    		'product'=>$product,
    		'photos'=>Productphoto::orderby('id', 'desc')->where('product_id', $product->id)->get()
    	];
    	return view('admin.product.managephoto', $data);
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
    }
  
    public function postProductPhotoAdd(Request $request, $productid){
        if(auth()->user()->role == 'A'){
        $photo = $request->file('photo');
        $i=0;
        $countphoto = count($photo);
            foreach($photo as $item=>$key){ 
                 
                    $getDocumentname = $i.''.md5(time());
                    $i=$i+1;
                $getPhotoExtensin = $request->photo[$item] -> getClientOriginalExtension();
                $getrealDocumentname=$getDocumentname.'.'.$getPhotoExtensin;
                $request->photo[$item]->move('site/uploads/products/',$getrealDocumentname);
                $documents_data = array(
                    'photo' => $getrealDocumentname,
                    'product_id' => $productid
                );
                    Productphoto::insert($documents_data);
                
            }
        return redirect()->back()->with('message-success', 'Gallery Added successfully!');
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
    }
    public function getDeleteProduct(Product $product){
        if(auth()->user()->role == 'A'){
            // check product already in cart table or not
            $cartcheck = Cart::where('product_id', $product->id)->count();
            if($cartcheck == 0){
                unlink('site/uploads/products/'.$product->photo);
                if($product->alt_product != null){
                    unlink('site/uploads/products/'.$product->alt_photo);
                }
                $product->delete();
                return redirect()->back()->with('status', 'Product deleted Success');
            }
            else{
                return redirect()->back()->with('status', 'Product unable to delete because this product was used in customer cart table.');
            }
            
    }
    else{
        dd('Access denied you are not allowed to access this page.');
    }
    }
    public function getProductPhotoDelete(Productphoto $productphoto){
        if(auth()->user()->role == 'A'){
    	unlink('site/product/'.$productphoto->photo);
    	$productphoto->delete();
    	return redirect()->back()->with('message', 'Photo deleted Success');
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
    }
    public function getManageSizeColor(Product $product){
        if(auth()->user()->role == 'A'){
    	$data =[
    		'product'=>$product,
    		'sizes'=>Productsize::where('product_id', $product->id)->get(),
    		'colors'=>Productcolor::where('product_id', $product->id)->get()
    	];
    	return view('admin.product.managesizecolor', $data);
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
    }
    public function postProductColorAdd(Request $request, $product){
        if(auth()->user()->role == 'A'){
    	$color = $request->input('color');

    	$pcolor = New Productcolor;
    	$pcolor->color= $color;
    	$pcolor->product_id= $product;
    	$pcolor->save();
    	return redirect()->back()->with('message', 'Photo Color Added Success');
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
    }
    public function postProductSizeAdd(Request $request, $product){
        if(auth()->user()->role == 'A'){
    	$size = $request->input('size');

    	$psize = New Productsize;
    	$psize->size= $size;
    	$psize->product_id= $product;
    	$psize->save();
    	return redirect()->back()->with('message', 'Photo Size Added Success');
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
    }

    public function getDeleteProductSize(Productsize $size){
        if(auth()->user()->role == 'A'){
    	$size->delete();
    	return redirect()->back()->with('message', 'Product size delete Success');
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
    }
    public function getDeleteProductColor(Productcolor $color){
        if(auth()->user()->role == 'A'){
    	$color->delete();
    	return redirect()->back()->with('message', 'Product Color delete Success');
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
    }
    public function getProductEdit(Request $request, Product $product){
        if(auth()->user()->role == 'A'){
        $data=[
            'product'=>$product,
            'catagories'=>Catagory::all(),
        ];
        return view('admin.product.edit',$data);
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
    }
    public function postProductEdit(Request $request , Product $product){
        if(auth()->user()->role == 'A'){
        $title = $request->input('name');
    	$slug = Str::slug($title);
        $code = $product->code;
        $changeslug = $slug.'-'.$code;
    	$catagory_id = $request->input('catagory_id');
    	$detail = $request->input('detail');
    	$benefit = $request->input('benefit');
    	$acost = $request->input('acost');
    	$dcost = $request->input('dcost');
    	$ingredient = $request->input('ingredient');
        $weight = $request->input('weight');
    	$photo = $request->file('photo');
    	$altphoto = $request->file('altphoto');
        $shippingfree = $request->input('shippingfree');
        if($shippingfree == 'on'){
            $freeshipping = 'Y';
        }
        else{
            $freeshipping = 'N';
        }

         $checked=Product::where('slug',$slug)->where('id','!=',$product->id)->count();
         if($checked == 0){
            if($photo){
                $getuniquename_photo = sha1($photo->getClientOriginalName().time());
                $getextension_photo = $photo->getClientOriginalExtension();
                $getrealname_photo = $getuniquename_photo.'.'.$getextension_photo;
                $photo->move('site/uploads/products/', $getrealname_photo);

                $product->name = $title;
                $product->slug = $changeslug;
                $product->catagory_id = $catagory_id;
                $product->detail = $detail;
                $product->benefit = $benefit;
                $product->acost = $acost;
                $product->dcost = $dcost;
                $product->ingredient = $ingredient;
                $product->weight = $weight;
                $product->shippingfree =$freeshipping;
                $product->photo = $getrealname_photo;
                $product->alt_photo = $getrealname_photo;
                $product->save();
            }
            else{
                $product->name = $title;
                $product->slug = $changeslug;
                $product->catagory_id = $catagory_id;
                $product->detail = $detail;
                $product->benefit = $benefit;
                $product->acost = $acost;
                $product->dcost = $dcost;
                $product->weight = $weight;
                $product->shippingfree =$freeshipping;
                $product->ingredient = $ingredient;
                $product->save();
            }
                return redirect()->route('getProductManage')->with('message', 'Product Edited Success');                

            }
    
         
         else{
             return redirect()->back()->with('message', 'Unable to edit. due to dublicate product title. Please change your title, which is unique from other product');

         }
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
    }

    public function getAddOtherPhoto(Product $product){
        if(auth()->user()->role == 'A'){
        $data =[
            'photos' => Productphoto::where('product_id', $product->id)->get(),
            'product' => $product
        ];
        return view('admin.product.addphoto', $data);
        }
        else{
            dd('Access denied you are not allowed to access this page.');
        }
    }
    public function getStockChange(product $product){
        if(auth()->user()->role == 'A'){
        if($product->stock == 'Y'){
            $product->stock = 'N';
            $product->save();
            return redirect()->back()->with('Item mark as Out of Stock');
        }
        else{
            $product->stock = 'Y';
            $product->save();
            return redirect()->back()->with('Item mark as In Stock');
        }
    }
    else{
        dd('Access denied you are not allowed to access this page.');
    }
    }
    
}
