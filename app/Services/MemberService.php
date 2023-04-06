<?php

namespace App\Services;

use App\Models\Member;

class MemberService
{
        public function insert($data) {
            $member = Member::create($data);
            return $member;
        }
}
