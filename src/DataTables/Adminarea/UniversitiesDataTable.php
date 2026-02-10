<?php

declare(strict_types=1);

namespace Cortex\UniversitiesModule\DataTables\Adminarea;

use Illuminate\Http\JsonResponse;
use Cortex\UniversitiesModule\Models\University;
use Cortex\Foundation\DataTables\AbstractDataTable;
use Cortex\UniversitiesModule\Transformers\Adminarea\UniversityTransformer;

class UniversitiesDataTable extends AbstractDataTable
{
    /**
     * {@inheritdoc}
     */
    protected $model = University::class;

    /**
     * {@inheritdoc}
     */
    protected $transformer = UniversityTransformer::class;

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax(): JsonResponse
    {
        return datatables($this->query())
            ->setTransformer(app($this->transformer))
            ->orderColumn('name', 'name->"$.'.app()->getLocale().'" $1')
            ->whitelist(array_keys($this->getColumns()))
            ->make(true);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        $link = config('cortex.foundation.route.locale_prefix')
            ? '"<a href=\""+routes.route(\'adminarea.cortex.categories.categories.edit\', {university: full.id, locale: \''.$this->request()->segment(1).'\'})+"\">"+data+"</a>"'
            : '"<a href=\""+routes.route(\'adminarea.cortex.categories.categories.edit\', {university: full.id})+"\">"+data+"</a>"';

        return [
            'id' => ['checkboxes' => json_decode('{"selectRow": true}'), 'exportable' => false, 'printable' => false],
            'name' => ['title' => trans('cortex/categories::common.name'), 'render' => $link, 'responsivePriority' => 0],
            'created_at' => ['title' => trans('cortex/categories::common.created_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
            'updated_at' => ['title' => trans('cortex/categories::common.updated_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
        ];
    }
}
