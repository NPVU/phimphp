<section class="npv-nam">
    <div id="nam">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">
            @foreach($listNam as $row)
                <a href="#" onclick="loadNam({{$row->nam}})" class="btn btn-primary nam nam-{{$row->nam}}" style="min-width: 100px;margin-bottom: 5px;">
                    <span>{{$row->nam}}</span>
                </a>  
            @endforeach                                        
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 listPhimNam">
            <span class="nam-page-1">
                     
            </span>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <i onclick="xtn()" aria-page="2" class="xtn npv-icon-xemthem fa fa-2x fa-angle-double-down display-none" data-toggle="tooltip" title="Xem thêm"></i>
        </div>
    </div>   
    <script>
        function xtn(){
                var page = $('.xtn').attr('aria-page');
                var nam = $('.xtn').attr('aria-nam');
                $.ajax({
                        url: '{{url("/nam/")}}?page='+page+'&nam='+nam,
                        dataType: 'text',                    
                        type: 'get',                    
                        success: function (data) {
                            console.log(data);  
                            $('.nam-page-'+page).html(data);
                            var nextPage = parseInt(page)+1;
                            $('.xtn').attr('aria-page', nextPage);
                            var newPage = document.createElement('span');
                            newPage.className = 'nam-page-'+nextPage;
                            $('.listPhimNam').append(newPage);
                        }
                });
            }
        function loadNam(i){
            $('a.nam').removeClass('btn-warning');
            $('a.nam').addClass('btn-primary');
            $('a.nam-'+i).removeClass('btn-primary');
            $('a.nam-'+i).addClass('btn-warning');
            $('.listPhimNam > span').remove();
            var page1 = document.createElement('span');
            page1.className = 'nam-page-1';
            $('.listPhimNam').append(page1);
            $.ajax({
                url: '{{url("/nam/")}}?page=1&nam='+i,
                dataType: 'text',                    
                type: 'get',                    
                success: function (data) {
                    console.log(data);  
                    $('.xtn').attr('aria-page', '2');
                    $('.xtn').attr('aria-nam', i);
                    if(data != 'Không tìm thấy dữ liệu'){
                        $('.xtn').removeClass('display-none');
                    } else {
                        $('.xtn').addClass('display-none');
                    }
                    $('.nam-page-1').html(data);
                    var newPage = document.createElement('span');
                    newPage.className = 'nam-page-2';
                    $('.listPhimNam').append(newPage);
                }
            });
        }
        $('#nam').iziModal({
            title: 'Năm',        
            overlayClose: true,                        
            openFullscreen:true,
            bodyOverflow:true,
            headerColor: 'rgb(56, 98, 111)'
        });
    </script>
</section>
