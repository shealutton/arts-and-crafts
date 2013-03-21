            <table style="border: none; width: 100%;">
                <tr>
                    <td><?php echo CHtml::activeLabelEx($model,'title'); ?></td>
                    <td><?php echo CHtml::activeTextField($model,'title',array('size'=>60,'maxlength'=>100,'id'=>'inputfocus')); ?></td>
		    <script>$("#inputfocus").focus()</script>
                </tr>
                
                <?php foreach($trial->experiment->metrics as $metric): ?>
                <tr>
                    <td><label for="metrics[<?php echo $metric->metric_id ?>]"><?php echo $metric->title ?></label></td>
                    <td>
                        <?php $val = $model->value_for_metric($metric) ?>
                        <?php
                        switch($metric->data_type__id) {
                        case 1:
                        // boolean
                        ?>
                        <select name="metrics[<?php echo $metric->metric_id ?>]">
                            <option>Select...</option>
                            <option value="1" <?php if($val == true or $val == "1") { echo "selected='selected'"; }?>>Yes/True</option>
                            <option value="0" <?php if($val === false or $val == "0") { echo "selected='selected'"; }?>>No/False</option>
                        </select>
                        
                        <?php
                        break;
                        case 2:
                        // Integer
                        ?>
                        <input type="number" name="metrics[<?php echo $metric->metric_id ?>]" value="<?php echo $val ?>" />
                        
                        <?php
                        break;
                        case 3:
                        // Real number
                        ?>
                        <input type="text" name="metrics[<?php echo $metric->metric_id ?>]" value="<?php echo $val ?>" />
                        
                        <?php
                        break;
                        case 4:
                        // text
                        ?>
                        <input type="text" name="metrics[<?php echo $metric->metric_id ?>]" value="<?php echo $val ?>" />
                        
                        <?php
                        break;
                        case 6:
                        // Timestamp
                                if($val == NULL) {
                                        $val = date("Y-m-d G:i:s");
                                }
                        ?>
                        <input name="metrics[<?php echo $metric->metric_id ?>]" value="<?php echo $val ?>" />
                        <?php
                        break;
                        }
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>

