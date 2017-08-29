@extends('layout')
@section('header-nav')
    Cosin-权限管理
@stop
@section('title')
    Cosin-权限管理
@stop
@section('header-tips')
    权限管理
@stop
@section('nav')
    Cosin
@stop
@section('tips')
    权限管理
@stop
@section('content')
    @if(Session::has('error'))
        <div class="col-xs-3 text-danger">
            {{Session::get('error')}}
        </div>
    @endif
    @if(Session::has('success'))
        <div class="col-xs-3 text-success">
            {{Session::get('success')}}
        </div>
    @endif
    @if(count($errors) > 0)
        <div class="col-xs-3 text-danger">
            @foreach($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        </div>
    @endif
    <!-- Button trigger modal -->
    <div class='col-xs-1 col-md-offset-9'>
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addPermission">
            添加权限
        </button>
    </div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-lg pull-right"  data-toggle="modal" data-target="#addRole">
        添加角色
    </button>
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
                    <th class="text-center">DisplayName</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">CreateTime</th>
                    <th class="text-center">UpdateteTime</th>
                    <th class="text-center">Handle</th>
                </tr>
                </thead>

                <tbody>
                @foreach($roles as $role)
                    <tr class="text-center">
                        {{--<td class="center">
                            <label>
                                <input type="checkbox" class="ace" />
                                <span class="lbl"></span>
                            </label>
                        </td>--}}
                        <td>
                            <a href="#">{{$role -> name}}</a>
                        </td>
                        <td class="hidden-480">
                            {{$role -> display_name}}
                        </td>
                        <td class="hidden-480">
                            {{$role -> description}}
                        </td>
                        <td>
                            <a href="#">{{$role -> created_at}}</a>
                        </td>
                        <td>
                            <a href="#">{{$role -> updated_at}}</a>
                        </td>
                        <td>
                            <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                                <a class="green" href="javascript:void(0)"
                                   onclick="editRole({{$role -> id}})" title="编辑">
                                    <i class="icon-pencil bigger-130"></i>
                                </a>

                                {{--<a class="red" href="javascript:void(0)" onclick="delRole({{$role -> id}})" title="删除">
                                    <i class="icon-trash bigger-130"></i>
                                </a>--}}
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="dataTables_paginate paging_bootstrap">
        {{$roles -> render()}}
    </div>

    <!-- AddPermissionModal -->
    <div class="modal fade" id="addPermission" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">添加权限</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="post" action="{{url('auth/addPermission')}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">所属权限</label>
                            <div class="col-sm-4">
                                <select name="parent_per" class="form-control">
                                    <option value="0">请选择</option>
                                    @foreach($permissions as $permission)
                                        <option value="{{$permission->id}}">{{$permission->display_name}}</option>
                                    @endforeach
                                </select>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle text-danger name-tips"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">权限名称</label>
                            <div class="col-sm-9">
                                <input type="text" name="name" id="form-field-1" class="col-xs-10 col-sm-5"/>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle text-danger name-tips"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">显示名称</label>
                            <div class="col-sm-9">
                                <input type="text" name="display_name" id="form-field-1" class="col-xs-10 col-sm-5"/>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle text-danger display_name-tips"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">详细描述</label>
                            <div class="col-sm-9">
                                <input type="text" name="description" id="form-field-1" class="col-xs-10 col-sm-5"/>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle text-danger description-tips"></span>
                                </span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- DelRoleModal -->
    <div class="modal fade" id="delRole" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">添加/编辑角色</h4>
                    </div>
                </div>
                <div class="modal-body lead text-danger tips-text">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary delRole">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- AddRoleModal -->
    <div class="modal fade" id="addRole">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">角色管理</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" action="{{url('auth/addRole')}}">
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                角色名称
                            </label>
                            <div class="col-sm-9">
                                <input type="text" name="name" id="form-field-1" class="col-xs-10 col-sm-5"/>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle text-danger name-tips"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                显示名称
                            </label>
                            <div class="col-sm-9">
                                <input type="text" name="display_name" id="form-field-1" class="col-xs-10 col-sm-5"/>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle text-danger display_name-tips"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                可操作权限
                            </label>
                            <div class="col-sm-9">
                                @foreach($permissions as $permission)
                                    <div class="row">
                                            <div class="col-md-4">
                                                <label>
                                                    <input name="permission[]" class="selectPer" value="{{$permission->id}}" type="checkbox" />
                                                    <span class="lbl">{{$permission->display_name}}</span>
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                @foreach($permission->child as $child)
                                                    <label>
                                                        <input name="permission[]" value="{{$child->id}}" type="checkbox" />
                                                        <span class="lbl">{{$child->display_name}}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                详细描述
                            </label>
                            <div class="col-sm-9">
                                <textarea name="description" class="form-control" rows="3">

                                </textarea>
                                <span class="help-inline col-xs-12 col-sm-7">
                                    <span class="middle text-danger description-tips"></span>
                                </span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- EditRoleModal -->
    <div class="modal fade" id="editRole">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">角色管理</h4>
                </div>
                <div class="modal-body edit_role">

                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script src="{{asset('js/admin/auth.js')}}"></script>
@stop
