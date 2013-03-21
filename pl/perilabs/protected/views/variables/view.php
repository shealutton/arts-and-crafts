<?php
$this->breadcrumbs=array(
	//'Variables'=>array('index'),
	$model->experiment->title => array('/experiments/'.$model->experiment__id),
	$model->title,
);
?>

<h1>Variable: <?php echo $model->title; ?></h1>

<div style="margin: 1em">
	<b><?php echo CHtml::encode($model->getAttributeLabel('variable_id')); ?> #:</b>
	<?php echo CHtml::encode($model->variable_id); ?>
	<br />
	
	<b><?php echo CHtml::encode($model->getAttributeLabel('experiment__id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($model->experiment->title), array('/experiments/'.$model->experiment__id)); ?>
	<br />
	
	<b><?php echo CHtml::encode($model->getAttributeLabel('data_type__id')); ?>:</b>
	<span class="tooltip" title="<?php echo CHtml::encode($model->dataType->description); ?>"><?php echo CHtml::encode($model->dataType->title); ?></span>
</div>

<?php /*$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'variable_id',
		'experiment__id',
		'title',
		'data_type__id',
	),
));*/ ?>
