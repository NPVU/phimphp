@extends('layouts.app') 
@section('title') 
    Thể Loại &nbsp;-&nbsp;{{$theloai[0]->theloai_ten}} 
@endsection 
@section('contentLeft')
<div class="content-left-section" >
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">THỂ LOẠI</h2>
    </div>
        <div>
        @if(count($listPhimTheloai) > 0)
            @foreach($listPhimTheloai as $row)
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                    <a class="click-loading" href="{{URL::to('/xem-phim').'/'.strtolower(str_replace('/','-',str_replace(' ', '-',ClassCommon::removeVietnamese($row->phim_ten)))).'/?pid='.$row->phim_id.'&t=1&s='.md5('google')}}" data-toggle="modal" data-target="">
                        <div class="box-phim">
                            <div class="box-image">
                                <img src="{{$row->phim_hinhnen}}">
                            </div>
                            <div class="box-overlay-rich"></div>
                            <div class="box-info">
                                <div class="box-title">{{$row->phim_ten}}</div>
                                <div class="box-text">{{$theloai[0]->theloai_ten}}</div>
                            </div>
                        </div>
                        <div class="phim-tip">
                            <div class="phim-tip-content">
                            <div class="phim-tip-ten">{{$row->phim_ten}}</div>
                            <div class="phim-tip-underten">
                                <span class="glyphicon glyphicon-time"></span>&nbsp;<span class="title">Season</span>&nbsp; {{$row->phim_season}}
                                <span style="float:right">
                                    <span class="glyphicon glyphicon-calendar"></span>&nbsp;<span class="title">Năm</span>&nbsp; {{$row->phim_nam}}
                                    <span></span>
                                </span>
                            </div>
                            <div class="phim-tip-noidung">
                                @if(is_null($row->phim_gioithieu))
                                    Đang cập nhật ...
                                @else
                                {{strlen($row->phim_gioithieu)>255?substr($row->phim_gioithieu,0,strrpos(substr($row->phim_gioithieu,0,255),' ')).' ...':$row->phim_gioithieu}}
                                @endif                            
                            </div>
                            <div class="phim-tip-underten">
                                <span class="glyphicon glyphicon-tasks"></span>&nbsp;<span class="title">Thể loại:</span> 
                                        {{$row->listTheLoai}}
                            </div>
                            <div class="phim-tip-underten">
                                <span class="glyphicon glyphicon-list"></span>&nbsp;<span class="title">Số tập:</span> {{$row->phim_sotap}}
                            </div>
                            <div class="phim-tip-underten">
                                <span class="glyphicon glyphicon-expand"></span>&nbsp;<span class="title">Dạng:</span> {{$row->phim_kieu}}
                            </div>
                            <div class="phim-tip-underten">
                                <span class="glyphicon glyphicon-globe"></span>&nbsp;<span class="title">Quốc gia:</span> {{$row->quocgia_ten}}
                            </div>
                            <div class="phim-tip-underten">
                                <span class="glyphicon glyphicon-eye-open"></span>&nbsp;<span class="title">Lượt xem:</span> {{$row->phim_luotxem}}
                            </div>
                            <div class="phim-tip-underten">
                                <span class="glyphicon glyphicon-star"></span>&nbsp;<span class="title">Đánh giá:</span> 
                                <?php
                                    $star = ClassCommon::getStar($row->phim_id); 
                                    for($i = 1; $i <= 5; $i++){
                                        if($i <= intval($star)){
                                            echo '<span class="glyphicon fa fa-star star star-color"></span>';
                                        } else if($i > $star && ($i-1) < $star){
                                            echo '<span class="glyphicon fa fa-star-half-alt star star-half-color"></span>';
                                        } else {
                                            echo '<span class="fa fa-star star"></span>';
                                        }
                                    }   
                                ?>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                {{$listPhimTheloai->links()}}
            </div>
        @else
            <div class="text-center"><i style="color:gray">Không tìm thấy phim của thể loại <b>{{$theloai[0]->theloai_ten}}</b></i></div>
        @endif
    </div>
</div>
@endsection 
@section('contentRight') 
    @include('layouts.rank_min') 
@endsection 