<section class="content-header">
    <h1>
        UPLOAD VIDEO
        <small></small>
    </h1>    
</section>
<section class="content">
    <div class="row">        
        <div class="col-md-12">            
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>                                       
                </div>                
                <div class="box-body">
                    <form method="POST">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>URL</label>
                            <input type="text" class="form-control required" name="url" />                            
                        </div>
                        <div class="form-group">
                            <label>File Name</label>
                            <input type="text" class="form-control required" name="filename" />                            
                        </div>
                        <div class="form-group">
                            <label>Thư mục</label>
                            <input type="text" class="form-control required" name="folder" />                            
                        </div>
                        
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-danger" name="btn" value="add">Upload</button>
                            <a href="{{ session('backURLAdmin') }}" class="btn btn-warning" ><i class="fa fa-backward"></i> Trở về</a>
                        </div>
                    </form>
                </div>                              
            </div>            
        </div>        
    </div>
    
</section>