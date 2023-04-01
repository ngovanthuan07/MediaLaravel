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

    public function addProduct(Request $request) {
        $post = new Post;
        $post->fill($request->only([
                'name',
                'category',
                'description',
                'watch',
                'public_searchable',
                'dangerous_goods',
                'currency',
                'pricing',
                'discount',
                'quantity',
                'stock',
                'views',
                'choose'
            ]));
        $post->user_id = Auth::user()->id; // thêm dòng này để gán giá trị cho trường user_id
        $post->save();

        $assets = $request->input('assets', []);
        $post->assets()->createMany($assets);

        return response()->json([
            'success' => true
        ]);
    }


    public function search(Request $request) {
        try {
            $searchable = $request["searchable"];



            $posts = Post::query()
                ->select('*')
                ->where('public_searchable', '1')
                ->where('choose', 'PRODUCT')
                ->where('name', 'LIKE', "%$searchable%")
                ->union(
                    Post::query()
                        ->select('*')
                        ->where('watch', 'EVERYTHING')
                        ->where('choose', 'PICTURE_VIDEO')
                        ->where('name', 'LIKE', "%$searchable%")
                )
                ->union(
                    Post::query()
                        ->select('*')
                        ->where('user_id', Auth::user()->id)
                        ->where('choose', 'PICTURE_VIDEO')
                        ->where('name', 'LIKE', "%$searchable%")
                )
                ->groupBy('id')
                ->get();
            foreach($posts as $post) {
                $post['assets'] = $post->assets && [];
            }
            return response()->json([
                'posts' => $posts,
                'success'=> true,
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
