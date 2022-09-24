<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\website;
use App\Models\user;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class RelationShipController extends Controller
{
    public function userWebsites($id)
    {
        $user = User::findOrFail($id)->website;
        $fields = array();
        $filtered = array();
        foreach ($user as $website) {
            $fields['id'] = $website->id;
            $fields['Title'] = $website->title;
            $fields['url'] = $website->url;
            $fields['user_id'] = $website->user_id;
            $filtered[] = $fields;
        }
        return Response::json([
            'data' => $filtered,
        ],200);
    }

    public function websitePosts($id)
    {
        $website = Website::findOrFail($id)->post;
        $fields = array();
        $filtered = array();
        foreach ($website as $post) {
            $fields['Title'] = $post->title;
            $fields['Content'] = $post->description;
            $fields['website_id'] = $post->website_id;
            $filtered[] = $fields;
        }
        return Response::json([
            'data' => $filtered,
        ],200);;
    }
}
