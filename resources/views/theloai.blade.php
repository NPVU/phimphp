@extends('layouts.app') 
@section('title') 
    Thể Loại &nbsp;-&nbsp;{{$theloai[0]->theloai_ten}} 
@endsection 
@section('contentLeft')
<div class="content-left-section" >
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">THỂ LOẠI&nbsp;-&nbsp;{{$theloai[0]->theloai_ten}} </h2>
    </div>
        <div>
        @if(count($listPhimTheloai) > 0)
            @foreach($listPhimTheloai as $row)
                @include('layouts.boxphim_min')
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