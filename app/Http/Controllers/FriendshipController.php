<?php namespace App\Http\Controllers;

use App\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class FriendshipController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$not_friends = User::where('id', '!=', Auth::user()->id);
		if (Auth::user()->friends->count()) {
			$not_friends->whereNotIn('id', d);
		}
		$not_friends = $not_friends->get();

		return View('friends')->with('not_friends', $not_friends);
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
		//
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
	public function update($id)
	{
		//
	}

	/**
	 * Remove Friend
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = User::find(Auth::user()->id);
		$friend = User::find($id);
		$user->removeFriend($friend);
		return redirect()->back();
	}
	/**
	 * Add friend
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function add($id)
	{
		$user = User::find(Auth::user()->id);
		$friend = User::find($id);
		$user->addFriend($friend);
		return redirect()->back();
	}
}
