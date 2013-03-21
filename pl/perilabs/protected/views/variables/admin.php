<?php
$this->breadcrumbs=array(
	'Variables'=>array('index'),
	'Manage',
);
/*
$this->menu=array(
	array('label'=>'List Variables', 'url'=>array('index')),
	array('label'=>'Create Variables', 'url'=>array('create')),
);
*/
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('variables-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Variables</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'variables-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'variable_id',
		'experiment__id',
		'title',
		'data_type__id',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
