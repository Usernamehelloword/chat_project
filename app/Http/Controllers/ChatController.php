<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent;


class ChatController extends Controller
{

    // public function index()
    // {
    //    $message = Message::with('user')
    //         ->latest()
    //         ->get();
    //      return view('chat',compact('message'));

    // }


    // public function send(Request $request)
    // {

    //     $request->validate([
    //         'message'=>'required|string'
    //     ]);


    //     $message = Message::create([

    //         'user_id'=>auth()->id(),

    //         'message'=>$request->message

    //     ]);


    //     broadcast(new MessageSent($message));


    //     return response()->json([

    //         'status'=>'success',

    //         'message'=>$message

    //     ]);
    // }
}
