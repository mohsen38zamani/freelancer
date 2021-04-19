<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
    /**
     * ChatsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $current_user = \App\User::with('user_profile')->where('id', Auth::id())->first();
        return view('chat', array('current_user' => $current_user));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function fetchMessages(Request $request)
    {
        $id = \auth()->id();
        $tid = $request->target_user_id;

        /* update visit message */
        \App\Message::where('user_id', $tid)->where('target_user_id', $id)->update(['visit' => 1]);

        return Message::
        with('user')->
        whereRaw('(user_id = ? AND target_user_id = ?) OR (target_user_id = ? AND user_id = ?)', array($id, $tid, $id, $tid))->get();
    }

    /**
     * @param Request $request
     */
    public function seeMessages(Request $request)
    {
        /* update visit message */
        \App\Message::where('id', $request->id)->update(['visit' => 1]);
    }

    /**
     * @return array
     */
    public function getHistoryUser()
    {
        $ids = array();
        $result = array();
        $id = \auth()->id();
        $target_user_id = array();

        $records = Message::
        select('user_id', 'target_user_id')->
        groupby('target_user_id', 'user_id')->
        distinct()->
        with('iuser')->
        whereRaw('(user_id = ? OR target_user_id = ?)', array($id, $id))->get();
        foreach ($records as $item) {
            if (!$item->target_user_id || !$item->user_id) continue;
            $target_user_id[] = $item->target_user_id;
            if (!in_array($item->iuser->id, $ids)) {
                $ids[] = $item->iuser->id;
                $result[] = $item->iuser;
            }
        }

        /* Add user if chat history is one-way */
        foreach ($target_user_id as $item) {
            if (!in_array($item, $ids)) {
                $ids[] = $item;
                $result[] = \App\User::with('user_profile_img')->find($item);
            }
        }

        /* add if does not have self chat history */
        if (!in_array($id, $ids)) {
            $ids[] = $id;
            $result[] = \App\User::with('user_profile_img')->find($id);
        }

        /* message unread message */
        foreach ($result as $key => $item) {
            if ($item) {
                $result[$key]->message_count = \App\Message::where('user_id', $item->id)->where('target_user_id', $id)->where('visit', 0)->count();
                $site_url = App::make('url')->to('/') . '/';
                if (!$item->user_profile_img->profile_img) {
                    $result[$key]->img_user = $site_url . 'images/50x50.jpg';
                } else {
                    $result[$key]->img_user = $site_url . $item->user_profile_img->profile_img->path;
                }
            }
        }

        return $result;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function sendMessage(Request $request)
    {
        $message = auth()->user()->messages()->create([
            'message' => $request->message,
            'target_user_id' => $request->target_user_id
        ]);

        broadcast(new MessageSent($message->load('user')))->toOthers();

        return ['status' => 'Message Sent!'];
    }
}
