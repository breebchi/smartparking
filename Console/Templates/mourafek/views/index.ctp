<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<?php 
 echo "<?php \$this->Paginator->options(\$ajax); ?>\n"; 
?>
<ol class="breadcrumb">
	<li class="active"><?php echo "<?php echo __('{$pluralHumanName}'); ?>"; ?></li>
</ol>
<div class="widget widget-blue <?php echo $pluralVar; ?> index">
	<div class="widget-title">
		<div class="widget-controls">
		<?php 
		echo "\t\t\t\t\t\t\t<?php echo \$this->Js->link(\$this->Html->tag('i', '', array('class'=>'fa fa-plus-circle')), array('action' => 'add'), array_merge(\$ajax, array('class'=>'widget-control widget-control-full-screen', 'escape'=>false, 'title'=>__('Add'), 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>__('Add')))); ?>\n";
		?>
		</div>
		<h3><i class="fa fa-table"></i><?php echo "<?php echo __('{$pluralHumanName}'); ?>"; ?></h3>
	</div>
	<div class="widget-content">
        <div class="table-responsive">
        	<table class="table table-bordered table-hover table-striped">
          		<thead>
            		<tr>
			<?php foreach ($fields as $field): ?>
			<th><?php echo "<?php echo \$this->Paginator->sort('{$field}'); ?>"; ?></th>
			<?php endforeach; ?>
			<th class="actions"><?php echo "<?php echo __('Actions'); ?>"; ?></th>
            		</tr>
          		</thead>
          		<tbody>
		            <?php
					echo "<?php foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
						echo "\t\t\t\t\t<tr>\n";
						foreach ($fields as $field) {
							$isKey = false;
							if (!empty($associations['belongsTo'])) {
								foreach ($associations['belongsTo'] as $alias => $details) {
									if ($field === $details['foreignKey']) {
										$isKey = true;
										echo "\t\t\t\t\t\t<td>\n\t\t\t<?php echo \$this->Js->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}']), \$ajax); ?>\n\t\t</td>\n";
										break;
									}
								}
							}
							if ($isKey !== true) {
								echo "\t\t\t\t\t\t<td><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";
							}
						}
				
						echo "\t\t\t\t\t\t<td class=\"actions text-right\">\n";
						echo "\t\t\t\t\t\t\t<?php echo \$this->Js->link(\$this->Html->tag('i', '', array('class'=>'fa fa-eye')), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array_merge(\$ajax, array('class'=>'btn btn-success btn-xs', 'escape'=>false, 'title'=>__('View'), 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>__('View')))); ?>\n";
						echo "\t\t\t\t\t\t\t<?php echo \$this->Js->link(\$this->Html->tag('i', '', array('class'=>'fa fa-pencil')), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array_merge(\$ajax, array('class'=>'btn btn-warning btn-xs', 'escape'=>false, 'title'=>__('Edit'), 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>__('Edit')))); ?>\n";
						echo "\t\t\t\t\t\t\t<?php echo \$this->Form->postLink(\$this->Html->tag('i', '', array('class'=>'fa fa-trash-o')), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class'=>'btn btn-danger btn-xs', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>__('Delete'), 'escape'=>false), __('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
						echo "\t\t\t\t\t\t</td>\n";
					echo "\t\t\t\t\t</tr>\n";
				
					echo "\t\t\t\t\t<?php endforeach; ?>\n";
					?>
				</tbody>
			</table>
			<div class="row">
				<div class="col-sm-12">
					<div class="pull-left">
						<div id="DataTables_Table_0_info" class="dataTables_info" style="margin-top: 18px;">
						<?php echo "<?php
						echo \$this->Paginator->counter(array(
						'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
						));
						?>"; ?>
						</div>
					</div>
					<div class="pull-right">
						<div class="dataTables_paginate paging_bootstrap">
							<ul class="pagination pagination-sm">
								<?php
							      	echo "<?php\n";
							       	echo "\t\t\t\t\t\t\techo \$this->Paginator->prev('← ' . __('previous'), array('tag' => 'li'), null, array('class' => 'prev disabled', 'tag' => 'li'));\n";
							       	echo "\t\t\t\t\t\t\techo \$this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentClass' => 'active'));\n";
							       	echo "\t\t\t\t\t\t\techo \$this->Paginator->next(__('next') . ' →', array('tag' => 'li'), null, array('class' => 'next disabled', 'tag' => 'li'));\n";
							       	echo "\t\t\t\t\t\t\t?>\n";
								?>
							</ul>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo "<?php echo \$this->Js->writeBuffer(); ?>"; ?>