<?php
$this->breadcrumbs=array(
	$model->experiment->title => array('/experiments/'.$model->experiment__id),
	$model->title,
);
/*
$this->menu=array(
	array('label'=>'<img src="'.Yii::app()->theme->baseUrl.'/images/index.png" /> List Metrics', 'url'=>array('index'), 'visible'=>Yii::app()->user->isAdmin()),
	array('label'=>'<img src="'.Yii::app()->theme->baseUrl.'/images/pencil.png" /> Edit Metric', 'url'=>array('update', 'id'=>$model->metric_id)),
	array('label'=>'<img src="'.Yii::app()->theme->baseUrl.'/images/remove.png" /> Delete Metric', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->metric_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'<img src="'.Yii::app()->theme->baseUrl.'/images/wrench.png" /> Manage Metrics', 'url'=>array('admin'), 'visible'=>Yii::app()->user->isAdmin()),
);
*/
?>

<h1>Metric: <?php echo $model->title; ?></h1>

<div style="margin: 1em">
	<b><?php echo CHtml::encode($model->getAttributeLabel('metric_id')); ?> #:</b>
	<?php echo CHtml::encode($model->metric_id); ?>
	<br />
	
	<b><?php echo CHtml::encode($model->getAttributeLabel('experiment__id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($model->experiment->title), array('/experiments/'.$model->experiment__id)); ?>
	<br />
	
	<b><?php echo CHtml::encode($model->getAttributeLabel('data_type__id')); ?>:</b>
	<span title="<?php echo CHtml::encode($model->dataType->description); ?>"><?php echo CHtml::encode($model->dataType->title); ?></span>
</div>
