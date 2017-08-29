@extends('layout')
@section('header-nav')
    Cosin-管理员
@stop
@section('header-tips')
    管理员
@stop
@section('title')
    Cosin-管理员
@stop
@section('nav')
    管理员
@stop
@section('tips')
    管理员列表
@stop
@section('style')
    <link rel="stylesheet" href="{{asset('css/admin/user.css')}}">
@stop
@section('content')
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-lg pull-right" data-toggle="modal" data-target="#myModal">
        添加管理员
    </button>
    <div class="col-xs-12 text-success lead">
        {{Session::get('success')}}
    </div>
    <div class="col-xs-12 text-danger lead">
        {{Session::get('error')}}
    </div>
    <div class="col-xs-12">
        <div class="table-responsive">
            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    {{--<th class="center">
                        <label>
                            <input type="checkbox" class="ace" />
                            <span class="lbl"></span>
                        </label>
                    </th>--}}
                    <th class="text-center">Name</th>
                    <th class="hidden-480 text-center">Status</th>
                    <th class="text-center">CreateTime</th>
                    <th class="text-center">UpdateteTime</th>
                    <th class="text-center">Handle</th>
                </tr>
                </thead>

                <tbody>
                @foreach($admins as $admin)
                    <tr class="text-center">
                        {{--<td class="center">
                            <label>
                                <input type="checkbox" class="ace" />
                                <span class="lbl"></span>
                            </label>
                        </td>--}}
                        <td>
                            <a href="#">{{$admin -> username}}</a>
                        </td>
                        <td class="hidden-480">
                            <span class="label label-sm label-info arrowed-righ">
                                @if ($admin -> status == 1)
                                    正常
                                @else
                                    异常
                                @endif
                            </span>
                        </td>
                        <td>
                            <a href="#">{{$admin -> created_at}}</a>
                        </td>
                        <td>
                            <a href="#">{{$admin -> updated_at}}</a>
                        </td>
                        <td>
                            <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                                <a class="green" href="javascript:void(0)" onclick="editManager({{$admin->id}})" title="修改密码">
                                    <i class="icon-pencil bigger-130"></i>
                                </a>

                                <a class="red" href="javascript:void(0)" onclick="delManager({{$admin -> id}})" title="删除">
                                    <i class="icon-trash bigger-130"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="dataTables_paginate paging_bootstrap">
        {{$admins -> render()}}
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">添加管理员</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">用户名</label>

                            <div class="col-sm-9">
                                <input type="text" name="Admin[username]" id="form-field-1" placeholder="Username"
                                       class="col-xs-10 col-sm-5"/>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle text-danger username-tips"></span>
                                </span>
                            </div>
                        </div>

                        <div class="space-4"></div>

                        <div class="form-group bg-success">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-2">密码</label>

                            <div class="col-sm-9">
                                <input type="password" name="Admin[password]" id="form-field-2" placeholder="Password"
                                       class="col-xs-10 col-sm-5"/>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle text-danger password-tips"></span>
                                </span>
                            </div>
                        </div>
                        <div class="space-4"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-2">用户角色</label>

                            <div class="col-sm-5">
                                <select name="Admin[role]" class="form-control">
                                    <option value="0">请选择</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role -> id}}">{{$role -> display_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary submit-add">Save changes</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="del" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body lead text-danger tips-text">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary del-manager">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">编辑管理员</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">用户名</label>
                            <div class="col-sm-9">
                                <input type="text" class="username" id="form-field-1"
                                       class="col-xs-10 col-sm-5"/>
                                <span>
                                    <span class="middle text-danger uname-tips"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-2">密码</label>
                            <div class="col-sm-9">
                                <input type="text" class="passwd" id="form-field-2" placeholder="Password"
                                       class="col-xs-10 col-sm-5"/>
                                <span>
                                    <span class="middle text-danger passwd-tips"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">角色</label>
                            <div class="col-sm-5">
                                <select name="role_name" class="form-control role-name">
                                    <option value="0">请选择</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary edit-manager">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script src="{{asset('js/admin/user.js')}}"></script>
    <script>

    </script>
@stop