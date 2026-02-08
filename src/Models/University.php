<?php

declare(strict_types=1);

namespace Cortex\Universities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class University extends Model
{
    use HasFactory;

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
        'email' => 'array',
        'languages' => 'array',
    ];

    /**
     * Get the table name for the model.
     */
    public function getTable(): string
    {
        return config('cortex_universities.table_name', 'universities');
    }

    /**
     * Scope a query to only include universities from a specific country.
     */
    public function scopeFromCountry($query, string $country)
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
}
