<?php
$this->breadcrumbs=array(
	'Datasets'=>array('index'),
	'Manage',
);
/*
$this->menu=array(
	array('label'=>'List Datasets', 'url'=>array('index')),
	array('label'=>'Create Datasets', 'url'=>array('create')),
);
*/
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('datasets-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Datasets</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'datasets-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'dataset_id',
		'result__id',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
