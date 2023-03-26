<?php

namespace App\Services;

use App\Models\Heart;

class HeartService
{
    public function count($postId) {
        try {
            return Heart::query()
                ->where('post_id', $postId)
                ->count();
        } catch (\Exception $e) {
            return 0;
        }
    }
}
