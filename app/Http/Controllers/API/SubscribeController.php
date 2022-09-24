<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use App\Http\Resources\Subscribe as SubscribeResource;
use App\Jobs\PostJob;

class SubscribeController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth.basic.once');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit') <= 50 ? $request->input('limit') : 15;
        $subscribe = SubscribeResource::collection(Subscribe::paginate($limit));
        return $subscribe->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subscribe = new SubscribeResource(Subscribe::create([
            'website_id' => $request->website_id,
            'user_id' => auth()->user()->id,
        ]));
        $data = $subscribe->response()->setStatusCode(200);

        $email = auth()->user()->email;
        $posts = post::where('website_id' , $request->website_id)->get();
        PostJob::dispatch($posts , $email);

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\subscribe  $subscribe
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subscribe = new SubscribeResource(Subscribe::findOrFail($id));
        return $subscribe->response()->setStatusCode(200,'User Returned Succefully')->header('Additional Header','True');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\subscribe  $subscribe
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Subscribe::findOrFail($id)->delete();

        return 204;
    }
}
