<h1>Please Upgrade your Account</h1>

<h3> You are currently using <?php echo Experiments::model()->count('"user__id"=:owner_id', array(":owner_id" => Yii::app()->user->id)); ?> experiment slots. You only have <?php echo Yii::app()->user->availableExperiments() ?> available.</h3>
<p>In order to create more experiments, you must upgrade to a larger plan. Contact Peri Labs <a href="mailto:support@perilabs.com">Support Team</a> to upgrade your account.</p>
