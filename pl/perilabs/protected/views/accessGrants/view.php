<h1>Share your experiment</h1>
  <div class="row">
    <div class="span12 wellbackground">
      <div class="row">
	<div class="span6">
	<?php if($experiment->organization->plan == "free") { ?>
	  <p>Free accounts cannot share individual experiments with people outside their organization. Upgrade to enable this feature.</p>
	  </br></br>
	<?php } else { 
	  if(AccessControl::canShareExperiment($_REQUEST["id"])) {
                $this->renderPartial('_form', array("model" => new AccessGrants(), "experiment" => $experiment));
	  }
	}?>
	</div>
	<div class="span6">
	  <h2>Accounts with access to "<?php echo $experiment->title ?>"</h2>
	  <ul id="accessgrants-list">
	  <?php foreach($accessgrants as $accessgrant):
	      $this->renderPartial('_list_view', array("model"=>$accessgrant));
	  endforeach; ?>
	  </ul>

	  <p>Pending invitations to this experiment:</p>
	  <ul id="invitations-list">
	  <?php foreach($invitations as $invitation):
		if ($invitation->invited__id == null) {
			$this->renderPartial('/invitations/_list_view', array("model"=>$invitation));
	  	}
	  endforeach; ?>
	  </ul>
	</div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="span12 wellbackground">
      <div class="row">
        <div class="span6">
	  <?php if(AccessControl::canShareOrganization($experiment->organization->organization_id)) {
                $this->renderPartial('/memberships/_form', array("model" => new Memberships(), "organization" => $experiment->organization));
          } ?>
	</div>
	<div class="span6">
	  <h2>People In The Organization: <?php echo $experiment->organization->name ?></h2>
	  <p>Adding people to your Organization allows them to see all of the experiments in that Organization. Add people from your team or group to your Organization.</p>
	  <ul id="members-list">
	  <?php
	  foreach($experiment->organization->memberships as $member):
		$this->renderPartial('/memberships/_list_view', array("model"=>$member));
	  endforeach;
	  ?>
	  </ul>
	  <p>Pending invitations to the whole organization:</p>
	  <ul id="organization-invitations-list">
	  <?php 
          $organization_invitations = Invitations::model()->findAll("organization__id=:organization_id", array(':organization_id' => $experiment->organization->organization_id));
          foreach($organization_invitations as $invitation):
                if($invitation->invited__id == null) {
                        $this->renderPartial('/invitations/_list_view', array("model"=>$invitation));
                }
          endforeach;
	  ?>
	  </ul>
	</div>
      </div>
    </div>
  </div>

</br>
<h3>Permissions Reference Chart</h3>
<table class="table table-condensed table-bordered table-striped">
  <thead>
	<tr>
        <th>Role</th>
        <th>Access To:</th>
        <th>Add Org Members:</th>
        <th>Read:</th>
        <th>Copy:</th>
        <th>Design*:</th>
        <th>Gather**:</th>
        <th>Lock/Unlock:</th>
        <th>Delete:</th>
        <th>Share:</th>
	</tr>
  </thead>
  <tbody>
	<tr>
	<td>Site Admin</td>
	<td class="center">All Experiments</td>
	<td class="center">X</td>
	<td class="center">X</td>
	<td class="center">X</td>
	<td class="center">X</td>
	<td class="center">X</td>
	<td class="center">X</td>
	<td class="center">X</td>
	<td class="center">X</td>
	</tr>
        <tr>
        <td>Organization Manager</td>
        <td class="center">Org Experiments</td>
        <td class="center">X</td>
        <td class="center">X</td>
        <td class="center">X</td>
        <td class="center">X</td>
        <td class="center">X</td>
        <td class="center">X</td>
        <td class="center">X</td>
        <td class="center">X</td>
        </tr>
        <tr>
        <td>Organization Member</td>
        <td class="center">Org Experiments</td>
        <td class="center"></td>
        <td class="center">X</td>
        <td class="center">X</td>
        <td class="center"></td>
        <td class="center"></td>
        <td class="center"></td>
        <td class="center"></td>
        <td class="center"></td>
        </tr>
        <tr>
        <td>Experiment Owner</td>
        <td class="center">Single Experiment</td>
        <td class="center"></td>
        <td class="center">X</td>
        <td class="center">X</td>
        <td class="center">X</td>
        <td class="center">X</td>
        <td class="center">X</td>
        <td class="center">X</td>
        <td class="center">X</td>
        </tr>
        <tr>
        <td>Experiment Collaborator</td>
        <td class="center">Single Experiment</td>
        <td class="center"></td>
        <td class="center">X</td>
        <td class="center">X</td>
        <td class="center">X</td>
        <td class="center">X</td>
        <td class="center"></td>
        <td class="center"></td>
        <td class="center"></td>
        </tr>
        <tr>
        <td>Experiment Reviewer</td>
        <td class="center">Single Experiment</td>
        <td class="center"></td>
        <td class="center">X</td>
        <td class="center"></td>
        <td class="center"></td>
        <td class="center"></td>
        <td class="center"></td>
        <td class="center"></td>
        <td class="center"></td>
        </tr>
  </tbody>
</table>
  <div class="span12">
    <p>* If the experiment is locked, nobody can Design</br>** If the experiment is unlocked, nobody can Gather</p>
  </div>
</div>

