<?php
$this->breadcrumbs=array(
	'Metrics'=>array('index'),
	'Manage',
);
/*
$this->menu=array(
	array('label'=>'List Metrics', 'url'=>array('index')),
);
*/
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('metrics-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Metrics</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'metrics-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'metric_id',
		'title',
		'experiment__id',
		'data_type__id',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
