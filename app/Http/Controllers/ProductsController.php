<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Eppiks\IfThenPay\Facades\IfThenPay;
use App\Category;
use App\Product;
use App\Country;
use App\Coupon;
use App\ProductsImage;
use App\ProductAttribute;
use App\User;
use App\Order;
use App\DeliveryAddress;
use App\OrdersProduct;
use Image;
use DB;
use Session;
use Auth;

use Carbon\Carbon;
use Dompdf\Dompdf;
use AshAllenDesign\LaravelExchangeRates\Classes\ExchangeRate;


class ProductsController extends Controller
{
    // função adicionar productos - admin
    public function addProduct(Request $request){

        if (Session::get('adminDetails')['products_access']==0) {
            return redirect('/admin/dashboard')->with('flash_message_error', 'You have no access for this module');
        }

        if($request->isMethod('post')){
            $data=$request->all();
            //echo "<pre>"; print_r($data); die;

            if(empty($data['category_id'])){
                return redirect()->back()->with('flash_message_error', 'Categoria de produto em falta');
            }
            $product = new Product;
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];

            if(!empty($data['weight'])){
                $product->weight = $data['weight'];
            } else {
                $product->weight = 0;
            }

            if(!empty($data['description'])){
                $product->description = $data['description'];
            } else {
                $product->description = '';
            }

            if(!empty($data['material'])){
                $product->material = $data['material'];
            } else {
                $product->material = '';
            }

            if(empty($data['feature_item'])){
                $feature_item = '0';
            } else {
                $feature_item = '1';
            }

            if(empty($data['status'])){
                $status='0';
            }else{
                $status='1';
            }
            
            $product->price = $data['price'];


            //upload da imagem
            if($request->hasFile('image')){
                $image_tmp = $request->file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $fileName = rand(111,99999).'.'.$extension;
                    $large_image_path = 'images/backend_images/products/large'.'/'.$fileName;
                    $medium_image_path = 'images/backend_images/products/medium'.'/'.$fileName;  
                    $small_image_path = 'images/backend_images/products/small'.'/'.$fileName;  

                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300, 300)->save($small_image_path);

                    //alocar imagem na tabela
                    $product->image = $fileName;
                }
            }

            // Upload Video
            if($request->hasFile('video')){
                $video_tmp = $request->file('video');
                $video_name = $video_tmp->getClientOriginalName();
                $video_path = 'videos/';
                $video_tmp->move($video_path,$video_name);
                $product->video = $video_name;
            }


            $product->status = $status;
            $product->feature_item = $feature_item;
            $product->save();
            return redirect()->back()->with('flash_message_success', 'Produto foi adicionado com sucesso!');
        }
    	$categories = Category::where(['parent_id'=>0])->get();
    	$categories_dropdown = "<option selected disabled>Selecionar</option>";
    	foreach ($categories as $cat) {
    		$categories_dropdown .= "<option value='".$cat->id."'>".$cat->name."</option>";    	
    		$sub_categories = Category::where(['parent_id'=>$cat->id])->get();
    		foreach ($sub_categories as $sub_cat) {
    			$categories_dropdown = "<option value = '".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->name."</option>";
    		}
    	}
    	return view('admin.products.add_product')->with(compact('categories_dropdown'));
    }

    // função eliminar productos - admin
    public function deleteProduct($id = null){

        if (Session::get('adminDetails')['products_access']==0) {
            return redirect('/admin/dashboard')->with('flash_message_error', 'You have no access for this module');
        }

        Session::forget('CouponAmount');
        Session::forget('CouponCode');

        Product::where(['id'=>$id])->delete();

        return redirect()->back()->with('flash_message_success', 'Produto foi eliminado com sucesso!');
    }

    // função eliminar imagem dos productos - admin
    public function deleteProductImage($id = null){

        if (Session::get('adminDetails')['products_access']==0) {
            return redirect('/admin/dashboard')->with('flash_message_error', 'You have no access for this module');
        }

        $productImage = Product::where(['id'=>$id])->first();

        $large_image_path = 'images/backend_images/products/larg/';
        $medium_image_path = 'images/backend_images/products/medium/';  
        $small_image_path = 'images/backend_images/products/small/';  

        if (file_exists($large_image_path.$productImage->image)) {
            unlink($large_image_path.$productImage->image);
        }

        if (file_exists($medium_image_path.$productImage->image)) {
            unlink($medium_image_path.$productImage->image);
        }

        if (file_exists($small_image_path.$productImage->image)) {
            unlink($small_image_path.$productImage->image);
        }

        Product::where(['id'=>$id])->update(['image'=>'']);

        return redirect()->back()->with('flash_message_success', 'Imagem do Produto foi eliminada com sucesso!');
    }

    public function deleteProductVideo($id){

        if (Session::get('adminDetails')['products_access']==0) {
            return redirect('/admin/dashboard')->with('flash_message_error', 'You have no access for this module');
        }

        // obter nome do video
        $productVideo = Product::select('video')->where('id',$id)->first();

        // caminho para a pasta dos videos
        $video_path = 'videos/';

        // apagar video se existir no ficheiro
        if(file_exists($video_path.$productVideo->video)){
            unlink($video_path.$productVideo->video);
        }

        // apagar atributo "video" da tabela dos produtos 
        Product::where('id',$id)->update(['video'=>'']);

        return redirect()->back()->with('flash_message_success','Product Video has been deleted successfully');
    }

    // função editar productos - admin
    public function editProduct(Request $request, $id = null){

        if (Session::get('adminDetails')['products_access']==0) {
            return redirect('/admin/dashboard')->with('flash_message_error', 'You have no access for this module');
        }

        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            if(empty($data['status'])){
                $status='0';
            }else{
                $status='1';
            }

            if(empty($data['feature_item'])){
                $feature_item = '0';
            } else {
                $feature_item = '1';
            }

            //upload da imagem
            if($request->hasFile('image')){
                $image_tmp = $request->file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $fileName = rand(111,99999).'.'.$extension;
                    $large_image_path = 'images/backend_images/products/large'.'/'.$fileName;
                    $medium_image_path = 'images/backend_images/products/medium'.'/'.$fileName;  
                    $small_image_path = 'images/backend_images/products/small'.'/'.$fileName;  

                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300, 300)->save($small_image_path);          
                }
            }else if (!empty($data['current_image'])) {
                $fileName = $data['current_image'];
            } else {
                $fileName = '';
            }

            // Upload Video
            if($request->hasFile('video')){
                $video_tmp = $request->file('video');
                $video_name = $video_tmp->getClientOriginalName();
                $video_path = 'videos/';
                $video_tmp->move($video_path,$video_name);
                $videoName = $video_name;
            }else if(!empty($data['current_video'])){
                $videoName = $data['current_video'];
            }else{
                $videoName = '';
            }

            if(empty($data['category_id'])){
                return redirect()->back()->with('flash_message_error', 'Categoria de produto em falta');
            }

            if(empty($data['material'])){
                $data['material'] = "";
            }

            Product::where(['id'=>$id])->update(['feature_item'=>$feature_item, 'status'=>$status, 'category_id'=>$data['category_id'],'product_name'=>$data['product_name'],
                'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],'description'=>$data['description'],'material'=>$data['material'], 'price'=>$data['price'], 'weight'=>$data['weight'], 'image'=>$fileName, 'video'=>$videoName]);
        

            return redirect()->back()->with('flash_message_success', 'Produto foi editado com sucesso!');

        }
        $productDetails = Product::where(['id'=>$id])->first();

        // Categories drop down start //
        $categories = Category::where(['parent_id' => 0])->get();

        //dropdown de categorias
        $categories_dropdown = "<option selected disabled>Select</option>";
        foreach ($categories as $cat) {
            if($cat->id == $productDetails->category_id){
                $selected = "selecionado";
            } else {
                $selected = "";
            }
            $categories_dropdown .= "<option value='".$cat->id."' ".$selected.">".$cat->name."</option>";     
           
        }

        return view('admin.products.edit_product')->with(compact('productDetails', 'categories_dropdown'));
    }

    // função ver productos - admin
    public function viewProducts(){
        if (Session::get('adminDetails')['products_access']==0) {
            return redirect('>/admin/dashboard')->with('flash_message_error', 'You have no access for this module');
        }

        $products = Product::orderBy('id', 'DESC')->get();
        $products = json_decode(json_encode($products));
        foreach($products as $key => $val){
            $category_name = Category::where(['id' => $val->category_id])->first();
            $products[$key]->category_name = $category_name->name;
        }
        
        return view('admin.products.view_products')->with(compact('products'));
    }

    // função adicionar atributos de productos (tamanho, preço, stock) - admin
    public function addAttributes(Request $request, $id = null){

        $productDetails = Product::with('attributes')->where(['id'=>$id])->first();
        $productDetails = json_decode(json_encode($productDetails));
        //echo "<pre>"; print_r($productDetails); die;

        $categoryDetails = Category::where(['id'=>$productDetails->category_id])->first();
        $category_name = $categoryDetails->name;

        if($request->isMethod('post')){
            $data = $request->all();

            foreach ($data['sku'] as $key => $val) {
                if(!empty($val)){
                    // SKU Check
                    $attrCountSKU = ProductAttribute::where('sku', $val)->count();
                    if ($attrCountSKU>0) {
                        return redirect('admin/add-attributes/'.$id)->with('flash_message_error', 'A Referência já existe! Por favor inserir outra Referência');
                    }

                    $attrCountSizes = ProductAttribute::where(['product_id'=>$id, 'size'=>$data['size'][$key]])->count();
                    if ($attrCountSizes>0) {
                        return redirect('admin/add-attributes/'.$id)->with('flash_message_error', '"'.$data['size'][$key].'"O tamanho desta referência já existe! Por favor inserir outro tamanho');
                    }

                    $attribute = new ProductAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $val;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->save();
                }
            }
            return redirect('admin/add-attributes/'.$id)->with('flash_message_success', 'Atributos do artigo foram adicionados com sucesso');
        }
        return view('admin.products.add_attributes')->with(compact('productDetails', 'category_name'));
    }

    // função editar atributos de productos (tamanho, preço, stock) - admin
    public function editAttributes(Request $request, $id = null){
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            foreach ($data['idAttr'] as $key => $attr) {
                ProductAttribute::where(['id'=>$data['idAttr'][$key]])->update(['price'=>$data['price'][$key], 'stock'=>$data['stock'][$key]]);
            }
            return redirect()->back()->with('flash_message_success', 'Atributos do artigo foram atualizados com sucesso');
        }
    }

    // função eliminar atributos de productos (tamanho, preço, stock) - admin
    public function deleteAttribute($id = null){
        ProductAttribute::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Atributo do artigo foi eliminado com sucesso');
    }

    // função ver produtos - utilizadores
   public function products($url=null){



        $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
        if($categoryCount==0){
            abort(404);
        }

        $categoryDetails = Category::where(['url'=>$url])->first();

        $productsAll = Product::where(['products.category_id'=>$categoryDetails->id])->orderBy('products.id','Desc');

        $productAltImages = ProductsImage::where('product_id',$id)->get();

        $mainCategory = Category::where('id',$categoryDetails->parent_id)->first();
   
        return view('allproducts')->with(compact('categories','productsAll','categoryDetails', 'url', 'productAltImages'));
    }

    public function filter(Request $request){
        $data = $request->all();
        /*echo "<pre>"; print_r($data); die;*/

        $colorUrl="";
        if(!empty($data['colorFilter'])){
            foreach($data['colorFilter'] as $color){
                if(empty($colorUrl)){
                    $colorUrl = "&color=".$color;
                }else{
                    $colorUrl .= "-".$color;
                }
            }
        }
        $finalUrl = "products/".$data['url']."?".$colorUrl;
        return redirect::to($finalUrl);
    }

    // função ver detalhes dos produtos
    public function product($id = null){

        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        
        $productDetails = Product::with('attributes')->where('id',$id)->first();

        $productAltImages = ProductsImage::where('product_id',$id)->get();

        $total_stock = ProductAttribute::where('product_id',$id)->sum('stock');

        return view('products.detail')->with(compact('productDetails', 'categories', 'total_stock', 'productAltImages'));
    }

    public function getProductPrice(Request $request){
        $data = $request->all();
        //echo "<pre>"; print_r($data); die;
        $proArr = explode("-", $data['idSize']);
        $proAttr = ProductAttribute::where(['product_id' => $proArr[0], 'size' => $proArr[1]])->first();
        echo $proAttr->price;
        echo "#";
        echo $proAttr->stock;
    }

    public function wishList(){
        if (Auth::check()) {
            $user_email = Auth::user()->email;
            $userWishList = DB::table('wish_list')->where('user_email',$user_email)->get();

            if (empty($userWishList)) {
                return redirect("/allproducts");
            }
            foreach ($userWishList as $key => $product) {
                $productDetails = Product::where('id',$product->product_id)->first();
                $userWishList[$key]->image = $productDetails->image;
            }
        }else{
            $userWishList = array();
        }
        

        return view('products.wish_list')->with(compact('userWishList'));
    }

    public function deleteWishListProduct($id){
        DB::table('wish_list')->where('id',$id)->delete();
        return redirect()->back()->with('flash_message_success','Product has been delected from wish ');
    }

    // função adicionar produtos ao carrinho
    public function addToCart(Request $request){

        Session::forget('CouponAmount');
        Session::forget('CouponCode');

        $data = $request->all();
        /*echo "<pre>"; print_r($data); die;*/

        if ((!empty($data['wishListButton'])) && ($data['wishListButton']=="Wish List")) {


            if (!Auth::check()) {
                return redirect()->back()->with('flash_message_error', 'Please Login to add product in your Wish List');
            }

            if (empty($data['size'])) {
                return redirect()->back()->with('flash_message_error', 'Please select size to add product in your Wish List');
            }

            $sizeIDArr = explode('-',$data['size']);
            $product_size = $sizeIDArr[1];

            $proPrice = ProductAttribute::where(['product_id'=>$data['product_id'], 'size'=>$product_size])->first();

            $product_price = $proPrice->price;

            $user_email = Auth::user()->email;
            $quantity = 1;

            $created_at = Carbon::now(); 

            $wishListCount = DB::table('wish_list')->where(['user_email'=>$user_email, 'product_id'=>$data['product_id'], 'product_code'=>$data['product_code'], 'product_color'=>$data['product_color'], 'size'=>$product_size])->count();

            if ($wishListCount > 0) {
                return redirect()->back()->with('flash_message_error', 'Product already exists in Wish List');
            } else {
                DB::table('wish_list')->insert(['product_id'=>$data['product_id'], 'product_name'=>$data['product_name'], 'product_code'=>$data['product_code'], 'product_color'=>$data['product_color'], 'price'=>$product_price, 'size'=>$product_size, 'quantity'=>$quantity, 'user_email'=>$user_email, 'created_at'=>$created_at]);
            }

            

            return redirect()->back()->with('flash_message_success', 'Product has been added in Wish List');

        } else {


        if ((!empty($data['cartButton'])) && ($data['cartButton']=="Add To Cart")) {
            $data['quantity'] = 1;
        }

         //stock do produto é valido??

        $product_size = explode("-",$data['size']);
        $getProductStock = ProductAttribute::where(['product_id'=>$data['product_id'],'size'=>$product_size[1]])->first();

        if(($getProductStock->stock)<$data['quantity']){
            return redirect()->back()->with('flash_message_error','Required Quantity is not available!');
        }

        if(empty(Auth::user()->email)){
            $data['user_email'] = '';    
        }else{
            $data['user_email'] = Auth::user()->email;
        }

        $session_id = Session::get('session_id');
        if(!isset($session_id)){
            $session_id = Str::random(40);
            Session::put('session_id',$session_id);
        }



        $sizeIDArr = explode('-',$data['size']);
        $product_size = $sizeIDArr[1];

        if(empty(Auth::check())){
            $countProducts = DB::table('cart')->where(['product_id' => $data['product_id'],'product_color' => $data['product_color'],'size' => $product_size,'session_id' => $session_id])->count();
            if($countProducts>0){
                return redirect()->back()->with('flash_message_error','Product already exist in Cart!');
            }
        }else{
            $countProducts = DB::table('cart')->where(['product_id' => $data['product_id'],'product_color' => $data['product_color'],'size' => $product_size,'user_email' => $data['user_email']])->count();
            if($countProducts>0){
                return redirect()->back()->with('flash_message_error','Product already exist in Cart!');
            }    
        }
        

        $getSKU = ProductAttribute::select('sku')->where(['product_id' => $data['product_id'], 'size' => $product_size])->first();
                
        DB::table('cart')->insert(['product_id' => $data['product_id'],'product_name' => $data['product_name'],
            'product_code' => $getSKU['sku'],'product_color' => $data['product_color'],
            'price' => $data['price'],'size' => $product_size,'quantity' => $data['quantity'],'user_email' => $data['user_email'],'session_id' => $session_id]);

        return redirect('cart')->with('flash_message_success','Product has been added in Cart!');
        }


    }

    // função sessão carrinho
    public function cart(){

        if(Auth::check()){
            $user_email = Auth::user()->email;
            $userCart = DB::table('cart')->where(['user_email' => $user_email])->get();     
        }else{
            $session_id = Session::get('session_id');
            $userCart = DB::table('cart')->where(['session_id' => $session_id])->get();    
        }
        
        foreach($userCart as $key => $product){
            $productDetails = Product::where('id',$product->product_id)->first();
            $userCart[$key]->image = $productDetails->image;
        }

        return view('products.cart')->with(compact('userCart'));
    }

    // função checkout
    public function checkout(Request $request){

         $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;

        $userDetails = User::find($user_id);


        $countries = Country::get();

        //validar se existe morada de entrega
        $shippingCount = DeliveryAddress::where('user_id',$user_id)->count();
        $shippingDetails = array();
        if($shippingCount>0){
            $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();
        }

        //atualizar carrinho com e
        $session_id = Session::get('session_id');
        DB::table('cart')->where(['session_id'=>$session_id])->update(['user_email'=>$user_email]);
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            

            // retornar para a página do checkout caso algum campo esteja vazio
            
          

            if($shippingCount>0){
                // atualizar moraada de entrega
                DeliveryAddress::where('user_id',$user_id)->update(['name'=>$data['shipping_name'],'address'=>$data['shipping_address'],'city'=>$data['shipping_city'],'state'=>$data['shipping_state'],'pincode'=>$data['shipping_pincode'],'country'=>$data['shipping_country'],'mobile'=>$data['shipping_mobile']]);
            }else{
                
                // Adicionar nova morada de entrega
                $shipping = new DeliveryAddress;
                $shipping->user_id = $user_id;
                $shipping->user_email = $user_email;
                $shipping->name = $data['shipping_name'];
                $shipping->address = $data['shipping_address'];
                $shipping->city = $data['shipping_city'];
                $shipping->state = $data['shipping_state'];
                $shipping->pincode = $data['shipping_pincode'];
                $shipping->country = $data['shipping_country'];
                $shipping->mobile = $data['shipping_mobile'];
                $shipping->save();
            }

            $pincodeCount = DB::table('pincodes')->where('pincode',$data['shipping_pincode'])->count();
            if($pincodeCount == 0){
                return redirect()->back()->with('flash_message_error','Your location is not available for delivery. Please enter another location.');
            }

            return redirect()->action('ProductsController@orderReview');
        }
        return view('products.checkout')->with(compact('userDetails', 'countries', 'shippingDetails'));
    }

    // função rever pedido antes de pagar
    public function orderReview(Request $request){

        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $userDetails = User::where('id', $user_id)->first();
        $shippingDetails = DeliveryAddress::where('user_id', $user_id)->first();
        $shippingDetails = json_decode(json_encode($shippingDetails));
        $userCart = DB::table('cart')->where(['user_email' => $user_email])->get();
        $total_weight = 0;

        foreach($userCart as $key => $product){
            $productDetails = Product::where('id',$product->product_id)->first();
            $userCart[$key]->image = $productDetails->image;
            $total_weight = $total_weight + $productDetails->weight;
        }

        $codpincodeCount = DB::table('cod_pincodes')->where('pincode',$shippingDetails->pincode)->count();
        $prepaidpincodeCount = DB::table('prepaid_pincodes')->where('pincode',$shippingDetails->pincode)->count();

        $shippingCharges = Product::getShippingCharges($total_weight,$shippingDetails->country);
        Session::put('ShippingCharges',$shippingCharges);


        //echo "<pre>"; print_r($userCart); die;
        return view('products.order_review')->with(compact('userDetails', 'shippingDetails', 'userCart', 'codpincodeCount', 'prepaidpincodeCount','shippingCharges'));
    }

    // função confirmação
    public function placeOrder(Request $request){
        if ($request->isMethod('post')) {
            $data = $request->all();
            $user_id = Auth::user()->id;
            $user_email = Auth::user()->email;

            $userCart = DB::table('cart')->where('user_email',$user_email)->get();

            foreach($userCart as $cart){

                $getAttributeCount = Product::getAttributeCount($cart->product_id,$cart->size);
                if($getAttributeCount==0){
                    Product::deleteCartProduct($cart->product_id,$user_email);
                    return redirect('/cart')->with('flash_message_error','One of the product is not available. Try again!');
                }

                $product_stock = Product::getProductStock($cart->product_id,$cart->size);
                if($product_stock==0){
                    Product::deleteCartProduct($cart->product_id,$user_email);
                    return redirect('/cart')->with('flash_message_error','Sold Out product removed from Cart. Try again!');
                }
      
                if($cart->quantity>$product_stock){
                    return redirect('/cart')->with('flash_message_error','Reduce Product Stock and try again.');    
                }

                $getCategoryId = Product::select('category_id')->where('id',$cart->product_id)->first();
                $category_status = Product::getCategoryStatus($getCategoryId->category_id);
                if($category_status==0){
                    Product::deleteCartProduct($cart->product_id,$user_email);
                    return redirect('/cart')->with('flash_message_error','One of the product category is disabled. Please try again!');    
                }
            }

            $shippingDetails = DeliveryAddress::where(['user_email' => $user_email])->first();

            $pincodeCount = DB::table('pincodes')->where('pincode',$shippingDetails->pincode)->count();
            if($pincodeCount == 0){
                return redirect()->back()->with('flash_message_error','Your location is not available for delivery. Please enter another location.');
            }

            if(empty(Session::get('CouponCode'))){
               $coupon_code = ''; 
            }else{
               $coupon_code = Session::get('CouponCode'); 
            }

            if(empty(Session::get('CouponAmount'))){
               $coupon_amount = ''; 
            }else{
               $coupon_amount = Session::get('CouponAmount'); 
            }

            if (empty($data['payment_method'])) {
                return redirect()->back()->with('flash_message_error', 'Por favor introduza método do pagamento!');
            }

            $grand_total = Product::getGrandTotal();


            $order = new Order;
            $order->user_id = $user_id;
            $order->user_email = $user_email;
            $order->name = $shippingDetails->name;
            $order->address = $shippingDetails->address;
            $order->city = $shippingDetails->city;
            $order->state = $shippingDetails->state;
            $order->pincode = $shippingDetails->pincode;
            $order->country = $shippingDetails->country;
            $order->mobile = $shippingDetails->mobile;
            $order->coupon_code = $coupon_code;
            $order->coupon_amount = $coupon_amount;
            $order->order_status = "New";
            $order->payment_method = $data['payment_method'];
            $order->shipping_charges = Session::get('ShippingCharges');
            $order->grand_total = $data['grand_total'];
            $order->save();

            $order_id = DB::getPdo()->lastInsertId();

            $cartProducts = DB::table('cart')->where(['user_email'=>$user_email])->get();
            foreach ($cartProducts as $pro) {
                $cartPro = new OrdersProduct;
                $cartPro->order_id = $order_id;
                $cartPro->user_id = $user_id;
                $cartPro->product_id = $pro->product_id;
                $cartPro->product_code = $pro->product_code;
                $cartPro->product_name = $pro->product_name;
                $cartPro->product_color = $pro->product_color;
                $cartPro->product_size = $pro->size;
                $product_price = Product::getProductPrice($pro->product_id,$pro->size);
                $cartPro->product_price = $product_price;
                $cartPro->product_qty = $pro->quantity;
                $cartPro->save();

                // reduzir stock
                $getProductStock = ProductAttribute::where('sku',$pro->product_code)->first();
                /*echo "Original Stock: ".$getProductStock->stock;
                echo "Stock to reduce: ".$pro->quantity;*/
                $newStock = $getProductStock->stock - $pro->quantity;
                if($newStock<0){
                    $newStock = 0;
                }
               ProductAttribute::where('sku',$pro->product_code)->update(['stock'=>$newStock]);

            }

            Session::put('order_id',$order_id);
            Session::put('grand_total',$data['grand_total']);

            if ($data['payment_method']=="COD") {

                $productDetails = Order::with('orders')->where('id',$order_id)->first();
                $productDetails = json_decode(json_encode($productDetails),true);
                /*echo "<pre>"; print_r($productDetails);*/ /*die;*/

                $userDetails = User::where('id',$user_id)->first();
                $userDetails = json_decode(json_encode($userDetails),true);

                $email = $user_email;
                $messageData = [
                    'email' => $email,
                    'name' => $shippingDetails->name,
                    'order_id' => $order_id,
                    'productDetails' => $productDetails
                ];

                Mail::send('emails.order', $messageData, function($message) use($email){
                    $message->to($email)->subject('Order Placed - WolWork Brand');
                });
                return redirect('/thanks');
            }else if($data['payment_method']=="multibanco"){
                // redireciona para a página do payumoney
                return redirect('/multibanco');
            }else{
                // redireciona para a página do paypal
                return redirect('/paypal');
            }
        }
    }

    public function thanksPaypal(){
        return view('orders.thanks_paypal');
    }

    // função agradecimento
    public function thanks(Request $request){
        $user_email = Auth::user()->email;
        DB::table('cart')->where('user_email',$user_email)->delete();
        return view('orders.thanks');
    }

    // função reencaminha para paypal
    public function paypal(Request $request){
        $user_email = Auth::user()->email;
        DB::table('cart')->where('user_email',$user_email)->delete();
        return view('orders.paypal');
    }

    public function cancelPaypal(){
        return view('orders.cancel_paypal');
    }

    // função ver encomendas
    public function userOrders(){
        $user_id = Auth::user()->id;
        $orders = Order::with('orders')->where('user_id',$user_id)->orderBy('id','DESC')->get();

        if (empty($orders)) {
            return redirect()->back()->with('flash_message_error', 'You have not any order already!');
        }
        /*$orders = json_decode(json_encode($orders));
        echo "<pre>"; print_r($orders); die;*/
        return view('orders.user_orders')->with(compact('orders'));
    }

    // função ver detalhes das encomendas
    public function userOrderDetails($order_id){
        $user_id = Auth::user()->id;
        $orderDetails = Order::with('orders')->where('id',$order_id)->first();
        $orderDetails = json_decode(json_encode($orderDetails));
        return view('orders.user_order_details')->with(compact('orderDetails'));
    }

    // função eliminar produto do carrinho
    public function deleteCartProduct($id = null){
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        
        DB::table('cart')->where('id',$id)->delete();
        return redirect('cart')->with('flash_message_success', 'Produto foi apagado do carrinho!');
    }

    // função atualizar quantidade no carrinho
    public function updateCartQuantity($id=null,$quantity=null){
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        $getProductSKU = DB::table('cart')->select('product_code','quantity')->where('id',$id)->first();
        $getProductStock = ProductAttribute::where('sku',$getProductSKU->product_code)->first();
        $updated_quantity = $getProductSKU->quantity+$quantity;
        if($getProductStock->stock>=$updated_quantity){
            DB::table('cart')->where('id',$id)->increment('quantity',$quantity); 
            return redirect('cart')->with('flash_message_success','Product Quantity has been updated in Cart!');   
        }else{
            return redirect('cart')->with('flash_message_error','Required Product Quantity is not available!');    
        }
    }

    // função aplicar cupão
    public function applyCoupon(Request $request){

         Session::forget('CouponAmount');
        Session::forget('CouponCode');

        $data = $request->all();
        /*echo "<pre>"; print_r($data); die;*/
        $couponCount = Coupon::where('coupon_code',$data['coupon_code'])->count();
        if($couponCount == 0){
            return redirect()->back()->with('flash_message_error','This coupon does not exists!');
        }else{
            
            $couponDetails = Coupon::where('coupon_code',$data['coupon_code'])->first();
            
            // cupão encontra-se inativo
            if($couponDetails->status==0){
                return redirect()->back()->with('flash_message_error','This coupon is not active!');
            }

            // cupão encontra-se expirado
            $expiry_date = $couponDetails->expiry_date;
            $current_date = date('Y-m-d');
            if($expiry_date < $current_date){
                return redirect()->back()->with('flash_message_error','This coupon is expired!');
            }

            // ok, está pronto para ser utilizado

        
            if(Auth::check()){
                $user_email = Auth::user()->email;
                $userCart = DB::table('cart')->where(['user_email' => $user_email])->get();     
            }else{
                $session_id = Session::get('session_id');
                $userCart = DB::table('cart')->where(['session_id' => $session_id])->get();    
            }

            $total_amount = 0;
            foreach($userCart as $item){
               $total_amount = $total_amount + ($item->price * $item->quantity);
            }

            //verificar se é preço fixo ou percentegam
            if($couponDetails->amount_type=="Fixed"){
                $couponAmount = $couponDetails->amount;
            }else{
                $couponAmount = $total_amount * ($couponDetails->amount/100);
            }

            // adicionar cupão na sessão
            Session::put('CouponAmount',$couponAmount);
            Session::put('CouponCode',$data['coupon_code']);

            return redirect()->back()->with('flash_message_success','Coupon code successfully
                applied. You are availing discount!');

        }
    }

    // função adicionar imagens - admin (ainda por inserir na vista!!!!)
    public function addImages(Request $request, $id=null){
        $productDetails = Product::where(['id' => $id])->first();

        $categoryDetails = Category::where(['id'=>$productDetails->category_id])->first();
        $category_name = $categoryDetails->name;

        if($request->isMethod('post')){
            $data = $request->all();
            if ($request->hasFile('image')) {
                $files = $request->file('image');
                foreach($files as $file){
                    

                    // atualizar imagens após os 
                    $image = new ProductsImage;
                    $extension = $file->getClientOriginalExtension();
                    $fileName = rand(111,99999).'.'.$extension;
                    $large_image_path = 'images/backend_images/products/large'.'/'.$fileName;
                    $medium_image_path = 'images/backend_images/products/medium'.'/'.$fileName;  
                    $small_image_path = 'images/backend_images/products/small'.'/'.$fileName;  
                    Image::make($file)->save($large_image_path);
                    Image::make($file)->resize(600, 600)->save($medium_image_path);
                    Image::make($file)->resize(300, 300)->save($small_image_path);
                    $image->image = $fileName;  
                    $image->product_id = $data['product_id'];
                    $image->save();
                }   
            }

            return redirect('admin/add-images/'.$id)->with('flash_message_success', 'Product Images has been added successfully');

        }

        $productImages = ProductsImage::where(['product_id' => $id])->orderBy('id','DESC')->get();

        $title = "Add Images";
        return view('admin.products.add_images')->with(compact('title','productDetails','category_name','productImages'));
    }

     // função eliminar imagens 
    public function deleteProductAltImage($id=null){

        // Get Product Image
        $productImage = ProductsImage::where('id',$id)->first();

        // Get Product Image Paths
        $large_image_path = 'images/backend_images/products/large/';
        $medium_image_path = 'images/backend_images/products/medium/';
        $small_image_path = 'images/backend_images/products/small/';

        // apagar se não existir nos ficheiros
        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }


        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }

        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }

        // apagar imagem da tabela imagens
        ProductsImage::where(['id'=>$id])->delete();

        return redirect()->back()->with('flash_message_success', 'Product alternate mage has been deleted successfully');
    }

    public function viewOrders(){

        if (Session::get('adminDetails')['orders_access']==0) {
            return redirect('/admin/dashboard')->with('flash_message_error', 'You have no access for this module');
        }

        $orders = Order::with('orders')->orderBy('id','Desc')->get();
        $orders = json_decode(json_encode($orders));
        /*echo "<pre>"; print_r($orders); die;*/
        return view('admin.orders.view_orders')->with(compact('orders'));
    }

    public function viewOrderDetails($order_id){

        if (Session::get('adminDetails')['orders_access']==0) {
            return redirect('/admin/dashboard')->with('flash_message_error', 'You have no access for this module');
        }

        $orderDetails = Order::with('orders')->where('id',$order_id)->first();
        $orderDetails = json_decode(json_encode($orderDetails));
        /*echo "<pre>"; print_r($orderDetails); die;*/
        $user_id = $orderDetails->user_id;
        $userDetails = User::where('id',$user_id)->first();
        /*$userDetails = json_decode(json_encode($userDetails));
        echo "<pre>"; print_r($userDetails);*/
        return view('admin.orders.order_details')->with(compact('orderDetails','userDetails'));
    }

    public function updateOrderStatus(Request $request){

        if (Session::get('adminDetails')['orders_access']==0) {
            return redirect('/admin/dashboard')->with('flash_message_error', 'You have no access for this module');
        }
        
        if($request->isMethod('post')){
            $data = $request->all();
            Order::where('id',$data['order_id'])->update(['order_status'=>$data['order_status']]);
            return redirect()->back()->with('flash_message_success','Order Status has been updated successfully!');
        }
    }

    public function viewOrderInvoice($order_id){
        $orderDetails = Order::with('orders')->where('id',$order_id)->first();
        $orderDetails = json_decode(json_encode($orderDetails));
        /*echo "<pre>"; print_r($orderDetails); die;*/
        $user_id = $orderDetails->user_id;
        $userDetails = User::where('id',$user_id)->first();
        /*$userDetails = json_decode(json_encode($userDetails));
        echo "<pre>"; print_r($userDetails);*/
        return view('admin.orders.order_invoice')->with(compact('orderDetails','userDetails'));
    }

    public function checkPincode(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            echo $pincodeCount = DB::table('pincodes')->where('pincode',$data['pincode'])->count();

        }
    }

    public function viewPDFInvoice($order_id){
        $orderDetails = Order::with('orders')->where('id',$order_id)->first();
        $orderDetails = json_decode(json_encode($orderDetails));
        /*echo "<pre>"; print_r($orderDetails); die;*/
        $user_id = $orderDetails->user_id;
        $userDetails = User::where('id',$user_id)->first();
        /*$userDetails = json_decode(json_encode($userDetails));
        echo "<pre>"; print_r($userDetails);*/
        
        $output = '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Example 2</title>
    <style>
    @font-face {
  font-family: SourceSansPro;
  src: url(SourceSansPro-Regular.ttf);
}

.clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #0087C3;
  text-decoration: none;
}

