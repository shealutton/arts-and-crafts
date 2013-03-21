<?php
$this->breadcrumbs=array(
	'Conclusions'=>array('index'),
	'Manage',
);
/*
$this->menu=array(
	array('label'=>'List Conclusions', 'url'=>array('index')),
	array('label'=>'Create Conclusions', 'url'=>array('create')),
);
*/
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('conclusions-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Conclusions</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'conclusions-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'conclusion_id',
		'experiment__id',
		'description',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
