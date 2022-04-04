<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Events\MessengerText;
use App\Models\Chat;
use App\Models\User;
use Auth;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function messenger()
    {
        return view('messenger');
    }

    public function getConnects()
    {
        
        $receivers = Chat::where('user_id', auth::id())->distinct('receiver_id')->latest()->pluck('receiver_id')->toArray();
        $receivers = User::whereIn('id', $receivers)->select(['id','name', 'last_active', 'photo'])->get()->toArray();
        $receivedFrom = Chat::where('receiver_id', auth::id())->distinct('user_id')->latest()->pluck('user_id')->toArray();
        $receivedFrom = User::whereIn('id', $receivedFrom)->select(['id','name', 'last_active', 'photo'])->get()->toArray();
        $unreadMsgs = [];
        $allConnects = array_unique( array_merge($receivers, $receivedFrom), SORT_REGULAR );
        // dd($allConnects);
        if(count($allConnects) > 0 ){
            foreach ($allConnects as $key => $value) {
                $unreadMsgs[] = [
                    'id' => $value['id'],
                    'name' => $value['name'],
                    'last_active' => $value['last_active'],
                    'photo' => $value['photo'],
                    'unreadMsgsCount' => Chat::where('user_id', $value['id'])->where('receiver_id', auth::id())->where('msg_read', 0)->count()
                ];
            }
           
        }

        return $unreadMsgs;

    }

    public function getConnectsNavbar()
    {
       
        $receivers = Chat::where('user_id', auth::id())->distinct('receiver_id')->latest()->pluck('receiver_id')->toArray();
        $receivers = User::whereIn('id', $receivers)->select(['id','name', 'photo', 'last_active'])->get()->toArray();
        
        $receivedFrom = Chat::where('receiver_id', auth::id())->distinct('user_id')->latest()->pluck('user_id')->toArray();
        $receivedFrom = User::whereIn('id', $receivedFrom)->select(['id','name', 'photo', 'last_active'])->get()->toArray();
        
        $unreadMsgs = [];
        
        $allConnects = array_unique( array_merge($receivers, $receivedFrom), SORT_REGULAR );
        // dd($receivedFrom);
        if(count($receivedFrom) > 0 ){
            foreach ($allConnects as $key => $value) {
                $unreadMsgs[] = [
                    'id' => $value['id'],
                    'name' => $value['name'],
                    'last_active' => $value['last_active'],
                    'photo' => $value['photo'],
                    'unreadMsgsCount' => Chat::where('user_id', $value['id'])->where('receiver_id', auth::id())->where('msg_read', 0)->count(),
                    'unreadMsgs' => Chat::where('user_id', $value['id'])->where('receiver_id', auth::id())->where('msg_read', 0)->latest()->first() 
                ];
            }
            // for ($i = 0; $i < count($receivedFrom); $i++) {
            //     $count = Chat::where('user_id', $receivedFrom[$i]['id'])->where('receiver_id', auth::id())->where('msg_read', 0)->count();
            //         $receivedFrom[$i] += [
            //                                 'unreadMsgsCount' => $count,
            //                                 'unreadMsgs' => Chat::where('user_id', $receivedFrom[$i]['id'])->where('receiver_id', auth::id())->where('msg_read', 0)->latest()->first() 
            //                             ];
            // }
        }

        return $unreadMsgs;

    }

    public function fetchMessages($receiver)
    {                                                                                       
        return Chat::where(function($query) use ($receiver) {
                                    $query->where('user_id', auth::id())->where('receiver_id', $receiver);
                                        })->orWhere(function ($query) use ($receiver) {
                                                        $query->where('user_id', $receiver)->where('receiver_id', auth::id());
                                                    })
                                                    ->orderBy('created_at', 'ASC')->limit(100)->get()->toArray();

    }

    public function seen($id)
    {
        Chat::where('user_id', $id)->where('receiver_id', auth::id())->update(['msg_read' => 1]);
    }

    // video call chat
    public function sendMessengerText(Request $request, $id)
    {
        $message = new Chat();
        
            $message->message = $request->message;
            $message->user_id = auth::id();
            $message->receiver_id = $id;
            $message->connected_on = $request->channel;

        $message->save();
        

		broadcast(new MessengerText(auth()->user(), $message, $request->channel))->toOthers();

        return ['status' => 'Message Sent!'];
    }

    // video call chat
    public function sendMessage(Request $request, $id)
    {
        $message = new Chat();
        
            $message->message = $request->message;
            $message->appointmentId = $id;
            $message->user_id = auth::id();

        $message->save();
        

		broadcast(new MessageSent(auth()->user(), $message, $id))->toOthers();

        return ['status' => 'Message Sent!'];
    }

    public function lastActive($id)
    {
        User::where('id', $id)->update(['last_active'=> date('Y-m-d H:i:s')]);
    }

    public function search($str)
    {
        return User::where('name', 'like', '%'.$str.'%')->get();
    }
}
