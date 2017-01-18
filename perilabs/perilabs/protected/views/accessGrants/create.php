<?php
$this->breadcrumbs=array(
  'Access Grants'=>array('index'), // TODO: change this to experiment name
  'Create',
);
?>
<h1>Grant Access</h1>

<?php if ($errors !== NULL): ?>
  <p class="error" style="color: red"><?php echo $errors ?></p>
<?php endif; ?>

<?php $this->renderPartial('_form', array("model" => new AccessGrants(), "experiment" => $experiment)); ?>
