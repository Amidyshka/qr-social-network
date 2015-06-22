<?php namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Thread;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Redirect;

class MessagesController extends Controller
{
    /**
     * Just for testing - the user should be logged in. In a real
     * app, please use standard authentication practices
     */
    public function __construct()
    {

    }

    /**
     * Show all of the message threads to the user
     *
     * @return mixed
     */
    public function index()
    {
        $currentUserId = Auth::user()->id;
        // All threads, ignore deleted/archived participants
        //$threads = Thread::getAllLatest()->get();
        // All threads that user is participating in
        $threads = Thread::forUser($currentUserId)->latest('updated_at')->get();
        // All threads that user is participating in, with new messages
        // $threads = Thread::forUserWithNewMessages($currentUserId)->latest('updated_at')->get();
        return view('messenger.index', compact('threads', 'currentUserId'));
    }

    /**
     * Shows a message thread
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');
            return redirect('messages');
        }
        // show current user in list if not a current participant
        // $users = User::whereNotIn('id', $thread->participantsUserIds())->get();
        // don't show the current user in list
        $userId = Auth::user()->id;
        $users = User::whereNotIn('id', $thread->participantsUserIds($userId))->get();
        $thread->markAsRead($userId);
        return view('messenger.show', compact('thread', 'users'));
    }

    public function show_ajax($id)
    {
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');
            return redirect('messages');
        }
        // show current user in list if not a current participant
        // $users = User::whereNotIn('id', $thread->participantsUserIds())->get();
        // don't show the current user in list
        $userId = Auth::user()->id;
        $users = User::whereNotIn('id', $thread->participantsUserIds($userId))->get();
        $thread->markAsRead($userId);
        return view('messenger.ajax', compact('thread', 'users'));
    }

    /**
     * Creates a new message thread
     *
     * @return mixed
     */
    public function create()
    {
        //$users = User::where('id', '!=', Auth::id())->get();
        $users = Auth::user()->friends;

        return view('messenger.create', compact('users'));
    }

    /**
     * Stores a new message thread
     *
     * @return mixed
     */
    public function store()
    {
        $input = Input::all();
        $thread = Thread::create(
            [
                'subject' => $input['subject'],
            ]
        );
        // Message
        Message::create(
            [
                'thread_id' => $thread->id,
                'user_id' => Auth::user()->id,
                'body' => $input['message'],
            ]
        );
        // Sender
        Participant::create(
            [
                'thread_id' => $thread->id,
                'user_id' => Auth::user()->id,
                'last_read' => new Carbon
            ]
        );
        // Recipients
        if (Input::has('recipients')) {
            $thread->addParticipants($input['recipients']);
        }
        return redirect('messages');
    }

    /**
     * Adds a new message to a current thread
     *
     * @param $id
     * @return mixed
     */
    public function update($id)
    {
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');
            return redirect('messages');
        }
        $thread->activateAllParticipants();
        // Message
        Message::create(
            [
                'thread_id' => $thread->id,
                'user_id' => Auth::id(),
                'body' => htmlspecialchars(Input::get('message')),
            ]
        );
        // Add replier as a participant
        $participant = Participant::firstOrCreate(
            [
                'thread_id' => $thread->id,
                'user_id' => Auth::user()->id
            ]
        );
        $participant->last_read = new Carbon;
        $participant->save();
        // Recipients
        if (Input::has('recipients')) {
            $thread->addParticipants(Input::get('recipients'));
        }
        return redirect('messages/' . $id);

    }

    /**
     * Adds a new content to a current thread
     *
     * @param $id
     * @return mixed
     */
    public function addPicture($id, Request $request)
    {
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');
            return redirect('messages');
        }
        $thread->activateAllParticipants();
        // Message
        $fileName = $thread->id . rand(0, 145454545454) . Auth::id() . '.' .
            $request->file('pic')->getClientOriginalExtension();

        if ($request->file('pic')->getClientOriginalExtension() == 'jpg' || $request->file('audio')->getClientOriginalExtension() == 'png') {

            $request->file('pic')->move(
                base_path() . '/public/pic/' . Auth::id() . '/', $fileName
            );

            $img = Image::make(base_path() . '/public/pic/' . Auth::id() . '/' . $fileName);
            $img->resize(320, 240);
            $img->save(base_path() . '/public/pic/' . Auth::id() . '/min' . $fileName);

            Message::create(
                [
                    'thread_id' => $thread->id,
                    'user_id' => Auth::id(),
                    'body' => "<a href='" . '/pic/' . Auth::id() . '/' . $fileName . "'data-toggle=\"lightbox\" data-gallery=\"mess\">
                        <img width='200px' src='" . '/pic/' . Auth::id() . '/min' . $fileName . "' >
                </a>",
                ]
            );


            // Add replier as a participant
            $participant = Participant::firstOrCreate(
                [
                    'thread_id' => $thread->id,
                    'user_id' => Auth::user()->id
                ]
            );
            $participant->last_read = new Carbon;
            $participant->save();
            // Recipients
            if (Input::has('recipients')) {
                $thread->addParticipants(Input::get('recipients'));
            }
        }
        return redirect('messages/' . $id);
    }

    public function addAudio($id, Request $request)
    {
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');
            return redirect('messages');
        }
        $thread->activateAllParticipants();
        // Message

        $audioName = $thread->id . rand(0, 145454545454) . Auth::id() . '.' .
            $request->file('audio')->getClientOriginalExtension();

        if ($request->file('audio')->getClientOriginalExtension() == 'mp3') {

            $request->file('audio')->move(
                base_path() . '/public/audio/' . Auth::id() . '/', $audioName
            );

            Message::create(
                [
                    'thread_id' => $thread->id,
                    'user_id' => Auth::id(),
                    'body' => "<audio controls>
                <source src='" . '/audio/' . Auth::id() . '/' . $audioName . "' type=\"audio/mpeg\">
                </audio>",
                ]
            );
            // Add replier as a participant
            $participant = Participant::firstOrCreate(
                [
                    'thread_id' => $thread->id,
                    'user_id' => Auth::user()->id
                ]
            );
            $participant->last_read = new Carbon;
            $participant->save();
            // Recipients
            if (Input::has('recipients')) {
                $thread->addParticipants(Input::get('recipients'));
            }
        }
        return redirect('messages/' . $id);
    }

    public function delMessage($id)
    {

        Message::destroy([$id]);
        Session::flash('success_message', 'Message deleted');
        return Redirect::back()->withErrors(['msg', 'The Message']);

    }

    public function delThread($id)
    {
        Thread::destroy($id);
        Session::flash('success_message', 'Dialog deleted');
        return Redirect::back()->withErrors(['msg', 'The Message']);

    }

    public function rules()
    {
        return [
            'audio' => 'required|mimes:mp3'
        ];
    }
}