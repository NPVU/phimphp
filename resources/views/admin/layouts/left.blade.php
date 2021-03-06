<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel" style="min-height:60px">
            <div class="pull-left image">
                <a href="#" data-izimodal-open="#modal-avatar">
                    <img src="{{ asset((Auth::user()->avatar)) }}" class="avatar img-circle" alt="User Image" style="background: white">
                </a>
            </div>
            <div class="pull-left info">
                <p><a href="#" data-izimodal-open="#modal-name" class="displayUserName">{{ Auth::user()->name }}</a></p>
                
                <span style="font-size:10px"><i class="fa fa-circle text-success"></i> Online</span>
            </div>
        </div>
        
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="header">BẢNG ĐIỀU KHIỂN</li>            
                @if(count(explode(RoleUtils::getRoleSuperAdmin(),Auth::user()->getRoles())) > 1)
                <li>
                    <a href="{{ url('/quan-ly/') }}">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>                    
                    </a>                
                </li>
                @endif
                @if(count(explode(RoleUtils::getRoleSuperAdmin(),Auth::user()->getRoles())) > 1 || count(explode(RoleUtils::getRoleAdminUser(),Auth::user()->getRoles())) > 1)
                <li>
                    <a href="{{ url('/quan-ly/truy-cap/') }}">
                        <i class="fa fa-link"></i>
                        <span>Quản lý truy cập</span>      
                        <span class="pull-right-container">
                            <small class="label pull-right bg-primary"></small>
                        </span>              
                    </a>                
                </li>
                <li>
                    <a href="{{ url('/quan-ly/tai-khoan/') }}">
                        <i class="fa fa-users"></i>
                        <span>Quản lý tài khoản</span>                    
                        <span class="pull-right-container">
                            <small class="label pull-right bg-primary">{{ClassCommon::countUser()}}</small>
                        </span>  
                    </a>                
                </li>                       
                @endif
                @if(count(explode(RoleUtils::getRoleSuperAdmin(),Auth::user()->getRoles())) > 1 || count(explode(RoleUtils::getRoleAdminPhim(),Auth::user()->getRoles())) > 1)
                <li>
                    <a href="{{ url('/quan-ly/phim/') }}">
                        <i class="fa fa-film"></i>
                        <span>Quản lý phim</span>      
                        <span class="pull-right-container">
                            <small class="label pull-right bg-primary">{{ClassCommon::countPhim()}}</small>
                        </span>              
                    </a>                
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-list"></i> 
                        <span>Quản lý danh mục</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{ url('/quan-ly/danh-muc/the-loai/') }}">
                                <i class="fa fa-circle-o"></i> Thể loại
                            </a>
                        </li>                    
                    </ul>
                </li>
                @endif
                @if(count(explode(RoleUtils::getRoleSuperAdmin(),Auth::user()->getRoles())) > 1)
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-share"></i> 
                        <span>Hỗ trợ</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                            <small class="label pull-right bg-green">{{ClassCommon::countYeuCauPhim()}}</small>
                            <small class="label pull-right bg-red">{{ClassCommon::countReportError()}}</small>                            
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{ url('/quan-ly/ho-tro/bao-loi') }}">
                                <i class="fa fa-exclamation-circle"></i>
                                <span>Báo lỗi</span>                    
                            </a>                
                        </li>
                        <li>
                            <a href="{{ url('/quan-ly/ho-tro/yeu-cau-phim') }}">
                                <i class="fa fa-gift"></i>
                                <span>Yêu cầu phim</span>                    
                            </a>                
                        </li>                    
                    </ul>
                </li>                
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-gears"></i> 
                        <span>Cấu hình</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{ url('/quan-ly/cau-hinh/he-thong') }}">
                                <i class="fa fa-gear"></i>
                                <span>Hệ thống</span>                    
                            </a>                
                        </li>                    
                    </ul>
                </li>
                @endif                                                         
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>