<?php
$this->breadcrumbs=array(
	'Experiments'=>array('index'),
	'Create',
);
?>

<h1>Create a new Experiment</h1>

<?php echo $this->renderPartial('_create-form', array('model'=>$model)); ?>
