<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\Request;
use App\Http\Resources\website as websiteResource;

class WebsiteController extends Controller
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
        $website = WebsiteResource::collection(website::paginate($limit));
        return $website->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $website = new WebsiteResource(website::create([
            'title' => $request->title,
            'url'   => $request->url,
            'user_id' => auth()->user()->id,
        ]));
        return $website->response()->setStatusCode(200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\website  $website
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $website = new WebsiteResource(website::findOrFail($id));
        return $website->response()->setStatusCode(200,'User Returned Succefully')->header('Additional Header','True');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\website  $website
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $websiteId = Website::findOrFail($id);
        $this->authorize('update',$websiteId);
        $website = new WebsiteResource(Website::findOrFail($id));
        $website->update($request->all());
        return $website->response()->setStatusCode(200,'User Updated Succefully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\website  $website
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $websiteId = Website::findOrFail($id);
        $this->authorize('destroy',$websiteId);
        Website::findOrFail($id)->delete();

        return 204;
    }
}
