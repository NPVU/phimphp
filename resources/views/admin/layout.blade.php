<html lang="{{ app()->getLocale() }}">
    @include('admin.template.head')
    <body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
        <div class="wrapper" style="height: auto; min-height: 100%;">
            @include('admin.template.header')
            @include('admin.template.left')
            
            <div class="content-wrapper" style="min-height: 946px;">
                                
                @include($page)
                
            </div>
            
            @include('admin.template.footer')

            @include('admin.template.setting')
        </div>
        @include('admin.template.user')
        <script>
            <?php if(isset($showToastr) && strcmp($showToastr, 'success') == 0) :?>
                showMessageSuccess();
            <?php endif;?>
        </script>
    </body>
</html>