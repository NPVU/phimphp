@extends('layouts.app') 
@section('title') 
    Quốc Gia &nbsp;-&nbsp;{{$quocgia[0]->quocgia_ten}} 
@endsection 
@section('contentLeft')
<div class="content-left-section" >
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">QUỐC GIA&nbsp;-&nbsp;{{$quocgia[0]->quocgia_ten}} </h2>
    </div>
        <div>
        @if(count($listPhimQuocGia) > 0)
            @foreach($listPhimQuocGia as $row)
                @include('layouts.boxphim_min')
            @endforeach
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                {{$listPhimQuocGia->links()}}
            </div>
        @else
            <div class="text-center"><i style="color:gray">Không tìm thấy phim của quốc gia <b>{{$quocgia[0]->quocgia_ten}}</b></i></div>
        @endif
    </div>
</div>
@endsection 
@section('contentRight') 
    @include('layouts.rank_min') 
@endsection 