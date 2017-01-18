<?php
$this->breadcrumbs=array(
	'Variables Texts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List VariablesText', 'url'=>array('index')),
	array('label'=>'Manage VariablesText', 'url'=>array('admin')),
);
?>

<h1>Create VariablesText</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>