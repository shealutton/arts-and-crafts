<?php
$this->breadcrumbs=array(
	//'Conclusions'=>array('index'),
	$model->experiment->title => array('/experiments/'.$model->experiment__id),
	$model->description,
);
/*
$this->menu=array(
	array('label'=>'<img src="'.Yii::app()->theme->baseUrl.'/images/index.png" /> List Conclusions', 'url'=>array('index'), 'visible'=>Yii::app()->user->isAdmin()),
	array('label'=>'<img src="'.Yii::app()->theme->baseUrl.'/images/pencil.png" /> Edit Conclusion', 'url'=>array('update', 'id'=>$model->conclusion_id)),
	array('label'=>'<img src="'.Yii::app()->theme->baseUrl.'/images/remove.png" /> Delete Conclusion', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->conclusion_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'<img src="'.Yii::app()->theme->baseUrl.'/images/wrench.png" /> Manage Conclusions', 'url'=>array('admin'), 'visible'=>Yii::app()->user->isAdmin()),
);
*/
?>

<h1>Conclusion: <?php echo $model->description; ?></h1>

<div style="margin: 1em">
	<b><?php echo CHtml::encode($model->getAttributeLabel('conclusion_id')); ?> #:</b>
	<?php echo CHtml::encode($model->conclusion_id); ?>
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
		'conclusion_id',
		'experiment__id',
		'description',
	),
)); */?>
