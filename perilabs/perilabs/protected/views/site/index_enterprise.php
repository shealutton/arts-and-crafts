<?php $this->pageTitle=Yii::app()->name; ?>
<div class="container frontpage">
<?php
if (Yii::app()->user->isGuest) { ?>
	<div class="centered">
	        <div>
                  <?php $this->renderPartial('login', array('model' => new LoginForm(), 'title' => "Peri Labs for Enterprise")) ?>
	        </div>
	</div>

<?php } else { ?>
   	<div class="row">
		<div class="span12">
			<h1>Peri Labs for Enterprise</h1>
		</div>
	</div>
   	<div class="row margintop">
		<div class="span5">
			<div class="well">
			<h2>Active Experiments</h2>
<?php
        $user = User::model()->findByPk(Yii::app()->user->id); 
        $connection = Yii::app()->db2;
        $sql="SELECT experiment_id, title, last_updated 
        FROM experiments 
        WHERE organization__id IN (
            SELECT organization__id                                                           
            FROM memberships
            WHERE user__id = '$user->id') 
        ORDER BY last_updated DESC;";
        $command = $connection->createCommand($sql);
        $results = $command->query();
        foreach($results as $result):
?>
<h3><a href="<?php echo $this->createUrl('experiments/view', array("id" => $result["experiment_id"])) ?>"><?php echo $result["title"] ?></a></h3>
<p>Last Updated: <?php echo $result["last_updated"] ?></p>
<?php
        endforeach;
?>
			</div>
		</div>
		<div class="span5">
			<div class="well">
			<h2>Active Users</h2>
<?php
        foreach($user->organizations as $organization):
                echo "<h3>$organization->name</h3>";
                echo "<ul>";
                foreach($organization->memberships as $member):
                        $user = $member->user;
                        echo "<li><a href='mailto:$user->email'>$user->firstname $user->lastname</a>: $member->level</li>";
                endforeach;
                echo '</ul>';
        endforeach;
?>
			</div>
		</div>
   	</div>
   </div>
<?php } ?>
<br>
</div>
