<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\post;
use Illuminate\Http\Request;
use App\Http\Resources\post as PostResource;
use App\Jobs\NewPostJob;
use App\Models\subscribe;

class PostController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth.basic.once')->only('store','update','destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit') <= 50 ? $request->input('limit') : 15;
        $post = PostResource::collection(Post::paginate($limit));
        return $post->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new PostResource(Post::create($request->all()));
        $data = $post->response()->setStatusCode(200);
        $emailPost = subscribe::with('user')->where('website_id',$request->website_id)->get();
        NewPostJob::dispatch($post , $emailPost);
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = new PostResource(Post::findOrFail($id));
        return $post->response()->setStatusCode(200,'User Returned Succefully')->header('Additional Header','True');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = new PostResource(Post::findOrFail($id));
        $post->update($request->all());
        return $post->response()->setStatusCode(200,'User Updated Succefully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::findOrFail($id)->delete();

        return 204;
    }
}
