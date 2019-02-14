@extends('./admin.layout.master')
@section('title', __('Edit Employee') )
@section('module', __('Edit Employee'))
@section('content')
    <div class="m-portlet" data-select2-id="5">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{ __('Edit Employee') }}
                    </h3>
                </div>
            </div>
        </div>
        {!! Form::model($user, ['url' => 'user/' . $user->id, 'method' => 'PATCH', 'class' => 'm-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed', 'files' => true]) !!}
        {!! Form::hidden('id', $user->id) !!}
        <div class="m-portlet__body">
            <div class="form-group m-form__group row">
                <div class="col-lg-6">
                    {!! Form::label(__('Full Name')) !!}
                    {!! Form::text('name', $user->name, ['class' => 'form-control m-input', 'placeholder' => __('Enter full Name')]) !!}
                    {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
                    <span class="m-form__help">{{ __('Please enter Full Name') }}</span>
                </div>
                <div class="col-lg-6">
                    {!! Form::label(__('Email')) !!}
                    {!! Form::email('email', $user->email, ['class' => 'form-control m-input', 'placeholder' => __('Enter Email')]) !!}
                    {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
                    <span class="m-form__help">{{ __('Please enter Email') }}</span>
                </div>
            </div>
            <div class="form-group m-form__group row">
                <div class="col-lg-6">
                    {!! Form::label(__('Program')) !!}
                    <div class="m-input-icon m-input-icon--right">
                        {!! Form::select('program_id', $programs, null, ['class' => 'form-control m-input', 'id' => 'select_program', 'url' => route('get_trainer_by_program')]) !!}
                    </div>
                    <span class="m-form__help">{{ __('Please select Program') }}</span>
                </div>
                <div class="col-lg-6">
                    {!! Form::label(__('Language')) !!}
                    <div class="m-input-icon m-input-icon--right">
                        {!! Form::select('lang', config('site.list-lang'), null, ['class' => 'form-control m-input']) !!}
                    </div>
                    <span class="m-form__help">{{ __('Please select Language') }}</span>
                </div>
            </div>
            <div class="form-group m-form__group row">
                @if(Entrust::can('change-role'))
                    <div class="col-lg-6">
                        {!! Form::label(__('Position')) !!}
                        <div class="m-input-icon m-input-icon--right">
                            {!! Form::select('position_id', $positions, null, ['class' => 'form-control m-input']) !!}
                        </div>
                        <span class="m-form__help">{{ __('Please select Position') }}</span>
                    </div>
                @else
                <div class="col-lg-6">
                    {!! Form::label(__('Position')) !!}
                    <div class="col-md-3">{{ $user->position->name }}</div>
                </div>
                @endif
                <div class="col-lg-6">
                    {!! Form::label(__('Workspace')) !!}
                    <div class="m-input-icon m-input-icon--right">
                        {!! Form::select('workspace_id', $workspaces, null, ['class' => 'form-control m-input']) !!}
                    </div>
                    <span class="m-form__help">{{ __('Please select Workspace') }}</span>
                </div>
            </div>
            <div class="form-group m-form__group row">
                <div class="col-lg-6">
                    {!! Form::label(__('Avatar')) !!}
                    <div class="custom-file">
                        {!! Form::file('avatar', ['class' => 'custom-file-input', 'id' => 'input-display']) !!}
                        {!! Form::label(__('Choose file'), null, ['class' => 'custom-file-label']) !!}
                        {!! $errors->first('avatar', '<p class="text-danger">:message</p>') !!}
                    </div>
                    <div class="text-center py-2">
                        {!! Html::image(Auth::user()->avatarUser, null, ['id' => 'image-display' ]) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions--solid">
                <div class="row">
                    <div class="col-lg-6">
                        {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
                        <a href="{{ url('/admin') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/all.js') }}"></script>
@endsection
