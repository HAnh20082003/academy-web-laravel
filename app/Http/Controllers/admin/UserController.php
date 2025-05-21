<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.pages.users.index', [
            'title' => 'User',
            // 'parent_paths' => [
            //     ['label' => 'Trang chủ', 'url' => route('admin.users.index')],
            // ]
        ]);
    }
}
