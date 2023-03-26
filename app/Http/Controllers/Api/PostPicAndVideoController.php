<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostPicAndVideoController extends Controller
{
    public function home(Request $request) {
        $post = new Post;
        $post->fill($request->only(['name', 'category', 'watch']));
        $post->user_id = Auth::user()->id; // thêm dòng này để gán giá trị cho trường user_id
        $post->save();

        $assets = $request->input('assets', []);
        $post->assets()->createMany($assets);

        return response()->json([
            'success' => true
        ]);
    }
    public function display_user_posts() {
        try {
            $posts = Post::query()
                ->where('user_id', Auth::user()->id)
                ->get();

            foreach($posts as $post) {
                $post['assets'] = $post->assets && [];
            }

            return response()->json([
                'posts' => $posts,
                'success'=> true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'posts' => [],
                'success'=> false,
                'error' => $e
            ], 404);
        }
    }
}
