<?php echo "<?php "; ?>
/**
 *@var $this View
 */
<?php echo "?>"; ?>
<div class="row">
	<div class="span16 columns">
	<?php echo "<?php echo \$this->Form->create('{$modelClass}', array(
				'inputDefaults' => array(
				'label' => false,
				)
			));?>\n";?>
	<fieldset>
		<legend><?php printf("<?php __('%s %s'); ?>", Inflector::humanize($action), $singularHumanName); ?></legend>
<?php
		foreach ($fields as $field) {
			if (strpos($action, 'add') !== false && $field == $primaryKey) {
				continue;
			} elseif (!in_array($field, array('created', 'modified', 'updated'))) {
				?>
		<div class="clearfix<?php echo "<?php if (!empty(\$errors)&&array_key_exists('{$field}',\$errors)) { ?> error<?php }?>";?>"<?php if ($field == $primaryKey) { ?> style="display:none;"<?php } ?>>
		<?php echo "\t<?php echo \$this->Form->label('{$field}'); ?>\n"; ?>
        <?php echo "\t<?php \$after = ''; ?>\n"; ?>
        <?php echo "\t<?php if (!empty(\$errors)&&array_key_exists('{$field}',\$errors)) { ?>\n"; ?>
        <?php echo "\t\t<?php \$after = '<span class=\"help-inline\">'.\$errors['{$field}'].'</span>'; ?>\n"; ?>
        <?php echo "\t<?php } ?>\n"; ?>
        <?php echo "\t<?php echo \$this->Form->input('{$field}',array('after'=>\$after)); ?>\n"; ?>
        </div>
<?php
			}
		}
		if (!empty($associations['hasAndBelongsToMany'])) {
			foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
				?>
		<div class="clearfix<?php echo "<?php if (!empty(\$errors)&&array_key_exists('{$assocName}',\$errors)) { ?> error<?php }?>";?>">
        <?php echo "\t<?php echo \$this->Form->label('{$assocName}'); ?>\n"; ?>
        <?php echo "\t<?php \$after = ''; ?>\n"; ?>
        <?php echo "\t<?php if (!empty(\$errors)&&array_key_exists('{$assocName}',\$errors)) { ?>\n"; ?>
        <?php echo "\t\t<?php \$after = '<span class=\"help-inline\">'.\$errors['{$assocName}'].'</span>'; ?>\n"; ?>
        <?php echo "\t<?php } ?>\n"; ?>
        <?php echo "\t<?php echo \$this->Form->input('{$assocName}',array('after'=>\$after)); ?>\n"; ?>
        </div>
<?php
			}
		}
?>
		<div class="actions">
		<?php echo "\t<?php echo \$this->Form->button(__('Save', true),array('class'=>'btn primary'));?>\n"; ?>
		</div>
	</fieldset>
    <?php echo "<?php echo \$this->Form->end(); ?>\n"; ?>
	</div>
</div>
<div class="well">
<?php if (strpos($action, 'add') === false): ?>
	<?php echo "<?php echo \$this->Html->link(__('Borrar', true), array('action' => 'delete', \$this->Form->value('{$modelClass}.{$primaryKey}')), array('class'=>'btn danger'), sprintf(__('Estas seguro que quieres borrar el # %s?', true), \$this->Form->value('{$modelClass}.{$primaryKey}'))); ?>\n";?>
<?php endif;?>
	<?php echo "<?php echo \$this->Html->link(__('List " . $pluralHumanName . "', true), array('action' => 'index'), array('class'=>'btn'));?>\n";?>
<?php
		$done = array();
		foreach ($associations as $type => $data) {
			foreach ($data as $alias => $details) {
				if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
					echo "\t<?php echo \$this->Html->link(__('List " . Inflector::humanize($details['controller']) . "', true), array('controller' => '{$details['controller']}', 'action' => 'index'), array('class'=>'btn')); ?>\n";
					echo "\t<?php echo \$this->Html->link(__('New " . Inflector::humanize(Inflector::underscore($alias)) . "', true), array('controller' => '{$details['controller']}', 'action' => 'add'), array('class'=>'btn')); ?>\n";
					$done[] = $details['controller'];
				}
			}
		}
?>
</div>