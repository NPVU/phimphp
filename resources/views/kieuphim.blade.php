@extends('layouts.app') 
@section('title') 
    {{$kieuphim}} 
@endsection 
@section('contentLeft')
<div class="content-left-section" >
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">{{$kieuphim}}</h2>
    </div>
        <div>
        @if(count($listPhim) > 0)
            @foreach($listPhim as $row)
                @include('layouts.boxphim_min')
            @endforeach
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                {{$listPhim->links()}}
            </div>
        @else
            <div class="text-center"><i style="color:gray">Không tìm thấy phim thuộc loại <b>{{$kieuphim}}</b></i></div>
        @endif
    </div>
</div>
@endsection 
@section('contentRight') 
    @include('layouts.rank_min') 
@endsection 