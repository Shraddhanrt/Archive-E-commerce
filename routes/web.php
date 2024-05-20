<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Clear Cache facade value:
Route::get('/clear-cache', function ()
{
	$exitCode = Artisan::call('cache:clear');
	return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function ()
{
	$exitCode = Artisan::call('optimize');
	return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function ()
{
	$exitCode = Artisan::call('route:cache');
	return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function ()
{
	$exitCode = Artisan::call('route:clear');
	return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function ()
{
	$exitCode = Artisan::call('view:clear');
	return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function ()
{
	$exitCode = Artisan::call('config:clear');
	return '<h1>Clear Config cleared</h1>';
});

Route::get('/', [App\Http\Controllers\SiteController::class, 'getHome'])->name('getHome');
Route::get('/story', [App\Http\Controllers\SiteController::class, 'getStory'])->name('getStory');
Route::get('/products', [App\Http\Controllers\SiteController::class, 'getProducts'])->name('getProducts');
Route::get('/product/{slug}', [App\Http\Controllers\SiteController::class, 'getProductDetail'])->name('getProductDetail');
Route::get('/cartsingle/{product}', [App\Http\Controllers\SiteController::class, 'getAddtoCardSingle'])->name('getAddtoCardSingle');
Route::post('/cart', [App\Http\Controllers\SiteController::class, 'postAddToCart'])->name('postAddToCart');
Route::get('/carts', [App\Http\Controllers\SiteController::class, 'getCart'])->name('getCart');
Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'getCheckOut'])->name('getCheckOut');
Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'postCheckOut'])->name('postCheckOut');
Route::get('/order-confirmation', [App\Http\Controllers\CheckoutController::class, 'getDirectBankTransfer'])->name('getDirectBankTransfer');

Route::get('/cart/delete/{cart}', [App\Http\Controllers\SiteController::class, 'getDeleteCart'])->name('getDeleteCart');
Route::post('/cart/edit/{cart}', [App\Http\Controllers\SiteController::class, 'postEditCart'])->name('postEditCart');
Route::get('/contact', [App\Http\Controllers\SiteController::class, 'getContact'])->name('getContact');
Route::get('/blogs', [App\Http\Controllers\SiteController::class, 'getBlogs'])->name('getBlogs');
Route::get('/order/confirm/{cart}', [App\Http\Controllers\SiteController::class, 'getConfirm'])->name('getConfirm');
Route::get('/payments/', [App\Http\Controllers\SiteController::class, 'getPayment'])->name('getPayment');
Route::get('/online/order/result', [App\Http\Controllers\SiteController::class, 'getSenangpayStatus'])->name('getSenangpayStatus');
Route::get('/online/order/cancel', [App\Http\Controllers\SiteController::class, 'getCancelPayment'])->name('getCancelPayment');
Route::get('/order/status/{cart}', [App\Http\Controllers\SiteController::class, 'getOrderStatus'])->name('getOrderStatus');
Route::get('/ritzenchantress/{slug}', [App\Http\Controllers\SiteController::class, 'getBlogDetail'])->name('getBlogDetail');
Route::get('/newsandevents', [App\Http\Controllers\SiteController::class, 'getNews'])->name('getNews');
Route::get('/dietplan', [App\Http\Controllers\SiteController::class, 'getDietPlan'])->name('getDietPlan');
Route::get('/testimonials', [App\Http\Controllers\SiteController::class, 'getTestimonials'])->name('getTestimonials');
Route::get('/faq', [App\Http\Controllers\SiteController::class, 'getFaq'])->name('getFaq');
Route::get('/policy/{page}', [App\Http\Controllers\SiteController::class, 'getPolicy'])->name('getPolicy');
Route::get('/ordered/success/{cardcode}', [App\Http\Controllers\SiteController::class, 'getCodSuccessStatus'])->name('getCodSuccessStatus');
Route::get('/paypal', [App\Http\Controllers\PayPalController::class, 'payWithpaypal'])->name('payWithpaypal');
Route::get('/paypal/status', [App\Http\Controllers\PayPalController::class, 'getPaymentStatus'])->name('getPaymentStatus');
Route::get('/clearcart', [App\Http\Controllers\SiteController::class, 'getClearCarts'])->name('getClearCarts');
Route::get('/order-confirmed/invoice/{code}', [App\Http\Controllers\SiteController::class, 'getOrderConfirmInvoice'])->name('getOrderConfirmInvoice');
Route::post('/order-callback/callback', [App\Http\Controllers\SiteController::class, 'getSenangpayCallBack'])->name('getSenangpayCallBack');
Route::post('/save1-shipping', [App\Http\Controllers\SiteController::class, 'postShiipingAddressToSession'])->name('postShiipingAddressToSession');
Route::post('/newsletter/add', [App\Http\Controllers\SiteController::class, 'postAddNewsLetter'])->name('postAddNewsLetter');
Route::post('/forgotpassword', [App\Http\Controllers\SiteController::class, 'postForgotPassword'])->name('postForgotPassword');
Route::get('/resetpassword/{code}', [App\Http\Controllers\SiteController::class, 'getResetPasswordLink'])->name('getResetPasswordLink');
Route::post('/resetpassword/{code}', [App\Http\Controllers\SiteController::class, 'postPassportReset'])->name('postPassportReset');
Route::get('/permissiondenied', [App\Http\Controllers\SiteController::class, 'getPermissionDenied'])->name('getPermissionDenied');

Route::post('/agent/login', [App\Http\Controllers\AgentController::class, 'postAgentCheckLogin'])->name('postAgentCheckLogin');
Route::get('/agent/logout', [App\Http\Controllers\AgentController::class, 'AgentLogOut'])->name('AgentLogOut');

Route::get('/customer/login', [App\Http\Controllers\SiteController::class, 'getCustomerLogin'])->name('getCustomerLogin');
Route::post('/customer/login', [App\Http\Controllers\SiteController::class, 'postCustomerLogin'])->name('postCustomerLogin');
Route::post('/customer/register', [App\Http\Controllers\SiteController::class, 'postCustomerRegister'])->name('postCustomerRegister');
Route::get('/customer/logout', [App\Http\Controllers\SiteController::class, 'getCustomerLogOut'])->name('getCustomerLogOut');
Route::get('/customer/dashboard', [App\Http\Controllers\CustomerController::class, 'getCustomerDashboard'])->name('getCustomerDashboard');
Route::get('/customer/order/history', [App\Http\Controllers\CustomerController::class, 'getCustomerOrderHistory'])->name('getCustomerOrderHistory');
Route::get('/customer/profile', [App\Http\Controllers\CustomerController::class, 'getCustomerprofile'])->name('getCustomerprofile');
Route::get('/customer/password-change', [App\Http\Controllers\CustomerController::class, 'getCustomerpasswordChange'])->name('getCustomerpasswordChange');
Route::post('/getorderdetail/ajax', [App\Http\Controllers\CustomerController::class, 'getOrderDetailAjax'])->name('getOrderDetailAjax');

Route::get('/customer/profile11', [App\Http\Controllers\CustomerController::class, 'getCustomerProfile'])->name('getCustomerProfile');
Route::get('/customer/buyer-infotmation\profile\edit', [App\Http\Controllers\CustomerController::class, 'getBuyerInformationEdit'])->name('getBuyerInformationEdit');
Route::post('/customer/buyer-infotmation\profile\edit', [App\Http\Controllers\CustomerController::class, 'postEditBuyerInformation'])->name('postEditBuyerInformation');
Route::get('/customer/shipping-infotmation\profile\edit', [App\Http\Controllers\CustomerController::class, 'getShippingInformationEdit'])->name('getShippingInformationEdit');
Route::post('/customer/shipping-infotmation\profile\edit', [App\Http\Controllers\CustomerController::class, 'postEditShippingInformation'])->name('postEditShippingInformation');
Route::post('/customer/passwordchange', [App\Http\Controllers\CustomerController::class, 'postPasswordChange'])->name('postPasswordChange');

Route::post('/customer/ajax/checkcoupon', [App\Http\Controllers\CustomerController::class, 'ajaxPostCheckCoupon'])->name('ajaxPostCheckCoupon');

Route::get('/popupbanner/manage', [App\Http\Controllers\NoticesController::class, 'getPopUpBanner'])->name('getPopUpBanner');
Route::post('/popupbanner/manage/{banner}', [App\Http\Controllers\NoticesController::class, 'postPopUpBanner'])->name('postPopUpBanner');
Route::get('/popupbanner/remove/{banner}', [App\Http\Controllers\NoticesController::class, 'getRemoveBanner'])->name('getRemoveBanner');

Route::get('/notics/manage/', [App\Http\Controllers\NoticesController::class, 'getManageNotices'])->name('getManageNotices');
Route::post('/notics/add/', [App\Http\Controllers\NoticesController::class, 'postAddNotice'])->name('postAddNotice');
Route::get('/notics/delete/{notice}', [App\Http\Controllers\NoticesController::class, 'getDeleteNotice'])->name('getDeleteNotice');

Route::get('/paymentwithesewa/{order}', [App\Http\Controllers\EsewaController::class, 'getPayWithEsewa'])->name('getPayWithEsewa');
Route::get('/esewa-success', [App\Http\Controllers\EsewaController::class, 'getEsewaPaymentSuccess'])->name('getEsewaPaymentSuccess');










Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['middleware' => 'auth'], function ()
{
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('upgrade', function ()
	{
		return view('pages.upgrade');
	})->name('upgrade');
	Route::get('map', function ()
	{
		return view('pages.maps');
	})->name('map');
	Route::get('icons', function ()
	{
		return view('pages.icons');
	})->name('icons');
	Route::get('table-list', function ()
	{
		return view('pages.tables');
	})->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

	Route::get('manage/category', ['as' => 'getManageCategory', 'uses' => 'App\Http\Controllers\CategoryController@getManageCategory']);
	Route::post('manage/category', ['as' => 'postAddCatagory', 'uses' => 'App\Http\Controllers\CategoryController@postAddCatagory']);

	Route::get('manage/products', ['as' => 'getProductManage', 'uses' => 'App\Http\Controllers\ProductController@getProductManage']);
	Route::get('add/product', ['as' => 'getAddProduct', 'uses' => 'App\Http\Controllers\ProductController@getAddProduct']);
	Route::post('add/product', ['as' => 'postProductAdd', 'uses' => 'App\Http\Controllers\ProductController@postProductAdd']);
	Route::get('/product/edit/{product}', [App\Http\Controllers\ProductController::class, 'getProductEdit'])->name('getProductEdit');
	Route::post('/product/edit/{product}', [App\Http\Controllers\ProductController::class, 'postProductEdit'])->name('postProductEdit');
	Route::get('/product/delete/{product}', [App\Http\Controllers\ProductController::class, 'getDeleteProduct'])->name('getDeleteProduct');
	Route::get('/product/photos/{product}', [App\Http\Controllers\ProductController::class, 'getAddOtherPhoto'])->name('getAddOtherPhoto');
	Route::post('/product/photos/{product}', [App\Http\Controllers\ProductController::class, 'postProductPhotoAdd'])->name('postProductPhotoAdd');
	Route::get('/product/stock/{product}', [App\Http\Controllers\ProductController::class, 'getStockChange'])->name('getStockChange');
	Route::get('/product/toogle/{product}', [App\Http\Controllers\ProductController::class, 'getProductToogle'])->name('getProductToogle');

	Route::get('/manage/orders', [App\Http\Controllers\OrderController::class, 'getManageOrder'])->name('getManageOrder');
	Route::get('/invoice/{order}', [App\Http\Controllers\OrderController::class, 'getManageInvoice'])->name('getManageInvoice');
	Route::get('/order-admin/delete/{order}', [App\Http\Controllers\OrderController::class, 'getDeleteOrder'])->name('getDeleteOrder');
	Route::get('/manage/orders/unpaid', [App\Http\Controllers\OrderController::class, 'getManageUnpaidOrder'])->name('getManageUnpaidOrder');
	Route::get('/manage/orders/paid', [App\Http\Controllers\OrderController::class, 'getManagePaidOrder'])->name('getManagePaidOrder');
	Route::get('/manage/orders/detail/{order}', [App\Http\Controllers\OrderController::class, 'getOrderDetail'])->name('getOrderDetail');
	Route::get('/makeasapaid/{order}', [App\Http\Controllers\OrderController::class, 'getMakeAsPaid'])->name('getMakeAsPaid');
	Route::get('/makeasaunpaid/{order}', [App\Http\Controllers\OrderController::class, 'getMakeAsUnPaid'])->name('getMakeAsUnPaid');
	Route::post('/orderstatus/modify', [App\Http\Controllers\OrderController::class, 'postChangeOrderStatus'])->name('postChangeOrderStatus');

	Route::get('/manage/testimonial', [App\Http\Controllers\TestimonialController::class, 'getManageTestimonial'])->name('getManageTestimonial');
	Route::get('/add/testimonial', [App\Http\Controllers\TestimonialController::class, 'getAddTestimonial'])->name('getAddTestimonial');
	Route::post('/add/testimonial', [App\Http\Controllers\TestimonialController::class, 'postTestimonialAdd'])->name('postTestimonialAdd');
	Route::get('/testimonial/edit/{testimonial}', [App\Http\Controllers\TestimonialController::class, 'getTestimonialEdit'])->name('getTestimonialEdit');
	Route::post('/testimonial/edit/{testimonial}', [App\Http\Controllers\TestimonialController::class, 'postTestimonialEdit'])->name('postTestimonialEdit');
	Route::get('/testimonial/delete/{testimonial}', [App\Http\Controllers\TestimonialController::class, 'getDeleteTestimonial'])->name('getDeleteTestimonial');

	Route::get('/manage/blog', [App\Http\Controllers\BlogController::class, 'getManageBlog'])->name('getManageBlog');
	Route::get('/add/blog', [App\Http\Controllers\BlogController::class, 'getAddBlog'])->name('getAddBlog');
	Route::post('/add/blog', [App\Http\Controllers\BlogController::class, 'postBlogAdd'])->name('postBlogAdd');
	Route::get('/blog/edit/{blog}', [App\Http\Controllers\BlogController::class, 'getBlogEdit'])->name('getBlogEdit');
	Route::post('/blog/edit/{blog}', [App\Http\Controllers\BlogController::class, 'postBlogEdit'])->name('postBlogEdit');
	Route::get('/blog/delete/{blog}', [App\Http\Controllers\BlogController::class, 'getDeleteBlog'])->name('getDeleteBlog');

	Route::get('/manage/faq', [App\Http\Controllers\FaqController::class, 'getManageFaq'])->name('getManageFaq');
	Route::get('/add/faq', [App\Http\Controllers\FaqController::class, 'getAddFaq'])->name('getAddFaq');
	Route::post('/add/faq', [App\Http\Controllers\FaqController::class, 'postFaqAdd'])->name('postFaqAdd');
	Route::get('/faq/edit/{faq}', [App\Http\Controllers\FaqController::class, 'getFaqEdit'])->name('getFaqEdit');
	Route::post('/faq/edit/{faq}', [App\Http\Controllers\FaqController::class, 'postFaqEdit'])->name('postFaqEdit');
	Route::get('/faq/delete/{faq}', [App\Http\Controllers\FaqController::class, 'getDeleteFaq'])->name('getDeleteFaq');

	Route::get('/manage/diet', [App\Http\Controllers\DietController::class, 'getManageDiet'])->name('getManageDiet');
	Route::get('/add/diet', [App\Http\Controllers\DietController::class, 'getAddDiet'])->name('getAddDiet');
	Route::post('/add/diet', [App\Http\Controllers\DietController::class, 'postDietAdd'])->name('postDietAdd');
	Route::get('/diet/edit/{dietplan}', [App\Http\Controllers\DietController::class, 'getDietEdit'])->name('getDietEdit');
	Route::post('/diet/edit/{dietplan}', [App\Http\Controllers\DietController::class, 'postDietEdit'])->name('postDietEdit');
	Route::get('/diet/delete/{dietplan}', [App\Http\Controllers\DietController::class, 'getDeleteDiet'])->name('getDeleteDiet');

	Route::get('/manage/Policy', [App\Http\Controllers\PolicyController::class, 'getManageReturnPolicy'])->name('getManageReturnPolicy');
	Route::post('/manage/Policy/edit/{policy}', [App\Http\Controllers\PolicyController::class, 'getEditPolicy'])->name('getEditPolicy');

	Route::post('/send/trackcode/{order}', [App\Http\Controllers\OrderController::class, 'getSendTrackCode'])->name('getSendTrackCode');
	Route::get('/courier/manage/{order}', [App\Http\Controllers\OrderController::class, 'getManageCourier'])->name('getManageCourier');
	Route::post('/addtocart/parsal', [App\Http\Controllers\OrderController::class, 'postAddtoCartParsal'])->name('postAddtoCartParsal');
	Route::get('/modify/courier/{order}', [App\Http\Controllers\OrderController::class, 'getAdminChangeCourier'])->name('getAdminChangeCourier');

	Route::get('/followback/{order}', [App\Http\Controllers\OrderController::class, 'getSendEmailFollowBack'])->name('getSendEmailFollowBack');

	Route::get('/admin/customer/list', [App\Http\Controllers\HomeController::class, 'getAllCustomer'])->name('getAllCustomer');
	Route::post('/getListofCustomerOrder/ajax', [App\Http\Controllers\HomeController::class, 'getListofCustomerOrder'])->name('getListofCustomerOrder');
	Route::post('/admin/makeagent', [App\Http\Controllers\HomeController::class, 'postUpdateAsAAgent'])->name('postUpdateAsAAgent');
	Route::get('/admin/remove/makeagent/{customer}', [App\Http\Controllers\HomeController::class, 'getAdminRemoveAgent'])->name('getAdminRemoveAgent');
	Route::get('/admin/chnagecourier', [App\Http\Controllers\HomeController::class, 'AminPostModifyCourier'])->name('AminPostModifyCourier');

	Route::get('/coupon/manage', [App\Http\Controllers\CouponController::class, 'getCouponManage'])->name('getCouponManage');
	Route::post('/coupon/manage', [App\Http\Controllers\CouponController::class, 'postCreateCoupon'])->name('postCreateCoupon');
	Route::get('/coupon/edit/{coupon}', [App\Http\Controllers\CouponController::class, 'getEditCoupon'])->name('getEditCoupon');
	Route::get('/coupon/delete/{coupon}', [App\Http\Controllers\CouponController::class, 'getDeleteCoupon'])->name('getDeleteCoupon');
	Route::post('/coupon/edit/{coupon}', [App\Http\Controllers\CouponController::class, 'postEditCoupon'])->name('postEditCoupon');
	Route::get('/coupon/enable-disable/{coupon}', [App\Http\Controllers\CouponController::class, 'getEnableDisableCoupon'])->name('getEnableDisableCoupon');


	Route::get('/manage/slider', [App\Http\Controllers\SliderController::class, 'getManageSlider'])->name('getManageSlider');
	Route::get('/add/slider', [App\Http\Controllers\SliderController::class, 'getAddSlider'])->name('getAddSlider');
	Route::post('/add/sider', [App\Http\Controllers\SliderController::class, 'postSliderAdd'])->name('postSliderAdd');
	Route::get('/slider/delete/{slider}', [App\Http\Controllers\SliderController::class, 'getDeleteSlider'])->name('getDeleteSlider');
});
