<?php namespace App\Http\Controllers;


use App\Photo;
use App\Post;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$posts = Post::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
		$photos = Photo::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
		$array = ['warning', 'primary', 'info', 'success'];

		return view('home', compact('posts', 'photos', 'array'));
	}

}
