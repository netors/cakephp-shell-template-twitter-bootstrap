<?php echo "<?php "; ?>
/**
 *@var $this View
 */
<?php echo "?>"; ?>
<div class="row">
	<div class="span16 columns">
		<h1><?php echo "<?php __('{$pluralHumanName}');?>";?></h1>
        <table class="common-table zebra-striped">
        <tr>
        <?php  foreach ($fields as $field):?>
            <th><?php echo "<?php echo \$this->Paginator->sort('{$field}');?>";?></th>
        <?php endforeach;?>
            <th><?php echo "<?php __('Actions');?>";?></th>
        </tr>
        <?php
        echo "<?php
        \$i = 0;
        foreach (\${$pluralVar} as \${$singularVar}):
            \$class = null;
            if (\$i++ % 2 == 0) {
                \$class = ' class=\"altrow\"';
            }
        ?>\n";
        echo "\t<tr<?php echo \$class;?>>\n";
            foreach ($fields as $field) {
                $isKey = false;
                if (!empty($associations['belongsTo'])) {
                    foreach ($associations['belongsTo'] as $alias => $details) {
                        if ($field === $details['foreignKey']) {
                            $isKey = true;
                            echo "\t\t<td>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t</td>\n";
                            break;
                        }
                    }
                }
                if ($isKey !== true) {
                    echo "\t\t<td><?php echo \${$singularVar}['{$modelClass}']['{$field}']; ?>&nbsp;</td>\n";
                }
            }

		echo "\t\t<td>\n";
		echo "\t\t\t<?php echo \$this->Html->link(__('View', true), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class'=>'btn small primary')); ?>\n";
		echo "\t\t\t<?php echo \$this->Html->link(__('Edit', true), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class'=>'btn small')); ?>\n";
		echo "\t\t\t<?php echo \$this->Html->link(__('Delete', true), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class'=>'btn small danger'), sprintf(__('Are you sure you want to delete # %s?', true), \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
		echo "\t\t</td>\n";
    	echo "\t</tr>\n";

	echo "\t<?php endforeach; ?>\n";
	?>
	</table>
	<p style="float:right;">
	<?php echo "<?php
	echo \$this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>";?>
	</p>

        <div class="pagination">
            <ul>
            <?php echo "\t<?php echo \$this->Paginator->prev('&larr; '.__('Previous', true), array('tag'=>'li','class'=>'prev', 'escape'=>false), '<a href=\"#\">&larr; '.__('Previous',true).'</a>', array('tag'=>'li','class'=>'prev disabled', 'escape'=>false));?>\n";?>
            <?php echo "\t<?php echo \$this->Paginator->numbers(array('tag'=>'li','separator'=>'','disabled'=>'active'));?>\n"?>
            <?php echo "\t<?php echo \$this->Paginator->next(__('Next', true).' &rarr;', array('tag'=>'li','class'=>'next','escape'=>false), '<a href=\"#\">'.__('Next', true).' &rarr;</a>', array('tag'=>'li','class' => 'next disabled', 'escape'=>false));?>\n";?>
            </ul>
        </div>
        <div class="well">
        <?php echo "\t<?php echo \$this->Html->link(__('New " . $singularHumanName . "', true), array('action' => 'add'), array('class'=>'btn primary')); ?>\n";?>
<?php
	$done = array();
	foreach ($associations as $type => $data) {
		foreach ($data as $alias => $details) {
			if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
				echo "\t\t<?php echo \$this->Html->link(__('List " . Inflector::humanize($details['controller']) . "', true), array('controller' => '{$details['controller']}', 'action' => 'index'), array('class'=>'btn')); ?>\n";
				echo "\t\t<?php echo \$this->Html->link(__('New " . Inflector::humanize(Inflector::underscore($alias)) . "', true), array('controller' => '{$details['controller']}', 'action' => 'add'), array('class'=>'btn')); ?>\n";
				$done[] = $details['controller'];
			}
		}
	}
?>
        </div>
	</div>
</div>