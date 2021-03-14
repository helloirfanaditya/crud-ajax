<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $req)
    {
        $users = User::paginate(10);
        if ($req->ajax()) {
            return view('load_table', ['users' => $users])->render();
        }
        return view('welcome', compact('users'));
    }

    public function store(Request $req)
    {
        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make('password')
        ]);
        return response([
            'code' => 200,
            'data' => $user
        ]);
    }

    public function update(Request $req, $id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->save();
        return response([
            'code' => 200,
            'name' => $req->name,
            'email' => $req->email,
            'message' => 'user has been updated'
        ]);
    }

    public function delete($id)
    {
        User::where('id', $id)->delete();
        return response([
            'code' => 200,
            'message' => 'Success Delete User'
        ]);
    }
}
