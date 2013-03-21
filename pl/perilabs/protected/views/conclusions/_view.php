<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('conclusion_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->conclusion_id), array('view', 'id'=>$data->conclusion_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('experiment__id')); ?>:</b>
	<?php echo CHtml::encode($data->experiment__id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />


</div>
