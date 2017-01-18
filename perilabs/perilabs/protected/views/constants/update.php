<?php
$this->breadcrumbs=array(
	//'Constants'=>array('index'),
	$model->experiment->title => array('/experiments/'.$model->experiment->experiment_id),	
	$model->title=>array('view','id'=>$model->constant_id),
	'Edit',
);
/*
$this->menu=array(
	array('label'=>'List Constants', 'url'=>array('index'), 'visible'=>Yii::app()->user->isAdmin()),
	array('label'=>'View Constant', 'url'=>array('view', 'id'=>$model->constant_id)),
	array('label'=>'Manage Constants', 'url'=>array('admin'), 'visible'=>Yii::app()->user->isAdmin()),
);
*/
?>

<h1>Edit Constant</h1>
<?php echo $this->renderPartial('_form', array('model'=>$model, 'experiment_id'=>$model->experiment->experiment_id)); ?>
