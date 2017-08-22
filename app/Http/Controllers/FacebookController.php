<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SammyK;
use Session;
use PDF;


class FacebookController extends Controller
{

  public function saveAccessToken(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
  {

    // Obtain an access token.
    try {
        $token = $fb->getAccessTokenFromRedirect();
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        dd($e->getMessage());
    }

    // Access token will be null if the user denied the request
    // or if someone just hit this URL outside of the OAuth flow.
    if (! $token) {
        // Get the redirect helper
        $helper = $fb->getRedirectLoginHelper();

        if (! $helper->getError()) {
            abort(403, 'Unauthorized action.');
        }

        // User denied the request
        dd(
            $helper->getError(),
            $helper->getErrorCode(),
            $helper->getErrorReason(),
            $helper->getErrorDescription()
        );
    }

    if (! $token->isLongLived()) {
        // OAuth 2.0 client handler
        $oauth_client = $fb->getOAuth2Client();

        // Extend the access token.
        try {
            $token = $oauth_client->getLongLivedAccessToken($token);
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
        }
    }


    //$fb->setDefaultAccessToken($token);

    // Save for later
    Session::put('fb_user_access_token', (string) $token);

    // Get basic info on the user from Facebook.
    // try {
    //     $response = $fb->get('/me?fields=id,name,email');
    // } catch (Facebook\Exceptions\FacebookSDKException $e) {
    //     dd($e->getMessage());
    // }

    // Convert the response to a `Facebook/GraphNodes/GraphUser` collection
    //$facebook_user = $response->getGraphUser()->asJson();

    // Create the user if it does not exist or update the existing entry.
    // This will only work if you've added the SyncableGraphNodeTrait to your User model.
    //$user = App\User::createOrUpdateGraphNode($facebook_user);

    // Log the user into Laravel
    //Auth::login($user);

    return redirect('/');
  }

    public function getProfile($provider = null, SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
    {

    //for searching
    $fb->setDefaultAccessToken(Session::get('fb_user_access_token'));
    // $request = 'ambot'.'allen beciera lamparas';

    // echo $provider.$request;
    // Search for users.
    try {
        $response = $fb->get('/'.$provider.'?fields=name,id,picture');
        $response1 = $fb->get('/'.$provider.'/feed');
        $response2 = $fb->get('/'.$provider.'?fields=name,id,picture');
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        dd($e->getMessage());
    }

        // Convert the response to a `GraphEdge` collection
        $data = $response->getGraphNode();
        $data1 = $response1->getGraphEdge();
        $data2 = '';

       //$json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';
        // $obj = json_decode($data1);
        // $array = json_decode($data1, true);
        //$data1 = (string)$data1;
        //echo $data1;
        //$facebook = json_encode($data1);
        //echo $data1[0]['created_time'];
        // $date = date_create($data1[0]['created_time']);
        // echo date_format($date, 'Y-m-d');

        //echo $data1[0]['created_time'];
        
        return view('facebook', compact('data', 'data1', 'data2'));
    }

  public function search($provider = null, SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
  {

    //for searching
    $fb->setDefaultAccessToken(Session::get('fb_user_access_token'));
    // $request = 'ambot'.'allen beciera lamparas';

    // echo $provider.$request;
    // Search for users.
    try {
        $response = $fb->get('/search?q='.$provider.'&type=user&fields=name,id,picture');
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        dd($e->getMessage());
    }

    // Convert the response to a `GraphEdge` collection
    $facebook_users = $response->getGraphEdge();

    echo $facebook_users;
    //dd($facebook_users);
  }

  public function feeds(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
  {
    //for retrieving posts
    $fb->setDefaultAccessToken(Session::get('fb_user_access_token'));

    //dd($fb);    
    // Retrieve users info.
    try {
        // basic infos
        // $response = $fb->get('/1363389647081456?fields=id, name, picture');
        //feeds
        $response = $fb->get('/me/feed');
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        dd($e->getMessage());
    }
    
    // Convert the response to a `GraphEdge` collection
    $facebook_users = $response->getGraphEdge();

    //echo $facebook_users;
    $pdf = PDF::loadHTML('<p>dsadsadsadadsa</p>');
    return $pdf->download('invoice.pdf');
  }



  public function friends(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
  {
    //for retrieving posts
    $fb->setDefaultAccessToken(Session::get('fb_user_access_token'));

    // Retrieve users info.
    try {
        // basic infos
        // $response = $fb->get('/1363389647081456?fields=id, name, picture');
        //feeds
        $response = $fb->get('/me?fields=id,name,about,birthday');
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        dd($e->getMessage());
    }

    // Convert the response to a `GraphEdge` collection
    $facebook_users = $response->getGraphNode();
    dd($response);
  }


  public function album(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
  {
    //for retrieving posts
    $fb->setDefaultAccessToken(Session::get('fb_user_access_token'));

    // Retrieve users info.
    try {
        // basic infos
        // $response = $fb->get('/1363389647081456?fields=id, name, picture');
        //feeds
        $response = $fb->get('/1377511782335909/');
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        dd($e->getMessage());
    }

    // Convert the response to a `GraphEdge` collection
    $facebook_users = $response->getGraphNode();
    dd($response);
  }
}
