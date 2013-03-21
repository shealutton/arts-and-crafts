<?php
$this->breadcrumbs=array(
	'Variables Texts'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List VariablesText', 'url'=>array('index')),
	array('label'=>'Create VariablesText', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('variables-text-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Variables Texts</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'variables-text-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'var_text_id',
		'variable__id',
		'value',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
