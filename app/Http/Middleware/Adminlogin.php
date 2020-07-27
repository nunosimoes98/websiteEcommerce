<?php

namespace App\Http\Middleware;
use App\Admin;
use App\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

use Closure;
use Session;

class Adminlogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(empty(Session::has('adminSession'))){
            return redirect('/admin');
        } else {
            $adminDetails = Admin::where('username',Session::get('adminSession'))->first();
            $adminDetails = json_decode(json_encode($adminDetails),true);

            Session::put('adminDetails',$adminDetails);

            $currentPath = Route::getFacadeRoot()->current()->uri();

            if ($currentPath == "admin/view-categories" && Session::get('adminDetails')['categories_view_access']==0) {
                return redirect('>/admin/dashboard')->with('flash_message_error', 'You have no access for this module');
            }

            if ($currentPath == "admin/view-products" && Session::get('adminDetails')['products_access']==0) {
                return redirect('>/admin/dashboard')->with('flash_message_error', 'You have no access for this module');
            }

            if ($currentPath == "admin/add-product" && Session::get('adminDetails')['products_access']==0) {
                return redirect('>/admin/dashboard')->with('flash_message_error', 'You have no access for this module');
            }

        }
        return $next($request);
    }
}