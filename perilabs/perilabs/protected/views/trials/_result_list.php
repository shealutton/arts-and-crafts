<?php
//Set config for script Ajax-Scroll instead of pagination page.
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScript('ajaxScroll','
	$(document).ready(function(){
		jQuery.ias({
			container : "#results-section",
			item: ".result",
			pagination: "#results-section .yiiPager",
			next: ".next a",
			loader: "<img src=\''.$baseUrl.'/js/ajax-scroll/images/loader.gif\'/>",
		});
	});
');
?>

<div id="results-section">
<?php
echo "<p>" . $listData['row_count'] . " results found.</p>\n";
$this->renderPartial('//results/_grid_view', array('listData'=>$listData, 'html_id'=>'results-list', 'model'=>$model));
//the pagination widget with some options to mess
$this->widget('CLinkPager', array(
			'pages' => $listData['pages'],
			'header'=>'',
        ));
?>
</div>
