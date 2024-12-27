<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    protected $member;
    public function __construct(){
        $this->member = new Member();
    }

    public function index(){
        return $this->member->all();
    }
}
