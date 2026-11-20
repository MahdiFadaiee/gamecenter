<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PostAdminController extends Controller
{
    public function index(): View { return view('admin.posts.index', ['posts' => Post::with('author')->latest()->paginate(20)]); }
    public function create(): View { return view('admin.posts.form', ['post' => new Post, 'categories' => Category::where('type', 'blog')->orderBy('name')->get()]); }
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['author_id'] = $request->user()->id;
        $data['slug'] = $this->slug($data['slug'] ?? null, $data['title']);
        $data['published_at'] = $data['status'] === 'published' ? ($data['published_at'] ?? now()) : null;
        $post = Post::create($data);
        return redirect()->route('admin.gamecenter.posts.edit', $post)->with('status', 'مقاله منتشر شد.');
    }
    public function edit(Post $post): View { return view('admin.posts.form', ['post' => $post, 'categories' => Category::where('type', 'blog')->orderBy('name')->get()]); }
    public function update(Request $request, Post $post): RedirectResponse
    {
        $data = $this->validated($request, $post);
        $data['slug'] = $this->slug($data['slug'] ?? null, $data['title'], $post);
        $data['published_at'] = $data['status'] === 'published' ? ($data['published_at'] ?? $post->published_at ?? now()) : null;
        $post->update($data);
        return back()->with('status', 'مقاله ذخیره شد.');
    }
    public function destroy(Post $post): RedirectResponse { $post->delete(); return redirect()->route('admin.gamecenter.posts.index')->with('status', 'مقاله حذف شد.'); }

    private function validated(Request $request, ?Post $post = null): array
    {
        return $request->validate([
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:200', Rule::unique('posts', 'slug')->ignore($post?->id)],
            'cover_image' => ['nullable', 'string', 'max:500'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string', 'max:50000'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'published_at' => ['nullable', 'date'],
        ]);
    }
    private function slug(?string $slug, string $title, ?Post $post = null): string
    {
        $base = Str::slug($slug ?: $title) ?: 'post';
        $candidate = $base;
        $suffix = 2;
        while (Post::where('slug', $candidate)->when($post, fn ($q) => $q->where('id', '!=', $post->id))->exists()) {
            $candidate = $base.'-'.$suffix++;
        }
        return $candidate;
    }
}
