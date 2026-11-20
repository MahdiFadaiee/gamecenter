<?php

namespace App\Support;

final class AdminMenuPermissions
{
    public const ITEMS = [
        'view admin dashboard' => ['نمای کلی', 'آمار و وضعیت گیم‌سنتر'],
        'manage games' => ['بازی‌ها', 'مدیریت بازی‌های مجموعه'],
        'manage tournaments' => ['جام‌ها', 'ساخت جام و مدیریت ثبت‌نام‌ها'],
        'manage members' => ['اعضا', 'مدیریت حساب اعضا'],
        'manage sessions' => ['زمان بازی', 'ثبت و پیگیری زمان بازی اعضا'],
        'manage rewards' => ['جایزه‌ها', 'تعریف قوانین پاداش زمان بازی'],
        'manage content' => ['محتوا', 'مدیریت بلاگ و صفحه‌های سایت'],
        'manage admins' => ['مدیران', 'مدیریت حساب‌های مدیر'],
    ];

    public static function names(): array
    {
        return array_keys(self::ITEMS);
    }
}
