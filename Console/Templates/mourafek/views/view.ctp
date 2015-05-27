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
<ol class="breadcrumb">
	<li class="active"><?php echo "<?php echo __('{$pluralHumanName}'); ?>"; ?></li>
</ol>
<div class="widget widget-blue <?php echo $pluralVar; ?> view">
	<div class="widget-title">
		<div class="widget-controls">
		<?php echo "\t<?php echo \$this->Js->link(\$this->Html->tag('i', '', array('class'=>'fa fa-pencil')), array('action' => 'edit',\${$singularVar}['{$modelClass}']['{$primaryKey}']), array_merge(\$ajax, array('class'=>'widget-control widget-control-full-screen', 'escape'=>false, 'title'=>__('Edit'), 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>__('Edit')))); ?>\n";?>
		<?php echo "\t<?php echo \$this->Js->link(\$this->Html->tag('i', '', array('class'=>'fa fa-plus-circle')), array('action' => 'add'), array_merge(\$ajax, array('class'=>'widget-control widget-control-full-screen', 'escape'=>false, 'title'=>__('Add'), 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>__('Add')))); ?>\n";?>
		<?php echo "\t<?php echo \$this->Js->link(\$this->Html->tag('i', '', array('class'=>'fa fa-list-alt')), array('action' => 'index'), array_merge(\$ajax, array('class'=>'widget-control widget-control-full-screen', 'escape'=>false, 'title'=>__('List'), 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>__('List')))); ?>\n";?>
		</div>
		<h3><i class="fa fa-table"></i><?php echo "<?php echo __('{$pluralHumanName}'); ?>"; ?></h3>
	</div>
	<div class="widget-content">
        <div class="row">
	        <?php
	        echo "<dl>\n";
				foreach ($fields as $field) {
					$isKey = false;
					if (!empty($associations['belongsTo'])) {
						foreach ($associations['belongsTo'] as $alias => $details) {
							if ($field === $details['foreignKey']) {
								$isKey = true;
								echo "\t\t\t\t<dt><?php echo __('" . Inflector::humanize(Inflector::underscore($alias)) . "'); ?></dt>\n";
								echo "\t\t\t\t<dd>
					<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>
					&nbsp;
						</dd>\n";
								break;
							}
						}
					}
					if ($isKey !== true) {
						echo "\t\t\t\t<dt><?php echo __('" . Inflector::humanize($field) . "'); ?></dt>\n";
						echo "\t\t\t\t<dd>
					<?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>
					&nbsp;
				</dd>\n";
					}
				}
			echo "\t\t\t</dl>\n";
			?>
		</div>
	</div>
</div>
<?php echo "<?php echo \$this->Js->writeBuffer(); ?>"; ?>
