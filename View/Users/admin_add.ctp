
<div class="widget widget-blue usersform">
	<div class="widget-title">
		<div class="widget-controls">
										<?php echo $this->Js->link($this->Html->tag('i', '', array('class'=>'fa fa-list-alt')), array('action' => 'index'), array_merge($ajax, array('class'=>'widget-control widget-control-full-screen', 'escape'=>false, 'title'=>__('List'), 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>__('List')))); ?>
		</div>
		<h3><i class="fa fa-table"></i><?php echo __('Admin Add User'); ?></h3>
	</div>
	<div class="widget-content">
		<?php echo $this->Form->create('User', array('class'=>'form-horizontal', 'role'=>'form'));?>
			<?php
			echo $this->Form->input('username', array('class'=>'form-control'));
			echo $this->Form->input('password', array('class'=>'form-control'));
			echo $this->Form->input('privilege', array('class'=>'form-control'));
			echo $this->Form->input('active', array('class'=>'form-control'));
			?>
			<div class="form-group shadowed-top">
              	<div class="col-md-offset-4 col-md-8">
				<?php echo $this->Js->submit(__('Submit'), array_merge($ajax, array('title' => sprintf(__('Save %s'), __('User')), 'class' => 'btn btn-primary', 'div' => false))); ?>
          		</div>
          	</div>
		<?php echo $this->Form->end();?>
	</div>
</div>
<?php echo $this->Js->writeBuffer(); ?>