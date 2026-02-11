<?php

declare(strict_types=1);

namespace Cortex\UniversitiesModule\Http\Requests\Adminarea;

use Rinvex\Support\Traits\Escaper;
use Cortex\Foundation\Http\FormRequest;

class UniversityFormRequest extends FormRequest
{
    use Escaper;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $university = $this->route('university') ?? app('cortex.universities.university');
        $university->updateRulesUniques();

        return $university->getRules();
    }
}
