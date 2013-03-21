<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('constant_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->constant_id), array('view', 'id'=>$data->constant_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('experiment__id')); ?>:</b>
	<?php echo CHtml::encode($data->experiment__id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />


</div>