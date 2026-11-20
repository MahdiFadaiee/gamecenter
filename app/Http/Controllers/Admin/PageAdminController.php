<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PageAdminController extends Controller
{
    public function index(): View { return view('admin.pages.index', ['pages' => Page::latest()->paginate(20)]); }
    public function create(): View { return view('admin.pages.form', ['page' => new Page]); }
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->slug($data['slug'] ?? null, $data['title']);
        $page = Page::create($data);
        return redirect()->route('admin.gamecenter.pages.edit', $page)->with('status', 'صفحه ساخته شد.');
    }
    public function edit(Page $page): View { return view('admin.pages.form', compact('page')); }
    public function update(Request $request, Page $page): RedirectResponse
    {
        $data = $this->validated($request, $page);
        $data['slug'] = $this->slug($data['slug'] ?? null, $data['title'], $page);
        $page->update($data);
        return back()->with('status', 'صفحه ذخیره شد.');
    }
    public function destroy(Page $page): RedirectResponse { $page->delete(); return redirect()->route('admin.gamecenter.pages.index')->with('status', 'صفحه حذف شد.'); }

    private function validated(Request $request, ?Page $page = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:200', Rule::unique('pages', 'slug')->ignore($page?->id)],
            'body' => ['required', 'string', 'max:50000'],
            'status' => ['required', Rule::in(['draft', 'published'])],
        ]);
    }
    private function slug(?string $slug, string $title, ?Page $page = null): string
    {
        $base = Str::slug($slug ?: $title) ?: 'page';
        $candidate = $base;
        $suffix = 2;
        while (Page::where('slug', $candidate)->when($page, fn ($q) => $q->where('id', '!=', $page->id))->exists()) {
            $candidate = $base.'-'.$suffix++;
        }
        return $candidate;
    }
}
