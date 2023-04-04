<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Post;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');
        $users = User::where('name', 'like', '%' . $search . '%')->get();

        return view('users.index', ['users' => $users]);
    }

    public function showProfile($userId)
    {
        // Recupera i posts dell'utente con l'id specificato
        $userPosts = Post::where('user_id', $userId)->orderBy('created_at', 'desc')->get();

        // Recupera l'utente con l'id specificato
        $user = User::withCount('followers')->find($userId);
        // Passa i dati alla vista della pagina del profilo
        return view('users.show', [
            'user' => $user,
            'userPosts' => $userPosts,
        ]);
    }

    public function follow(User $user)
    {
        auth()->user()->following()->attach($user);
        $user->increment('followers_count');
        auth()->user()->increment('following_count');
        return response()->json(['success' => true]);
    }

    public function unfollow(User $user)
    {
        auth()->user()->following()->detach($user);
        $user->decrement('followers_count');
        auth()->user()->decrement('following_count');
        return response()->json(['success' => true]);
    }
}
