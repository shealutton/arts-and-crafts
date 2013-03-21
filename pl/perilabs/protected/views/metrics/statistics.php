		<?php echo $trial->title; ?></h3>
        <h3><?php echo $metric->title; ?></h3>
        <p>
        <?php foreach($results as $key => $value) { 
		if ( $key == "Histogram" ) {
			echo "</p><h4>";
			echo $metric->title; 
			echo " Histogram</h4><p>";
		} else { ?>
                	<span><?php echo ucwords(str_replace("_", " ", $key)) ?>:</span> <?php echo $value ?></br>
		<?php } 
        }; ?>
        </p>
