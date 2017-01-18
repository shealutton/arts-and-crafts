<?php
$this->breadcrumbs=array(
    'Manage Users'=>array('admin'),
    'View'
);
?>

<h1>View user <?php echo $model->username;?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'username',
	'firstname',
	'lastname',
        'email',
        array(
            'name'=>'status',
            'value'=>User::getStatus($model->status),
        ),
        'role',
    ),
)); ?>

<?php echo CHtml::link('go back', Yii::app()->createUrl('user/admin'));?>
