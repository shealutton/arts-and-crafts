<?php
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery');
$cs->registerScriptFile($baseUrl.'/js/assets/highcharts.src.js');
$cs->registerScriptFile($baseUrl.'/js/assets/modules/exporting.js');
$cs->registerCssFile($baseUrl.'/css/ajax_loading.css');
$this->breadcrumbs=array(
		'Experiments'=>array('index'),
		$model->title,
); ?>
<!--Close div's from header-->
</div>
</div>

<!--<div class="container-fluid">-->
<!-- The style in this div is for the border line -->
<div class="row-fluid experiment-details"
	style="border-bottom: 1px solid lightgrey; padding-bottom: .125em; margin-bottom: .35em;">
	<!--Title and Updates-->
	<h2>
		<?php echo CHtml::encode($model->title);?>
	</h2>
	<p>
		Created on
		<?php echo CHtml::encode(date("M jS, Y", strtotime($model->date_created))); ?>
		and last updated on
		<?php echo CHtml::encode(date("M jS, Y", strtotime($model->last_updated))); ?>
	</p>
</div>
<div
	class="row-fluid" id="loadingDiv">
	<div class="span3">
		<h3>Trials:</h3>
		<ul>
			<?php
			$actual_trial_models = array();
                foreach($model->trials as $trial): ?>
			<li><input type="checkbox" name="trial[]" class="trials mleft mright"
				value="<?php echo $trial->trial_id; ?>" /> <strong> <?php echo CHtml::encode($trial->title); ?>
			</strong>
			</li>
			<?php endforeach; ?>
		</ul>
		</br>
		<h3>Metrics:</h3>
		<ul>
			<li><strong class="mright">X axis</strong><strong> Y axis</strong></li>
			<li><input type="radio" name="X[]" class="xAxis mleft mright"
				value="series" /> <input type="radio" name="Y[]"
				class="yAxis mleft mright" value="series" /> <strong class="mleft">Series</strong>
			</li>
			<?php foreach($model->metrics as $metric): ?>
			<li><input type="radio" name="X[]" class="xAxis mleft mright"
				value="<?php echo $metric->metric_id; ?>" /> <input type="radio"
				name="Y[]" class="yAxis mleft mright"
				value="<?php echo $metric->metric_id; ?>" /> <strong class="mleft"><?php echo CHtml::encode($metric->title); ?>
			</strong>
			</li>
			<?php endforeach; ?>

		</ul>
		</br>
		<h3>Graph Type:</h3>
		<ul>
			<li><input type="radio" name="graphtype"
				class="graph_type mleft mright" value="scatter" /> <strong>Scatter</strong>
			</li>
			<li><input type="radio" name="graphtype"
				class="graph_type mleft mright" value="line" /> <strong>Line</strong>
			</li>
			<li><input type="button" class="btn btn-info" value="Draw"
				style="margin-top: 5px;" onclick="yii_draw();" /></li>
		</ul>
	</div>
	<!-- Graph and Stats Section -->
	<div class="span9"
		style="border-left: 1px solid lightgrey; padding-left: 1em; padding-bottom: .125em; margin-bottom: .35em; margin-left: .35em">
		<h3>
			<?php echo CHtml::encode($model->title);?>
			Graph
		</h3>
		<p>
			<input type="checkbox" id="chkShowAll" onclick="checkShowAll()" />
			Graph all data points
		</p>
		<div id="chart_container"></div>
		<div id="stats_page"></div>
	</div>

	<!-- Charting script -->
	<script type="text/javascript">
            var chart;
            function yii_draw() {
                    //Generate Chart Type and Property
                    var  trials = [],x,y,chartType,showAllDataPoints;
                    $('.trials').each(function() {
                            if($(this).attr("checked") == "checked"){
                                    trials.push($(this).val());
                            }
                    });

                    // Get X axis Property
                    $('.xAxis').each(function() {
                            if($(this).attr("checked") == "checked"){
                                    x=$(this).val();
                            }
                    });

                    $('.yAxis').each(function() {
                            if($(this).attr("checked") == "checked"){
                                    y=$(this).val();
                            }
                    });

                    $('.graph_type').each(function() {
                            if($(this).attr("checked") == "checked"){
                                    chartType=$(this).val();
                            }
                    }); 
                    $('#chkShowAll').each(function() {
                            if($(this).attr("checked") == "checked"){
                                    showAllDataPoints=true;
                            }
                            else
                            {
                                showAllDataPoints=false;
                            }
                            
                    });   
                    var filter = {
                            Trials: trials, 
                            Xaxis: x, 
                            Yaxis: y,
                            ChartType:chartType,
                            ShowAll:showAllDataPoints
                    };

                    // Chart Draw Validation

                    if (trials.length==0) {
                            alert("You have to choose Trials");
                            return;
                    } else if (x==undefined) {
                            alert("You have to choose X aixs");
                            return;
                    } else if (y==undefined) {
                            alert("You have to choose Y aixs");
                            return;
                    } else if (chartType==undefined) {
                            alert("You have to choose Chart Type");
                            return;
                    }

                    $("#loadingDiv").addClass("loading");      
                    CreateExperimentChart(filter);            
            }

            var YiiExperiments={
                    apiLocation:"<?php echo $this->createUrl('chart', array('id' => $model->experiment_id)) ?>",
                    baseUrl:"<?php echo $this->createUrl('/') ?>",
                    lastRequestErrorCode: 0,
                    lastRequestErrorText: "",
                    XDatalist:undefined,
                    YDatalist:undefined     
            }

            function CreateExperimentChart(filter) {
                    //Request if we don't have results yet
                    $.post(YiiExperiments.apiLocation, {filter:filter}, 
                            function(data){ //SUCCESS
                                    YiiExperiments.XDatalist = data.DataList.XResults;
                                    YiiExperiments.YDatalist = data.DataList.YResults;

                                    // Setting HighChart options
                                    var opt={
                                            chart:{
                                                    renderTo:'chart_container',
                                                    type:data.ChartType,
                                                    zoomType:'xy'
                                            },
                                            credits: {
                                                enabled: false
                                            },
                                            title:{
                                                    text:''
                                            },
                                            exporting:{
                                                    enabled:true
                                            },
                                            xAxis:{
                                                    startOnTick:true,
                                                    endOnTick:true,
                                                    showLastLabel:true,

                                                    title:{
                                                        enabled:true,
                                                        text:data.X_axis_Title
                                                    },
                                                    labels: {
                                                    	rotation:0
                                                    },
                                            },
                                            yAxis:{
                                                    startOnTick:true,
                                                    endOnTick:true,
                                                    showLastLabel:true,
                                                    ticklength:3,
                                                    title:{
                                                        enabled:true,
                                                        text:data.Y_axis_Title
                                                    },
                                                    labels: {
                                                    	rotation:0
                                                    },
                                            },
                                            tooltip:{

                                            },
                                            plotOptions:{
                                            	series: {         //scatter->series
                                                    marker: {
                                                        radius: 5,
                                                        states: {
                                                            hover: {
                                                                enabled: true,
                                                                lineColor: 'rgb(100,100,100)'
                                                            }
                                                         }
                                                     },
                                                     states: {
                                                         hover: {
                                                             marker: {
                                                                 enabled: false
                                                             }
                                                         }
                                                     }
                                                 }
                                             },

                                             series:[]       
                                    }
                                    //Display results

                                    if (data.DataList.XTimeType=="XAxis")
                                    { 
                                            opt.xAxis.labels.rotation=10;
                                            opt.tooltip['formatter']=function() 
                                    {        
                                            var macrosec=this.x%1000000;
                                            var timespan=(this.x-macrosec)/1000000;
                                            var d=new Date(timespan*1000);

                                            var dtime=d.getUTCFullYear()+"-"+(d.getUTCMonth()+1)+"-"+d.getUTCDate()+" "+d.getUTCHours()+":"+d.getUTCMinutes()+":"+d.getUTCSeconds()+"."+macrosec;

                                            return "x: "+dtime+" y :"+this.y;
                                    }
                                            opt.xAxis.labels['formatter']=function() {
                                                    var macrosec=this.value%1000000;
                                                    var timespan=(this.value-macrosec)/1000000;
                                                    var d=new Date(timespan*1000);

                                                    return d.getUTCFullYear()+"-"+(d.getUTCMonth()+1)+"-"+d.getUTCDate()+" "+d.getUTCHours()+":"+d.getUTCMinutes()+":"+d.getUTCSeconds()+"."+macrosec;
                                                    // return this.value;
                                            }
                                    }
                                    if(data.DataList.YTimeType=="YAxis")
                                    {
                                            //opt.yAxis.labels.rotation=10;
                                            opt.tooltip['formatter']=function() 
                                    {
                                            var macrosec=this.y%1000000;
                                            var timespan=(this.y-macrosec)/1000000;
                                            var d=new Date(timespan*1000);

                                            var dtime=d.getUTCFullYear()+"-"+(d.getUTCMonth()+1)+"-"+d.getUTCDate()+" "+d.getUTCHours()+":"+d.getUTCMinutes()+":"+d.getUTCSeconds()+"."+macrosec;

                                            return "x: "+this.x+" y :"+dtime;
                                    }
                                            opt.yAxis.labels['formatter']=function() {

                                                    var macrosec=this.value%1000000;
                                                    var timespan=(this.value-macrosec)/1000000;
                                                    var d=new Date(timespan*1000);

                                                    return d.getUTCFullYear()+"-"+(d.getUTCMonth()+1)+"-"+d.getUTCDate()+" "+d.getUTCHours()+":"+d.getUTCMinutes()+":"+d.getUTCSeconds()+"."+macrosec;
                                            }
                                    }

                                    chart=new Highcharts.Chart(opt);

                                    var coords = data.DataList.Coord;

                                    if (data.DataList.YAxisType=="Label" && data.DataList.XAxisType=="Label") {
                                        alert("No Label"); 
                                    }else{
                                        if (data.DataList.YAxisType=="Label") {
                                            chart.yAxis[0].setCategories(data.DataList.YResults);
                                            //chart.yAxis[0].redraw(); 
                                        }else if (data.DataList.XAxisType=="Label") {
                                            chart.xAxis[0].setCategories(data.DataList.XResults);
                                            //chart.xAxis[0].redraw();
                                        }
                                        $.each(coords,function(key, coord)
                                            {                                  	
                                                chart.addSeries({data: coord,name:key});       
                                            });

                                            $("#loadingDiv").removeClass("loading");      
                                    }               
                                      
                            }
                    ,'json').error( function(data){ //ERROR        
                                    YiiExperiments.lastRequestErrorCode = data.status;
                                    YiiExperiments.lastRequestErrorText = "Server error" + data.status;
                                    alert(YiiExperiments.lastRequestErrorText);

                                    $("#loadingDiv").removeClass("loading");
                            });

		    //Label and order the stats sections
                    $('#stats_page').html('');
    		        //var colors = ['#4572A7', '#AA4643', '#89A54E', '#80699B', '#3D96AE', '#DB843D', '#92A8CD', '#A47D7C', '#B5CA92'];
    		        if(filter.Trials instanceof Array) {
    		            for(index in filter.Trials) {
    			        //var color = colors[index];
    		                if(filter.Xaxis != "series") {
    			                $.ajax({
    					            type:"get",
    					            url:YiiExperiments.baseUrl+'/metrics/statistics/'+filter.Xaxis+"?"+"trial_id="+filter.Trials[index],
    					            async:true,
    					            success:function(data){
    						        //$('#stats_page').append("<div style='width:20%; float:left; padding-top:2em; padding-left:5%;'><h3 style='color:"+color+"'>"+data+"</div>");
    						        $('#stats_page').append("<div style='width:20%; float:left; padding-top:2em; padding-left:5%;'><h3>"+data+"</div>");
    					            },
    				            });
    		                 }
    		                 if(filter.Yaxis != "series") {
    		    	             $.ajax({
    					             type:"get",
    					             url:YiiExperiments.baseUrl+'/metrics/statistics/'+filter.Yaxis+"?"+"trial_id="+filter.Trials[index],
    					             async:true,
    					             success:function(data){
    						       //$('#stats_page').append("<div style='width:20%; float:left; padding-top:2em; padding-left:5%;'><h3 style='color:"+color+"'>"+data+"</div>");
    						       $('#stats_page').append("<div style='width:20%; float:left; padding-top:2em; padding-left:5%;'><h3>"+data+"</div>");
    					             },
    				             });
    		                 }
                        }
    		        }
    		        $('#stats_page :nth-child(4n)').after("<div style='clear:both;'></div>");
            }

		function checkShowAll() {
		  if ($("#chkShowAll").attr("checked") == "checked") {
		    yii_draw();
		  }
		  else {
		    yii_draw();
		  }
		}
	</script>
</div>
</div>
