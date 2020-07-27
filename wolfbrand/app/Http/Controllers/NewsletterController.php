<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NewsletterSubscriber;

class NewsletterController extends Controller
{
    public function checkSubscriber(Request $request){
    	if ($request->ajax()) {
    		$data = $request->all();

    		$subscriberCount = NewsletterSubscriber::where('email',$data['subscriber_email'])->count();
    		if ($subscriberCount > 0) {
    			echo "exists";
    		}
    	}
    }

    public function addSubscriber(Request $request){
    	if ($request->ajax()) {
    		$data = $request->all();

    		$subscriberCount = NewsletterSubscriber::where('email',$data['subscriber_email'])->count();
    		if ($subscriberCount > 0) {
    			echo "exists";
    		} else {
    			$newsletter = new NewsletterSubscriber;
    			$newsletter->email = $data['subscriber_email'];
    			$newsletter->status = 1;
    			$newsletter->save();
    			echo "saved";
    		}
    	}
    }

    public function viewNewsletterSubscribers(Request $request){
    	$newsletters = NewsletterSubscriber::get();
    	return view('admin.newsletters.view_newsletters')->with(compact('newsletters'));
    }

    public function updateNewsletterStatus($id,$status){
    	NewsletterSubscriber::where('id',$id)->update(['status'=>$status]);
    	return redirect()->back()->with('flash_message_success', 'Estado do subscritor foi alterado com sucesso!');
    }

    public function deleteNewsletterEmail($id){
    	NewsletterSubscriber::where('id',$id)->delete();
    	return redirect()->back()->with('flash_message_success', 'Email do subscritor foi eliminado com sucesso!');

    }
}
