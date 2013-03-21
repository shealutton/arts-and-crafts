<?php
        $content = $this->renderPartial("_list_view", array("model" => $model), true);
        $content = json_encode($content);
?>
$('#invitation-<?php echo $model->invitation_id ?>').replaceWith(<?php echo $content ?>);
