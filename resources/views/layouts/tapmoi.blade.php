<section class="npv-tapmoi">
    <div id="tapmoi">        
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 listTapMoi">
            <span class="tapmoi-page-1">
                <?php echo $htmlTapMoi ?>     
            </span>
            <span class="tapmoi-page-2"></span>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <i onclick="xt()" aria-page="2" class="xttm npv-icon-xemthem fa fa-2x fa-angle-double-down" data-toggle="tooltip" title="Xem thêm"></i>
        </div>
    </div>   
    <script>
        function xt(){
                var page = $('.xttm').attr('aria-page');
                $.ajax({
                        url: '{{url("/tap-moi/")}}?page='+page,
                        dataType: 'text',                    
                        type: 'get',                    
                        success: function (data) {
                            console.log(data);  
                            $('.tapmoi-page-'+page).html(data);
                            var nextPage = parseInt(page)+1;
                            $('.xttm').attr('aria-page', nextPage);
                            var newPage = document.createElement('span');
                            newPage.className = 'tapmoi-page-'+nextPage;
                            $('.listTapMoi').append(newPage);
                        }
                });
            }
        $('#tapmoi').iziModal({
            title: 'Tập Mới',        
            overlayClose: true,                        
            openFullscreen:true,
            bodyOverflow:true,
            headerColor: 'rgb(56, 98, 111)',
            icon: 'fa fa-list',
            iconColor: 'white'
        });
    </script>
</section>
