<?php
$this->breadcrumbs=array(
	'States'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Manage'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('states-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Users</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'profiles-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'columns'=>array(
					'id',
					'email',
					array(
					'class'=>'CButtonColumn',
		),
					),

)); ?>


