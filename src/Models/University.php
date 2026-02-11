<?php

declare(strict_types=1);

namespace Cortex\UniversitiesModule\Models;

use Spatie\Activitylog\LogOptions;
use Cortex\Foundation\Traits\Auditable;
use Spatie\Activitylog\Traits\LogsActivity;
use Cortex\UniversitiesModule\Events\UniversityCreated;
use Cortex\UniversitiesModule\Events\UniversityDeleted;
use Cortex\UniversitiesModule\Events\UniversityUpdated;
use Cortex\UniversitiesModule\Events\UniversityRestored;
use Rinvex\Support\Traits\ValidatingTrait;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;


/**
 *
 * @mixin \Eloquent
 */
class University extends Model
{
    use Auditable;
    use LogsActivity;
    use ValidatingTrait;

    /**
     * The event map for the model.
     *
     * @var array
     */
    // protected $dispatchesEvents = [
    //     'created' => UniversityCreated::class,
    //     'updated' => UniversityUpdated::class,
    //     'deleted' => UniversityDeleted::class,
    //     'restored' => UniversityRestored::class,
    // ];


    protected $fillable = [
        'name',
        'alt_name',
        'country',
        'state',
        'street',
        'city',
        'province',
        'postal_code',
        'telephone',
        'website',
        'email',
        'fax',
        'funding',
        'languages',
        'academic_year',
        'accrediting_agency',
    ];

    protected $casts = [
        'languages' => 'array',
    ];

    protected $observables = [
        'validating',
        'validated',
    ];

    public $translatable = [
        'name',
    ];

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Whether the model should throw a
     * ValidationException if it fails validation.
     *
     * @var bool
     */
    protected $throwValidationExceptions = true;


    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setTable(config('cortex.universities.tables.universities'));
        $this->mergeRules([
            'name' => 'required|string|max:256',
            'alt_name' => 'nullable|string|max:256',
            'country' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:50',
            'telephone' => 'nullable|string|max:50',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'fax' => 'nullable|string|max:50',
            'funding' => 'nullable|string|max:255',
            'languages' => 'nullable|array',
            'academic_year' => 'nullable|string',
            'accrediting_agency' => 'nullable|string',
        ]);

