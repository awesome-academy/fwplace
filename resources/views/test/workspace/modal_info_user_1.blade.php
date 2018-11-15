<div class="modal fade" id="modal-info-user-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <h4 class="modal-title">{{ __('Information user') }}</h4>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center login-header clearfix">
                                {!! Html::image( asset(config('site.static') . 'favicon.png'), 'alt' ) !!}
                                <p></p>
                            </div>
                            {!! Form::open([ 'method' => 'POST', 'route' => 'edit_info_user','files' => true, 'class'=>'m-form m-form--fit'] ) !!}
                                <div class="m-portlet__body">
                                    <div class="form-group m-form__group row">
                                        <div class="col-12">
                                            <div class="container-img">
                                                <div class="avatar-upload">
                                                    <div class="avatar-edit">
                                                        {!! Form::file('avatar', ['accept' => '.png, .jpg, .jpeg', 'id' => 'imageUpload']) !!}
                                                    </div>
                                                    <div class="avatar-preview">
                                                        <div id="imagePreview">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! htmlspecialchars_decode(Form::label('name', __('User Name').'<span class="required">*</span>', [ 'class' => 'control-label col-md-4 col-sm-4 col-xs-12'])) !!}
                                        <div class="col-8">
                                            {!! Form::select('edit_userId',$listUser, null, ['class' => 'form-control m-input list-name', 'placeholder' => 'User - Name' ]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! htmlspecialchars_decode(Form::label('language', __('Language').'<span class="required">*</span>', [ 'class' => 'control-label col-md-4 col-sm-4 col-xs-12'])) !!}
                                        <div class="col-8">
                                            {!! Form::select('language',$listProgram, null, ['class' => 'form-control m-input list-program', 'id' => 'list-language']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! htmlspecialchars_decode(Form::label('position', __('Position').'<span class="required">*</span>', [ 'class' => 'control-label col-md-4 col-sm-4 col-xs-12'])) !!}
                                        <div class="col-8">
                                            {!! Form::select('position',$listPosition, null, ['class' => 'form-control m-input list-position', 'id' => 'list-position']) !!}
                                        </div>
                                    </div>
                                    {!! Form::hidden('seat_id', '', ['id' => 'locations-1']) !!}
                                    {!! Form::hidden('user_id', '', ['id' => 'user-id-current']) !!}
                                </div>
                                <div class="boder"></div>
                                {!! Form::submit(__('Save'), ['class' => 'col-md-12 btn btn-success']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
