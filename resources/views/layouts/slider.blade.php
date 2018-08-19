<section class="slider">
    <div class="callbacks_container">
        <ul class="rslides" id="slider">
            <?php $index = 0; ?>
            @foreach($listPhimToday as $phim)
            <?php $index++; ?>
            <li>
                <div class="w3layouts-banner-top w3layouts-banner-top{{$index}}" style="background: url({{$phim->phim_hinhnen}}) no-repeat 0px 0px;background-size: 100%;">
                    <div class="banner-dott">
                        <div class="container">
                            <div class="slider-info">
                                <h2 style="display:inline;">{{$phim->tap[0]->tap_tapsohienthi}}</h2>                                
                                <h4>{{$phim->phim_ten}}</h4>
                                <div class="w3ls-button">
                                    <a class="click-loading" href="{{url('xem-phim')}}/{{strtolower(str_replace(' ', '-',ClassCommon::removeVietnamese($phim->phim_ten)))}}/?pid={{$phim->phim_id}}&t={{$phim->tap[0]->tap_tapso}}&s={{md5('google')}}&token={{csrf_token()}}" data-toggle="modal" data-target="">
                                        Xem ngay
                                    </a>
                                </div>
                                <div class="bannergrids">
                                    <div class="col-md-4">
                                        <div class="grid1">
                                            <i class="fa fa-star" aria-hidden="true"> đánh giá</i> 
                                            <p>                                                
                                                <?php for($i = 1; $i <= 5; $i++): ?>
                                                    @if($i <= intval($phim->star))
                                                        <span class="fa fa-star"></span>
                                                    @elseif($i > $phim->star && ($i-1) < $phim->star)
                                                        <span class="fa fa-star-half-full"></span>
                                                    @else
                                                        <span class="fa fa-star-o"></span>
                                                    @endif
                                                <?php endfor; ?>  
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="grid1">
                                            <i class="fa fa-play-circle" aria-hidden="true"> số tập</i>
                                            <p>{{$phim->tap[0]->tap_tapso}}/{{$phim->phim_sotap}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="grid1">
                                            <i class="fa fa-eye" aria-hidden="true"> lượt xem</i>
                                            <p class="view-slider-{{$phim->phim_id}}">{{number_format($phim->phim_luotxem)}}</p>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>   
            @endforeach
        </ul>
    </div>
    <div class="clearfix"></div>        
</section>
<script>
    $(function () {
        $("#slider").responsiveSlides({
            auto: true,
            pager: false,
            nav: true,
            speed: 1000,
            namespace: "callbacks",
            before: function () {
                $('.events').append("<li>before event fired.</li>");
            },
            after: function () {
                $('.events').append("<li>after event fired.</li>");
            }
        });
    });
</script>