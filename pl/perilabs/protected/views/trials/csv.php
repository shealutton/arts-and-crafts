"Peri Labs Data Template","Date Created:","<?php echo date('j/n/Y') ?>","","Peri Labs Trial ID# (do not change!)",
"",,,,"<?php echo $model->trial_id ?>",
"Experiment Title:","<?php echo addslashes($model->experiment->title) ?>",
"Goal/Hypothesis:","<?php echo addslashes($model->experiment->goal) ?>",
"Constants:",
<?php foreach($model->experiment->constants as $constant) { echo "\"{$constant->title}\",\"{$constant->description}\",\n"; } ?>
,,
"Instructions:",
"This template has been created to help import your data. Do not make changes to the information above this row",
"or to the names of the metrics. All rows below will be added to your trial on import.",
"Name, Title, or ID#",<?php foreach($model->experiment->metrics as $metric) { echo "\"{$metric->title}\","; } ?>,

