<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    public const CACHE_KEY = 'site-settings.values';
    public const KEY_SITE_NAME = 'site_name';
    public const KEY_SITE_TAGLINE = 'site_tagline';
    public const KEY_SITE_DESCRIPTION = 'site_description';
    public const KEY_SITE_META_TITLE = 'site_meta_title';
    public const KEY_SITE_META_DESCRIPTION = 'site_meta_description';
    public const KEY_SITE_META_KEYWORDS = 'site_meta_keywords';
    public const KEY_SITE_PRIMARY_COLOR = 'site_primary_color';
    public const KEY_SITE_ACCENT_COLOR = 'site_accent_color';
    public const KEY_SITE_LOGO = 'site_logo';
    public const KEY_SITE_FAVICON = 'site_favicon';
    public const KEY_CONTACT_EMAIL = 'contact_email';
    public const KEY_CONTACT_PHONE = 'contact_phone';
    public const KEY_FOOTER_COPYRIGHT = 'footer_copyright';

    protected $fillable = ['key', 'value', 'group', 'type'];

    protected static function booted(): void
    {
        static::saved(static function (self $setting): void { Cache::forget(self::CACHE_KEY); });
        static::deleted(static function (self $setting): void { Cache::forget(self::CACHE_KEY); });
    }

    public static function siteDefinitions(): array
    {
        return [
            self::KEY_SITE_NAME => ['group' => 'general', 'type' => 'string', 'default' => 'گیم‌سنتر'],
            self::KEY_SITE_TAGLINE => ['group' => 'general', 'type' => 'string', 'default' => 'بازی کن، رقابت کن، جایزه بگیر'],
            self::KEY_SITE_DESCRIPTION => ['group' => 'general', 'type' => 'string', 'default' => 'خانه بازی، رقابت و رفاقت'],
            self::KEY_SITE_PRIMARY_COLOR => ['group' => 'general', 'type' => 'string', 'default' => '#7367f0'],
            self::KEY_SITE_ACCENT_COLOR => ['group' => 'general', 'type' => 'string', 'default' => '#ea5455'],
            self::KEY_SITE_LOGO => ['group' => 'general', 'type' => 'string', 'default' => '/site/gamecenter/assets/img/logo/logo.png'],
            self::KEY_SITE_FAVICON => ['group' => 'general', 'type' => 'string', 'default' => ''],
            self::KEY_SITE_META_TITLE => ['group' => 'seo', 'type' => 'string', 'default' => 'گیم‌سنتر'],
            self::KEY_SITE_META_DESCRIPTION => ['group' => 'seo', 'type' => 'string', 'default' => 'بازی، رقابت و جایزه در گیم‌سنتر.'],
            self::KEY_SITE_META_KEYWORDS => ['group' => 'seo', 'type' => 'string', 'default' => 'گیم‌سنتر، بازی، جام، مسابقه'],
            self::KEY_CONTACT_EMAIL => ['group' => 'contact', 'type' => 'string', 'default' => ''],
            self::KEY_CONTACT_PHONE => ['group' => 'contact', 'type' => 'string', 'default' => ''],
            self::KEY_FOOTER_COPYRIGHT => ['group' => 'general', 'type' => 'string', 'default' => 'همه حقوق محفوظ است.'],
        ];
    }

    public static function siteDefaults(): array
    {
        return collect(self::siteDefinitions())
            ->mapWithKeys(static fn (array $definition, string $key): array => [$key => $definition['default']])
            ->all();
    }
}
