<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', User::ROLE_ADMIN)->get();

        return view('admin.pages.users.index', [
            'title' => 'User Accounts',
            'users' => $users,
            'parent_paths' => [
                ['label' => 'Users', 'url' => null],
            ],
        ]);
    }

    public function get($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found!');
        }
        return response()->json($user);
    }

    // Xử lý lưu user mới
    public function store(Request $request)
    {
        $rules = array_merge([
            'username' => 'required|string|unique:users,username',
            'displayname' => 'nullable|string',
            'email' => 'nullable|email|unique:users,email',
        ], User::passwordRules());
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        User::create([
            'username' => $request->username,
            'displayname' => $request->displayname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    // Xử lý cập nhật user
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users,username,' . $id,
            'displayname' => 'nullable|string',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'password' => 'nullable|min:' . User::MIN_PASSWORD
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found!');
        }
        $user->username = $request->username;
        $user->displayname = $request->displayname;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    // Xóa user
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found!');
        }
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function massDestroy(Request $request)
    {
        $ids = explode(',', $request->input('ids'));
        if (!empty($ids)) {
            User::whereIn('id', $ids)->delete();
            return redirect()->route('admin.users.index')->with('success', 'Users deleted successfully.');
        }
        return redirect()->back()->with('error', 'No users selected.');
    }
}
