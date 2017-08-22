<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twitter;
use File;
use PDF;
use Mail;   
class PDFController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */    
    public function index($provider = null)
    {
        // $data2 = Twitter::getFollowers(['user_id' => '307850358', 'format' => 'array']);
         //$data1 = Twitter::getFriends(['user_id' => $provider, 'format' => 'array']);
         $data = Twitter::getUserTimeline(['user_id' => '307850358', 'count' => 1000, 'format' => 'array']);

        //return view('pdf', compact('data', 'data1', 'data2'));
         //$pdf = PDF::loadHtml('<div class="post-media"><img class="user-img" src="{{ $value["user"]["profile_image_url_https"]}}"><div class="content"><h5 width="50px" class="username">{{ $value["user"]["name"]}}</a></h5><p class="text-muted"><small>{{ $value["created_at"]}}</small></p></div></div>');
         $pdf = PDF::loadView('pdf', compact('data'));
         // Render the HTML as PDF
        //$pdf->render();

        // Output the generated PDF to Browser
        return $pdf->download();
         //return $pdf->download('invoice.pdf');


    }


public function postContact(Request $request){
 ini_set('max_execution_time', 300); 
  
    // $this->validate($request,[
    //     'email'=>'required|email']);
   $datani=array(
    'email'=> 'lamparasallen@gmail.com',
    'subject'=> 'ninjapi',
    'bodyMessage'=> 'wa');

    Mail::send('email',$datani,function($message)use($datani){
         
        $message->from('ninjapidetectiveagency@gmail.com','NinjaPi Detective Agency');
       // $message->attach($pdf->output());
        $message->to($datani['email']);
        $message->subject($datani['subject']);
       // $message->attach($pdf);
       //$message->attach('C:/Users/ab_lamparas/Downloads/Documents/tweets_2.pdf');
});

// return view('pdf', compact('data'));
        //Session::flash('Success',' Message was sent!');
    return redirect('/login');
}

}