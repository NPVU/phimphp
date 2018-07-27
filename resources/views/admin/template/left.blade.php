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
                @if(count(explode('100',Auth::user()->getRoles())) > 1)
                <li>
                    <a href="{{ url('/quan-ly/') }}">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>                    
                    </a>                
                </li>
                @endif
                @if(count(explode('100',Auth::user()->getRoles())) > 1 || count(explode('200',Auth::user()->getRoles())) > 1)
                <li>
                    <a href="{{ url('/quan-ly/tai-khoan/') }}">
                        <i class="fa fa-users"></i>
                        <span>Quản lý tài khoản</span>                    
                    </a>                
                </li>
                @endif
                @if(count(explode('100',Auth::user()->getRoles())) > 1 || count(explode('300',Auth::user()->getRoles())) > 1)
                <li>
                    <a href="{{ url('/quan-ly/phim/') }}">
                        <i class="fa fa-film"></i>
                        <span>Quản lý phim</span>                    
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
                @if(count(explode('100',Auth::user()->getRoles())) > 1)
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