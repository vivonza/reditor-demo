<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EditorPostController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_title' => 'required|string|max:255',
            'post_content' => 'required|string', // Clean HTML with Gutenberg block comments
            'blocks_json' => 'nullable|json',     // Structured block tree
            'post_status' => 'nullable|string',
            'post_slug' => 'nullable|string',
        ]);

        $post = Post::create([
            'title' => $validated['post_title'],
            'content' => $validated['post_content'],
            'blocks_json' => $validated['blocks_json'] ?? null,
            'status' => $validated['post_status'] ?? 'publish',
            'slug' => $validated['post_slug'] ?? \Illuminate\Support\Str::slug($validated['post_title']),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Post saved successfully.',
            'post_id' => $post->id
        ]);
    }
}
