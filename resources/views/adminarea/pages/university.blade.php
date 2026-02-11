{{-- Master Layout --}}
@extends('cortex/foundation::adminarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{-- {{ extract_title(Breadcrumbs::render()) }} --}}
@endsection

@push('inline-scripts')
    {!! JsValidator::formRequest(Cortex\UniversitiesModule\Http\Requests\Adminarea\UniversityFormRequest::class)->selector(
            "#adminarea-cortex-universities-universities-create-form, #adminarea-cortex-universities-universities-{$university->getRouteKey()}-update-form",
        )->ignore('.skip-validation') !!}
@endpush

{{-- Main Content --}}
@section('content')
    @includeWhen($university->exists, 'cortex/foundation::adminarea.partials.modal', [
        'id' => 'delete-confirmation',
    ])

    <div class="content-wrapper">
        <section class="content-header">
            {{-- <h1>{{ Breadcrumbs::render() }}</h1> --}}
        </section>

        {{-- Main content --}}
        <section class="content">

            <div class="nav-tabs-custom">
                @includeWhen($university->exists, 'cortex/foundation::adminarea.partials.actions', [
                    'name' => 'university',
                    'model' => $university,
                    'resource' => trans('cortex/universities::common.university'),
                    'routePrefix' => 'adminarea.cortex.universities.universities',
                ])
                {!! Menu::render('adminarea.cortex.universities.universities.tabs', 'nav-tab') !!}

                <div class="tab-content">

                    <div class="tab-pane active" id="details-tab">

                        @if ($university->exists)
                            {{ Form::model($university, ['url' => route('adminarea.cortex.universities.universities.update', ['university' => $university]), 'method' => 'put', 'id' => "adminarea-cortex-universities-universities-{$university->getRouteKey()}-update-form"]) }}
                        @else
                            {{ Form::model($university, ['url' => route('adminarea.cortex.universities.universities.store'), 'id' => 'adminarea-cortex-universities-universities-create-form']) }}
                        @endif

                        <div class="row">

                            <div class="col-md-4">

                                {{-- Name --}}
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    {{ Form::label('name', trans('cortex/universities::common.name'), ['class' => 'control-label']) }}
                                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('cortex/universities::common.name'), 'data-slugify' => '[name="slug"]', 'required' => 'required', 'autofocus' => 'autofocus']) }}

                                    @if ($errors->has('name'))
                                        <span class="help-block">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4">

                                {{-- alt_name --}}
                                <div class="form-group{{ $errors->has('alt_name') ? ' has-error' : '' }}">
                                    {{ Form::label('alt_name', trans('cortex/universities::common.alt_name'), ['class' => 'control-label']) }}
                                    {{ Form::text('alt_name', null, ['class' => 'form-control', 'placeholder' => trans('cortex/universities::common.alt_name'), 'autofocus' => 'autofocus']) }}

                                    @if ($errors->has('alt_name'))
                                        <span class="help-block">{{ $errors->first('alt_name') }}</span>
                                    @endif
                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4">

                                {{-- country --}}
                                <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                                    {{ Form::label('country', trans('cortex/universities::common.country'), ['class' => 'control-label']) }}
                                    {{ Form::text('country', null, ['class' => 'form-control', 'placeholder' => trans('cortex/universities::common.country'), 'required' => 'required', 'autofocus' => 'autofocus']) }}

                                    @if ($errors->has('country'))
                                        <span class="help-block">{{ $errors->first('country') }}</span>
                                    @endif
                                </div>

                            </div>

                            <div class="col-md-4">

                                {{-- state --}}
                                <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                                    {{ Form::label('state', trans('cortex/universities::common.state'), ['class' => 'control-label']) }}
                                    {{ Form::text('state', null, ['class' => 'form-control', 'placeholder' => trans('cortex/universities::common.state'), 'autofocus' => 'autofocus']) }}

                                    @if ($errors->has('state'))
                                        <span class="help-block">{{ $errors->first('state') }}</span>
                                    @endif
                                </div>

                            </div>


                        </div>

                        <div class="row">


                        </div>

                        <div class="row">

                            <div class="col-md-4">

                                {{-- street --}}
                                <div class="form-group{{ $errors->has('street') ? ' has-error' : '' }}">
                                    {{ Form::label('street', trans('cortex/universities::common.street'), ['class' => 'control-label']) }}
                                    {{ Form::text('street', null, ['class' => 'form-control', 'placeholder' => trans('cortex/universities::common.street'), 'autofocus' => 'autofocus']) }}

                                    @if ($errors->has('street'))
                                        <span class="help-block">{{ $errors->first('street') }}</span>
                                    @endif
                                </div>

                            </div>

                            <div class="col-md-3">
                                {{-- city --}}

                                <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                    {{ Form::label('city', trans('cortex/universities::common.city'), ['class' => 'control-label']) }}
                                    {{ Form::text('city', null, ['class' => 'form-control', 'placeholder' => trans('cortex/universities::common.city'), 'autofocus' => 'autofocus']) }}

                                    @if ($errors->has('city'))
                                        <span class="help-block">{{ $errors->first('city') }}</span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-3">

                                {{-- province --}}
                                <div class="form-group{{ $errors->has('province') ? ' has-error' : '' }}">
                                    {{ Form::label('province', trans('cortex/universities::common.province'), ['class' => 'control-label']) }}
                                    {{ Form::text('province', null, ['class' => 'form-control', 'placeholder' => trans('cortex/universities::common.province'), 'autofocus' => 'autofocus']) }}

                                    @if ($errors->has('province'))
                                        <span class="help-block">{{ $errors->first('province') }}</span>
                                    @endif
                                </div>

                            </div>

                            <div class="col-md-3">

                                {{-- postal_code --}}
                                <div class="form-group{{ $errors->has('postal_code') ? ' has-error' : '' }}">
                                    {{ Form::label('postal_code', trans('cortex/universities::common.postal_code'), ['class' => 'control-label']) }}
                                    {{ Form::text('postal_code', null, ['class' => 'form-control', 'placeholder' => trans('cortex/universities::common.postal_code'), 'autofocus' => 'autofocus']) }}

                                    @if ($errors->has('postal_code'))
                                        <span class="help-block">{{ $errors->first('postal_code') }}</span>
                                    @endif
                                </div>

                            </div>

                            <div class="col-md-3">

                                {{-- telephone --}}
                                <div class="form-group{{ $errors->has('telephone') ? ' has-error' : '' }}">
                                    {{ Form::label('telephone', trans('cortex/universities::common.telephone'), ['class' => 'control-label']) }}
                                    {{ Form::text('telephone', null, ['class' => 'form-control', 'placeholder' => trans('cortex/universities::common.telephone'), 'autofocus' => 'autofocus']) }}

                                    @if ($errors->has('telephone'))
                                        <span class="help-block">{{ $errors->first('telephone') }}</span>
                                    @endif
                                </div>

                            </div>

                            <div class="col-md-3">

                                {{-- fax --}}
                                <div class="form-group{{ $errors->has('fax') ? ' has-error' : '' }}">
                                    {{ Form::label('fax', trans('cortex/universities::common.fax'), ['class' => 'control-label']) }}
                                    {{ Form::text('fax', null, ['class' => 'form-control', 'placeholder' => trans('cortex/universities::common.fax'), 'autofocus' => 'autofocus']) }}

                                    @if ($errors->has('fax'))
                                        <span class="help-block">{{ $errors->first('fax') }}</span>
                                    @endif
                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">

                                {{-- website --}}
                                <div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
                                    {{ Form::label('website', trans('cortex/universities::common.website'), ['class' => 'control-label']) }}
                                    {{ Form::text('website', null, ['class' => 'form-control', 'placeholder' => trans('cortex/universities::common.website'), 'autofocus' => 'autofocus']) }}

                                    @if ($errors->has('website'))
                                        <span class="help-block">{{ $errors->first('website') }}</span>
                                    @endif
                                </div>

                            </div>

                            <div class="col-md-6">

                                {{-- email --}}
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    {{ Form::label('email', trans('cortex/universities::common.email'), ['class' => 'control-label']) }}
                                    {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => trans('cortex/universities::common.email'), 'autofocus' => 'autofocus']) }}

                                    @if ($errors->has('email'))
                                        <span class="help-block">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4">

                                {{-- funding --}}
                                <div class="form-group{{ $errors->has('funding') ? ' has-error' : '' }}">
                                    {{ Form::label('funding', trans('cortex/universities::common.funding'), ['class' => 'control-label']) }}
                                    {{ Form::text('funding', null, ['class' => 'form-control', 'placeholder' => trans('cortex/universities::common.funding'), 'autofocus' => 'autofocus']) }}

                                    @if ($errors->has('funding'))
                                        <span class="help-block">{{ $errors->first('funding') }}</span>
                                    @endif
                                </div>

                            </div>

                            <div class="col-md-4">

                                {{-- languages --}}
                                <div class="form-group{{ $errors->has('languages') ? ' has-error' : '' }}">
                                    {{ Form::label('languages', trans('cortex/universities::common.languages'), ['class' => 'control-label']) }}
                                    {{ Form::text('languages', null, ['class' => 'form-control', 'placeholder' => trans('cortex/universities::common.languages'), 'autofocus' => 'autofocus']) }}

                                    @if ($errors->has('languages'))
                                        <span class="help-block">{{ $errors->first('languages') }}</span>
                                    @endif
                                </div>

                            </div>

                            <div class="col-md-4">

                                {{-- academic_year --}}
                                <div class="form-group{{ $errors->has('academic_year') ? ' has-error' : '' }}">
                                    {{ Form::label('academic_year', trans('cortex/universities::common.academic_year'), ['class' => 'control-label']) }}
                                    {{ Form::text('academic_year', null, ['class' => 'form-control', 'placeholder' => trans('cortex/universities::common.academic_year'), 'autofocus' => 'autofocus']) }}

                                    @if ($errors->has('academic_year'))
                                        <span class="help-block">{{ $errors->first('academic_year') }}</span>
                                    @endif
                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">

                                {{-- accrediting_agency --}}
                                <div class="form-group{{ $errors->has('accrediting_agency') ? ' has-error' : '' }}">
                                    {{ Form::label('accrediting_agency', trans('cortex/universities::common.accrediting_agency'), ['class' => 'control-label']) }}
                                    {{ Form::text('accrediting_agency', null, ['class' => 'form-control', 'placeholder' => trans('cortex/universities::common.accrediting_agency'), 'autofocus' => 'autofocus']) }}

                                    @if ($errors->has('accrediting_agency'))
                                        <span class="help-block">{{ $errors->first('accrediting_agency') }}</span>
                                    @endif
                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">

                                <div class="pull-right">
                                    {{ Form::button(trans('cortex/universities::common.submit'), ['class' => 'btn btn-primary btn-flat', 'type' => 'submit']) }}
                                </div>

                                @include('cortex/foundation::adminarea.partials.timestamps', [
                                    'model' => $university,
                                ])

                            </div>

                        </div>

                        {{ Form::close() }}

                    </div>

                </div>

            </div>

        </section>

    </div>
@endsection
