
<ul class="nav nav-list">
    <li class="{{Request::getPathInfo() == '/' ? 'active' : ''}}">
        <a href="/">
            <i class="icon-dashboard"></i>
            <span class="menu-text"> 首页 </span>
        </a>
    </li>

    <li class="{{Request::getPathInfo() == '/admin' ? 'active' : ''}}">
        <a href="{{url('/admin')}}">
            <i class="icon-text-width"></i>
            <span class="menu-text"> 管理员  </span>
        </a>
    </li>

    <li class="{{Request::getPathInfo() == '/auth' ? 'active' : ''}}">
        <a href="{{url('/auth')}}" class="dropdown-toggle">
            <i class="icon-desktop"></i>
            <span class="menu-text">权限管理</span>
        </a>

    </li>

    <li class="{{Request::getPathInfo() == '/article' ? 'active' : ''}}">
        <a href="{{url('/article')}}">
            <i class="icon-list-alt"></i>
            <span class="menu-text"> 文章管理 </span>
        </a>
    </li>

    <li>
        <a href="#" class="dropdown-toggle">
            <i class="icon-list"></i>
            <span class="menu-text"> 表格 </span>

            <b class="arrow icon-angle-down"></b>
        </a>

        <ul class="submenu">
            <li>
                <a href="tables.html">
                    <i class="icon-double-angle-right"></i>
                    简单 &amp; 动态
                </a>
            </li>

            <li>
                <a href="jqgrid.html">
                    <i class="icon-double-angle-right"></i>
                    jqGrid plugin
                </a>
            </li>
        </ul>
    </li>

    <li>
        <a href="#" class="dropdown-toggle">
            <i class="icon-edit"></i>
            <span class="menu-text"> 表单 </span>

            <b class="arrow icon-angle-down"></b>
        </a>

        <ul class="submenu">
            <li>
                <a href="form-elements.html">
                    <i class="icon-double-angle-right"></i>
                    表单组件
                </a>
            </li>

            <li>
                <a href="form-wizard.html">
                    <i class="icon-double-angle-right"></i>
                    向导提示 &amp; 验证
                </a>
            </li>

            <li>
                <a href="wysiwyg.html">
                    <i class="icon-double-angle-right"></i>
                    编辑器
                </a>
            </li>

            <li>
                <a href="dropzone.html">
                    <i class="icon-double-angle-right"></i>
                    文件上传
                </a>
            </li>
        </ul>
    </li>

    <li>
        <a href="widgets.html">
            <i class="icon-list-alt"></i>
            <span class="menu-text"> 插件 </span>
        </a>
    </li>

    <li>
        <a href="calendar.html">
            <i class="icon-calendar"></i>

            <span class="menu-text">
									日历
									<span class="badge badge-transparent tooltip-error" title="2&nbsp;Important&nbsp;Events">
										<i class="icon-warning-sign red bigger-130"></i>
									</span>
								</span>
        </a>
    </li>

    <li>
        <a href="gallery.html">
            <i class="icon-picture"></i>
            <span class="menu-text"> 相册 </span>
        </a>
    </li>

    <li>
        <a href="#" class="dropdown-toggle">
            <i class="icon-tag"></i>
            <span class="menu-text"> 更多页面 </span>

            <b class="arrow icon-angle-down"></b>
        </a>

        <ul class="submenu">
            <li>
                <a href="profile.html">
                    <i class="icon-double-angle-right"></i>
                    用户信息
                </a>
            </li>

            <li>
                <a href="inbox.html">
                    <i class="icon-double-angle-right"></i>
                    收件箱
                </a>
            </li>

            <li>
                <a href="pricing.html">
                    <i class="icon-double-angle-right"></i>
                    售价单
                </a>
            </li>

            <li>
                <a href="invoice.html">
                    <i class="icon-double-angle-right"></i>
                    购物车
                </a>
            </li>

            <li>
                <a href="timeline.html">
                    <i class="icon-double-angle-right"></i>
                    时间轴
                </a>
            </li>

            <li>
                <a href="login.html">
                    <i class="icon-double-angle-right"></i>
                    登录 &amp; 注册
                </a>
            </li>
        </ul>
    </li>

    <li>
        <a href="#" class="dropdown-toggle">
            <i class="icon-file-alt"></i>

            <span class="menu-text">
									其他页面
									<span class="badge badge-primary ">5</span>
								</span>

            <b class="arrow icon-angle-down"></b>
        </a>

        <ul class="submenu">
            <li>
                <a href="faq.html">
                    <i class="icon-double-angle-right"></i>
                    帮助
                </a>
            </li>

            <li>
                <a href="error-404.html">
                    <i class="icon-double-angle-right"></i>
                    404错误页面
                </a>
            </li>

            <li>
                <a href="error-500.html">
                    <i class="icon-double-angle-right"></i>
                    500错误页面
                </a>
            </li>

            <li>
                <a href="grid.html">
                    <i class="icon-double-angle-right"></i>
                    网格
                </a>
            </li>

            <li>
                <a href="blank.html">
                    <i class="icon-double-angle-right"></i>
                    空白页面
                </a>
            </li>
        </ul>
    </li>
</ul><!-- /.nav-list -->
