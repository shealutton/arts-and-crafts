<?php
$this->breadcrumbs=array(
	'Search Results',
);

$baseUrl = Yii::app()->request->hostInfo . Yii::app()->request->baseUrl;
?><h1>Search Results</h1>
<a href="<?php echo $baseUrl;?>/experiments">Back to Experiments</a>
<div>&nbsp;</div>
<?php 
echo $result;
?>
