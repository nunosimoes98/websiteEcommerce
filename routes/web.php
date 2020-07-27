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


Route::get('/', 'IndexController@index');

Route::get('/allproducts', 'IndexController@allproducts');

Route::get('/instagram-wolf', 'CmsController@instagram');

Route::match(['get', 'post'], '/admin', 'AdminController@login');

Route::get('/products/{url}', 'ProductsController@products');

Route::get('/product/{id}', 'ProductsController@product');

Route::get('/get-product-price', 'ProductsController@getProductPrice');

// carrinho
Route::match(['get','post'],'/add-cart','ProductsController@addToCart');
Route::match(['get', 'post'], '/cart', 'ProductsController@cart');
Route::get('/cart/delete-product/{id}', 'ProductsController@deleteCartProduct');
Route::get('/cart/update-quantity/{id}/{quantity}', 'ProductsController@updateCartQuantity');

// wish list
Route::match(['get', 'post'], '/wish-list', 'ProductsController@wishList');
Route::get('/wish-list/delete-product/{id}', 'ProductsController@deleteWishListProduct');

// procurar produtos
Route::post('/search-products','ProductsController@searchProducts');

// adicionar cupão
Route::post('/cart/apply-coupon', 'ProductsController@applyCoupon');

// conta
Route::get('/user-register', 'UsersController@userLoginRegister');
Route::get('/regist', 'UsersController@userRegister');
Route::post('/user-login', 'UsersController@login');
Route::post('/login-register', 'UsersController@register');
Route::get('confirm/{code}', 'UsersController@confirmAccount');
Route::match(['get','post'],'/forgot-password','UsersController@forgotPassword');

// Check Pincode
Route::post('/check-pincode','ProductsController@checkPincode');

// subscritores
Route::post('/check-subscriber-email','NewsletterController@checkSubscriber');
Route::post('/add-subscriber-email','NewsletterController@addSubscriber');

Route::group(['middleware'=>['frontlogin']],function(){

	// conta
	Route::match(['get','post'],'/user-account','UsersController@account');
	Route::post('/check-user-pwd', 'UsersController@chkUserPassword');
	Route::post('update-user-pwd', 'UsersController@updatePassword');

	// compras
	Route::match(['get','post'],'/checkout','ProductsController@checkout');
	Route::match(['get','post'],'/order-review','ProductsController@orderReview');
	Route::match(['get','post'],'/place-order','ProductsController@placeOrder');

	// dados de encomenda
	Route::get('/orders', 'ProductsController@userOrders');
	Route::get('/orders/{id}', 'ProductsController@userOrderDetails');

	//paypal
	Route::get('/paypal/thanks','ProductsController@thanksPaypal');
	Route::get('/paypal/cancel','ProductsController@cancelPaypal');
	Route::get('/thanks','ProductsController@thanks');
	Route::get('/paypal','ProductsController@paypal');


});

Route::get('multibanco','ProductsController@multibanco');


	Route::get('payumoney','PayumoneyController@payumoneyPayment');
	Route::post('/payumoney/response','PayumoneyController@payumoneyResponse');
	Route::get('/payumoney/thanks','PayumoneyController@payumoneyThanks');
	Route::get('/payumoney/fail','PayumoneyController@payumoneyFail');
	Route::get('/payumoney/verification/{id}','PayumoneyController@payumoneyVerification');
	Route::get('/payumoney/verify','PayumoneyController@payumoneyVerify');



Route::get('/user-logout', 'UsersController@logout');

//verificar se utilizador já existe
Route::match(['get', 'post'], '/check-email', 'UsersController@checkEmail');

Auth::routes();

