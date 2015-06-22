<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Photo;
use App\Post;
use Auth;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\View\View;

class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

		$user = User::find($id);
		$posts = Post::where('user_id', $id)->orderBy('created_at', 'desc')->get();
		$photos = Photo::where('user_id', $id)->orderBy('created_at', 'desc')->get();
		$array = ['warning', 'primary', 'info', 'success'];
		return view('user', array('user' => $user, 'posts' => $posts, 'photos' => $photos, 'array' => $array));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request)
	{
		$me = User::find(Auth::user()->id);
		if ($request->method('POST')) {
			$me->information = $request->info;
			$me->name = $request->name;
			$me->s_name = $request->s_name;
			if (strlen($request->password) > 4 || $request->password == $request->password_confirmation)
				$me->password = bcrypt($request->password);
			if ($request->file('pic')) {
				$fileName = Auth::id() . rand(0, 145454545454) . Auth::id() . '.' .
					$request->file('pic')->getClientOriginalExtension();

				if ($request->file('pic')->getClientOriginalExtension() == 'jpg' || $request->file('audio')->getClientOriginalExtension() == 'png') {

					$request->file('pic')->move(
						base_path() . '/public/pic/' . Auth::id() . '/avatar/', $fileName
					);
					$me->photo = '/pic/' . Auth::id() . '/avatar/' . $fileName;
				}
			}
			$me->save();
		}
		return redirect('/user/settings');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function qrauth(Request $request){
		$tok = $request->input('qr');
		try {
			$user = User::where('password', '=', $tok)->firstOrFail();

			Auth::loginUsingId($user->id);
			return redirect('/home');
		} catch (ModelNotFoundException $q) {
			$request->session()->flash('error_message', 'Bad auth token!');

			return redirect('auth/login');
		}
	}

	public function settings(Request $request)
	{
		$user = Auth::user();

		return view('user.settings', compact('user'));

	}

	public function post(Request $request)
	{
		try {
			if ($request->method('post')) {
				Post::create([
					'content' => $request->text,
					'user_id' => Auth::user()->id
				]);
			}
		} catch (ModelNotFoundException $q) {
			$request->session()->flash('error_message', 'Please input message');
		}
		return redirect('/home');
	}

	public function addpic(Request $request)
	{

		$fileName = Auth::id() . rand(0, 145454545454) . Auth::id() . '.' .
			$request->file('pic')->getClientOriginalExtension();

		if ($request->file('pic')->getClientOriginalExtension() == 'jpg' || $request->file('audio')->getClientOriginalExtension() == 'png') {

			$request->file('pic')->move(
				base_path() . '/public/pic/' . Auth::id() . '/photos/', $fileName
			);
			$link = '/pic/' . Auth::id() . '/photos/' . $fileName;
		}

		Photo::create([
			'link' => $link,
			'user_id' => Auth::user()->id,
			'description' => $request->descrition
		]);
		return redirect('/home');
	}

	public function delPost($id)
	{
		Post::destroy($id);
		return redirect('/home');
	}

	public function delPhoto($id)
	{
		Photo::destroy($id);
		return redirect('/home');
	}
}
