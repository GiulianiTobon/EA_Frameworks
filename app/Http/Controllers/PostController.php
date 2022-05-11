<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at','desc')->paginate(5);
        return view ('dashboard.post.index', ['post'=>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.post.create',['post' => new Post()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Post::create($request->validated());
        return back()->with('status','Publicación creada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('dashboard.post.show',["post"=>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        dd($post->image);
        $categories = Category::pluck('id','title');
        return view('dashboard.post.edit',["post"=>$post,'categories'=>$categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        Post::create($request->validated());
        $post->update();
        return back()->with('status');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return back()->with('status', "Post eliminado exitosamente");
    }

    /** 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostImage  $post
     * @return \Illuminate\Http\Response
    */
    public function image(Request $request, Post $post){
        $request->validate([
            'image'=> 'require|mimes:jpeg,bmp,png|max:10240',//10Mb
        ]);
        $filename = time(). "." . $request->image->extension(); /*Nombre de las imagenes */
        /* Almacenar imagen en el servidor funcion move(especificar path) dentro de la carpeta public */
        $request->image->move(public_path('images'),$filename);
        echo "Subio la imagen ".$filename;
        PostImage::create(['image'=>$filename, 'post_id'=>$post->id]);
        return back()->with('status','Imagen cargada con exito');
    }
}
