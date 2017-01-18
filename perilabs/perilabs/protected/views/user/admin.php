<?php
$this->breadcrumbs=array(
	'Manage Users',
);
/*
$this->menu=array(
	array('label'=>'List ', 'url'=>array('admin')),
	array('label'=>'Create ', 'url'=>array('create')),
);
*/
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Users</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<br/>
<?php echo CHtml::link('Create new User', Yii::app()->createAbsoluteUrl('user/create'));?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		'id',
		'username',
		'email',
        array(
            'name'=>'createtime',
            'value'=>'($data->createtime)? date("M j, Y", $data->createtime):""',
        ),
        array(
            'name'=>'lastvisit',
            'value'=>'($data->lastvisit)? date("M j, Y", $data->lastvisit):""',
        ),
        array(
            'name'=>'lastpasswordchange',
            'value'=>'($data->lastpasswordchange)? date("M j, Y", $data->lastpasswordchange):""',
        ),
        array(
            'name'=>'status',
            'value'=>'User::getStatus($data->status)',
        ),
        'role',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>



