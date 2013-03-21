        <ul id="document-list">
                <?php foreach($documents as $document): ?>

						<?php 
                        //$user = YumUser::model()->findByPk($document->user__id); // If USE MODULE 'yii-user-management'
                        $user = User::model()->findByPk($document->user__id);
                        ?>
						<li <?php if($document->parseable === false) { echo 'class="error" style=""';} ?>>
						<a href="<?php echo $this->createUrl('/documents/' . $document->document_id) ?>" title="uploaded by <?php echo $user->firstname . ' ' . $user->lastname ?>, <?php echo $document->date_created?>">
							<?php echo $document->file_name ?>
						</a>
                        <?php if(AccessControl::canDeleteDocument($document->document_id)): ?>
						<a href="<?php echo $this->createUrl('/documents/delete/' . $document->document_id) ?>" title="Delete"><img src="<?php echo Yii::app()->baseUrl ?>/images/remove.png" /></a>
										<?php if($document->parseable === false) { ?>
										<br />
										<?php echo $document->parse_error_reason ?>
										<?php } ?>
                        <?php endif;?>
						</li>

                <?php endforeach; ?>
        </ul>
