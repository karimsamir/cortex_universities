<?php

declare(strict_types=1);

namespace Cortex\Universities\Http\Controllers\Adminarea;

use Illuminate\Http\Request;
use Cortex\Universities\Models\University;
use Cortex\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\Importers\InsertImporter;
use Cortex\Foundation\Http\Requests\ImportFormRequest;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Universities\DataTables\Adminarea\UniversitiesDataTable;
use Cortex\Universities\Http\Requests\Adminarea\UniversityFormRequest;

class UniversitiesController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'cortex.universities.models.university';

    /**
     * List all universities.
     *
     * @param \Cortex\Universities\DataTables\Adminarea\UniversitiesDataTable $universitiesDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(UniversitiesDataTable $universitiesDataTable)
    {
        $countries = collect(countries())->map(function ($country, $code) {
            return [
                'id' => $code,
                'text' => $country['name'],
                'emoji' => $country['emoji'],
            ];
        })->values();
        
        return $universitiesDataTable->with([
            'id' => 'adminarea-cortex-universities-universities-index',
            'countries' => $countries,
            'routePrefix' => 'adminarea.cortex.universities.universities',
            'pusher' => ['entity' => 'university', 'channel' => 'cortex.universities.universities.index'],
        ])->render('cortex/universities::adminarea.pages.universities');
    }

    /**
     * List university logs.
     *
     * @param \Cortex\Universities\Models\University          $university
     * @param \Cortex\Foundation\DataTables\LogsDataTable $logsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function logs(University $university, LogsDataTable $logsDataTable)
    {
        return $logsDataTable->with([
            'resource' => $university,
            'tabs' => 'adminarea.cortex.universities.universities.tabs',
            'id' => "adminarea-cortex-universities-universities-{$university->getRouteKey()}-logs",
        ])->render('cortex/foundation::adminarea.pages.datatable-tab');
    }

    /**
     * Import universities.
     *
     * @param \Cortex\Foundation\Http\Requests\ImportFormRequest $request
     * @param \Cortex\Foundation\Importers\InsertImporter        $importer
     * @param \Cortex\Universities\Models\University                 $university
     *
     * @return void
     */
    public function import(ImportFormRequest $request, InsertImporter $importer, University $university)
    {
        $importer->withModel($university)->import($request->file('file'));
    }

    /**
     * Create new university.
     *
     * @param \Illuminate\Http\Request           $request
     * @param \Cortex\Universities\Models\University $university
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request, University $university)
    {
        return $this->form($request, $university);
    }

    /**
     * Edit given university.
     *
     * @param \Illuminate\Http\Request           $request
     * @param \Cortex\Universities\Models\University $university
     *
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, University $university)
    {
        return $this->form($request, $university);
    }

    /**
     * Show university create/edit form.
     *
     * @param \Illuminate\Http\Request           $request
     * @param \Cortex\Universities\Models\University $university
     *
     * @return \Illuminate\View\View
     */
    protected function form(Request $request, University $university)
    {
        if (! $university->exists && $request->has('replicate') && $replicated = $university->resolveRouteBinding($request->input('replicate'))) {
            $university = $replicated->replicate();
        }
        return view('cortex/universities::adminarea.pages.university', compact('university'));
    }

    /**
     * Store new university.
     *
     * @param \Cortex\Universities\Http\Requests\Adminarea\UniversityFormRequest $request
     * @param \Cortex\Universities\Models\University                             $university
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(UniversityFormRequest $request, University $university)
    {
        return $this->process($request, $university);
    }

    /**
     * Update given university.
     *
     * @param \Cortex\Universities\Http\Requests\Adminarea\UniversityFormRequest $request
     * @param \Cortex\Universities\Models\University                             $university
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(UniversityFormRequest $request, University $university)
    {
        return $this->process($request, $university);
    }

    /**
     * Process stored/updated university.
     *
     * @param \Cortex\Foundation\Http\FormRequest $request
     * @param \Cortex\Universities\Models\University  $university
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function process(FormRequest $request, University $university)
    {
        // Prepare required input fields
        $data = $request->validated();

        // Save university
        $university->fill($data)->save();

        return intend([
            'url' => route('adminarea.cortex.universities.universities.index'),
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => trans('cortex/universities::common.university'), 'identifier' => $university->getRouteKey()])],
        ]);
    }

    /**
     * Destroy given university.
     *
     * @param \Cortex\Universities\Models\University $university
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(University $university)
    {
        $university->delete();

        return intend([
            'url' => route('adminarea.cortex.universities.universities.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => trans('cortex/universities::common.university'), 'identifier' => $university->getRouteKey()])],
        ]);
    }
}
