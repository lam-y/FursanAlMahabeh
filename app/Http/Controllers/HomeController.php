<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Member;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->take(6)->with('images')->get();

        $members = Member::select('members.name', 'members.photo', 'member_types.name as member_type_name')
                            ->join('member_types', 'members.member_type_id', '=', 'member_types.id')
                            ->orderBy('members.created_at', 'desc')
                            ->paginate(6);

        return view('front.index', compact('posts', 'members'));
    }

}
