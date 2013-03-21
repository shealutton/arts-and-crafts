<?php
$this->breadcrumbs=array(
	'Results'=>array('index'),
	'Manage',
);
/*
$this->menu=array(
	array('label'=>'List Results', 'url'=>array('index')),
	array('label'=>'Create Results', 'url'=>array('create')),
);
*/
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('results-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Results</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'results-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'result_id',
		'trial__id',
		'title',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
