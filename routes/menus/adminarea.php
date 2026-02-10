<?php

declare(strict_types=1);

use Rinvex\Menus\Models\MenuItem;
use Cortex\Universities\Models\University;
use Rinvex\Menus\Models\MenuGenerator;

Menu::register('adminarea.sidebar', function (MenuGenerator $menu) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.taxonomy'), 30, 'fa fa-arrows', 'header', [], [], function (MenuItem $dropdown) {
        $dropdown->route(['adminarea.cortex.universities.universities.index'], trans('cortex/universities::common.universities'), 10, 'fa fa-sitemap')->ifCan('list', app('rinvex.universities.university'))->activateOnRoute('adminarea.cortex.universities.universities');
    });
});

Menu::register('adminarea.cortex.universities.universities.tabs', function (MenuGenerator $menu, University $university) {
    $menu->route(['adminarea.cortex.universities.universities.import'], trans('cortex/universities::common.records'))->ifCan('import', $university)->if(Route::is('adminarea.cortex.universities.universities.import*'));
    $menu->route(['adminarea.cortex.universities.universities.import.logs'], trans('cortex/universities::common.logs'))->ifCan('audit', $university)->if(Route::is('adminarea.cortex.universities.universities.import*'));
    $menu->route(['adminarea.cortex.universities.universities.create'], trans('cortex/universities::common.details'))->ifCan('create', $university)->if(Route::is('adminarea.cortex.universities.universities.create'));
    $menu->route(['adminarea.cortex.universities.universities.edit', ['university' => $university]], trans('cortex/universities::common.details'))->ifCan('update', $university)->if($university->exists);
    $menu->route(['adminarea.cortex.universities.universities.logs', ['university' => $university]], trans('cortex/universities::common.logs'))->ifCan('audit', $university)->if($university->exists);
});
