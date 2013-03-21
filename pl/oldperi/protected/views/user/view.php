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
        'email',
        array(
            'name'=>'createtime',
            'value'=>($data->createtime)? date("M j, Y", $data->createtime):"Empty",
        ),
        array(
            'name'=>'lastvisit',
            'value'=>($data->lastvisit)? date("M j, Y", $data->lastvisit):"Empty",
        ),
       /* array(
            'name'=>'lastaction',
            'value'=>($data->lastaction)? date("M j, Y", $data->lastaction):"Empty",
        ),*/
        array(
            'name'=>'lastpasswordchange',
            'value'=>($data->lastpasswordchange)? date("M j, Y", $data->lastpasswordchange):"Empty",
        ),
        array(
            'name'=>'status',
            'value'=>User::getStatus($data->status),
        ),
        'role',
    ),
)); ?>

<?php echo CHtml::link('go back', Yii::app()->createUrl('user/admin'));?>
