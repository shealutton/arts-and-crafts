<h1>Are you sure?</h1>

<p>Deleting items is a permanent act. There is no undo. If you are sure you want to delete the file named "<?php echo $model->file_name ?>", type "DELETE" in the box below.</p>

<form method="post">
        <input type="text" name="confirmation" autofocus="autofocus" /><br />
        <input type="submit" value="Yup, I'm sure" class="btn btn-danger" />
</form>
