@extends('admin.layout.master')

@section('title', __('Add Workspace'))
@section('css')
    <link rel="stylesheet" href="bower_components/lib_image_map/cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/image_map.css">
@endsection
@section('module')
    <div class="mr-auto">
        <h3 class="m-subheader__title m-subheader__title--separator">{{ __('Add Workspace') }}</h3>
    </div>
@endsection

@section('content')
{!! Form::open(['url' => route('save_design_diagram'), 'files' => true, 'method' => 'POST']) !!}
    <div class="container">
        <div class="row">
            <div class="col-md-12" >
                <div class="step">
                    {!! Form::button(__('Select Image from My PC'), ['class' => 'btn btn-success btn-lg', 'id' => 'image-mapper-upload']) !!}
                    {!! Form::file('diagram', ['accept' => '.png, .jpg, .jpeg', 'id' => 'image-mapper-file']) !!}
                    <span class="divider">&nbsp; &nbsp; &nbsp; -- OR -- &nbsp; &nbsp; &nbsp;</span>
                    {!! Form::button(__('Load Image from Website'), ['class' => 'btn btn-success btn-lg', 'data-toggle' => 'modal', 'data-target' => '#image-mapper-load']) !!}
                </div>
                {!! Form::text('name', '', ['class' => 'col-lg-8 col-lg-offset-2 form-control input-sm ', 'placeholder' => __('Enter Name Diagram'), 'id' => 'title-diagram']) !!}
                <div class="clearfix"> </div>
                <div class="col-lg-8 col-lg-offset-2">
                    <small class="text-danger" >{{$errors->first('name') }}</small>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid toggle-content">
        <div class="row">
            <div class="col-md-12">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12" id="image-map-wrapper">
                            <div id="image-map-container">
                                <div id="image-map">
                                    <span class="glyphicon glyphicon-picture"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table" id="image-mapper-table">
                    <thead>
                        <tr>
                            <th>{{ __('Active') }}</th>
                            <th>{{ __('Shape') }}</th>
                            <th>{{ __('Link') }}</th>
                            <th>{{ __('Shape') }}</th>
                            <th>{{ __('Target') }}</th>
                            <th id="image-mapper-table-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="image-mapper-table-2">
                                <div class="control-label input-sm">
                                    {!! Form::radio('im[0][active]', 1) !!}
                                </div>
                            </td>
                            <td>
                                {!! Form::select('im[0][shape]', config('site.default_img_map_shape'), null, ['class' => 'form-control input-sm'])  !!}
                            </td>
                            <td>
                                <select name="im[0][href]" class="form-control input-sm">
                                    @foreach ($workspaces as $id)
                                       <option value="{{ route('generate', ['id' => $id]) }}">{{ $id->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                {!! Form::text('im[0][title]', '', ['placeholder' => __('Title'), 'class' => 'form-control input-sm']) !!}
                            </td>
                            <td>
                                {!! Form::select('im[0][target]', config('site.default_img_map_target'), '', ['class' => 'form-control input-sm'])  !!}
                            </td>
                            <td>
                                {!! htmlspecialchars_decode(Form::button('Click Me!'.'<span class="glyphicon glyphicon-remove"></span>', ['class' => 'btn btn-default btn-sm remove-row', 'name' => 'im[0][remove]'])) !!}
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6" id="add-new-area">
                                {!! htmlspecialchars_decode(Form::button(__('Add New Area').' <span class="glyphicon glyphicon-plus"></span>', ['class' => 'btn btn-danger btn-sm add-row'])) !!}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="container toggle-content segment">
        <div class="row">
            <div class="col-md-12 text-center" id="show-me-the-code">
                {!! htmlspecialchars_decode(Form::button(__('Show Code').' <span class="glyphicon glyphicon-plus"></span>', ['class' => 'btn btn-success btn-lg', 'data-toggle' => 'modal', 'data-target' => '#modal-code'])) !!}
            </div>
        </div>
    </div>
    <div class="modal fade" id="image-mapper-load" tabindex="-1" role="dialog" aria-labelledby="image-mapper-load-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="image-mapper-dialog">
                <div class="modal-header">
                    {!! Form::button('&times;', ['class' => 'close', 'data-dismiss' => 'modal', 'aria-hidden' => 'true']) !!}
                    <h4 class="modal-title" id="image-mapper-load-label">{{ __('Load Image from Website') }}</h4></div>
                <div class="modal-body">
                    <div class="input-group input-group-sm has-error">
                        {!! Form::text('', '', ['calss' => 'form-control input-sm', 'id' => 'image-mapper-url']) !!}
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-remove">
                            </span>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    {!! Form::button(__('Close'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) !!}
                    {!! Form::button(__('Continue'), ['class' => 'btn btn-primary', 'id' => 'image-mapper-continue']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-code" tabindex="-1" role="dialog" aria-labelledby="modal-code-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="modal-code-dialog">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-code-label">{{ __('Generated Image Map Output') }}</h4>
                    {!! Form::button('&times;', ['class' => 'close', 'data-dismiss' => 'modal', 'aria-hidden' => 'true']) !!}
                </div>
                <div class="modal-body">
                    {!! Form::textarea('content', null, ['class' => 'form-control input-sm', 'readonly'=>'readonly', 'id' => 'modal-code-result', 'row' => '10' ]) !!}
                </div>
                <div class="modal-footer">
                    {!! Form::submit(__('Save'), ['class' => 'btn btn btn-success ']) !!}
                    {!! Form::button(__('Close'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) !!}
                </div>
            </div>
        </div>
    </div>
{!! Form::close() !!}
@endsection
@section('js')
    <script src="bower_components/lib_image_map/cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="bower_components/lib_image_map/cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="js/image_map.js"></script>
    <script src="js/image_mapping.js" type="text/javascript"></script>
@endsection


