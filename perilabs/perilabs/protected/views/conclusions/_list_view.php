<li id="conclusion-<?php echo $model->conclusion_id; ?>">
<?php echo $model->description;
if($model->experiment->locked) {
?>
<?php if(AccessControl::canWriteConclusion($model->conclusion_id)): ?>
  <a href="<?php echo $this->createUrl('/conclusions/update/'.$model->conclusion_id) ?>" class="toolbar-icon" data-remote="true"title="Edit Conclusion"><img src="<?php echo Yii::app()->baseUrl.'/images/pencil.png' ?>" alt="edit" /></a>
<?php endif;?>

<?php if(AccessControl::canDeleteConclusion($model->conclusion_id)): ?>
  <a href="<?php echo $this->createUrl('/conclusions/delete/'.$model->conclusion_id) ?>" class="toolbar-icon" data-remote="true" data-confirm="Are you sure you want to delete this conclusion?" data-method="post" title="Delete Conclusion"><img src="<?php echo Yii::app()->baseUrl.'/images/remove.png' ?>" alt="delete" /></a>
<?php endif;?>

</li>
<?php } ?>
