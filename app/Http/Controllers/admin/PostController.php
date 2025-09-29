<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;


class PostController extends Controller
{

    public function index()
    {
        $posts=Post::orderBy('id','desc')->get();
        return view('admin.news.index',compact('posts'));
    }


    public function create()
    {
        return view('admin.news.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|string',
            'image'=>'required|mimes:png,jpg|max:2048',
            'description'=>'string|required|min:10',
            'short_description'=>'string|required|min:10',

        ]);
        $slug = Str::of($request->title.uniqid())->slug('-');
        $image=$request->file('image')->store('imgs_categories','public');
        Post::create([
            'title'=>$request->title,
            'image'=>$image,

            'description'=>$request->description,
            'short_description'=>$request->short_description,

            'slug'=>$slug,

        ]);
        return redirect()->route('news.index');
    }


    public function show(string $id)
    {
        $post=Post::find($id);
        return view('admin.news.show',compact('post'));
    }


    public function edit(string $id)
    {
        $post=Post::find($id);
        return view('admin.news.edit',compact('post'));
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'title'=>'required|string',
            'image'=>'required|mimes:png,jpg|max:2048',
            'description'=>'string|required|min:10',
            'short_description'=>'string|required|min:10',

        ]);
        $slug = Str::of($request->title.uniqid())->slug('-');
        $image=$request->file('image')->store('imgs_categories','public');
        Post::where('id',$id)->update([
            'title'=>$request->title,
            'image'=>$image,
            'description'=>$request->description,
            'short_description'=>$request->short_description,
            'slug'=>$slug,
        ]);
        return redirect()->route('news.index');
    }


    public function destroy(string $id)
    {
        Post::where('id',$id)->delete();
        return redirect()->route('news.index');
    }
}
