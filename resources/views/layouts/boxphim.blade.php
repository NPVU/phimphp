<div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
    <a data-template="phim-{{$row->phim_id}}" class="click-loading ttip" href="{{URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($row->phim_ten)))).'/'.$row->tap_id.'.html'}}" data-toggle="modal" data-target="">
        <div class="box-phim">
            <div class="box-image">
                <img class="lazy" data-src="{{$row->phim_thumb!=null?$row->phim_thumb:$row->phim_hinhnen}}">
            </div>
            <div class="box-overlay-rich"></div>
            <div class="box-info">
                <div class="box-title">
                    <div>{{$row->phim_ten}}</div>
                    <div class="title-vn">{{$row->phim_tenvn}}</div>
                </div>
                <div class="box-text">@if(!empty($row->tap[0])) {{$row->tap[0]->tap_tapso.'/'}} @else 0.'/' @endif {{$row->phim_sotap}}</div>
            </div>
        </div>
        <div id="phim-{{$row->phim_id}}">
            <div class="phim-tip-content">
                <div class="tip ten-phim ten-phim-chinh">{{$row->phim_ten}}</div>
                    <div class="tip ten-phim ten-phim-phu">{{$row->phim_tenkhac}}</div>
                    <div class="tip ten-phim ten-phim-tieng-viet">{{$row->phim_tenvn}}</div>
                    <div class="tip the-loai" style="margin-top:10px;"><span class="tip-title">Thể loại:</span>
                            {{$row->listTheLoai}}
                    </div>     
                    <div class="tip so-tap"><span class="tip-title">Số tập:</span> {{$row->phim_sotap}}</div>
                    <div class="tip nam"><span class="tip-title">Năm:</span> {{$row->phim_nam}}</div>                                
                    <div class="tip luot-xem"><span class="tip-title">Tổng lượt xem:</span> {{number_format($row->phim_luotxem)}}</div>
                    <div class="tip noi-dung">{{$row->phim_gioithieu}}</div>
            </div>
        </div>        
    </a>
</div>
@section('metaCEO')
<meta property="og:title" content="XEM PHIM ONLINE MIỄN PHÍ | XEM PHIM KHÔNG QUẢNG CÁO | XEMPHIMZERO.COM" />
<meta property="og:description" content="Xem Phim Anime Vietsub Online, Xem phim anime, Anime Hành động, Anime Download, Anime HD, Anime Vietsub Online" /> 
<meta name="keywords" content="Xem Phim Online Miễn Phí | Xem Phim Không Quảng Cáo | XEMPHIMZERO.COM" />
<meta name="description" content="Xem Phim Online Miễn Phí | Xem Phim Không Quảng Cáo | XEMPHIMZERO.COM" />
@endsection 