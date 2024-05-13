<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Posts;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class PostsController extends Controller
{
    public function index()
    {
        //get posts
        $posts = Posts::latest()->paginate(5);

        //return collection of posts as a resource
        return new ApiResource(true, 'List Data Posts', $posts);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/uploads/posts', $image->hashName());

        //create post
        $post = Posts::create([
            'title'         => $request->title,
            'slug'          => Str::slug($request->title),
            'image'         => $image->hashName(),
            'description'   => $request->description,
        ]);

        //return response
        return new ApiResource(true, 'Data Post Berhasil Ditambahkan!', $post);
    }

    public function show(Posts $post)
    {
        //return single post as a resource
        return new ApiResource(true, 'Data Post Ditemukan!', $post);
    }

    public function update(Request $request, Posts $post)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'description'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //check if image is not empty
        if ($request->hasFile('image')) {

            //upload image
            $image = $request->file('image');
            $image->storeAs('public/uploads/posts', $image->hashName());

            //delete old image
            Storage::delete('public/uploads/posts/' . $post->image);

            //update post with new image
            $post->update([
                'title'         => $request->title,
                'slug'          => Str::slug($request->title),
                'image'         => $image->hashName(),
                'description'   => $request->description,
            ]);
        } else {

            //update post without image
            $post->update([
                'title'         => $request->title,
                'slug'          => Str::slug($request->title),
                'description'   => $request->description,
            ]);
        }

        //return response
        return new ApiResource(true, 'Data Post Berhasil Diubah!', $post);
    }

    public function destroy(Posts $post)
    {
        //delete image
        Storage::delete('public/uploads/posts/' . $post->image);

        //delete post
        $post->delete();

        //return response
        return new ApiResource(true, 'Data Post Berhasil Dihapus!', null);
    }
}
