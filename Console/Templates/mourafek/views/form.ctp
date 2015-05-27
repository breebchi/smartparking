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
<div class="widget widget-blue <?php echo $pluralVar; ?>form">
	<div class="widget-title">
		<div class="widget-controls">
			<?php 
				echo "\t\t\t\t\t\t\t<?php echo \$this->Js->link(\$this->Html->tag('i', '', array('class'=>'fa fa-list-alt')), array('action' => 'index'), array_merge(\$ajax, array('class'=>'widget-control widget-control-full-screen', 'escape'=>false, 'title'=>__('List'), 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>__('List')))); ?>\n";
			?>
		</div>
		<h3><i class="fa fa-table"></i><?php printf("<?php echo __('%s %s'); ?>", Inflector::humanize($action), $singularHumanName); ?></h3>
	</div>
	<div class="widget-content">
		<?php echo "<?php echo \$this->Form->create('{$modelClass}', array('class'=>'form-horizontal', 'role'=>'form'));?>\n";?>
			<?php
			echo "<?php\n";
			foreach ($fields as $field) {
				if (strpos($action, 'add') !== false && $field === $primaryKey) {
					continue;
				} elseif (!in_array($field, array('created', 'modified', 'updated'))) {
					echo "\t\t\techo \$this->Form->input('{$field}', array('class'=>'form-control'));\n";
				}
			}
			if (!empty($associations['hasAndBelongsToMany'])) {
				foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
					echo "\t\techo \$this->Form->input('{$assocName}', array('class'=>'form-control'));\n";
				}
			}
			echo "\t\t\t?>\n";
			?>
			<div class="form-group shadowed-top">
              	<div class="col-md-offset-4 col-md-8">
				<?php
				if (strpos($action, 'edit') === false){
					echo "<?php echo \$this->Js->submit(__('Submit'), array_merge(\$ajax, array('title' => sprintf(__('Save %s'), __('{$singularHumanName}')), 'class' => 'btn btn-primary', 'div' => false))); ?>\n";
				}else{
					echo "<?php echo \$this->Js->submit(__('Submit'), array_merge(\$ajax, array('url'=> array('action'=>'edit'), 'title' => sprintf(__('Save %s'), __('{$singularHumanName}')), 'class' => 'btn btn-primary', 'div' => false))); ?>\n";
				}
				?>
          		</div>
          	</div>
		<?php echo "<?php echo \$this->Form->end();?>\n"; ?>
	</div>
</div>
<?php echo "<?php echo \$this->Js->writeBuffer(); ?>"; ?>