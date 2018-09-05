<html lang="{{ app()->getLocale() }}">
    @include('admin.layouts.head')
    <body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
        <div class="wrapper" style="height: auto; min-height: 100%;">
            @include('admin.layouts.header')
            @include('admin.layouts.left')
            
            <div class="content-wrapper" style="min-height: 946px;">
                                
                @include($page)
                
            </div>
            
            @include('admin.layouts.footer')

            @include('admin.layouts.setting')
        </div>
        @include('admin.layouts.user')
        <script>
            <?php if(isset($showToast) && !empty($showToast)){ echo $showToast;} ?>
        </script>
        @if (session('success'))
        <script>
            showToast("success", "", "{{ session('success') }}", true);          
        </script>
        @endif
        @if (session('error'))
        <script>
            showToast("error", "", "{{ session('error') }}", true);          
        </script>
        @endif
    </body>
</html>