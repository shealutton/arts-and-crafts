<?php
$this->breadcrumbs=array(
	'Results',
);
?>

<h1>Results</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
