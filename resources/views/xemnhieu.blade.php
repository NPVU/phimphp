@extends('layouts.app') 
@section('title') 
    Phim Xem Nhiều 
@endsection 
@section('contentLeft')
<div class="content-left-section" >
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2 class="content-left-title">Xem Nhiều</h2>
    </div>
    <div>
            @foreach($listPhimXemNhieu as $row)
                @include('layouts.boxphim_min')
            @endforeach
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                {{$listPhimXemNhieu->links()}}
            </div>
    </div>
</div>
@endsection 
@section('contentRight') 
    @include('layouts.rank_min') 
@endsection 