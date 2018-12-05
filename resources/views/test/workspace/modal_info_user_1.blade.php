<div class="modal fade" id="modal-info-user-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="text-center mb-3">
                <div class="seat-options btn btn-light selected col-md-5">
                    <span>{{ __('Register Seat') }}</span>
                </div>
                <div class="seat-options btn btn-light col-md-5">
                    <span>{{ __('Edit Seat') }}</span>
                </div>
            </div>
            <div class="option-view">
                <h4 class="modal-title">{{ __('Information user') }}</h4>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
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
            <div class="option-view d-none">
                <h1 class="modal-title">{{ __('Edit Location') }}</h1>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['method' => 'POST', 'route' => 'edit_seat', 'class' => 'form-horizontal']) !!}
                            <div class="form-group row">
                                {!! Form::label('color', __('Color'), ['class' => 'col-md-3']) !!}
                                <div class="col-md-5">
                                    {!! Form::color('color', null, [
                                        'id' => 'seat_color', 
                                        'placeholder' => __('Color'),
                                    ]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3"></div>
                                <div class="boder"></div>
                                <div class="col-md-12">
                                    {!! Form::submit(__('Save'), ['class' => 'col-md-5 btn btn-success']) !!}
                                    <button class="delete-cell col-md-offset-2 btn btn-danger" data-dismiss="modal">{{ __('Delete Cell') }}</button>
                                </div>
                            </div>
                            {!! Form::hidden('seat_id', '', ['class' => 'locations']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
