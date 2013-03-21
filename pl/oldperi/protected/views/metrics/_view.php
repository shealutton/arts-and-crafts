<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('metric_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->metric_id), array('view', 'id'=>$data->metric_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('experiment__id')); ?>:</b>
	<?php echo CHtml::encode($data->experiment__id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('data_type__id')); ?>:</b>
	<?php echo CHtml::encode($data->data_type__id); ?>
	<br />


</div>