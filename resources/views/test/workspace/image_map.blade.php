@extends('admin.layout.master')

@section('title', __('Add Workspace'))
@section('css')
    <link rel="stylesheet" href="bower_components/lib_image_map/cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/image_map.css">
@endsection
@section('module', __('Add Workspace'))

@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="step">
                    <button type="button" class="btn btn-success btn-lg" id="image-mapper-upload">Select Image from My PC</button>
                    <input type="file" name="" id="image-mapper-file"><span class="divider">&nbsp; &nbsp; &nbsp; -- OR -- &nbsp; &nbsp; &nbsp;</span>
                    <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#image-mapper-load">Load Image from Website</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container toggle-content">
        <div class="row">
            <div class="col-md-12">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12" id="image-map-wrapper">
                            <div id="image-map-container">
                                <div id="image-map" style="max-width: 100%"><span class="glyphicon glyphicon-picture"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table" id="image-mapper-table">
                    <thead>
                        <tr>
                            <th>Active</th>
                            <th>Shape</th>
                            <th>Link</th>
                            <th>Title</th>
                            <th>Target</th>
                            <th style="width: 25px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width: 65px">
                                <div class="control-label input-sm">
                                    <input type="radio" name="im[0][active]" value="1">
                                </div>
                            </td>
                            <td>
                                <select name="im[0][shape]" class="form-control input-sm">
                                    <option value="">---</option>
                                    <option value="rect">Rect</option>
                                    <option value="poly">Poly</option>
                                    <option value="circle">Circle</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="im[0][href]" value="" placeholder="Link" class="form-control input-sm">
                            </td>
                            <td>
                                <input type="text" name="im[0][title]" value="" placeholder="Title" class="form-control input-sm">
                            </td>
                            <td>
                                <select name="im[0][target]" class="form-control input-sm">
                                    <option value="">---</option>
                                    <option value="_blank">_blank</option>
                                    <option value="_parent">_parent</option>
                                    <option value="_self">_self</option>
                                    <option value="_top">_top</option>
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-default btn-sm remove-row" name="im[0][remove]"><span class="glyphicon glyphicon-remove"></span></button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6" style="text-align: right">
                                <button type="button" class="btn btn-danger btn-sm add-row"><span class="glyphicon glyphicon-plus"></span> Add New Area</button>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="container toggle-content segment">
        <div class="row">
            <div class="col-md-12" style="text-align: center">
                <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modal-code">Show Me The Code!</button>
            </div>
        </div>
    </div>
    <div class="modal fade" id="image-mapper-load" tabindex="-1" role="dialog" aria-labelledby="image-mapper-load-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="image-mapper-dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="image-mapper-load-label">Load Image from Website</h4></div>
                <div class="modal-body">
                    <div class="input-group input-group-sm has-error">
                        <input type="text" value="" placeholder="http://..." id="image-mapper-url" class="form-control input-sm"><span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="image-mapper-continue">Continue</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-code" tabindex="-1" role="dialog" aria-labelledby="modal-code-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="modal-code-dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="modal-code-label">Generated Image Map Output</h4></div>
                <div class="modal-body">
                    <textarea class="form-control input-sm" readonly="readonly" id="modal-code-result" rows="10"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="bower_components/lib_image_map/cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="bower_components/lib_image_map/cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="js/image_map.js"></script>
    <script src="js/image_mapping.js" type="text/javascript"></script>
@endsection


