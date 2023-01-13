<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index(){
        // ambil semua data dari database
        $posts = Post::latest()->get();

        // mengembalikan view posts bererta data posts
        return view('posts', compact('posts'));
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'content'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $post = Post::create([
            'title'     => $request->title, 
            'content'   => $request->content
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $post  
        ]);
    }

    public function show(Post $post){
        return response()->json([
            'success' => true,
            'message' => "Detail Data Post",
            'data' => $post
        ]);
    }

    public function update(Request $request, Post $post){
        // validasi inputan user
        $validator = Validator::make($request->all(),[        
            'title' => 'required',
            'content' => 'required'
        ]);

        // jika ada data yang tidak valid
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        // update data lama menjadi data baru
        $post->update([
            'title' => $request->title,
            'content' => $request->content
        ]);

        // kembalikan response
        return response()->json([
            'success' => true,
            'message' => "Data Berhasil Diubah",
            'data' => $post
        ]);
    }

    public function destroy($id){
        Post::where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => "Data Berhasil Dihapus"
        ]);
    }
}