        parent::__construct($attributes);
    }

    /**
     * Set sensible Activity Log Options.
     *
     * @return \Spatie\Activitylog\LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }


    /**
     * Scope a query to only include universities from a specific country.
    {
        return $query->where('country', $country);
    }

    /**
     * Scope a query to only include universities from a specific state.
     */
    public function scopeFromState($query, string $state)
    {
        return $query->where('state', $state);
    }

    /**
     * Scope a query to only include universities with specific funding type.
     */
    public function scopeWithFunding($query, string $funding)
    {
        return $query->where('funding', $funding);
    }

    /**
     * Get the full address as a string.
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->street,
            $this->city,
            $this->province,
            $this->postal_code,
        ]);

        return implode(', ', $parts);
    }

    // Getter methods similar to Rinvex University class
    public function getName(): ?string
    {
        return $this->name;
    }

    public function getAltName(): ?string
    {
        return $this->alt_name;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function getAddress(): ?array
    {
        return [
            'street' => $this->street,
            'city' => $this->city,
            'province' => $this->province,
            'postal_code' => $this->postal_code,
        ];
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function getContact(): ?array
    {
        return [
            'telephone' => $this->telephone,
            'website' => $this->website,
            'email' => $this->email,
            'fax' => $this->fax,
        ];
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function getFunding(): ?string
    {
        return $this->funding;
    }

    public function getLanguages(): ?array
    {
        return $this->languages;
    }

    public function getAcademicYear(): ?string
    {
        return $this->academic_year;
    }

    public function getAccreditingAgency(): ?string
    {
        return $this->accrediting_agency;
    }

    // Setter methods
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setAltName(?string $altName): self
    {
        $this->alt_name = $altName;
        return $this;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;
        return $this;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;
        return $this;
    }

    public function setAddress(array $address): self
    {
        $this->street = $address['street'] ?? null;
        $this->city = $address['city'] ?? null;
        $this->province = $address['province'] ?? null;
        $this->postal_code = $address['postal_code'] ?? null;
        return $this;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;
        return $this;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function setProvince(?string $province): self
    {
        $this->province = $province;
        return $this;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postal_code = $postalCode;
        return $this;
    }

    public function setContact(array $contact): self
    {
        $this->telephone = $contact['telephone'] ?? null;
        $this->website = $contact['website'] ?? null;
        $this->email = $contact['email'] ?? null;
        $this->fax = $contact['fax'] ?? null;
        return $this;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;
        return $this;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;
        return $this;
    }

    public function setFunding(?string $funding): self
    {
        $this->funding = $funding;
        return $this;
    }

    public function setLanguages(?array $languages): self
    {
        $this->languages = $languages;
        return $this;
    }

    public function setAcademicYear(?string $academicYear): self
    {
        $this->academic_year = $academicYear;
        return $this;
    }

    public function setAccreditingAgency(?string $accreditingAgency): self
    {
        $this->accrediting_agency = $accreditingAgency;
        return $this;
    }

    // Magic methods for property access
    public function __get($key)
    {
        // Handle address.* properties
        if (str_starts_with($key, 'address.')) {
            $property = substr($key, 8);
            return match ($property) {
                'street' => $this->street,
                'city' => $this->city,
                'province' => $this->province,
                'postal_code' => $this->postal_code,
                default => null,
            };
        }

        // Handle contact.* properties
        if (str_starts_with($key, 'contact.')) {
            $property = substr($key, 8);
            return match ($property) {
                'telephone' => $this->telephone,
                'website' => $this->website,
                'email' => $this->email,
                'fax' => $this->fax,
                default => null,
            };
        }

        return parent::__get($key);
    }

    public function __set($key, $value)
    {
        // Handle address.* properties
        if (str_starts_with($key, 'address.')) {
            $property = substr($key, 8);
            match ($property) {
                'street' => $this->street = $value,
                'city' => $this->city = $value,
                'province' => $this->province = $value,
                'postal_code' => $this->postal_code = $value,
                default => null,
            };
            return;
        }

        // Handle contact.* properties
        if (str_starts_with($key, 'contact.')) {
            $property = substr($key, 8);
            match ($property) {
                'telephone' => $this->telephone = $value,
                'website' => $this->website = $value,
                'email' => $this->email = $value,
                'fax' => $this->fax = $value,
                default => null,
            };
            return;
        }

        parent::__set($key, $value);
    }

    // Model events for cache management
    protected static function boot(): void
    {
        parent::boot();

        // Clear cache when university is updated
        static::updated(function ($university) {
            clearUniversitiesCache("university.id.{$university->id}");
            clearUniversitiesCache("university.name." . md5(strtolower($university->name)));
        });

        // Clear cache when university is deleted
        static::deleted(function ($university) {
            clearUniversitiesCache("university.id.{$university->id}");
            clearUniversitiesCache("university.name." . md5(strtolower($university->name)));
        });
    }

    /**
     * Cache this university instance.
     *
     * @param int|null $duration
     * @return $this
     */
    public function cache(?int $duration = null): self
    {
        $cacheKey = "university.id.{$this->id}";
        $cacheDuration = $duration ?? config('cortex.universities.cache_duration');

        if ($cacheDuration) {
            Cache::put($cacheKey, $this, $cacheDuration);
        }

        return $this;
    }

    /**
     * Clear this university from cache.
     *
     * @return bool
     */
    public function clearCache(): bool
    {
        return clearUniversitiesCache("university.id.{$this->id}") &&
            clearUniversitiesCache("university.name." . md5(strtolower($this->name)));
    }

    /**
     * Get cached version of this university.
     *
     * @return self|null
     */
    public function getCached(): ?self
    {
        return Cache::get("university.id.{$this->id}");
    }

    /**
     * Check if this university is cached.
     *
     * @return bool
     */
    public function isCached(): bool
    {
        return Cache::has("university.id.{$this->id}");
    }
}
