{{-- Master Layout --}}
@extends('cortex/foundation::adminarea.pages.datatable-index')

{{-- Datatable Filters --}}
@section('datatable-filters')
    {{ Form::open(['id' => "adminarea-cortex-universities-universities-filters-form"]) }}

    <div class="row">

        {{-- Country Code --}}
        <div class="col-md-3">
            <div class="form-group{{ $errors->has('country_code') ? ' has-error' : '' }}">
                {{ Form::label('country_code', trans('cortex/auth::common.country'), ['class' => 'control-label']) }}
                {{ Form::hidden('country_code', '', ['class' => 'skip-validation', 'id' => 'country_code_hidden']) }}
                {{ Form::select('country_code', [], null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/auth::common.country'), 'data-allow-clear' => 'true', 'data-width' => '100%']) }}
            </div>
        </div>

    </div>

{{ Form::close() }}

<br />

@endsection

@push('inline-scripts')
    <script>
        window.countries = @json($countries);
    </script>
@endpush
