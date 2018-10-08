<section class="content">
    <div class="row">        
        <div class="col-md-12">        
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thống Kê</h3>                               
                </div>                
                <div class="box-body chart-responsive">
                  <div class="col-md-6">
                    <div id="hoanthanh"></div>
                  </div>
                  <div class="col-md-6">
                    <div id="updating-phim"></div>
                  </div>
                </div>                          
            </div>            
        </div>        
    </div>
    <link href="{{ asset('css/morris.css') }}" rel="stylesheet" type="text/css" />  
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
    <script type="text/javascript" src="{{ asset('js//morris.js') }}"></script>
    <script>
      Morris.Donut({
        element: 'hoanthanh',
        data: [
          {value: {{number_format(($phimhoanthanh/$tongphim)* 100, 2)}}, label: 'Hoàn thành'},
          {value: {{100-number_format(($phimhoanthanh/$tongphim)* 100, 2)}}, label: 'Chưa hoàn thành'}
        ],
        backgroundColor: '#ccc',
        labelColor: '#060',
        colors: [
          '#0BA462',
          '#39B580',
          '#67C69D',
          '#95D7BB'
        ],
        formatter: function (x) { return x + "%"}
    });

    Morris.Bar({
      element: 'updating-phim',
      data: [
        {x: '2011 Q1', y: 0},
        {x: '2011 Q2', y: 1},
        {x: '2011 Q3', y: 2},
        {x: '2011 Q4', y: 3},
        {x: '2012 Q1', y: 4},
        {x: '2012 Q2', y: 5},
        {x: '2012 Q3', y: 6},
        {x: '2012 Q4', y: 7},
        {x: '2013 Q1', y: 8}
      ],
      xkey: 'x',
      ykeys: ['y'],
      labels: ['Y'],
      barColors: function (row, series, type) {
        if (type === 'bar') {
          var red = Math.ceil(255 * row.y / this.ymax);
          return 'rgb(' + red + ',0,0)';
        }
        else {
          return '#000';
        }
      }
    });
  </script>    
  <style>
      tspan{
          font-family: --webkit-body;
      }
  </style>
</section>