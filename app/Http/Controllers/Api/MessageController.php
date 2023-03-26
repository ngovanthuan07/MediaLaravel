<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function showMessages(Request $request) {
        $postId = $request['id'];

        $messages = Message::where('post_id', $postId)->get();

        return response()->json([
            'messages' => $messages,
            'success' => true
        ]);
    }

    public function addMessage(Request $request) {
        try {
            $postId = $request->input('post_id');
            $userId = Auth::user()->id;
            $content = $request->input('content');

            $message = Message::create([
                'post_id' => $postId,
                'user_id' => $userId,
                'content' => $content
            ]);

            return response()->json([
                'message' => $message,
                'success' => true
            ]);
        } catch(\Exception $exception) {
            return response()->json([
                'success' => false
            ]);
        }
    }
}
