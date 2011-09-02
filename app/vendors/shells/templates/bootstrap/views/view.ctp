<?php echo "<?php "; ?>
/**
 *@var $this View
 */
<?php echo "?>\n"; ?>
<div class="row">
	<div class="span16 columns">
        <h1><?php echo "<?php  __('{$singularHumanName}');?>";?></h1>
    	<dl>
<?php
foreach ($fields as $field) {
	$isKey = false;
	if (!empty($associations['belongsTo'])) {
		foreach ($associations['belongsTo'] as $alias => $details) {
			if ($field === $details['foreignKey']) {
				$isKey = true;
				echo "\t\t\t<dt><?php __('" . Inflector::humanize(Inflector::underscore($alias)) . "'); ?></dt>\n";
				echo "\t\t\t<dd><?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?></dd>\n";
				break;
			}
		}
	}
	if ($isKey !== true) {
		echo "\t\t\t<dt><?php __('" . Inflector::humanize($field) . "'); ?></dt>\n";
        if ($field=='created'||$field=='updated'||$field=='modified') {
            echo "\t\t\t<dd><?php echo \$time->format('d/m/Y',\${$singularVar}['{$modelClass}']['{$field}']); ?></dd>\n";
        } else {
            echo "\t\t\t<dd><?php echo \${$singularVar}['{$modelClass}']['{$field}']; ?></dd>\n";
        }
	}
}
?>
	    </dl>
	    <div class="well">
<?php
	echo "\t\t\t<?php echo \$this->Html->link(__('Edit " . $singularHumanName ."', true), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']),array('class'=>'btn')); ?>\n";
	echo "\t\t\t<?php echo \$this->Html->link(__('Delete " . $singularHumanName . "', true), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class'=>'btn danger'), sprintf(__('Estas seguro que quieres borrar el # %s?', true), \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
	echo "\t\t\t<?php echo \$this->Html->link(__('Lista " . $pluralHumanName . "', true), array('action' => 'index'),array('class'=>'btn')); ?>\n";
	echo "\t\t\t<?php echo \$this->Html->link(__('New " . $singularHumanName . "', true), array('action' => 'add'),array('class'=>'btn primary')); ?>\n";

	$done = array();
	foreach ($associations as $type => $data) {
		foreach ($data as $alias => $details) {
			if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
				echo "\t\t\t<?php echo \$this->Html->link(__('Lista " . Inflector::humanize($details['controller']) . "', true), array('controller' => '{$details['controller']}', 'action' => 'index'),array('class'=>'btn')); ?>\n";
				echo "\t\t\t<?php echo \$this->Html->link(__('New " .  Inflector::humanize(Inflector::underscore($alias)) . "', true), array('controller' => '{$details['controller']}', 'action' => 'add'),array('class'=>'btn primary')); ?>\n";
				$done[] = $details['controller'];
			}
		}
	}
?>
	    </div>
    </div>
</div>
<?php
if (!empty($associations['hasOne'])) :
	foreach ($associations['hasOne'] as $alias => $details): ?>
<div class="row">
	<div class="span16 columns">
		<h3><?php echo "<?php __('" . Inflector::humanize($details['controller']) . "');?>";?></h3>
	    <dl>
<?php
			foreach ($details['fields'] as $field) {
				echo "\t\t<dt><?php __('" . Inflector::humanize($field) . "');?></dt>\n";
				echo "\t\t<dd><?php echo \${$singularVar}['{$alias}']['{$field}'];?></dd>\n";
			}
?>
		</dl>
		<div class="well">
		    <?php echo "<?php echo \$this->Html->link(__('Edit " . Inflector::humanize(Inflector::underscore($alias)) . "', true), array('controller' => '{$details['controller']}', 'action' => 'edit', \${$singularVar}['{$alias}']['{$details['primaryKey']}']),array('class'=>'btn')); ?>\n";?>
		</div>
	</div>
</div>
	<?php
	endforeach;
endif;
if (empty($associations['hasMany'])) {
	$associations['hasMany'] = array();
}
if (empty($associations['hasAndBelongsToMany'])) {
	$associations['hasAndBelongsToMany'] = array();
}
$relations = array_merge($associations['hasMany'], $associations['hasAndBelongsToMany']);
$i = 0;
foreach ($relations as $alias => $details):
	$otherSingularVar = Inflector::variable($alias);
	$otherPluralHumanName = Inflector::humanize($details['controller']);
	?>
<div class="row">
    <div class="span16 columns">
        <h3><?php echo "<?php __('" . $otherPluralHumanName . "');?>";?></h3>
        <?php echo "<?php if (!empty(\${$singularVar}['{$alias}'])) { ?>\n";?>
        <table class="common-table zebra-striped">
    	    <tr>
<?php
			foreach ($details['fields'] as $field) {
                if ($field!='id'&&$field!=$singularVar.'_id')
				echo "\t\t\t\t<th><?php __('" . Inflector::humanize($field) . "'); ?></th>\n";
			}
?>
    		    <th><?php echo "<?php __('Actions');?>";?></th>
	        </tr>
<?php
        echo "\t\t\t<?php foreach (\${$singularVar}['{$alias}'] as \${$otherSingularVar}) { ?>\n";
		echo "\t\t\t<tr>\n";

				foreach ($details['fields'] as $field) {
                    if ($field!='id'&&$field!=$singularVar.'_id')
					echo "\t\t\t\t<td><?php echo \${$otherSingularVar}['{$field}'];?></td>\n";
				}

				echo "\t\t\t\t<td>\n";
				echo "\t\t\t\t\t<?php echo \$this->Html->link(__('View', true), array('controller' => '{$details['controller']}', 'action' => 'view', \${$otherSingularVar}['{$details['primaryKey']}']),array('class'=>'btn primary')); ?>\n";
				echo "\t\t\t\t\t<?php echo \$this->Html->link(__('Edit', true), array('controller' => '{$details['controller']}', 'action' => 'edit', \${$otherSingularVar}['{$details['primaryKey']}']),array('class'=>'btn')); ?>\n";
				echo "\t\t\t\t\t<?php echo \$this->Html->link(__('Delete', true), array('controller' => '{$details['controller']}', 'action' => 'delete', \${$otherSingularVar}['{$details['primaryKey']}']), array('class'=>'btn danger'), sprintf(__('Are you sure you want to delete # %s?', true), \${$otherSingularVar}['{$details['primaryKey']}'])); ?>\n";
				echo "\t\t\t\t</td>\n";
			echo "\t\t\t</tr>\n";
            echo "\t\t\t<?php } //endforeach; ?>\n";
?>
    	</table>
        <?php echo "<?php } //endif; ?>\n";?>
        <div class="well">
            <?php echo "<?php echo \$this->Html->link(__('New " . Inflector::humanize(Inflector::underscore($alias)) . "', true), array('controller' => '{$details['controller']}', 'action' => 'add'),array('class'=>'btn primary'));?>\n";?>
        </div>
    </div>
</div>
<?php endforeach;?>