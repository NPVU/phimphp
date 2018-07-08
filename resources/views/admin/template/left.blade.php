<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel" style="min-height:60px">
            <div class="pull-left image">
                <a href="#" data-izimodal-open="#modal-avatar">
                    <img src="{{ Auth::user()->avatar }}" class="avatar img-circle" alt="User Image" style="background: white">
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
            <li>
                <a href="{{ url('/quan-ly/') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>                    
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
                        <a href="{{ url('/quan-ly/danh-muc/san-pham/') }}">
                            <i class="fa fa-circle-o"></i> Danh mục sản phẩm
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/quan-ly/danh-muc/khach-hang/') }}">
                            <i class="fa fa-circle-o"></i> Danh mục khách hàng
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Quản lý nhân công</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/quan-ly/nhan-cong/nhan-vien/') }}"><i class="fa fa-circle-o"></i> Nhân viên</a></li>
                    <li><a href="{{ url('/quan-ly/cham-cong/cham-cong/') }}"><i class="fa fa-circle-o"></i> Chấm công</a></li>
                    <li><a href="{{ url('/quan-ly/nhan-cong/luong/') }}"><i class="fa fa-circle-o"></i> Lương</a></li>                   
                </ul>
            </li>
            <li>
                <a href="{{ url('/quan-ly/san-pham/') }}">
                    <i class="fa fa-cubes"></i>
                    <span>Quản lý sản phẩm</span>                    
                </a>                
            </li> 
            <li>
                <a href="{{ url('/quan-ly/chi-tieu/') }}">
                    <i class="fa fa-dollar"></i>
                    <span>Quản lý chi tiêu</span>                    
                </a>                
            </li>
            <li>
                <a href="{{ url('/quan-ly/cau-hinh/') }}">
                    <i class="fa fa-gears"></i>
                    <span>Cấu hình hệ thống</span>                    
                </a>                
            </li>
            
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>