Route::group(['middleware' => ['adminlogin']], function(){

	Route::get('/admin/dashboard', 'AdminController@dashboard');
	Route::get('/admin/settings', 'AdminController@settings');
	Route::get('/admin/check-pwd','AdminController@chkPassword');
	Route::match(['get','post'],'/admin/update-pwd','AdminController@updatePassword');

	//categorias
	Route::match(['get','post'],'/admin/add-category','CategoryController@addCategory');
	Route::match(['get','post'],'/admin/edit-category/{id}', 'CategoryController@editCategory');
	Route::match(['get','post'],'/admin/delete-category/{id}', 'CategoryController@deleteCategory');
	Route::get('/admin/view-categories', 'CategoryController@viewCategories');

	//produtos
	Route::match(['get','post'], '/admin/add-product', 'ProductsController@addProduct');
	Route::match(['get','post'], '/admin/edit-product/{id}', 'ProductsController@editProduct');
	Route::get('/admin/view-products','ProductsController@viewProducts');
	Route::get('/admin/delete-product/{id}', 'ProductsController@deleteProduct');
	Route::get('/admin/delete-product-image/{id}', 'ProductsController@deleteProductImage');
	Route::get('/admin/delete-product-video/{id}','ProductsController@deleteProductVideo');
	Route::match(['get', 'post'], '/admin/add-images/{id}','ProductsController@addImages');
	Route::get('/admin/delete-alt-image/{id}','ProductsController@deleteProductAltImage');

	//atributos dos produtos
	Route::match(['get','post'], '/admin/add-attributes/{id}', 'ProductsController@addAttributes');
	Route::match(['get','post'], '/admin/edit-attributes/{id}', 'ProductsController@editAttributes');
	Route::get('/admin/delete-attribute/{id}', 'ProductsController@deleteAttribute');

	//cupoes de desconto
	Route::match(['get','post'], '/admin/add-coupon', 'CouponsController@addCoupon');
	Route::match(['get','post'], '/admin/edit-coupon/{id}', 'CouponsController@editCoupon');
	Route::match(['get','post'], '/admin/delete-coupon/{id}', 'CouponsController@deleteCoupon');
	Route::get('/admin/view-coupons', 'CouponsController@viewCoupons');

	// lista de encomendas
	Route::get('/admin/view-orders','ProductsController@viewOrders');
	Route::get('/admin/view-order/{id}','ProductsController@viewOrderDetails');
	Route::get('/admin/view-orders-charts','UsersController@viewOrdersCharts');
	Route::post('/admin/update-order-status','ProductsController@updateOrderStatus');

	// ver utilzadores
	Route::get('/admin/view-users','UsersController@viewUsers');

	// ver relatórios (encomendas e utilizadores)
	Route::get('/admin/view-users-charts','UsersController@viewUsersCharts');
	Route::get('/admin/view-users-countries-charts','UsersController@viewUsersCountriesCharts');

	// ver fatura e pdf
	Route::get('/admin/view-order-invoice/{id}','ProductsController@viewOrderInvoice');
	Route::get('/admin/view-pdf-invoice/{id}','ProductsController@viewPDFInvoice');

	// paginas
	Route::match(['get','post'],'/admin/add-cms-page','CmsController@addCmsPage');
	Route::match(['get','post'],'/admin/edit-cms-page/{id}','CmsController@editCmsPage');
	Route::get('/admin/view-cms-pages','CmsController@viewCmsPages');
	Route::get('/admin/delete-cms-page/{id}','CmsController@deleteCmsPage');

	// transporte
	Route::get('/admin/view-shipping','ShippingController@viewShipping');
	Route::match(['get','post'],'/admin/edit-shipping/{id}','ShippingController@editShipping');

	// subscritores
	Route::get('/admin/view-newsletter-subscribers','NewsletterController@viewNewsletterSubscribers');
	Route::get('/admin/update-newsletter-status/{id}/{status}','NewsletterController@updateNewsletterStatus');
	Route::get('/admin/delete-newsletter-email/{id}','NewsletterController@deleteNewsletterEmail');

	// administradores
	Route::get('/admin/view-admins','AdminController@viewAdmins');
	Route::match(['get','post'],'/admin/add-admin','AdminController@addAdmin');
	Route::match(['get','post'],'/admin/edit-admin/{id}','AdminController@editAdmin');

});

Route::get('/logout', 'AdminController@logout');

Route::match(['get','post'],'/page/{url}','CmsController@cmsPage');


Route::match(['get','post'],'/pages/contact','CmsController@contact');

// (Vue.js)
Route::match(['get','post'],'/pages/post','CmsController@addPost');