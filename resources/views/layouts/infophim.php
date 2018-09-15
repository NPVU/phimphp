            <div id="modal-info-phim" data-izimodal-transitionin="comingInDown">
                <div class="modal-body" style="padding-bottom: 20px">        
                    <div class="row">                
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center">
                                <img src="{{$phim[0]->phim_hinhanh}}" width="100%" style="max-width:300px"/>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                <div class="text-center">
                                    <strong style="color: lightseagreen;font-size: 1.5em;">
                                        {{$phim[0]->phim_ten}}
                                    </strong>                            
                                </div>
                                <div>
                                    <ul style="list-style: none;padding-left: 0px;">      
                                        <li>
                                            <label>Season:</label>
                                            <span>{{$phim[0]->phim_season}}</span>
                                        </li>
                                        <li>
                                            <label>Thể loại:</label>
                                            <span>
                                                <?php
                                                    for($i = 0; $i < count($listTheLoaiPhim); $i++){
                                                        echo $listTheLoaiPhim[$i]->theloai_ten;
                                                        echo $i+1<count($listTheLoaiPhim)?', ':'.';
                                                    }
                                                ?>                                        
                                            </span>
                                        </li>
                                        <li>
                                            <label>Số tập:</label>
                                            <span>{{$phim[0]->phim_sotap}}</span>
                                        </li>
                                        <li>
                                            <label>Năm phát hành:</label>
                                            <span>{{$phim[0]->phim_nam}}</span>
                                        </li>                                
                                        <li>
                                            <label>Lượt xem:</label>
                                            <span class="npv-modal-view-times modal-view-{{$phim[0]->phim_id}}">{{number_format($phim[0]->phim_luotxem)}}</span>
                                        </li>
                                        <li>
                                            <label>Đánh giá:</label>                                    
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                @if($i <= intval($star))
                                                    <span class="fa fa-star star star-color"></span>
                                                @elseif($i > $star && ($i-1) < $star)
                                                    <span class="fa fa-star-half-alt star star-half-color"></span>
                                                @else
                                                    <span class="fa fa-star star"></span>
                                                @endif
                                            <?php endfor; ?>                                    
                                        </li>                                                                
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <ul style="list-style: none;padding-left: 0px;">                            
                                    <li>
                                        <label>Nguồn video:</label>
                                        <span>{{$phim[0]->phim_nguon}}</span>
                                    </li>
                                    <li>
                                        <label>Tóm tắt nội dung:</label>
                                        <span>{{empty($phim[0]->phim_gioithieu)?'đang cập nhật':$phim[0]->phim_gioithieu}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>               
                    </div>            
                </div>
            </div>
            <script>
                $('#modal-info-phim').iziModal({
                    title: 'Thông tin phim',
                    top: 100,
                    overlayClose: true,                
                    width: 600,
                    openFullscreen:false,
                    headerColor: '#263238',
                    icon: 'fa fa-info-circle',
                    iconColor: 'white'
                }); 
            </script>