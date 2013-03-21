<li id="constant-<?php echo $model->constant_id; ?>">
<?php echo "<strong title='".CHtml::encode($model->description) . "'>".CHtml::encode($model->title) . "</strong>&nbsp;&nbsp;";
if(!$model->experiment->locked) {
?>
<?php if(AccessControl::canWriteConstant($model->constant_id)): ?>
  <a href="<?php echo $this->createUrl('/constants/update/'.$model->constant_id) ?>" class="toolbar-icon" data-remote="true"title="Edit Constant"><img src="<?php echo Yii::app()->baseUrl.'/images/pencil.png' ?>" alt="edit" /></a>
<?php endif;?>

<?php if(AccessControl::canDeleteConstant($model->constant_id)): ?>
  <a href="<?php echo $this->createUrl('/constants/delete/'.$model->constant_id) ?>" class="toolbar-icon" data-remote="true" data-confirm="Are you sure you want to delete this constant?" data-method="post" title="Delete Constant"><img src="<?php echo Yii::app()->baseUrl.'/images/remove.png' ?>" alt="delete" /></a>
<?php endif;?>

</li>
<?php
}
?>
