<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SiteSettings
{
    private const CACHE_TTL_SECONDS = 3600;

    /**
     * Return all public site settings merged with their safe defaults.
     *
     * @return array<string, string>
     */
    public function all(): array
    {
        $settings = Cache::remember(Setting::CACHE_KEY, self::CACHE_TTL_SECONDS, function (): array {
            if (! Schema::hasTable('settings')) {
                return Setting::siteDefaults();
            }

            $storedValues = Setting::query()
                ->whereIn('key', array_keys(Setting::siteDefinitions()))
                ->pluck('value', 'key')
                ->map(static fn (?string $value): string => (string) $value)
                ->all();

            return array_replace(Setting::siteDefaults(), $storedValues);
        });

        config(['app.name' => $settings[Setting::KEY_SITE_NAME]]);

        return $settings;
    }

    /** Return one setting with an optional fallback value. */
    public function get(string $key, ?string $default = null): ?string
    {
        return $this->all()[$key] ?? $default;
    }

    /**
     * Persist editable settings and invalidate the cached setting map.
     *
     * @param array<string, mixed> $settings
     */
    public function update(array $settings): void
    {
        $definitions = Setting::siteDefinitions();

        DB::transaction(function () use ($definitions, $settings): void {
            foreach ($definitions as $key => $definition) {
                if (! array_key_exists($key, $settings)) {
                    continue;
                }

                Setting::query()->updateOrCreate(
                    ['key' => $key],
                    [
                        'value' => (string) $settings[$key],
                        'group' => $definition['group'],
                        'type' => $definition['type'],
                    ],
                );
            }
        });

        $this->forget();
    }

    /** Clear the cached setting map after a mutation. */
    public function forget(): void
    {
        Cache::forget(Setting::CACHE_KEY);
    }
}
