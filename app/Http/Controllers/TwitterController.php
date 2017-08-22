<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twitter;
use File;
use PDF;

class TwitterController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function getFriendsList($provider = null)
    {
        $data1 = Twitter::getFriends(['user_id' => $provider]);
        //dd($data);        
        return view('home', compact('data1'));
    }

    public function getFollowers($provider = null)
    {
        $data = Twitter::getFollowers(['user_id' => $provider, 'format' => 'array']);
        dd($data);
    }

    public function getUserTimeline($provider = null)
    {
        $data2 = Twitter::getFollowers(['user_id' => $provider, 'format' => 'array']);
        $data1 = Twitter::getFriends(['user_id' => $provider, 'format' => 'array']);
        $data = Twitter::getUserTimeline(['user_id' => $provider, 'count' => 1000, 'format' => 'array']);

        view('pdf', compact('data', 'data1', 'data2'));
        
        return view('twitter', compact('data', 'data1', 'data2'));
    }


    public function getLikes($provider = null)
    {
        $data = Twitter::getFavorites(['id' => $provider]);
        echo json_encode($data);

    }

    public function twitterUserSearch(Request $request)    {

        $this->validate($request, [
                'search' => 'required'
            ]);

        //return $newTwitte = ['status' => $request->search];

        $data = Twitter::getUsersSearch(['q' => $request->search, 'format' => 'array']);
        //return $data;
    	//return view('userSearch', compact('data'));
        echo json_encode($data);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
/*    public function tweet(Request $request)
    {
    	$this->validate($request, [
        		'tweet' => 'required'
        	]);

    	$newTwitte = ['status' => $request->tweet];

    	
    	if(!empty($request->images)){
    		foreach ($request->images as $key => $value) {
    			$uploaded_media = Twitter::uploadMedia(['media' => File::get($value->getRealPath())]);
    			if(!empty($uploaded_media)){
                    $newTwitte['media_ids'][$uploaded_media->media_id_string] = $uploaded_media->media_id_string;
                }
    		}
    	}

    	$twitter = Twitter::postTweet($newTwitte);

    	
    	return back();
    }*/
}