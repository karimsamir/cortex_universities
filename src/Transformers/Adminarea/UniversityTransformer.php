<?php

declare(strict_types=1);

namespace Cortex\UniversitiesModule\Transformers\Adminarea;

use Rinvex\Support\Traits\Escaper;
use Cortex\UniversitiesModule\Models\University;
use League\Fractal\TransformerAbstract;

class UniversityTransformer extends TransformerAbstract
{
    use Escaper;

    /**
     * Transform university model.
     *
     * @param \Cortex\UniversitiesModule\Models\University $university
     *
     * @throws \Exception
     *
     * @return array
     */
    public function transform(University $university): array
    {
        return $this->escape([
            'id' => (string) $university->getRouteKey(),
            'name' => (string) $university->name,
            'created_at' => (string) $university->created_at,
            'updated_at' => (string) $university->updated_at,
        ]);
    }
}
