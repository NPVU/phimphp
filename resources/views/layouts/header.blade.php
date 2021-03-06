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
                            <img src="{{asset('img/themes/logo-2.png')}}" width="100"/>
                            
                        </a>
                        <div class="search-addon search-mobile" style="max-width:unset">
                                <div class="input-group" style="padding:8px 10px;">
                                    <span class="input-group-addon btn-search"><span class="glyphicon glyphicon-search"></span></span>
                                    <input type="text" class="form-control input-search" placeholder="Nhập tên phim..." aria-describedby="sizing-addon2">
                                </div>
                                <div class="result-search">
                                    
                                </div>
                        </div>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">                 
                            <li><a href="/xem-nhieu">Xem Nhiều</a></li>
                            <li><a href="/tv-series">TV Series</a></li>   
                            <li><a href="/movie">Movie</a></li>                        
                            <li class="dropdown">
                                <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Quốc Gia <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php 
                                    $listQuocGia = DB::table('quocgia')->orderBy('quocgia_ten')->get(); 
                                    ?>                                   
                                    @foreach($listQuocGia as $quocgia)
                                    <li><a href="/quoc-gia/{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($quocgia->quocgia_ten)))).'-'.$quocgia->quocgia_id}}">{{$quocgia->quocgia_ten}}</a></li>                                    
                                    @endforeach                                    
                                    
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Thể Loại <span class="caret"></span></a>
                                <ul class="dropdown-menu" style="min-width:500px">
                                    <?php 
                                    $listTheLoai = DB::table('theloai')->orderBy('theloai_ten')->get(); 
                                    ?>                                     
                                    @foreach($listTheLoai as $theloai)
                                    <li style="float:left;width:120px"><a href="/the-loai/{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($theloai->theloai_ten)))).'-'.$theloai->theloai_id}}">{{$theloai->theloai_ten}}</a></li>                                    
                                    @endforeach                                    
                                </ul>
                            </li>                                                                 
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="search-addon seach-pc">
                                <div class="input-group" style="padding:10px 10px; min-width: 300px;">
                                    <span class="input-group-addon btn-search"><span class="glyphicon glyphicon-search"></span></span>
                                    <input type="text" class="form-control input-search" placeholder="Nhập tên phim..." aria-describedby="sizing-addon2">
                                </div>
                                <div class="result-search">
                                    
                                </div>
                            </li>
                            <!--
                            @guest
                            <li><a href="{{route('login')}}">Đăng nhập</a></li>
                            <li><a href="{{route('register')}}">Đăng ký</a></li>
                            @else
                            @if(!empty($notification))
                            <li data-izimodal-open="#user-notification">
                                <a href="javascript:void(0)">
                                    <i class="fa fa-bell" style="font-size:1.5em">
                                        @if(count($notification)>0)
                                        <sup class="notify-message">{{count($notification)}}</sup>
                                        @endif
                                    </i>
                                </a>
                            </li>
                            @endif
                            <li class="open-popup-user" onclick="$('.npv-user').toggle('fast');">
                                <a href="javascript:void(0)" style="margin:5px 5px;width:45px; height:45px; border-radius:100%; text-align:center; background-color:gray;">
                                    <i class="glyphicon glyphicon-user"></i>
                                </a>                        
                            </li>                            
                            @endguest
                            -->
                        </ul>
                    </div>
                </div>
            </nav>    
        </div>
    </div>