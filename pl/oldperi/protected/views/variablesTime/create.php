<?php
$this->breadcrumbs=array(
	'Variables Times'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List VariablesTime', 'url'=>array('index')),
	array('label'=>'Manage VariablesTime', 'url'=>array('admin')),
);
?>

<h1>Create VariablesTime</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>