<?php
if($model->access_grant_id == null) {
  $url = $this->createAbsoluteUrl("accessGrants/create", array('id'=>$experiment->experiment_id));
  $id = "create-accessgrant-form";
  $subheading = "<h4>Grant Access</h4>";
} else {
  $url = $this->createAbsoluteUrl("accessGrants/update", array('id'=>$model->result_id));
  $id = "accessgrant-$model->access_grant_id";
  $subheading = "<h4>Edit Access</h4>";
}
?>
<?php echo $subheading ?>
<form action="<?php echo $url ?>" data-remote="true" method="POST" id="<?php echo $id ?>">
                <div class="well">
          <p>Enter the email address for the user you would like to add to the project:</p>
          <p>
            <label for="email">Email Address:</label>
            <input name="email" id="email" type="text" />
          </p>
          <p>
            <label for="level">Select Access Level:</label>
            <select name="level" id="level" />
              <option value="reviewer">Reviewer</option>
              <option value="collaborator">Collaborator</option>
              <option value="owner">Owner</option>
            </select>*
          </p>
          <b>* Key *</b>
          <ul>
            <li>Reviewer = read only.</li>
            <li>Collaborator = read and make changes.</li>
            <li>Owner = read, make changes, and manage access.</li>
          </ul>

          <input name="Add to Project" type="submit" />
                </div>
        </form>
