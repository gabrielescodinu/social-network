<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;

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

    public function edit($userId)
    {
        $user = User::find($userId);

        // Verifica se l'utente loggato è il proprietario del profilo
        if (auth()->id() !== $user->id) {
            return redirect()->route('users.show', $user->id);
        }

        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, $userId)
    {
        $user = User::find($userId);

        // Aggiorna i dati dell'utente con i valori inviati dal form
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->hasFile('image')) {
            $validatedData = $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $profileImage = $validatedData['image'];
            $profileImageName = time() . '_' . $profileImage->getClientOriginalName();
            $path = $profileImage->storeAs('public/images', $profileImageName);
            $user->image = 'storage/images/' . $profileImageName;
        }

        // Modifica la password solo se è stata inserita una nuova password
        if ($request->filled('password') && $request->filled('password_confirmation') && $request->password === $request->password_confirmation) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Reindirizza alla pagina del profilo aggiornata
        return redirect()->route('users.show', $user->id);
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

    public function showFollowers($userId)
    {
        $user = User::find($userId);

        $followers = $user->followers;

        return view('users.followers', compact('user', 'followers'));
    }
}
