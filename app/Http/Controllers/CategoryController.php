<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Session;

class CategoryController extends Controller
{
    // função adicionar categoria - admin
    public function addCategory(Request $request){

        if (Session::get('adminDetails')['categories_full_access']=0) {
            return redirect('/admin/dashboard')->with('flash_message_error', 'You have no access for this module');
        }

    	if($request->isMethod('post')){
    		$data = $request->all();

            $category = new Category;
            $category->name = $data['category_name'];
       
    		$category->description = $data['description'];
    		$category->url = $data['url'];
    		$category->save();

    		return redirect('/admin/view-categories')->with('flash_message_success','Categoria adicionada com sucesso!');;
    	}

    	$levels = Category::where(['parent_id'=>0])->get();

    	return view('admin.categories.add_category')->with(compact('levels'));
    }

    // função ver categorias - admin
    public function viewCategories(){
        if (Session::get('adminDetails')['categories_view_access']==0) {
            return redirect('/admin/dashboard')->with('flash_message_error', 'You have no access for this module');
        }
    	$categories = Category::get();
    	$categories = json_decode(json_encode($categories));
    	return view('admin.categories.view_categories')->with(compact('categories'));
    }

    // função editar categorias - admin
    public function editCategory(Request $request, $id = null){
        if (Session::get('adminDetails')['categories_edit_access']==0) {
            return redirect('/admin/dashboard')->with('flash_message_error', 'You have no access for this module');
        }
    	if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            Category::where(['id'=>$id])->update(['name'=>$data['category_name'],'description'=>$data['description'],'url'=>$data['url']]);
            return redirect('/admin/view-categories')->with('flash_message_success','Category updated Successfully!');
        }
    	$categoryDetails = Category::where(['id'=>$id])->first();
    	$levels = Category::where(['parent_id'=>0])->get();
    	 return view('admin.categories.edit_category')->with(compact('categoryDetails', 'levels'));
    }

    // função editar categorias - admin
    public function deleteCategory(Request $request, $id = null){
        if (Session::get('adminDetails')['categories_access']==0) {
            return redirect('/admin/dashboard')->with('flash_message_error', 'You have no access for this module');
        }
       	if(!empty($id)){
       		Category::where(['id'=>$id])->delete();
       		return redirect()->back()->with('flash_message_success', 'Categoria apagada com sucesso!');
       	}
    }
}
