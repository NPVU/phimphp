<section class="npv-theloai">
    <div id="theloai">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">
            @foreach($listTheLoai as $row)            
                <a href="#" onclick="loadTheLoai({{$row->theloai_id}})" class="btn btn-primary theloai theloai-{{$row->theloai_id}}" style="min-width: 100px;margin-bottom: 5px;">
                    <span>{{$row->theloai_ten}}</span>
                </a>            
            @endforeach                            
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 listPhimTheLoai">
            <span class="theloai-page-1">
                     
            </span>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <i onclick="xttl()" aria-page="2" class="xttl npv-icon-xemthem fa fa-2x fa-angle-double-down display-none" data-toggle="tooltip" title="Xem thêm"></i>
        </div>
    </div>   
    <script>
        function xttl(){
                var page = $('.xttl').attr('aria-page');
                var theloai = $('.xttl').attr('aria-theloai');
                $.ajax({
                        url: '{{url("/the-loai/")}}?page='+page+'&theloai='+theloai,
                        dataType: 'text',                    
                        type: 'get',                    
                        success: function (data) {
                            console.log(data);  
                            $('.theloai-page-'+page).html(data);
                            var nextPage = parseInt(page)+1;
                            $('.xttl').attr('aria-page', nextPage);
                            var newPage = document.createElement('span');
                            newPage.className = 'theloai-page-'+nextPage;
                            $('.listPhimTheLoai').append(newPage);
                        }
                });
            }
        function loadTheLoai(i){
            $('a.theloai').removeClass('btn-warning');
            $('a.theloai').addClass('btn-primary');
            $('a.theloai-'+i).removeClass('btn-primary');
            $('a.theloai-'+i).addClass('btn-warning');
            $('.listPhimTheLoai > span').remove();
            var page1 = document.createElement('span');
            page1.className = 'theloai-page-1';
            $('.listPhimTheLoai').append(page1);
            $.ajax({
                url: '{{url("/the-loai/")}}?page=1&theloai='+i,
                dataType: 'text',                    
                type: 'get',                    
                success: function (data) {
                    console.log(data);  
                    $('.xttl').attr('aria-page', '2');
                    $('.xttl').attr('aria-theloai', i);
                    if(data != 'Không tìm thấy dữ liệu'){
                        $('.xttl').removeClass('display-none');
                    } else {
                        $('.xttl').addClass('display-none');
                    }
                    $('.theloai-page-1').html(data);
                    var newPage = document.createElement('span');
                    newPage.className = 'theloai-page-2';
                    $('.listPhimTheLoai').append(newPage);
                }
            });
        }
        $('#theloai').iziModal({
            title: 'Thể loại',        
            overlayClose: true,                        
            openFullscreen:true,
            bodyOverflow:true,
            headerColor: 'rgb(56, 98, 111)'
        });
    </script>
</section>