body {
  position: relative;
  width: 21cm;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #555555;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 14px; 
  font-family: SourceSansPro;
}

header {
  padding: 10px 0;
  margin-bottom: 20px;
  border-bottom: 1px solid #AAAAAA;
}

#logo {
  float: left;
  margin-top: 8px;
}

#logo img {
  height: 70px;
}

#company {
  float: right;
  text-align: right;
}


#details {
  margin-bottom: 50px;
}

#client {
  padding-left: 6px;
  border-left: 6px solid #0087C3;
  float: left;
}

#details #client .to {
  color: #000000;
}

h2.name {
  font-size: 1.4em;
  font-weight: normal;
  margin: 0;
}

#invoice {
  float: right;
  text-align: right;
}

#invoice h1 {
  color: #0087C3;
  font-size: 2.4em;
  line-height: 1em;
  font-weight: normal;
  margin: 0  0 10px 0;
}

#invoice .date {
  font-size: 1.1em;
  color: #777777;
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table th,
table td {
  padding: 20px;
  background: #EEEEEE;
  text-align: center;
  border-bottom: 1px solid #FFFFFF;
}

table th {
  white-space: nowrap;        
  font-weight: normal;
}

table td {
  text-align: right;
}

table td h3{
  color: #57B223;
  font-size: 1.2em;
  font-weight: normal;
  margin: 0 0 0.2em 0;
}

