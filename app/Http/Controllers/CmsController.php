<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CmsPage;
use App\Category;
use Illuminate\Support\Facades\Mail;
use Validator;
use App\Enquiry;

class CmsController extends Controller
{
    public function addCmsPage(Request $request){
    	if($request->isMethod('post')){
    		$data = $request->all();
    		/*echo "<pre>"; print_r($data); die;*/
            if(empty($data['meta_title'])){
                $data['meta_title'] = "";    
            }
            if(empty($data['meta_description'])){
                $data['meta_description'] = "";    
            }
            if(empty($data['meta_keywords'])){
                $data['meta_keywords'] = "";    
            }
    		$cmspage = new CmsPage;
    		$cmspage->title = $data['title'];
    		$cmspage->url = $data['url'];
            $cmspage->description = $data['description'];

    		if(empty($data['status'])){
    			$status = 0;
    		}else{
    			$status = 1;
    		}
    		$cmspage->status = $status;
    		$cmspage->save();
    		return redirect()->back()->with('flash_message_success','CMS Page has been added successfully');
    	}
    	return view('admin.pages.add_cms_page');
    }

    public function instagram(){
        return view("pages.instagram");
    }
    public function viewCmsPages(){
        $cmsPages = CmsPage::get();
        return view('admin.pages.view_cms_pages')->with(compact('cmsPages'));
    }

    public function editCmsPage(Request $request,$id){
        if($request->isMethod('post')){
            $data = $request->all();
            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }
            CmsPage::where('id',$id)->update(['title'=>$data['title'],'url'=>$data['url'],'description'=>$data['description'],'status'=>$status]);
            return redirect()->back()->with('flash_message_success','CMS Page has been updated successfully!');
        }
        $cmsPage = CmsPage::where('id',$id)->first();
        return view('admin.pages.edit_cms_page')->with(compact('cmsPage'));
    }

    public function deleteCmsPage($id){
        CmsPage::where('id',$id)->delete();
        return redirect('/admin/view-cms-pages')->with('flash_message_success','CMS Page has been deleted successfully!');
    }

    public function cmsPage($url){

        $cmsPageDetails = "";
        // Redirect to 404 if CMS Page is disabled or does not exists
        $cmsPageCount = CmsPage::where(['url'=>$url,'status'=>1])->count();
        if($cmsPageCount>0){
            // Get CMS Page Details
            $cmsPageDetails = CmsPage::where('url',$url)->first();

        }


        return view('pages.cms_page')->with(compact('cmsPageDetails'));
    }

     public function contact(Request $request){

        if($request->isMethod('post')){
            $data = $request->all();

            $validator = Validator::make($request->all(), [
                'name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'email' => 'required|email',
                'subject' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'message' => 'required|regex:/^[\pL\s\-]+$/u|max:255'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('flash_message_error','It was not possible send message to Admin!');
            }

            // envia contacto para o mail
            $email = "wolfworkbrand@gmail.com";
            $messageData = [
                'name'=>$data['name'],
                'email'=>$data['email'],
                'subject'=>$data['subject'],
                'comment'=>$data['message']
            ];
            Mail::send('emails.enquiry',$messageData,function($message)use($email){
                $message->to($email)->subject('Enquiry from WolfWork Website');
            });

            return redirect()->back()->with('flash_message_success','Thanks for your enquiry. We will get back to you soon.');
        }

        
        return view('pages.contact');
    }




    public function addPost(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            $enquiry = new Enquiry;
            $enquiry->name = $data['name'];
            $enquiry->email = $data['email'];
            $enquiry->subject = $data['subject'];
            $enquiry->message = $data['message'];
            $enquiry->save();
            echo "Thanks for contacting us. We will get back to you soon."; die;
        }

        return view('pages.post');
    }

    public function getEnquiries(){
        $enquiries = Enquiry::orderBy('id','Desc')->get();
        $enquiries = json_encode($enquiries);
        return $enquiries;
    }

    public function viewEnquiries(){
        return view('admin.enquiries.view_enquiries');
    }
 
}
