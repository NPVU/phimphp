    <div class="container">
        <div class="content col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="content-left col-xs-12 col-sm-12 col-md-8 col-lg-9">
                @yield('contentLeft')                
            </div>

            <div class="content-right col-xs-12 col-sm-12 col-md-4 col-lg-3">                
                <div class="content-right-section">
                    <h4 class="content-right-title">BẢNG XẾP HẠNG TUẦN</h4>
                    <ul class="list-anime">
                        @foreach($phimXepHangTuan as $tuan)
                        <li><a href="{{URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($tuan->phim_ten)))).'/?pid='.$tuan->phim_id.'&t=1&s='.md5('google')}}">
                            <div class="" style="float:left;">
                                <img src="{{$tuan->phim_hinhnen}}" width="50" height="60" style="border-radius:3px;"/>                                
                            </div>
                            <div style="float:left;padding-left:10px;">
                                <div>{{strlen($tuan->phim_ten)>24?substr($tuan->phim_ten,0,24).'...':$tuan->phim_ten}}</div>
                                <div><span class="glyphicon glyphicon-eye-open"></span> {{ClassCommon::formatLuotXem($tuan->phim_luotxem)}}</div>
                                <div>
                                    <?php 
                                        $star = ClassCommon::getStar($tuan->phim_id); 
                                        for($i = 1; $i <= 5; $i++){
                                            if($i <= intval($star)){
                                                echo '<span class="glyphicon glyphicon-star star star-color"></span>';
                                            } else if($i > $star && ($i-1) < $star){
                                                echo '<span class="glyphicon glyphicon-star-half-full star star-half-color"></span>';
                                            } else {
                                                echo '<span class="glyphicon glyphicon-star-o star"></span>';
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </a></li>
                        @endforeach                        
                    </ul>
                </div>

                <div class="content-right-section">
                    <h4 class="content-right-title">BẢNG XẾP HẠNG THÁNG</h4>
                    <ul class="list-anime">
                        @foreach($phimXepHangThang as $thang)
                        <li><a href="{{URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($thang->phim_ten)))).'/?pid='.$thang->phim_id.'&t=1&s='.md5('google')}}">
                            <div class="" style="float:left;">
                                <img src="{{$thang->phim_hinhnen}}" width="50" height="60" style="border-radius:3px;"/>                                
                            </div>
                            <div style="float:left;padding-left:10px;">
                                <div>{{strlen($thang->phim_ten)>24?substr($thang->phim_ten,0,24).'...':$thang->phim_ten}}</div>
                                <div><span class="glyphicon glyphicon-eye-open"></span> {{ClassCommon::formatLuotXem($thang->phim_luotxem)}}</div>
                                <div>
                                    <?php 
                                        $star = ClassCommon::getStar($thang->phim_id); 
                                        for($i = 1; $i <= 5; $i++){
                                            if($i <= intval($star)){
                                                echo '<span class="glyphicon glyphicon-star star star-color"></span>';
                                            } else if($i > $star && ($i-1) < $star){
                                                echo '<span class="glyphicon glyphicon-star-half-full star star-half-color"></span>';
                                            } else {
                                                echo '<span class="glyphicon glyphicon-star-o star"></span>';
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </a></li>
                        @endforeach                        
                    </ul>
                </div>
            </div>
        </div>
    </div>