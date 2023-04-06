<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Post;
use App\Models\Room;
use App\Models\RoomDetail;
use App\Models\User;
use App\Services\MemberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    public function showRoom(Request $request) {
        $roomId = $request["id"];

        $room = Room::where('id', $roomId)->first();
        $members = Member::query()
            ->where('room_id', $roomId)
            ->get();
        foreach ($members as $member) {
            $member['user'] = User::query()
                ->where('id', $member->user_id)
                ->first();
        }
        $room["members"] = $members;


        return response()->json([
            'room' => $room,
            'status' => true
        ]);
    }

    public function showPostRoom(Request $request) {
        $roomId = $request->input("roomId");
        $roomDetails = RoomDetail::query()
            ->where("room_id", $roomId)
            ->orderBy('updated_at', 'desc')
            ->get();
        $posts = [];
        foreach ($roomDetails as $rd) {
            $post = Post::query()->where('id', $rd['post_id'])->first();
            $post['assets'] = $post->assets && [];

            $posts[] = $post;
        }

        return response()->json([
            'posts' => $posts,
            'success'=> true
        ]);
    }

    public function showAllRoom(Request $request) {
        try {
            $userId = Auth::user()->id;

            $members = Member::query()
                ->where('user_id', $userId)
                ->get();

            $rooms = [];
            foreach ($members as $member) {
                $room = Room::query()
                    ->where('id', $member["room_id"])
                    ->first();
                $room["count"] = Member::query()
                    ->where("room_id", $room->id)
                    ->count();
                $rooms[] = $room;

            }

            return response()->json([
                'rooms' => $rooms,
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'rooms' => [],
                'success' => false
            ]);
        }
    }

    public function createRoom(Request $request) {
        $room = Room::create([
            'name' => $request->input("name"),
            'image' => $request->input("image")
        ]);

        $member = Member::create(
            [
                'role' => 'LEADER',
                'status' => 'ON',
                'room_id' => $room->id,
                'user_id' => Auth::user()->id
            ]
        );
        return response()->json([
           'status' => true
        ]);
    }

    public function inviteMember(Request $request) {
        $roomId = $request->input('roomId');
        $userId = $request->input('userId');

        $member = Member::create(
            [
                'role' => 'MEMBER',
                'status' => 'ON',
                'room_id' => $roomId,
                'user_id' => $userId
            ]
        );
        return response()->json([
            'success' => true
        ]);
    }
    public function showAllPost(Request $request) {
        try {
            $roomId = $request->input("roomId");
            $roomDetails = RoomDetail::query()
                ->where("room_id", $roomId)
                ->get();
            $posts = [];
            foreach ($roomDetails as $rd) {
                $post = Post::query()
                    ->where('id', $rd->post_id)->first();
                $post['assets'] = $post->assets && [];
                $posts[] = $post;
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
