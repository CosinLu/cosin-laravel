<form class="form-horizontal" method="post" action="{{url('auth/doEditRole')}}">
    {{csrf_field()}}
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
            角色名称
        </label>
        <div class="col-sm-9">
            <input type="text" name="name" value="{{$roleData -> name}}" id="form-field-1" class="col-xs-10 col-sm-5"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
            显示名称
        </label>
        <div class="col-sm-9">
            <input type="text" name="display_name" value="{{$roleData -> display_name}}" id="form-field-1" class="col-xs-10 col-sm-5"/>
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
                                <input name="permission[]"
                                       @if(in_array($permission->id,$roleData->permissions))
                                             checked="checked"
                                       @endif
                                       class="selectPer" value="{{$permission->id}}" type="checkbox"/>
                                <span class="lbl">{{$permission->display_name}}</span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            @foreach($permission->child as $child)
                                <label>
                                    <input name="permission[]"
                                           @if(in_array($child->id,$roleData->permissions))
                                           checked
                                           @endif
                                           value="{{$child->id}}" type="checkbox"/>
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
            <textarea name="description" class="form-control" rows="3">{{$roleData -> display_name}}</textarea>
        </div>
    </div>
    <div class="modal-footer">
        <input type="hidden" name="id" value="{{$roleData -> id}}">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>
