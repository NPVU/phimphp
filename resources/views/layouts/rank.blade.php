            <div class="content-right-section" style="background: none;padding: 0px;margin: 0px;">               
                <div align="center">
                    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <script> (adsbygoogle = window.adsbygoogle || []).push({
                    google_ad_client: "ca-pub-2839502508878727",
                    enable_page_level_ads: true
                    });
                    </script>
                </div>
            </div>
            <div class="content-right-section">
                    <h4 class="content-right-title">BẢNG XẾP HẠNG TUẦN</h4>
                    <ul class="list-anime">
                        @if(count($phimXepHangTuan) > 0)
                        @foreach($phimXepHangTuan as $tuan)
                        <a title="{{$tuan->phim_ten}}&nbsp;{{strlen($tuan->phim_tenvn)>0?'| '.$tuan->phim_tenvn:''}}" href="/xem-phim/{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($tuan->phim_ten)))).'/'.$tuan->tap_id.'.html'}}"><li>
                            <div class="" style="float:left;">
                                <img class="lazy" src="{{($tuan->phim_thumb!=null?$tuan->phim_thumb:$tuan->phim_hinhnen)}}" style="border-radius:3px;"/>                                
                            </div>
                            <div style="float:left;padding-left:10px;">
                                <div class="title" style="font-weight: 600;color: #ffc355;">{{$tuan->phim_ten}}</div>
                                @if(strlen($tuan->phim_tenvn)>0)
                                <div class="title title-vn">{{$tuan->phim_tenvn}}</div>               
                                @endif
                                <div style="font-size:0.8em"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp; {{number_format($tuan->phim_luotxem)}}</div>
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
                        @if(count($phimXepHangThang) > 0)
                        @foreach($phimXepHangThang as $thang)
                        <a title="{{$thang->phim_ten}}&nbsp;{{strlen($thang->phim_tenvn)>0?'| '.$thang->phim_tenvn:''}}" href="/xem-phim/{{strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($thang->phim_ten)))).'/'.$thang->tap_id.'.html'}}"><li>
                            <div class="" style="float:left;">
                                <img class="lazy" src="{{($thang->phim_thumb!=null?$thang->phim_thumb:$thang->phim_hinhnen)}}" style="border-radius:3px;"/>                                
                            </div>
                            <div style="float:left;padding-left:10px;">
                                <div class="title" style="font-weight: 600;color: #ffc355;">{{$thang->phim_ten}}</div>
                                @if(strlen($thang->phim_tenvn)>0)
                                <div class="title title-vn">{{$thang->phim_tenvn}}</div>               
                                @endif
                                <div style="font-size:0.8em"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp; {{number_format($thang->phim_luotxem)}}</div>
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