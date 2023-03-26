<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Heart;
use App\Services\HeartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HeartController extends Controller
{
    public function __construct(HeartService $heartService)
    {
        $this->heartService = $heartService;
    }

    public function like(Request $request) {
        $heart = Heart::where('post_id', $request->input('post_id'))
            ->where('user_id', Auth::user()->id)
            ->first();

        $checked = $request->input('checked');

        if($checked) {
            return response()->json([
                'status' => $heart !== null ? true : false,
            ]);
        }


        if ($heart !== null) {
            $heart->delete();
            return response()->json([
                'status' => false,
            ]);
        }

        Heart::create([
            'post_id' => $request->input('post_id'),
            'user_id' => Auth::user()->id
        ]);

        return response()->json([
            'status' => true,
        ]);
    }

    public function count(Request $request) {
        $like = $this->heartService->count($request['post_id']);
        return response()->json(['count' => $like]);
    }

}
