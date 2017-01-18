<?php
if($model->membership_id == null) {
        $url = $this->createAbsoluteUrl("memberships/create", array('id'=>$organization->organization_id));
        $id = "create-membership-form";
        $subheading="<h2>Invite People To Your Organization</h2>";
} else {
        $url = $this->createAbsoluteUrl("memberships/update", array('id'=>$model->membership_id));
        $id = "membership-$model->membership_id";
        $subheading = "<h3>Edit Membership</h3>";
}
echo $subheading;
?>

<form action="<?php echo $url ?>" data-remote="true" method="POST" id="<?php echo $id ?>">
        <div class="">
                  <p>Enter the email address for the user you would like to add to the organization:</p>
          <p>
            <label for="email">Email Address:</label>
            <input name="email" id="email" type="text" />
          </p>
          <p>
            <label for="level">Select Access Level:</label>
            <select name="level" id="level" />
              <option value="member">Member</option>
              <option value="manager">Manager</option>
            </select>
          </p>
          <b>Key</b>
          <ul>
            <li>Organization Member   = View and copy experiments.</li>
            <li>Organization Manager  = View and collaborate on experiments and manage group access.</li>
          </ul>

          <input name="Add to Organization" type="submit" />
        </div>
</form>
