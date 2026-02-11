<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Access\Authorizable;

Broadcast::channel('cortex.universities.universities.index', function (Authorizable $user) {
    return $user->can('list', app('cortex.universities.university'));
});
