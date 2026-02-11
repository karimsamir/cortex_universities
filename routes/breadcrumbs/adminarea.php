<?php

declare(strict_types=1);

use Diglactic\Breadcrumbs\Generator;
use Cortex\Universities\Models\University;
use Diglactic\Breadcrumbs\Breadcrumbs;

Breadcrumbs::for('adminarea.cortex.universities.universities.index', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.home');
    $breadcrumbs->push(trans('cortex/universities::common.universities'), route('adminarea.cortex.universities.universities.index'));
});

Breadcrumbs::for('adminarea.cortex.universities.universities.import', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.universities.universities.index');
    $breadcrumbs->push(trans('cortex/universities::common.import'), route('adminarea.cortex.universities.universities.import'));
});

Breadcrumbs::for('adminarea.cortex.universities.universities.import.logs', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.universities.universities.import');
    $breadcrumbs->push(trans('cortex/universities::common.logs'), route('adminarea.cortex.universities.universities.import.logs'));
});

Breadcrumbs::for('adminarea.cortex.universities.universities.create', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.universities.universities.index');
    $breadcrumbs->push(trans('cortex/universities::common.create_university'), route('adminarea.cortex.universities.universities.create'));
});

Breadcrumbs::for('adminarea.cortex.universities.universities.edit', function (Generator $breadcrumbs, University $university) {
    $breadcrumbs->parent('adminarea.cortex.universities.universities.index');
    $breadcrumbs->push(strip_tags($university->name), route('adminarea.cortex.universities.universities.edit', ['university' => $university]));
});

Breadcrumbs::for('adminarea.cortex.universities.universities.logs', function (Generator $breadcrumbs, University $university) {
    $breadcrumbs->parent('adminarea.cortex.universities.universities.edit', $university);
    $breadcrumbs->push(trans('cortex/universities::common.logs'), route('adminarea.cortex.universities.universities.logs', ['university' => $university]));
});
