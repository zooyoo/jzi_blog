@extends('admin.layout')

@section('styles')
    <link href="/assets/pickadate/themes/default.css" rel="stylesheet">
    <link href="/assets/pickadate/themes/default.date.css" rel="stylesheet">
    <link href="/assets/pickadate/themes/default.time.css" rel="stylesheet">
    <link href="/assets/selectize/css/selectize.css" rel="stylesheet">
    <link href="/assets/selectize/css/selectize.bootstrap3.css" rel="stylesheet">
@stop

@section('content')
    <div class="container-fluid">
        <div class="row page-title-row">
            <div class="col-md-12">
                <h3>文章 <small>» 编辑文章</small></h3>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">表单</h3>
                    </div>
                    <div class="panel-body">

                        @include('admin.partials.errors')
                        @include('admin.partials.success')

                        <form class="form-horizontal" role="form" method="POST" action="{{ route('post.update', $id) }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">

                            @include('admin.post._form')

                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="col-md-10 col-md-offset-2">
                                        <button type="submit" class="btn btn-primary btn-lg" name="action" value="continue">
                                            <i class="fa fa-floppy-o"></i>
                                            保存 - 继续
                                        </button>
                                        <button type="submit" class="btn btn-success btn-lg" name="action" value="finished">
                                            <i class="fa fa-floppy-o"></i>
                                            保存 - 完成
                                        </button>
                                        <button type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#modal-delete">
                                            <i class="fa fa-times-circle"></i>
                                            删除
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

        {{-- 确认删除 --}}
        <div class="modal fade" id="modal-delete" tabIndex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            ×
                        </button>
                        <h4 class="modal-title">请确认</h4>
                    </div>
                    <div class="modal-body">
                        <p class="lead">
                            <i class="fa fa-question-circle fa-lg"></i>
                            您确认要删除此文章?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <form method="POST" action="{{ route('post.destroy', $id) }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-times-circle"></i> 确认
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')
    <script src="/assets/pickadate/picker.js"></script>
    <script src="/assets/pickadate/picker.date.js"></script>
    <script src="/assets/pickadate/picker.time.js"></script>
    <script src="/assets/selectize/selectize.min.js"></script>
    <script>
        $(function() {
            $("#update_date").pickadate({
                format: "mmm-d-yyyy"
            });
            $("#update_time").pickatime({
                format: "h:i A"
            });
            $("#tags").selectize({
                create: true
            });
        });
    </script>
@stop