<?php
$this->breadcrumbs=array(
	//'Constants'=>array('index'),
	$model->experiment->title => array('/experiments/'.$model->experiment__id),
	$model->title,
);
/*
$this->menu=array(
	array('label'=>'<img src="'.Yii::app()->theme->baseUrl.'/images/index.png" /> List Constants', 'url'=>array('index'), 'visible'=>Yii::app()->user->isAdmin()),
	array('label'=>'<img src="'.Yii::app()->theme->baseUrl.'/images/pencil.png" /> Edit Constant', 'url'=>array('update', 'id'=>$model->constant_id)),
	array('label'=>'<img src="'.Yii::app()->theme->baseUrl.'/images/remove.png" /> Delete Constant', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->constant_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'<img src="'.Yii::app()->theme->baseUrl.'/images/wrench.png" /> Manage Constants', 'url'=>array('admin'), 'visible'=>Yii::app()->user->isAdmin()),
);
*/
?>

<h1>Constant: <?php echo $model->title; ?></h1>

<div style="margin: 1em">
	<b><?php echo CHtml::encode($model->getAttributeLabel('constant_id')); ?> #:</b>
	<?php echo CHtml::encode($model->constant_id); ?>
	<br />
	
	<b><?php echo CHtml::encode($model->getAttributeLabel('experiment__id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($model->experiment->title), array('/experiments/'.$model->experiment__id)); ?>
	<br />
	
	<b><?php echo CHtml::encode($model->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($model->description); ?>
</div>

<?php /*$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'constant_id',
		'experiment__id',
		'title',
		'description',
	),
)); */?>
