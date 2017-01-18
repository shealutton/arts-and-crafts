<?php
$this->breadcrumbs=array(
	'Constants'=>array('index'),
	'Manage',
);
/*
$this->menu=array(
	array('label'=>'List Constants', 'url'=>array('index')),
	array('label'=>'Create Constants', 'url'=>array('create')),
);
*/
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('constants-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Constants</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'constants-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'constant_id',
		'experiment__id',
		'title',
		'description',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
