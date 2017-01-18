<?php
$this->breadcrumbs=array(
    'Manage Users'=>array('admin'),
    'Create'
);
?>

<h2>Create new User</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'user'=>$user)); ?>


