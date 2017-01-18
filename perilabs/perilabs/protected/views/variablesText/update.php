<?php
$this->breadcrumbs=array(
	'Variables Texts'=>array('index'),
	$model->var_text_id=>array('view','id'=>$model->var_text_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List VariablesText', 'url'=>array('index')),
	array('label'=>'Create VariablesText', 'url'=>array('create')),
	array('label'=>'View VariablesText', 'url'=>array('view', 'id'=>$model->var_text_id)),
	array('label'=>'Manage VariablesText', 'url'=>array('admin')),
);
?>

<h1>Update VariablesText <?php echo $model->var_text_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>