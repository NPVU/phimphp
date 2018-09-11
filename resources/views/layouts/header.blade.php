    <div class="header">
        <div class="container">            
            <nav class="navbar" style="margin-bottom: unset">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="{{url('/')}}">
                            <img src="{{asset('public/img/themes/logo-2.png')}}" width="100"/>
                            
                        </a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">                          
                            <li><a href="{{URL::to('xem-nhieu')}}">XEM NHIỀU</a></li>
                            <li class="dropdown">
                                <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Quốc gia <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    @foreach($listQuocGia as $quocgia)
                                    <li><a href="{{URL::to('/quoc-gia').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($quocgia->quocgia_ten)))).'-'.$quocgia->quocgia_id}}">{{$quocgia->quocgia_ten}}</a></li>                                    
                                    @endforeach
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Thể loại <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    @foreach($listTheLoai as $theloai)
                                    <li><a href="{{URL::to('/the-loai').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($theloai->theloai_ten)))).'-'.$theloai->theloai_id}}">{{$theloai->theloai_ten}}</a></li>                                    
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="search-addon">
                                <div class="input-group" style="padding:10px 10px;">
                                    <span class="input-group-addon btn-search" id="btn-search"><span class="glyphicon glyphicon-search"></span></span>
                                    <input type="text" class="form-control input-search" id="input-search" placeholder="Nhập tên phim..." aria-describedby="sizing-addon2">
                                </div>
                                <div class="result-search">
                                    
                                </div>
                            </li>
                            @guest
                            <li><a href="{{route('login')}}">Đăng nhập</a></li>
                            <li><a href="{{route('register')}}">Đăng ký</a></li>
                            @else
                            <li class="open-popup-user" onclick="$('.npv-user').toggle('fast');">
                                <a href="javascript:void(0)" style="margin:5px 5px;width:45px; height:45px; border-radius:100%; text-align:center; background-color:gray;">
                                    <i class="glyphicon glyphicon-user"></i>
                                </a>                        
                            </li>
                            <!--<li>
                                <a href="javascript:void(0)"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                    Thoát
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>-->
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>    
        </div>
    </div>