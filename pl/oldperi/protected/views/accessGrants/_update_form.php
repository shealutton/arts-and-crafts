<form method="post" action="<?php echo $this->createUrl('/accessGrants/update/'.$model->access_grant_id) ?>" class="form form-inline" data-remote="true" id="accessgrant-<?php echo $model->access_grant_id ?>" >
        <div class="well">
          <p>Set access level for <?php echo $user->firstname . " " . $user->lastname; ?>
          <p>
            <label for="level">Select Access Level:</label>
            <select name="level" id="level">
              <option value="reviewer" <?php if($model->level=="reviewer"){echo "selected";} ?>>Reviewer</option>
              <option value="collaborator" <?php if($model->level=="collaborator"){echo "selected";} ?>>Collaborator</option>
              <option value="owner" <?php if($model->level=="owner"){echo "selected";} ?>>Owner</option>
            </select>*
          </p>
          <p><input type="submit" name="Save" value="Save" /></p>
        </div>
</form>
