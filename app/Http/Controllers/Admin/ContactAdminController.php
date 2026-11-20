<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactAdminController extends Controller
{
    public function index(): View { return view('admin.messages.index', ['messages' => ContactMessage::latest()->paginate(30)]); }
    public function markRead(ContactMessage $message): RedirectResponse
    {
        $message->update(['status' => 'read']);
        return back()->with('status', 'پیام خوانده‌شده علامت خورد.');
    }
}
