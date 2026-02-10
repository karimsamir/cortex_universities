<?php

declare(strict_types=1);

namespace Cortex\UniversitiesModule\Models;

use Spatie\Activitylog\LogOptions;
use Rinvex\Support\Traits\Macroable;
use Cortex\Foundation\Traits\Auditable;
use Rinvex\Support\Traits\HashidsTrait;
// use Rinvex\Support\Traits\HasTimezones;
use Spatie\Activitylog\Traits\LogsActivity;
use Cortex\UniversitiesModule\Events\UniversityCreated;
use Cortex\UniversitiesModule\Events\UniversityDeleted;
use Cortex\UniversitiesModule\Events\UniversityUpdated;
use Cortex\UniversitiesModule\Events\UniversityRestored;
use Cortex\UniversitiesModule\Models\BaseUniversity;


/**
 *
 * @mixin \Eloquent
 */
class University extends BaseUniversity
{
    use Auditable;
    // use Macroable;
    // use HashidsTrait;
    // use HasTimezones;
    use LogsActivity;

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

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        // $this->mergeFillable(['style', 'icon']);

        // $this->mergeCasts(['style' => 'string', 'icon' => 'string']);

        $this->mergeRules(['style' => 'nullable|string|strip_tags|max:150', 'icon' => 'nullable|string|strip_tags|max:150']);

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
     * Get the route key for the model.
     *
     * @return string
     */
    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }
}
