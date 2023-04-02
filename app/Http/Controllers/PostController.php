<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'body' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('public/images', $imageName);
            $validatedData['image'] = 'storage/images/' . $imageName;
        }

        Auth::user()->posts()->create($validatedData);

        return redirect()->route('posts.index');
    }


    public function show(Post $post)
    {
        $comments = $post->comments()->latest()->get();
        return view('posts.show', compact('post', 'comments'));
    }



    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'body' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('public/images', $imageName);
            $validatedData['image'] = 'storage/images/' . $imageName;

            // Elimina la vecchia immagine
            if ($post->image) {
                Storage::delete(str_replace('storage/', 'public/', $post->image));
            }
        }

        $post->update($validatedData);

        return redirect()->route('posts.index');
    }


    public function destroy($id)
    {
        // Recupera il post
        $post = Post::findOrFail($id);

        // Verifica se l'utente autenticato è lo stesso che ha creato il post
        if (auth()->user()->id !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Elimina l'immagine associata al post
        if ($post->image) {
            Storage::delete(str_replace('storage/', 'public/', $post->image));
        }

        // Elimina il post
        $post->delete();

        // Redirect alla pagina dei post
        return redirect()->route('posts.index');
    }


    public function showProfile($userId)
    {
        // Recupera i posts dell'utente con l'id specificato
        $userPosts = Post::where('user_id', $userId)->orderBy('created_at', 'desc')->get();

        // Recupera l'utente con l'id specificato
        $user = User::find($userId);

        // Passa i dati alla vista della pagina del profilo
        return view('users.show', [
            'user' => $user,
            'userPosts' => $userPosts,
        ]);
    }

    public function like(Post $post)
    {
        $user = auth()->user();

        // verifica se l'utente ha già messo un like al post
        $existingLike = $user->likes()->where('post_id', $post->id)->first();

        // se l'utente ha già messo un like al post, restituisci un errore
        if ($existingLike && $existingLike->pivot->type === 'like') {
            return response()->json(['error' => 'User already liked this post.'], 403);
        }

        // aggiungi il like
        $user->likes()->syncWithoutDetaching([$post->id => ['type' => 'like']]);

        // restituisci il numero totale di like del post
        $totalLikes = $post->likes()->where('type', 'like')->count();
        return response()->json(['total_likes' => $totalLikes]);
    }


    public function dislike(Post $post)
    {
        $user = auth()->user();
        $user->likes()->detach($post->id);

        return back();
    }
}
