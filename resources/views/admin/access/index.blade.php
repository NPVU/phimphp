<section class="content-header">
    <h1>
        QUẢN LÝ TRUY CẬP
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/quan-ly/') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>        
        <li class="active"><a href="{{ url('/quan-ly/truy-cap') }}">Quản lý truy cập</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">        
        <div class="col-md-12">            
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Danh sách truy cập</h3>                                        
                </div>                
                <div class="box-body">                    
                    <table class="table table-hover" style="font-size:1em;">
                        <caption>
                            <span>Tổng: {{count($listAccess)}}</span>                                                     
                        </caption>
                        <thead>
                            <tr class="bg-primary">
                                <th scope="col" class="text-center" style="width: 3%">#</th>                                
                                <th scope="col" class="text-center" style="width: 15%">IP Address</th>
                                <th scope="col" class="text-center" style="width: 10%">Số lần</th>
                                <th scope="col" class="text-left" style="width: 40%">URL cuối</th>
                                <th scope="col" class="text-center" style="width: 17%">Thời gian</th>
                                <th scope="col" class="text-center" style="width: 15%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                if(isset($_GET['page'])){
                                    $rowIndex = ($_GET['page']-1)*10;
                                }else {
                                    $rowIndex = 0;
                                }                             
                            ?>
                            @foreach ($listAccess as $row)
                            <tr id="row{{$row->access_id}}" >
                                <td class="text-center">
                                    <?php $rowIndex++; echo $rowIndex ?>
                                </td>                                
                                <td class="text-center">
                                    {{$row->access_ipaddress}}
                                </td>
                                <td class="text-center">
                                    {{$row->access_times}}
                                </td> 
                                <td class="text-left">
                                    <a href="{{$row->access_url}}" target="_blank" />{{$row->access_url}}</a>
                                </td> 
                                <td class="text-center">
                                    <?php 
                                    $date=date_create($row->access_time);
                                    echo date_format($date,"d/m/Y H:i:s");
                                    ?>                                    
                                </td> 
                                <td class="text-center">                                      
                                    <div class="list-action-icon">                                                                              
                                                                  
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            <?php if($rowIndex == 0) :?>
                            <tr>
                                <td colspan="6" class="text-center">
                                    Không tìm thấy dữ liệu
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                        
                    </table>
                </div>                              
            </div>            
        </div>        
    </div>    
</section>