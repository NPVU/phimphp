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
                                    <a href="#" data-toggle="modal" data-target="#myModal">Xem ngay</a>
                                </div>
                                <div class="bannergrids">
                                    <div class="col-md-4">
                                        <div class="grid1">
                                            <i class="fa fa-truck" aria-hidden="true"></i>
                                            <p>lorem ipsum dolor sit amet consectetur adipiscing</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="grid1">
                                            <i class="fa fa-ship" aria-hidden="true"></i>
                                            <p>lorem ipsum dolor sit amet consectetur adipiscing</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="grid1">
                                            <i class="fa fa-bus" aria-hidden="true"></i>
                                            <p>lorem ipsum dolor sit amet consectetur adipiscing</p>
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