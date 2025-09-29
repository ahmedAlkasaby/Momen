<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
class CategoryController extends Controller
{

    public function index()
    {
        $categories=Category::orderBy('id','desc')->get();

        return view('admin.categories.index',compact('categories'));
    }


    public function create()
    {
        return view('admin.categories.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'image'=>'required|mimes:png,jpg|max:2048',
            'description'=>'string|required|min:10',
            'short_description'=>'string|required|min:10'
        ]);

        if(is_null($request->input('showing'))){
            $showing=0;
        }else{
            $showing=1;
        }
        if(is_null($request->input('trend'))){
            $trend=0;
        }else{
            $trend=1;
        }
        $slug = Str::of($request->name.uniqid())->slug('-');
        $image=$request->file('image')->store('imgs_categories','public');
        Category::create([
            'name'=>$request->name,
            'image'=>$image,
            'description'=>$request->description,
            'short_description'=>$request->short_description,
            'trend'=>$trend,
            'showing'=>$showing,
            'slug'=>$slug

        ]);
        return redirect()->route('category.index');

    }


    public function show(string $id)
    {
        $category=Category::find($id);
        return view('admin.categories.show',compact('category'));
    }


    public function edit(string $id)
    {
        $category=Category::find($id);
        return view('admin.categories.edit',compact('category'));

    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required|string',
            'image'=>'required|mimes:png,jpg|max:2048',
            'description'=>'string|required|min:10',
            'short_description'=>'string|required|min:10'
        ]);

        if(is_null($request->input('showing'))){
            $showing=0;
        }else{
            $showing=1;
        }
        if(is_null($request->input('trend'))){
            $trend=0;
        }else{
            $trend=1;
        }
        $image=$request->file('image')->store('imgs_categories','public');
        Category::where('id',$id)->update([
            'name'=>$request->name,
            'image'=>$image,
            'description'=>$request->description,
            'short_description'=>$request->short_description,
            'trend'=>$trend,
            'showing'=>$showing
        ]);
        return redirect()->route('category.index');

    }


    public function destroy(string $id)
    {
        Category::where('id',$id)->delete();
        return redirect()->route('category.index');


    }

    
}
