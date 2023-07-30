<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function Allcat(){
           $categories = Category::latest()->paginate(5);
        // $categories = DB::table('categories')->latest()->paginate(5);
        return view('admin.Category.index', compact('categories'));
    }
    public function Addcat(Request $request){
        $validateData = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
            
        ],
        [
            'category_name.required' => 'Please Input Category Name',
            'category_name.max' =>  ' Category Less Than 255Chars',
        ]);
         
        Category::insert([
                 'category_name' => $request->category_name,
                 'user_id' => Auth::user()->id,
                 'created_at' => Carbon::now()
        ]);
        // $category = new Category;
        // $category->category_name = $request->category_name;
        // $category->user_id = Auth::user()->id;
        // $category->save();
        return Redirect()->back()->with('success','Category Inserted Successfull');
    }
    public function Edit($id){
        $categories = Category::find($id);
        return view('admin.category.edit',compact('categories'));
    }
    public function Update(Request $request,$id){
        $update = Category::find($id)->update([
              'category_name' => $request->category_name,
              'user_id' => Auth::user()->id       
        ]);
        return Redirect()->route('all.category')->with('success','Category Updated Successfull');
    }
}
