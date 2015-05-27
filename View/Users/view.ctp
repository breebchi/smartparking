<ol class="breadcrumb">
	<li class="active"><?php echo __('Users'); ?></li>
</ol>
<div class="widget widget-blue users view">
	<div class="widget-title">
		<div class="widget-controls">
			<?php echo $this->Js->link($this->Html->tag('i', '', array('class'=>'fa fa-pencil')), array('action' => 'edit',$user['User']['id']), array_merge($ajax, array('class'=>'widget-control widget-control-full-screen', 'escape'=>false, 'title'=>__('Edit'), 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>__('Edit')))); ?>
			<?php echo $this->Js->link($this->Html->tag('i', '', array('class'=>'fa fa-plus-circle')), array('action' => 'add'), array_merge($ajax, array('class'=>'widget-control widget-control-full-screen', 'escape'=>false, 'title'=>__('Add'), 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>__('Add')))); ?>
			<?php echo $this->Js->link($this->Html->tag('i', '', array('class'=>'fa fa-list-alt')), array('action' => 'index'), array_merge($ajax, array('class'=>'widget-control widget-control-full-screen', 'escape'=>false, 'title'=>__('List'), 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>__('List')))); ?>
		</div>
		<h3><i class="fa fa-table"></i><?php echo __('Users'); ?></h3>
	</div>
	<div class="widget-content">
        <div class="row">
	        <dl>
				<dt><?php echo __('Id'); ?></dt>
				<dd>
					<?php echo h($user['User']['id']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Username'); ?></dt>
				<dd>
					<?php echo h($user['User']['username']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Password'); ?></dt>
				<dd>
					<?php echo h($user['User']['password']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Active'); ?></dt>
				<dd>
					<?php echo h($user['User']['active']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Created'); ?></dt>
				<dd>
					<?php echo h($user['User']['created']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Modified'); ?></dt>
				<dd>
					<?php echo h($user['User']['modified']); ?>
					&nbsp;
				</dd>
			</dl>
		</div>
	</div>
</div>
<?php echo $this->Js->writeBuffer(); ?>