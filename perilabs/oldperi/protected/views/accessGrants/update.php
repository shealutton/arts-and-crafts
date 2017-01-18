<?php
$this->breadcrumbs=array(
  'Access Grants'=>array('index'), // TODO: change this to experiment name
  'Create',
);
?>

<h1>Update Access Grant</h1>
<?php $this->renderPartial('_update_form', array("model" => $model, "user" => $user)); ?>
