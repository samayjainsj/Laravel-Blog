<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Post;

use Mail;

use Session;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $posts = Post::orderBy('created_at','desc')->limit(5)->get();
        return view('pages.welcome')->withPosts($posts);
    }
    public function getAbout()
    {
        $first = 'Samay';
        $middle = 'Kumar';
        $last = 'Jain';
        $full = $first . " " . $middle . " " . $last;
        $email = "samaykjain@gmail.com";
        return view('pages.about')->withFullname($full)->withEmail($email);
    }
    public function getContact()
    {
        return view('pages.contact');
    }

    public function postContact(Request $request) {
      $this->validate($request, [
  			'email' => 'required|email',
  			'subject' => 'min:3',
  			'message' => 'min:10']);

  		$data = array(
  			'email' => $request->email,
  			'subject' => $request->subject,
  			'bodyMessage' => $request->message
  			);

  		Mail::send('emails.contact', $data, function($message) use ($data){
  			$message->from($data['email']);
  			$message->to('hello@devmarketer.io');
  			$message->subject($data['subject']);
  		});

  		Session::flash('success', 'Your Email was Sent!');

  		}

}
