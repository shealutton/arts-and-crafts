<h1>Share your experiment</h1>
<p>Here is the list of accounts with access to "<?php echo $experiment->title ?>"</p>
  <ul id="accessgrants-list">
    <?php foreach($accessgrants as $accessgrant):
        $this->renderPartial('_list_view', array("model"=>$accessgrant));
    endforeach; ?>
  </ul>

<?php if(sizeof($invitations) > 0) { ?>
        <p>Here is a list of pending requests:</p>
        <ul id="invitations-list">
        <?php foreach($invitations as $invitation):
                $this->renderPartial('/invitations/_list_view', array("model"=>$invitation));
        endforeach; ?>
        </ul>
<?php } ?>
   
<?php $this->renderPartial('_form', array("model" => new AccessGrants(), "experiment" => $experiment));