table .no {
  color: #FFFFFF;
  font-size: 1.6em;
  background: #57B223;
}

table .desc {
  text-align: left;
}

table .unit {
  background: #DDDDDD;
}

table .qty {
}

table .total {
  background: #000000;
  color: #FFFFFF;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table tbody tr:last-child td {
  border: none;
}

table tfoot td {
  padding: 10px 20px;
  background: #FFFFFF;
  border-bottom: none;
  font-size: 1.2em;
  white-space: nowrap; 
  border-top: 1px solid #AAAAAA; 
}

table tfoot tr:first-child td {
  border-top: none; 
}

table tfoot tr:last-child td {
  color: #57B223;
  font-size: 1.4em;
  border-top: 1px solid #57B223; 

}

table tfoot tr td:first-child {
  border: none;
}

#thanks{
  font-size: 2em;
  margin-bottom: 50px;
}

#notices{
  padding-left: 6px;
  border-left: 6px solid #0087C3;  
}

#notices .notice {
  font-size: 1.2em;
}

footer {
  color: #777777;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #AAAAAA;
  padding: 8px 0;
  text-align: center;
}


    </style>
          </head>
          <body>
            <header class="clearfix">
              <div id="logo">
                <img src="images/frontend_images/logo.png">
              </div>
              
              </div>
            </header>
            <main>
                <div id="details" style="float: right;">
                <div><strong>Shipping Address</strong></div>
                <div> '.$orderDetails->name.'</div>
                <div> '.$orderDetails->address.'</div>
                <div>'.$orderDetails->city.', '.$orderDetails->state.'</div>

                <div> '.$orderDetails->pincode.'</div>
                <div> '.$orderDetails->country.'</div>
                <div> '.$orderDetails->mobile.'</div>
              </div>
              <div id="details" class="clearfix">
                <div id="client">
                  <div class="to">INVOICE TO:</div>
                  <div><span>Order ID</span> '.$orderDetails->id.'</div>
                  <div><span>Order Date</span> '.$orderDetails->created_at.'</div>
                  <div><span>Order Amount</span> '.$orderDetails->grand_total.'</div>
                  <div><span>Order Status</span> '.$orderDetails->order_status.'</div>
                  <div><span>Order Method</span> '.$orderDetails->payment_method.'</div>
                </div>
              </div>
              <table border="0" cellspacing="0" cellpadding="0">
                <thead>
                  <tr>
                    <th class="unit">PRODUCT_CODE</th>
                    <th class="desc">SIZE</th>
                    <th class="desc">COLOR</th>
                    <th class="desc">UNIT PRICE</th>
                    <th class="qty">QUANTITY</th>
                    <th class="total">TOTAL</th>
                  </tr>
                </thead>
                <tbody>';
                $Subtotal = 0;
                foreach($orderDetails->orders as $pro){
                                       $output .= '<tr>
                                            <td class="text-left">'. $pro->product_code .'</td>
                                            <td class="text-center">'. $pro->product_size .'</td>
                                            <td class="text-center">'. $pro->product_color .'</td>
                                            <td class="text-center"> '. $pro->product_price .'€</td>
                                            <td class="text-center">'. $pro->product_qty .'</td>
                                            <td class="text-right">'. $pro->product_price * $pro->product_qty .'€</td>
                                        </tr></tbody>';
                                        $Subtotal = $Subtotal + ($pro->product_price * $pro->product_qty); }
                $output .= '
                <tfoot>
                  <tr>
                    <td colspan="2"></td>
                    <td colspan="2">SUBTOTAL</td>
                    <td>'.$Subtotal.'</td>
                  </tr>
                  <tr>
                    <td colspan="2"></td>
                    <td colspan="2">Shipping Charges</td>
                    <td>'.$orderDetails->shipping_charges.'</td>
                  </tr>
                  <tr>
                    <td colspan="2"></td>
                    <td colspan="2">Coupon Discount</td>
                    <td>'.$orderDetails->coupon_amount.'</td>
                  </tr>
                  <tr style="color: #000000;">
                    <td colspan="2"></td>
                    <td colspan="2">Total</td>
                    <td>'.$orderDetails->grand_total.'</td>
                  </tr>
                </tfoot>
              </table>
            </main>
            <footer>
              Thank you for shop with us, Wolfwork brand.
            </footer>
          </body>
        </html>';
    
    $dompdf = new Dompdf();
    $dompdf->loadHtml($output);

    $dompdf->setPaper('A4','landscape');

    $dompdf->render();

    $dompdf->stream();
    
    }

    public function searchProducts(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $categories = Category::with('categories')->where(['parent_id' => 0])->get();
            $search_product = $data['product'];
            /*$productsAll = Product::where('product_name','like','%'.$search_product.'%')->orwhere('product_code',$search_product)->where('status',1)->paginate();*/

            $productsAll = Product::where(function($query) use($search_product){
                $query->where('product_name','like','%'.$search_product.'%')
                ->orWhere('product_code','like','%'.$search_product.'%')
                ->orWhere('description','like','%'.$search_product.'%')
                ->orWhere('product_color','like','%'.$search_product.'%');
            })->get();


            return view('allproducts')->with(compact('categories','productsAll','search_product')); 
        }
    }

    function format_number($number) 
    { 
        $verifySepDecimal = number_format(99,2);
    
        $valorTmp = $number;
    
        $sepDecimal = substr($verifySepDecimal, 2, 1);
    
        $hasSepDecimal = True;
    
        $i=(strlen($valorTmp)-1);
    
        for($i;$i!=0;$i-=1)
        {
            if(substr($valorTmp,$i,1)=="." || substr($valorTmp,$i,1)==","){
                $hasSepDecimal = True;
                $valorTmp = trim(substr($valorTmp,0,$i))."@".trim(substr($valorTmp,1+$i));
                break;
            }
        }
    
        if($hasSepDecimal!=True){
            $valorTmp=number_format($valorTmp,2);
        
            $i=(strlen($valorTmp)-1);
        
            for($i;$i!=1;$i--)
            {
                if(substr($valorTmp,$i,1)=="." || substr($valorTmp,$i,1)==","){
                    $hasSepDecimal = True;
                    $valorTmp = trim(substr($valorTmp,0,$i))."@".trim(substr($valorTmp,1+$i));
                    break;
                }
            }
        }
    
        for($i=1;$i!=(strlen($valorTmp)-1);$i++)
        {
            if(substr($valorTmp,$i,1)=="." || substr($valorTmp,$i,1)=="," || substr($valorTmp,$i,1)==" "){
                $valorTmp = trim(substr($valorTmp,0,$i)).trim(substr($valorTmp,1+$i));
                break;
            }
        }
    
        if (strlen(strstr($valorTmp,'@'))>0){
            $valorTmp = trim(substr($valorTmp,0,strpos($valorTmp,'@'))).trim($sepDecimal).trim(substr($valorTmp,strpos($valorTmp,'@')+1));
        }
        
        return $valorTmp; 
    } 
