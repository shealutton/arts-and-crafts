<?php $this->beginContent('//layouts/main'); ?>
  <div class="row-fluid">
    <div class="span9">
      <div id="content">
        <?php echo $content; ?>
      </div><!-- content -->
    </div>
    <div class="span3">
      <div id="sidebar">
      <?php
        $this->widget('bootstrap.widgets.BootMenu', array(
          'type'=>'list',
          'items'=>$this->menu,
          'encodeLabel'=>false,
          'htmlOptions'=>array('class'=>'operations'),
        ));
      ?>
      </div><!-- sidebar -->
    </div>
  </div>
<?php $this->endContent(); ?>
