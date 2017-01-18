<h1>Are you sure?</h1>

<p>Deleting items is a permanent act. There is no undo. If you are sure you want to delete the invitation for the email address <?php echo $model->email_address ?>, type "DELETE" in the box below.</p>

<form method="post">
        <input type="text" id="inputfocus" name="confirmation" />
        <input type="submit" value="Yup, I'm sure" />
</form>
<script>$("#inputfocus").focus()</script>
