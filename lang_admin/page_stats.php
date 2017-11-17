<div class="page-header">
  <h1>Statistics</h1>
</div>
<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Languages
                            
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <div id="morris-bar-chart"></div>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Sex Representations
                        </div>
                        <div class="panel-body">
                            <div id="morris-donut-chart"></div>
                            
                        </div>
                        
                    </div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		Morris.Donut({
        element: 'morris-donut-chart',
        data: <?php $counts = get_sex_data(); echo json_encode($counts); ?>,
        resize: true
    });

    Morris.Bar({
        element: 'morris-bar-chart',
        data: <?php 
        	$sts = get_lang_learn_teach();
        	echo json_encode($sts); 
        ?> ,
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Learn', 'Teach'],
        hideHover: 'auto',
        resize: true
    });
	});
</script>