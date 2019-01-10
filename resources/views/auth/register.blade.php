<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>@lang('auth.register')</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <script src="{{ asset('js/webfont.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('admin.assets.css')

    <link rel="stylesheet" href="{{ asset('bower_components/metro-asset/vendors/base/my-custom.css') }}">
    <link rel="shortcut icon" href="{{ asset(config('site.static') . 'favicon.png') }}" />
</head>
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1 login-bg" id="m_login">
            <div class="m-grid__item m-grid__item--fluid m-login__wrapper">
                <div class="m-login__container">
                    <div class="m-login__logo">
                        <a href="{{ url('/') }}">
                            {!! Html::image(config('site.static') . 'framgia-logo.png') !!}
                        </a>
                    </div>
                    <div class="m-login__signin">
                        <div class="m-login__head">
                            <h3 class="m-login__title">@lang('auth.register') Framgia Working Place</h3>
                        </div>
                        {!! Form::open(['url' => 'register', 'method' => 'POST', 'class' => 'm-login__form m-form']) !!}
                            @foreach($errors->all() as $error)
                                <p class="alert alert-danger">{{ $error }}</p>
                            @endforeach
                            <div class="form-group m-form__group">
                                {!! Form::text('name', null, ['class' => 'form-control m-input', 'placeholder' => __('Enter full Name')]) !!}
                                {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
                            </div>
                            <div class="form-group m-form__group">
                                {!! Form::email('email', null, ['class' => 'form-control m-input', 'placeholder' => __('Enter Email')]) !!}
                            </div>
                            <div class="form-group m-form__group">
                                {!! Form::password('password', ['class' => 'form-control m-input', 'placeholder' => __('Enter Password')]) !!}
                            </div>
                            <div class="form-group m-form__group">
                                {!! Form::password('password_confirm', ['class' => 'form-control m-input', 'placeholder' => __('Enter Password Confirm')]) !!}
                            </div>
                            <div class="form-group mt-4">
                                {!! Form::select('program_id', [__('Programs')] + $programs, null, ['class' => 'form-control m-input', 'id' => 'select_program', 'onchange' => 'getBatch()', 'url' => route('get_trainer_by_program')]) !!}
                            </div>
                            <div class="form-group mt-4">
                                {!! Form::select('position_id', [__('Positions')] + $positions, null, ['class' => 'form-control m-input', 'id' => 'position', 'onchange' => 'getBatch()']) !!}
                            </div>
                            <div class="form-group mt-4">
                                {!! Form::select('workspace_id', [__('Workspaces')] + $workspaces, null, ['class' => 'form-control m-input', 'id' => 'workspace_id', 'onchange' => 'getBatch()']) !!}
                            </div>
                            <div class="form-group mt-4">
                                {!! Form::select('batch_id', [__('Batches')], null, ['class' => 'form-control m-input', 'id' => 'batch']) !!}
                            </div>
                            <div class="m-login__form-action">
                                {!! Form::submit(__('auth.register'), ['class' => 'btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary']) !!}
                                <a href="{{ url('/') }}" class="ml-4 btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary">@lang('Cancel')</a>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.assets.js')
    @include('sweetalert::alert')

    <script src="{{ asset('js/all.js') }}"></script>
    <script src="{{ asset('js/get_batches.js') }}"></script>

</body>
</html>
