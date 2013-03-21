<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('var_text_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->var_text_id), array('view', 'id'=>$data->var_text_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('variable__id')); ?>:</b>
	<?php echo CHtml::encode($data->variable__id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('value')); ?>:</b>
	<?php echo CHtml::encode($data->value); ?>
	<br />


</div>