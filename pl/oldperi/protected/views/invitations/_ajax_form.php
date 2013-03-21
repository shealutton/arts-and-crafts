<form method="post" action="<?php echo $this->createUrl('/invitations/update/'.$model->invitation_id) ?>" class="form form-inline" data-remote="true" id="invitation-<?php echo $model->invitation_id ?>" >
        <div class="well">
          <p>Set access level for <?php echo $model->email_address; ?>
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
