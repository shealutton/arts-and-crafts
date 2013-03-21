<table class="table table-bordered table-striped experiment-trials-grid">
	<thead>
		<tr>
			<th>Trial Name</th>
<?php
$variables = $experiment->variables;
$values = array();


//First, loop through and get all the different possible values
//of the variables for the experiment. At the same time, output table headers.
foreach($variables as $variable):
        switch ($variable->data_type__id) {
        case 1:
                //boolean
                $vals = array(0, 1);
                break;
        case 2:
                //integer (2)
                $vals = array();
                for($i = (int)$variable->min; $i <= $variable->max; $i += $variable->increment) {
                        $vals[] = $i;
                }
                break;
        case 3:
                //real number (3)
                $vals = array();
                for($i = (float)$variable->min; $i <= $variable->max; $i += $variable->increment) {
                        $vals[] = "$i";
                }
                break;
        case 4:
                //text
		$vals = array(); // These vals are the array that make up the permutations below
		foreach ($variable->variablesTexts as $i):
			$vals[] = $i->value;
		endforeach;
                break;
        case 6: //there is no 5 
                //timestamp
		$vals = array(); // These vals are the array that make up the permutations below
		foreach ($variable->variablesTimes as $i):
                        $vals[] = $i->value;
                endforeach;
                break;
        }
        $values[$variable->variable_id] = $vals; //values is an array of {key: value} consisting of {variable_id: value}
        echo "<th class=vars>".$variable->title."</th>";
endforeach;

foreach($experiment->metrics as $metric):
        echo "<th class=metrics>".$metric->title."</th>";
endforeach;
?>

		<th># of data points</th>
		<?php if(AccessControl::canGatherExperiment($experiment->experiment_id)):?>
		<th class="trial-actions">Actions</th>
		<?php endif;?>
		</tr>
	</thead>
	<tbody>

<?php

function permutations(array $array) {
        switch(count($array)) { //what does this mean? we count the number of values or check to be sure it is not empty? 
        case 1:
                $return = array();
                foreach($array as $key => $values):
                        if($values != null):
                            foreach($values as $value):
                                $return[] = array($key => $value);
                            endforeach;
                        else:
                            $return[] = array($key => $values);
                        endif;
                endforeach;
                return $return;
                break;
        case 0: // if empty (?) quit?
                break;
        }
        $keys = array_keys($array); //keys are variable_id's
        $a = array_shift($array); // take the first value
        $k = array_shift($keys); // take the first key
        $b = permutations($array); // What is this?

        $return = array();
        foreach($a as $v) {
                foreach($b as $v2) {
                        $return[] = array($k => $v) + array_combine((array)$keys, (array) $v2);
                }
        }
        return $return;
}
$possible_trials = permutations($values); //set poss_trials to be passed in the array of key/value pairs 
$actual_trials = array(); 
$actual_trial_models = array();
foreach($experiment->trials as $trial):
        $values=array();
        foreach($experiment->variables as $var):
                $values[$var->variable_id] = $trial->value_for_variable($var);
        endforeach;
        $actual_trials[$trial->trial_id] = $values;
        $actual_trial_models[$trial->trial_id] = $trial;
endforeach;
$trialindex = 0;
foreach ($possible_trials as $possible_trial_index => $ptrial):
        ++$trialindex;
        $trial_id = array_search($ptrial, $actual_trials);
?>
<tr>
<?php if($trial_id !== false) { ?>
	<td><a href="<?php echo $this->createUrl('/trials/'.$trial_id) ?>"><?php echo CHtml::encode($actual_trial_models[$trial_id]->title); ?></a></td>
<?php } else { 
	// else what mother fucka? What the f do we do here? 
	?>
        <td><input type="text" size="15" placeholder="Trial <?php echo $trialindex ?>" value="" class="trial-name-input" id="trial-name-input-<?php echo $possible_trial_index ?>" /><span class="trial-name-placeholder">unnamed</span></td>
<?php } ?>
<?php foreach($ptrial as $variable_id => $value): ?>
        <td class="variable_<?php echo $variable_id ?>_value"><?php echo $value ?></td>
<?php endforeach; ?>
<?php /* 
foreach($experiment->constants as $constant):
        <td class="constant_<?php echo $constant->constant_id ?>_value"><?php echo $constant->description ?></td>
endforeach;*/ ?>
<?php foreach($experiment->metrics as $metric): ?>
        <?php // This is going to be the average of the test data, if there is test data! (Rounded to 2 places. Shea)?>
        <?php if($trial_id !== false) { ?>
        <td class="metric_<?php echo $metric->metric_id ?>_value">avg: <?php echo round($actual_trial_models[$trial_id]->average_for_metric($metric), 4); ?></td>
        <?php } else { ?>
        <td class="metric_<?php echo $metric->metric_id ?>_value"></td>
        <?php } ?>
<?php endforeach; 
if($trial_id !== false) {
?>
        <td><?php echo $actual_trial_models[$trial_id]->resultCount() ?></td>
		<?php if(AccessControl::canWriteTrial($trial_id)):?>
        <td class="trial-actions">
        	<span>
				<a href="<?php echo $this->createUrl('/trials/update/'.$trial_id) ?>" class="btn btn-mini btn-success">Edit</a>
	        	<a href="<?php echo $this->createUrl('/trials/'.$trial_id) ?>" class="btn btn-mini btn-info" style="margin-left: 0.5em;">Add Data</a>
	        </span>
        </td>
		<?php endif;?>
<?php
} else {
        $querystring = "?";
        $hidden_fields = "";
        foreach($ptrial as $var_id => $val):
                $querystring = $querystring . "variables[" . $var_id . "]=" . $val . "&";
                $hidden_fields .= "<input name='variables[{$var_id}]' type='hidden' value='{$val}' />";
        endforeach;
        $querystring = $querystring . "experiment_id=" . $experiment->experiment_id;
?>
        <td>0</td>
		<?php if(AccessControl::canGatherExperiment($experiment->experiment_id)):?>
        <td class="trial-actions">
        	<span>
        		<a href="<?php echo $this->createUrl('/trials/create'.$querystring) ?>" class="btn btn-mini btn-info btn-new-trial-data" data-trial-source="trial-name-input-<?php echo $possible_trial_index ?>" data-possible-trial-index="<?php echo $possible_trial_index ?>">Add Data</a>
        	</span>
        	<form method="post" id="create-trial-<?php echo $possible_trial_index ?>" action="<?php echo $this->createUrl('/trials/create?experiment_id='.$experiment->experiment_id) ?>"><input type="hidden" id="new-trial-name-<?php echo $possible_trial_index ?>" name="Trials[title]" /><?php echo $hidden_fields; ?></form>
        </td>
		<?php endif;?>
<?php
}
?>

		</tr>
<?php
endforeach;
?>
	</tbody>
</table>


<script type="text/javascript">
	$(document).ready( function() {
		$(".btn-new-trial-data").on('click', function(event){
			event.preventDefault();
			
			var possible_trial_index = $(this).data('possible-trial-index');
			var new_trial_name = $('#trial-name-input-' + $(this).data('possible-trial-index')).val();
			
			if ( new_trial_name == '') {
				new_trial_name = $('#trial-name-input-' + $(this).data('possible-trial-index')).attr('placeholder');
			}
			
			$('#new-trial-name-' + possible_trial_index).val(new_trial_name);
			
			$('#create-trial-' + possible_trial_index).submit();
			
			//alert(new_trial_name);
		});
	});
</script>
