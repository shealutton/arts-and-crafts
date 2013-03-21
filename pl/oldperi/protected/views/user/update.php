<?php
$this->breadcrumbs=array(
    'Manage Users'=>array('admin'),
    'Update'
);
?>

<h1>Update User: <?php echo $model->username; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'user'=>$user)); ?>
