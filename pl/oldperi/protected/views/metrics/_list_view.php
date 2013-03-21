<li id="metric-<?php echo $model->metric_id; ?>">
<?php echo "<strong title='".CHtml::encode($model->description) . "'>".CHtml::encode($model->title) . ":</strong>&nbsp;&nbsp;";
if(!$model->experiment->locked) {
?>
  <?php if(AccessControl::canWriteMetric($model->metric_id)): ?>
  <a href="<?php echo $this->createUrl('/metrics/update/'.$model->metric_id) ?>" class="toolbar-icon" data-remote="true" title="Edit Metric"><img src="<?php echo Yii::app()->baseUrl.'/images/pencil.png' ?>" alt="edit" /></a>
  <?php endif;?>
  <?php if(AccessControl::canDeleteMetric($model->metric_id)): ?>
  <a href="<?php echo $this->createUrl('/metrics/delete/'.$model->metric_id) ?>" class="toolbar-icon" data-remote="true" data-method="post" data-confirm="Are you sure you want to delete this metric?" title="Delete Metric"><img src="<?php echo Yii::app()->baseUrl.'/images/remove.png' ?>" alt="delete" /></a>
  <?php endif;?>
<?php
}
?>
  <em><?php echo $model->dataType->title ?></em>
</li>
