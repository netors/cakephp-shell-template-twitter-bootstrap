<?php
/**
 * Bake Template for Controller action generation.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.console.libs.template.objects
 * @since         CakePHP(tm) v 1.3
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

	function <?php echo $admin ?>index() {
		$this-><?php echo $currentModelName ?>->recursive = 0;
		$this->set('<?php echo $pluralName ?>', $this->paginate());
	}

	function <?php echo $admin ?>view($id = null) {
		if (!$id) {
<?php if ($wannaUseSession): ?>
			$this->Session->setFlash(__('<?php echo strtolower($singularHumanName) ?> invalido', true),'flash_error');
			$this->redirect(array('action' => 'index'));
<?php else: ?>
			$this->flash(__('<?php echo strtolower($singularHumanName); ?> invalido', true), array('action' => 'index'));
<?php endif; ?>
		}
		$this->set('<?php echo $singularName; ?>', $this-><?php echo $currentModelName; ?>->read(null, $id));
	}

<?php $compact = array(); ?>
	function <?php echo $admin ?>add() {
    	$errors = array();
		if (!empty($this->data)) {
			$this-><?php echo $currentModelName; ?>->create();
			if ($this-><?php echo $currentModelName; ?>->save($this->data)) {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('El <?php echo strtolower($singularHumanName); ?> ah sido guardado', true),'flash_success');
				$this->redirect(array('action' => 'index'));
<?php else: ?>
				$this->flash(__('<?php echo ucfirst(strtolower($currentModelName)); ?> guardado.', true), array('action' => 'index'));
<?php endif; ?>
			} else {
				$errors = $this-><?php echo $currentModelName; ?>->invalidFields();
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('El <?php echo strtolower($singularHumanName); ?> no pudo ser guardado. Por favor, intenta de nuevo.', true),'flash_error');
<?php endif; ?>
			}
		}
<?php
	foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
		foreach ($modelObj->{$assoc} as $associationName => $relation):
			if (!empty($associationName)):
				$otherModelName = $this->_modelName($associationName);
				$otherPluralName = $this->_pluralName($associationName);
				echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
				$compact[] = "'{$otherPluralName}'";
			endif;
		endforeach;
	endforeach;
	if (!empty($compact)):
		echo "\t\t\$this->set(compact(".join(', ', $compact).",'errors'));\n";
	endif;
?>
	}

<?php $compact = array(); ?>
	function <?php echo $admin; ?>edit($id = null) {
    	$errors = array();
		if (!$id && empty($this->data)) {
<?php if ($wannaUseSession): ?>
			$this->Session->setFlash(__('<?php echo strtolower($singularHumanName); ?> invalido', true),'flash_error');
			$this->redirect(array('action' => 'index'));
<?php else: ?>
			$this->flash(sprintf(__('<?php echo strtolower($singularHumanName); ?> invalido', true)), array('action' => 'index'));
<?php endif; ?>
		}
		if (!empty($this->data)) {
			if ($this-><?php echo $currentModelName; ?>->save($this->data)) {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('El <?php echo strtolower($singularHumanName); ?> ah sido guardado.', true),'flash_success');
				$this->redirect(array('action' => 'index'));
<?php else: ?>
				$this->flash(__('El <?php echo strtolower($singularHumanName); ?> ah sido guardado.', true), array('action' => 'index'));
<?php endif; ?>
			} else {
	            $errors = $this-><?php echo $currentModelName; ?>->invalidFields();
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('El <?php echo strtolower($singularHumanName); ?> no pudo ser guardado. Por favor, intenta de nuevo.', true),'flash_error');
<?php endif; ?>
			}
		}
		if (empty($this->data)) {
			$this->data = $this-><?php echo $currentModelName; ?>->read(null, $id);
		}
<?php
		foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
			foreach ($modelObj->{$assoc} as $associationName => $relation):
				if (!empty($associationName)):
					$otherModelName = $this->_modelName($associationName);
					$otherPluralName = $this->_pluralName($associationName);
					echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
					$compact[] = "'{$otherPluralName}'";
				endif;
			endforeach;
		endforeach;
		if (!empty($compact)):
			echo "\t\t\$this->set(compact(".join(', ', $compact).",'errors'));\n";
        else:
            echo "\t\t\$this->set('errors',\$errors);\n";
		endif;
	?>
	}

	function <?php echo $admin; ?>delete($id = null) {
		if (!$id) {
<?php if ($wannaUseSession): ?>
			$this->Session->setFlash(__('Id invalido para <?php echo strtolower($singularHumanName); ?>', true),'flash_error');
			$this->redirect(array('action'=>'index'));
<?php else: ?>
			$this->flash(sprintf(__('<?php echo strtolower($singularHumanName); ?> invalido.', true)), array('action' => 'index'));
<?php endif; ?>
		}
		if ($this-><?php echo $currentModelName; ?>->delete($id)) {
<?php if ($wannaUseSession): ?>
			$this->Session->setFlash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> borrado.', true),'flash_success');
			$this->redirect(array('action'=>'index'));
<?php else: ?>
			$this->flash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> borrado.', true), array('action' => 'index'));
<?php endif; ?>
		}
<?php if ($wannaUseSession): ?>
		$this->Session->setFlash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> no fue borrado.', true),'flash_error');
<?php else: ?>
		$this->flash(__('<?php echo ucfirst(strtolower($singularHumanName)); ?> no fue borrado.', true), array('action' => 'index'));
<?php endif; ?>
		$this->redirect(array('action' => 'index'));
	}