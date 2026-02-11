<?php

declare(strict_types=1);

return function () {
    // Bind route models and constrains
    Route::pattern('university', '[a-zA-Z0-9-_]+');
    Route::model('university', config('cortex.universities.models.university'));
};
