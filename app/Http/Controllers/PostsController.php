<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Validator;
use Response;
use App\{Post,Category};
use View;


class PostsController extends Controller
{
    /**
    * @var array
    */
    protected $rules =
    [
        'title' => 'required|min:2|max:32|regex:/^[a-z ,.\'-]+$/i',
        'content' => 'required|min:2|max:128|regex:/^[a-z ,.\'-]+$/i'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->get();       
        $category = Category::get()->pluck('title','id');

        return view('posts.index', ['posts' => $posts,'category' => $category]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $post = new Post();
            $post->title = $request->title;
            $post->content = $request->content;
            $post->category_id = $request->category_id;
            $post->save();
            return response()->json($post);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        return view('post.show', ['post' => $post]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $post = Post::findOrFail($id);
            $post->title = $request->title;
            $post->content = $request->content;
            $post->save();
            return response()->json($post);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json($post);
    }


    /**
     * Change resource status.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatus() 
    {
        $id = Input::get('id');

        $post = Post::findOrFail($id);
        $post->is_published = !$post->is_published;
        $post->save();

        return response()->json($post);
    }

    public function searchData(Request $request) {
        $posts = Post::when($request->has('search_date'),function( $q ) use( $request ) {
            return $q->where(\DB::raw('DATE(created_at)'),date('Y-m-d',strtotime($request->get('search_date'))));
        })->orderBy('id', 'desc')->get();
        $returnHTML = view('posts.table-data',['posts'=> $posts])->render();// or method that you prefere to return data + RENDER is the key here
        return response()->json($returnHTML);       
    }

}