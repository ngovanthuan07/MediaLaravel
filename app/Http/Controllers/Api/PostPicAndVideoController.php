<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Product;
use App\Models\RoomDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostPicAndVideoController extends Controller
{
    public function getPostById(Request $request) {
        $post = Post::query()->where('id', $request['id'])->first();
        $post['assets'] = $post->assets && [];

        return response()->json([
            'post' => $post,
            'success' => true
        ]);
    }

    public function home(Request $request) {
        $post = new Post;
        $post->fill($request->only(['name', 'category', 'watch', 'choose']));
        $post->user_id = Auth::user()->id; // thêm dòng này để gán giá trị cho trường user_id
        $post->save();

        $assets = $request->input('assets', []);
        $post->assets()->createMany($assets);

        return response()->json([
            'success' => true
        ]);
    }

    public function createPostRoom(Request $request) {
        $post = new Post;
        $post->fill($request->only(['name', 'watch', 'choose']));
        $post->user_id = Auth::user()->id; // thêm dòng này để gán giá trị cho trường user_id
        $post->save();

        $assets = $request->input('assets', []);
        $post->assets()->createMany($assets);

        RoomDetail::create([
           'room_id' =>   $request->input('roomId'),
           'post_id' => $post->id
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    public function display_posts() {
        try {
            $posts = Post::query()
                ->where('watch', 'EVERYONE')
                ->orderBy('id', 'desc')
                ->get();

            foreach($posts as $post) {
                $post['assets'] = $post->assets && [];
            }

            return response()->json([
                'posts' => $posts,
                'products' => [],
                'success'=> true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'posts' => [],
                'products' => [],
                'success'=> false,
                'error' => $e
            ], 404);
        }
    }


    public function display_user_post_and_product() {
        try {
            $posts = Post::query()
                ->where('user_id', Auth::user()->id)
                ->get();
            $products = Product::query()
                ->where('user_id', Auth::user()->id)
                ->get();

            foreach($posts as $post) {
                $post['assets'] = $post->assets && [];
            }

            return response()->json([
                'posts' => $posts,
                'products' => $products,
                'success'=> true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'posts' => [],
                'products' => [],
                'success'=> false,
                'error' => $e
            ], 404);
        }
    }

    public function search(Request $request) {
        try {
            $searchable = $request["searchable"];

            $products = Product::query()
                ->select('*')
                ->where('public_searchable', true)
                ->where('name', 'LIKE', "%$searchable%")
                ->get();

            $posts = Post::query()
                ->select('*')
                ->union(
                    Post::query()
                        ->select('*')
                        ->where('watch', 'EVERYTHING')
                        ->where('name', 'LIKE', "%$searchable%")
                )
                ->union(
                    Post::query()
                        ->select('*')
                        ->where('user_id', Auth::user()->id)
                        ->where('name', 'LIKE', "%$searchable%")
                )
                ->groupBy('id')
                ->get();
            foreach($posts as $post) {
                $post['assets'] = [$post->assets[0]] && [];
            }

            $users = User::query()
                ->where('name', 'LIKE', "%$searchable%")
                ->get();

            return response()->json([
                'products'=> $products,
                'posts' => $posts,
                'users' => $users,
                'success'=> true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'products' => [],
                'posts' => [],
                'users' => [],
                'success'=> false,
                'error' => $e
            ], 404);
        }
    }
}
