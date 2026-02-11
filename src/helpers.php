<?php

declare(strict_types=1);

use Cortex\UniversitiesModule\Models\University;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

if (! function_exists('university')) {
    /**
     * Get university by its name or ID.
     *
     * @param string|int $identifier
     * @param bool $asModel
     * @param bool $useCache
     *
     * @return \Cortex\UniversitiesModule\Models\University|array|null
     */
    function university($identifier, $asModel = true, $useCache = true)
    {
        $cacheKey = is_numeric($identifier)
            ? "university.id.{$identifier}"
            : "university.name." . md5(strtolower((string) $identifier));

        $cacheDuration = config('cortex.universities.cache_duration');

        if ($useCache && $cacheDuration) {
            $cached = Cache::get($cacheKey);
            if ($cached !== null) {
                return $asModel ? $cached : $cached->toArray();
            }
        }

        $query = University::query();

        // If identifier is numeric, search by ID, otherwise search by name
        if (is_numeric($identifier)) {
            $university = $query->find($identifier);
        } else {
            $university = $query->where('name', $identifier)->first();
        }

        if ($university && $useCache && $cacheDuration) {
            Cache::put($cacheKey, $university, $cacheDuration);
        }

        return $asModel ? $university : $university?->toArray();
    }
}

if (! function_exists('universities')) {
    /**
     * Get universities for the given country.
     *
     * @param string|null $countryCode
     * @param bool $asModels
     * @param bool $useCache
     *
     * @return \Illuminate\Database\Eloquent\Collection|array
     */
    function universities($countryCode = null, $asModels = true, $useCache = true)
    {
        $cacheKey = $countryCode
            ? "universities.country." . md5(strtolower($countryCode))
            : "universities.all";

        $cacheDuration = config('cortex.universities.cache_duration');

        if ($useCache && $cacheDuration) {
            $cached = Cache::get($cacheKey);
            if ($cached !== null) {
                return $asModels ? $cached : $cached->toArray();
            }
        }

        $query = University::query();

        if ($countryCode) {
            $query->where('country', $countryCode);
        }

        $universities = $query->get();

        if ($universities->isNotEmpty() && $useCache && $cacheDuration) {
            Cache::put($cacheKey, $universities, $cacheDuration);
        }

        return $asModels ? $universities : $universities->toArray();
    }
}

if (! function_exists('clearUniversitiesCache')) {
    /**
     * Clear all universities cache.
     *
     * @param string|null $key
     * @return bool
     */
    function clearUniversitiesCache($key = null): bool
    {
        if ($key) {
            return Cache::forget($key);
        }

        // Clear all universities-related cache
        return Cache::forget('universities.all') &&
               Cache::forget('universities.country.*') &&
               Cache::forget('university.*');
    }
}

if (! function_exists('getUniversitiesByCountry')) {
    /**
     * Get universities grouped by country.
     *
     * @param bool $useCache
     * @return array
     */
    function getUniversitiesByCountry($useCache = true): array
    {
        $cacheKey = 'universities.by_country';
        $cacheDuration = config('cortex.universities.cache_duration');

        if ($useCache && $cacheDuration) {
            $cached = Cache::get($cacheKey);
            if ($cached !== null) {
                return $cached;
            }
        }

        $universities = University::query()
            ->select('country', University::raw('COUNT(*) as count'))
            ->groupBy('country')
            ->orderBy('country')
            ->get()
            ->keyBy('country');

        if ($useCache && $cacheDuration) {
            Cache::put($cacheKey, $universities, $cacheDuration);
        }

        return $universities->toArray();
    }
}

if (! function_exists('searchUniversities')) {
    /**
     * Search universities by name, country, or other fields.
     *
     * @param string $query
     * @param array $fields
     * @param bool $useCache
     * @return \Illuminate\Database\Eloquent\Collection|array
     */
    function searchUniversities(string $query, array $fields = ['name', 'country', 'state', 'city'], $useCache = true)
    {
        if (!config('cortex.universities.search.enabled')) {
            return $useCache ? collect([]) : [];
        }

        $cacheKey = 'universities.search.' . md5($query . implode(',', $fields));
        $cacheDuration = config('cortex.universities.cache_duration');

        if ($useCache && $cacheDuration) {
            $cached = Cache::get($cacheKey);
            if ($cached !== null) {
                return $cached;
            }
        }

        $dbQuery = University::query();

        if (config('cortex.universities.search.fuzzy')) {
            // Fuzzy search across specified fields
            $dbQuery->where(function ($q) use ($query, $fields) {
                foreach ($fields as $field) {
                    $q->orWhere($field, 'LIKE', "%{$query}%");
                }
            });
        } else {
            // Exact search across specified fields
            $dbQuery->where(function ($q) use ($query, $fields) {
                foreach ($fields as $field) {
                    $q->orWhere($field, $query);
                }
            });
        }

        $results = $dbQuery->limit(50)->get();

        if ($useCache && $cacheDuration) {
            Cache::put($cacheKey, $results, $cacheDuration);
        }

        return $results;
    }
}
