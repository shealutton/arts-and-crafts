<li id="variable-<?php echo $model->variable_id; ?>">
<?php echo "<strong title='".CHtml::encode($model->description) . "'>".CHtml::encode($model->title) . ":</strong>&nbsp;&nbsp;";
if(!$model->experiment->locked) {
?>
<?php if(AccessControl::canWriteVariable($model->variable_id)): ?>
  <a href="<?php echo $this->createUrl('/variables/update/'.$model->variable_id) ?>" class="toolbar-icon" data-remote="true"title="Edit Variable"><img src="<?php echo Yii::app()->baseUrl.'/images/pencil.png' ?>" alt="edit" /></a>
<?php endif;?>
<?php if(AccessControl::canDeleteVariable($model->variable_id)): ?>
  <a href="<?php echo $this->createUrl('/variables/delete/'.$model->variable_id) ?>" class="toolbar-icon" data-remote="true" data-confirm="Are you sure you want to delete this variable?" data-method="post" title="Delete Variable"><img src="<?php echo Yii::app()->baseUrl.'/images/remove.png' ?>" alt="delete" /></a>
<?php endif;?>
<?php } ?>
<?php $datatype = $model->dataType->title;
if ($datatype == "Text") {
        echo "<ul>";
        // Loop through them
        foreach ($model->variablesTexts as $currentVariablesText):
                $this->renderPartial("//variablesText/_list_view", array("model" => $currentVariablesText));
        endforeach;
        /* $this->renderPartial("//variablesText/_ajax_form", array("model" => new VariablesText(), 'variable_id'=>$model->variable_id )); */
        echo "</ul>";
} elseif ($datatype == "Timestamp") {
	// Do we have any variablesTime?
        echo "<ul>";
        // Loop through them
        foreach ($model->variablesTimes as $currentVariablesTime):
                $this->renderPartial("/variablesTime/_list_view", array("model" => $currentVariablesTime));
        endforeach;
        echo "</ul>";
} elseif ($datatype == "Integers") { ?>
        <em><?php echo $datatype . " from " . $model->min . " to " . $model->max;?></em>
<?php } elseif ($datatype == "Real numbers") { ?>
        <em><?php echo $datatype . " from " . $model->min . " to " . $model->max . " by increments of " . $model->increment; ?></em>
<?php } else { ?>
        <em><?php echo $datatype ?></em>
<?php } ?>
</li>