//FIM TRATAMENTO DEFINIÇÕES REGIONAIS


//INICIO REF MULTIBANCO
    function GenerateMbRef($ent_id, $subent_id, $order_id, $order_value)
    {
        $chk_val = 0;
        
        $order_id ="0000".$order_id;
        
        if(strlen($ent_id)<5)
        {
            echo "Lamentamos mas tem de indicar uma entidade válida";
            return;
        }else if(strlen($ent_id)>5){
            echo "Lamentamos mas tem de indicar uma entidade válida";
            return;
        }if(strlen($subent_id)==0){
            echo "Lamentamos mas tem de indicar uma subentidade válida";
            return;
        }
        
        $order_value= sprintf("%01.2f", $order_value);
        
        $order_value =  format_number($order_value);

        if ($order_value < 1){
            echo "Lamentamos mas é impossível gerar uma referência MB para valores inferiores a 1 Euro";
            return;
        }
        if ($order_value >= 1000000){
            echo "<b>AVISO:</b> Pagamento fraccionado por exceder o valor limite para pagamentos no sistema Multibanco<br>";
        }
        
        if(strlen($subent_id)==1){
            //Apenas sao considerados os 6 caracteres mais a direita do order_id
            $order_id = substr($order_id, (strlen($order_id) - 6), strlen($order_id));
            $chk_str = sprintf('%05u%01u%06u%08u', $ent_id, $subent_id, $order_id, round($order_value*100));
        }else if(strlen($subent_id)==2){
            //Apenas sao considerados os 5 caracteres mais a direita do order_id
            $order_id = substr($order_id, (strlen($order_id) - 5), strlen($order_id));
            $chk_str = sprintf('%05u%02u%05u%08u', $ent_id, $subent_id, $order_id, round($order_value*100));
        }else {
            //Apenas sao considerados os 4 caracteres mais a direita do order_id
            $order_id = substr($order_id, (strlen($order_id) - 4), strlen($order_id));
            $chk_str = sprintf('%05u%03u%04u%08u', $ent_id, $subent_id, $order_id, round($order_value*100));
        }
            
        //cálculo dos check digits

        $chk_array = array(3, 30, 9, 90, 27, 76, 81, 34, 49, 5, 50, 15, 53, 45, 62, 38, 89, 17, 73, 51);
        
        for ($i = 0; $i < 20; $i++)
        {
            $chk_int = substr($chk_str, 19-$i, 1);
            $chk_val += ($chk_int%10)*$chk_array[$i];
        }
        
        $chk_val %= 97;
        
        $chk_digits = sprintf('%02u', 98-$chk_val);

        echo "<pre>";
        echo "\n\n<b>Entidade:    </b>".$ent_id;
        echo "\n\n<b>Referência:  </b>".substr($chk_str, 5, 3)." ".substr($chk_str, 8, 3)." ".substr($chk_str, 11, 1).$chk_digits;
        echo "\n\n<b>Valor: &euro;&nbsp;</b>".number_format($order_value, 2,',', ' ');
        echo "</pre>";           
    }

    public function multibanco(){
        $order_id = Session::get('order_id');
        $grand_total = Session::get('grand_total');
        $orderDetails = Order::getOrderDetails($order_id);
        format_number(123456);
        GenerateMbRef($order_id, $grand_total);
    }
}
