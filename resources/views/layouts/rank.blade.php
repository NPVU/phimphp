				<div class="content-right-section">
                    <h4 class="content-right-title">BẢNG XẾP HẠNG TUẦN</h4>
                    <ul class="list-anime">
                        @if(count($phimXepHangTuan) > 0)
                        @foreach($phimXepHangTuan as $tuan)
                        <a href="{{URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($tuan->phim_ten)))).'/?pid='.$tuan->phim_id.'&t=1&s='.md5('google')}}"><li>
                            <div class="" style="float:left;">
                                <img src="{{$tuan->phim_hinhnen}}" width="50" height="60" style="border-radius:3px;"/>                                
                            </div>
                            <div style="float:left;padding-left:10px;">
                                <div>{{strlen($tuan->phim_ten)>24?substr($tuan->phim_ten,0,24).'...':$tuan->phim_ten}}</div>
                                <div><span class="glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp; {{number_format($tuan->phim_luotxem)}}</div>
                                <div>
                                    <?php 
                                        $star = ClassCommon::getStar($tuan->phim_id); 
                                        for($i = 1; $i <= 5; $i++){
                                            if($i <= intval($star)){
                                                echo '<span class="fa fa-star star star-color"></span>';
                                            } else if($i > $star && ($i-1) < $star){
                                                echo '<span class="fa fa-star-half-alt star star-half-color"></span>';
                                            } else {
                                                echo '<span class="fa fa-star star"></span>';
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </li></a>
                        @endforeach  
                        @else
                        <i class="text-center"><p>Chưa có dữ liệu</p></i>
                        @endif
                    </ul>
                </div>

                <div class="content-right-section">
                    <h4 class="content-right-title">BẢNG XẾP HẠNG THÁNG</h4>
                    <ul class="list-anime">
                        @if(count($phimXepHangTuan) > 0)
                        @foreach($phimXepHangThang as $thang)
                        <a href="{{URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($thang->phim_ten)))).'/?pid='.$thang->phim_id.'&t=1&s='.md5('google')}}"><li>
                            <div class="" style="float:left;">
                                <img src="{{$thang->phim_hinhnen}}" width="50" height="60" style="border-radius:3px;"/>                                
                            </div>
                            <div style="float:left;padding-left:10px;">
                                <div>{{strlen($thang->phim_ten)>24?substr($thang->phim_ten,0,24).'...':$thang->phim_ten}}</div>
                                <div><span class="glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp; {{number_format($thang->phim_luotxem)}}</div>
                                <div>
                                    <?php 
                                        $star = ClassCommon::getStar($thang->phim_id); 
                                        for($i = 1; $i <= 5; $i++){
                                            if($i <= intval($star)){
                                                echo '<span class="fa fa-star star star-color"></span>';
                                            } else if($i > $star && ($i-1) < $star){
                                                echo '<span class="fa fa-star-half-alt star star-half-color"></span>';
                                            } else {
                                                echo '<span class="fa fa-star star"></span>';
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </li></a>
                        @endforeach  
                        @else
                        <i class="text-center"><p>Chưa có dữ liệu</p></i>
                        @endif                      
                    </ul>
                </div>