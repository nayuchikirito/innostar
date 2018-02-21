<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chatroom()
    {
    	return view('admin.chats.chatroom');
    }
}
