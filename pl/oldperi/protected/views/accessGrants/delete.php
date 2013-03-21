<h1>Are you sure?</h1>

<p>If you are sure you want to remove <?php echo YumUser::model()->findByPk($model->user__id)->profile->firstname ?> <?php echo YumUser::model()->findByPk($model->user__id)->profile->lastname ?> from the project click "Yup, I'm sure" below.</p>

<form method="post">
        <input type="submit" value="Yup, I'm sure" />
</form>

