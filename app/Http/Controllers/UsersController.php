<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Order;
use App\Country;
use DB;
use Auth;
use Session;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsersController extends Controller
{
    public function userLoginRegister(){
        return view('users.login_register');
    }

    public function userRegister(){
        return view('users.register');
    }

    public function account(Request $request){
        $user_id = Auth::user()->id;
        $userDetails = User::find($user_id);
        $countries = Country::get();

        if (Auth::check()) {
            if ($request->isMethod('post')) {
                $data = $request->all();

                if (empty($data['name'])) {
                    return redirect()->back()->with('flash_message_error', 'Por favor insira o Nome para atualizar detalhes de conta!');
                }

                if (empty($data['address'])) {
                    $data['address'] = '';
                }

                if (empty($data['city'])) {
                    $data['city'] = '';
                }

                if (empty($data['state'])) {
                    $data['state'] = '';
                }

                if (empty($data['country'])) {
                    $data['country'] = '';
                }

                if (empty($data['pincode'])) {
                    $data['pincode'] = '';
                }

                if (empty($data['mobile'])) {
                    $data['mobile'] = '';
                }

                $user = User::find($user_id);
                $user->name = $data['name'];
                $user->address = $data['address'];
                $user->city = $data['city'];
                $user->state = $data['state'];
                $user->country = $data['country'];
                $user->pincode = $data['pincode'];
                $user->mobile = $data['mobile'];
                $user->save();
                return redirect()->back()->with('flash_message_success', 'Detalhes de conta editados com sucesso!');

            }
        } else {
            return redirect()->back()->with('flash_message_error', 'Please Login to add product in your Wish List');
        }

        return view('users.account')->with(compact('countries' ,'userDetails'));
    }

    public function register(Request $request){
    	if ($request->isMethod('post')) {
    		$data = $request->all();

    		$usersCount = User::where('email', $data['email'])->count();

    		if ($usersCount > 0) {
    			return redirect()->back()->with('flash_message_error', 'Inserted email already exists!');
    		}
            else {

                $user = new User;
                $user->name = $data['name'];
                $user->email = $data['email'];


                $user->password = bcrypt($data['password']);




                date_default_timezone_set('Europe/Lisbon');
                $user->created_at = date("Y-m-d H:i:s");
                $user->updated_at = date("Y-m-d H:i:s");
                $user->save();

                /*//enviar mail de registo
                $email = $data['email'];
                $messageData = ['email'=>$data['email'], 'name'=>$data['name']];
                Mail::send('emails.register', $messageData, function($message) use($email){
                    $message->from('wolfworkbrand@gmail.com', 'Your account');
                    $message->to($email)->subject('New Wolf Account');
                });*/

                $email = $data['email'];
                $messageData = ['email'=>$data['email'],'name'=>$data['name'],'code'=>base64_encode($data['email'])];
                Mail::send('emails.confirmation', $messageData, function($message) use($email){
                    $message->from('wolfworkbrand@gmail.com', 'Your account');
                    $message->to($email)->subject('Confirm your Wolf Account');
                });

                return redirect()->back()->with('flash_message_success','Please confirm your email to activate.');

                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                    Session::put('frontSession',$data['email']);

                    if(!empty(Session::get('session_id'))){
                        $session_id = Session::get('session_id');
                        DB::table('cart')->where('session_id',$session_id)->update(['user_email' => $data['email']]);
                    }

                    return redirect('/cart');
                }
            }
        }
    }

    public function confirmAccount($email){
        $email = base64_decode($email);
        $userCount = User::where('email',$email)->count();
        if($userCount > 0){
            $userDetails = User::where('email',$email)->first();
            if($userDetails->status == 1){
                return redirect('user-register')->with('flash_message_success','Your Email account is already activated. You can login now.');
            }else{
                User::where('email',$email)->update(['status'=>1]);

                // Send Welcome Email
                $messageData = ['email'=>$email,'name'=>$userDetails->name];
                Mail::send('emails.welcome',$messageData,function($message) use($email){
                    $message->to($email)->subject('Welcome to WolfWork Brand!');
                });

                return redirect('user-register')->with('flash_message_success','Your Email account is activated. You can login now.');
            }
        }else{
            abort(404);
        }
    }

    public function chkUserPassword(Request $request) {
        $data = $request->all();

        $current_password = $data['current_pwd'];
        $user_id = Auth::User()->id;
        $check_password = User::where('id', $user_id)->first();
        if(Hash::check($current_password, $check_password->password)){
            echo "true"; die;
        } else {
            echo "false"; die;
        }
    }

    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            // procura um utilizador na tabela users com estes dados fornecidos no array
            
            if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                
                $userStatus = User::where('email',$data['email'])->first();
                
                if($userStatus->status == 0){
                    return redirect()->back()->with('flash_message_error',
                                                'Your account is not activated! Please confirm your email to activate.');    
                }
                Session::put('frontSession',$data['email']);

                if(!empty(Session::get('session_id'))){
                    $session_id = Session::get('session_id');
                    DB::table('cart')->where('session_id',$session_id)->update(['user_email' => $data['email']]);
                }
                return redirect('/allproducts');
            }else{
                return redirect()->back()->with('flash_message_error','Invalid Username or Password!');
            }
        }
    }

    public function logout(){
        Auth::logout();
        Session::forget('frontSession');
        Session::forget('session_id');
        return redirect('/');
    }

    public function checkEmail(Request $request){

        $data = $request->all();
        $usersCount = User::where('email', $data['email'])->count();

        if ($usersCount > 0) {
             echo "false";
        }
        else {
            echo "true"; die;
        }

    }

    public function updatePassword(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $old_pwd = User::where('id', Auth::User()->id)->first();
            $current_pwd = $data['current_pwd'];
            if (Hash::check($current_pwd, $old_pwd->password)) {
                $new_pwd = bcrypt($data['new_pwd']);
                User::where('id', Auth::User()->id)->update(['password'=>$new_pwd]);
                return redirect()->back()->with('flash_message_success', 'Password atualizada com sucesso');
            } else {
                return redirect()->back()->with('flash_message_error', 'Password atual está incorreta');
            }
        }
    }

    public function viewUsers(){
        if (Session::get('adminDetails')['users_access']==0) {
            return redirect('>/admin/dashboard')->with('flash_message_error', 'You have no access for this module');
        }
        $users = User::get();
        return view('admin.users.view_users')->with(compact('users'));
    }

    public function forgotPassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            $userCount = User::where('email',$data['email'])->count();
            if($userCount == 0){
                return redirect()->back()->with('flash_message_error','Email does not exists!');
            }

            // obter dados dos utilizadores
            $userDetails = User::where('email',$data['email'])->first();

            //Gerar password random
            $random_password = Str::random(8);

            // password encriptada
            $new_password = bcrypt($random_password);

            // atualizar password
            User::where('email',$data['email'])->update(['password'=>$new_password]);

            // enviar uma password por email
            $email = $data['email'];
            $name = $userDetails->name;
            $messageData = [
                'email'=>$email,
                'name'=>$name,
                'password'=>$random_password
            ];
            Mail::send('emails.forgotpassword',$messageData,function($message)use($email){
                $message->to($email)->subject('New Password - E-com WolfWork');
            });

            return redirect('user-register')->with('flash_message_success','Please check your email for new password!');

        }
        return view('users.forgot_password');
    }

    public function viewUsersCharts(){
        $current_month_users = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();
        $last_month_users = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(1))->count();
        $last_to_last_month_users = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(2))->count();
        return view('admin.users.view_users_charts')->with(compact('current_month_users', 'last_month_users', 'last_to_last_month_users'));
    }

    public function viewOrdersCharts(){
        $current_month_orders = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();
        $last_month_orders = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(1))->count();
        $last_to_last_month_orders = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(2))->count();
       
        return view('admin.products.view_orders_charts')->with(compact('current_month_orders', 'last_month_orders', 'last_to_last_month_orders'));
    }

}
