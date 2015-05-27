<?php
/**
 * ScopedTreeBehavior
 * Enables a model to be sorted as a tree.
 * Some logic from TreeBehavior of CakePHP :  Rapid Development Framework (http://www.cakephp.org)
 * @author Sahbi KHALFALLAH <sa7booch@yahoo.fr>
 * @since 1.2
 * @todo Optimisations of the code.
 * @version 0.2
 * @see https://trac.cakephp.org/browser/trunk/cake/1.2.x.x/cake/libs/model/behaviors/tree.php
 */
class ScopedTreeBehavior extends ModelBehavior {
	
	var $_defaults = array(
		'tree_id' => 'tree_id',
		'parent_id' => 'parent_id',
		'order' => 'order',
		'parent_change' => false,
		'old_parent_id' => null,
		'old_node_order' => null,
		'new_node_order' => null
	);
	
	/**
 	 * Initiate  behavior
 	 *
 	 * @param object $Model
 	 * @param array $config
 	 * @return void
 	 * @access public
 	 */
	function setup($Model, $config = array()) {
		$settings = array_merge($this->_defaults, $config);
		$this->settings[$Model->alias] = $settings;
		$this->maxRecursive = 4;
	}
	
	/**
	 * beforeSave Called before all saves
	 *
	 * Overriden to transparently manage the order of the record within the tree.
	 *
	 * @since		 1.2
	 * @param AppModel $Model
	 * @return boolean true to continue, false to abort the save
	 * @access public
	*/
	function beforeSave($Model) {
		if (!is_null($this->settings[$Model->alias]['parent_id']) && array_key_exists($this->settings[$Model->alias]['parent_id'], $Model->data[$Model->alias]) && $Model->data[$Model->alias][$this->settings[$Model->alias]['parent_id']]) {
			$parent_id = $Model->data[$Model->alias][$this->settings[$Model->alias]['parent_id']];
		} else {
			$parent_id = null;
		}
		if (!is_null($this->settings[$Model->alias]['tree_id'])) {
			if (array_key_exists($this->settings[$Model->alias]['tree_id'], $Model->data[$Model->alias]) && $Model->data[$Model->alias][$this->settings[$Model->alias]['tree_id']]) {
				$tree_id = $Model->data[$Model->alias][$this->settings[$Model->alias]['tree_id']];
			} else {
				return false;
			}
		} else {
			$tree_id = null;
		}
		if(!$Model->id) {
			$order = $this->getMax($Model, $tree_id, $parent_id);
			$order++;
			$Model->data[$Model->alias][$this->settings[$Model->alias]['order']] = $order;
		} else {
			$old_node_order = $Model->field($this->settings[$Model->alias]['order']);
			if (!is_null($this->settings[$Model->alias]['parent_id'])) {
				$old_parent_id = $Model->field($this->settings[$Model->alias]['parent_id']);
				if (isset($Model->data[$Model->alias][$this->settings[$Model->alias]['parent_id']])) {
					$new_parent_id = $Model->data[$Model->alias][$this->settings[$Model->alias]['parent_id']];
				} else {
					$new_parent_id = null;
				}
			}
			$new_node_order = $this->getMax($Model, $tree_id, $parent_id) + 1;
			if (!is_null($this->settings[$Model->alias]['parent_id'])) {
				if ($new_parent_id != $old_parent_id) {
					$this->settings[$Model->alias]['parent_change'] = true;
					$this->settings[$Model->alias]['old_parent_id'] = $old_parent_id;
				}
			}
			$this->settings[$Model->alias]['old_node_order'] = $old_node_order;
			$this->settings[$Model->alias]['new_node_order'] = $new_node_order;
			
		}
		return true;
	}
	
	/**
	 * afterSave Called after all saves
	 *
	 * Overriden to transparently manage the order of the record within the tree.
	 *
	 * @since		 1.2
	 * @param AppModel $Model
	 * @return boolean
	 * @access public
	*/
	function afterSave($Model, $created) {
		if (!is_null($this->settings[$Model->alias]['parent_id'])) {
			if (!$created && $this->settings[$Model->alias]['parent_change']) {
				if (!is_null($this->settings[$Model->alias]['tree_id'])) {
					if (array_key_exists($this->settings[$Model->alias]['tree_id'], $Model->data[$Model->alias]) && $Model->data[$Model->alias][$this->settings[$Model->alias]['tree_id']]) {
						$tree_id = $Model->data[$Model->alias][$this->settings[$Model->alias]['tree_id']];
					} else {
						return false;
					}
				}
				$Model->updateAll(
					array($Model->alias.'.'.$this->settings[$Model->alias]['order'] => $this->settings[$Model->alias]['new_node_order']),
					array(
						$Model->alias.'.'.$Model->primaryKey => $Model->data[$Model->alias][$Model->primaryKey]
					)
				);
				$conditions = array(
					$Model->alias.'.'.$this->settings[$Model->alias]['parent_id'] => $this->settings[$Model->alias]['old_parent_id'],
					$Model->alias.'.'.$this->settings[$Model->alias]['order'].' > '.$this->settings[$Model->alias]['old_node_order']
				);
				if (!is_null($this->settings[$Model->alias]['tree_id'])) {
					$conditions[$Model->alias.'.'.$this->settings[$Model->alias]['tree_id']] = $tree_id;
				}
				$Model->updateAll(
					array($Model->alias.'.'.$this->settings[$Model->alias]['order'] => $Model->alias.'.'.$this->settings[$Model->alias]['order'].' - 1'),
					$conditions
				);
			}
			$this->settings[$Model->alias]['parent_change'] = false;
			$this->settings[$Model->alias]['old_parent_id'] = null;
		}
		$this->settings[$Model->alias]['old_node_order'] = null;
		$this->settings[$Model->alias]['new_node_order'] = null;
		return true;
	}
	
	/**
	 * beforeDelete Called before all deletes
	 *
	 * Overriden to transparently manage the order of the record within the tree.
	 *
	 * @since		 1.2
	 * @param AppModel $Model
	 * @return boolean true to continue, false to abort the delete
	 * @access public
	*/	
	function beforeDelete($Model) {
		$this->removeFromTree($Model, $Model->id);
		return true;
	}

	/**
	 * moveUp
	 *
	 * Allows moving up a node inside it's parent
	 * A node cannot change parent
	 * @param AppModel $Model
	 * @param mixed $node_id The node id to use.
	 * @param mixed $tree_id The tree to work in.
	 * @param AppModel $node If specified, will use the provided node.
	 * @return boolean
	 */
	function moveUp($Model, $node_id, $tree_id = null, $node = null) {
		if(!$node) {
			$node = $this->getNode($Model, $node_id);
			if(!$node) {
				return false;
			}
		}
		if (!is_null($this->settings[$Model->alias]['tree_id'])) {
			if ($tree_id === null && $node) {
				$tree_id = $node[$Model->alias][$this->settings[$Model->alias]['tree_id']];
			} else if ($tree_id === null && $Model->data) {
				$tree_id = $Model->data[$Model->alias][$this->settings[$Model->alias]['tree_id']];
			}
		}
		$options = array();
		$options['conditions'] = array(
			$Model->alias.'.'.$this->settings[$Model->alias]['order'].' < '.$node[$Model->alias][$this->settings[$Model->alias]['order']]
		);
		if (!is_null($this->settings[$Model->alias]['parent_id'])) {
			$options['conditions'][$Model->alias.'.'.$this->settings[$Model->alias]['parent_id']] = $node[$Model->alias][$this->settings[$Model->alias]['parent_id']];
		}
		if (!is_null($this->settings[$Model->alias]['tree_id'])) {
			$options['conditions'][$Model->alias.'.'.$this->settings[$Model->alias]['tree_id']] = $tree_id;
		}
		$options['order'] = array($Model->alias.'.'.$this->settings[$Model->alias]['order'] => 'DESC');
		$options['contain'] = array();
		$down = $Model->find('first', $options);
		if($down) {
			$Model->updateAll(
				array(
					$Model->alias.'.'.$this->settings[$Model->alias]['order'] => $down[$Model->alias][$this->settings[$Model->alias]['order']] + 1
				),
				array(
					$Model->alias.'.'.$Model->primaryKey => $down[$Model->alias][$Model->primaryKey]
				)
			);
			$Model->updateAll(
				array(
					$Model->alias.'.'.$this->settings[$Model->alias]['order'] => $node[$Model->alias][$this->settings[$Model->alias]['order']] - 1
				),
				array(
					$Model->alias.'.'.$Model->primaryKey => $node[$Model->alias][$Model->primaryKey]
				)
			);
			return true;
		}
		return false;		
	}
	
	/**
	 * moveDown
	 *
	 * Allows moving down a node inside it's parent
	 * A node cannot change parent
	 * @param AppModel $Model
	 * @param mixed $node_id The node id to use.
	 * @param mixed $tree_id The tree to work in.
	 * @param AppModel $node If specified, will use the provided node.
	 * @return boolean
	 */
	function moveDown($Model, $node_id, $tree_id = null, $node = null) {
		if(!$node) {
			$node = $this->getNode($Model, $node_id);
			if(!$node) {
				return false;
			}
		}
		if (!is_null($this->settings[$Model->alias]['tree_id'])) {
			if ($tree_id === null && $node) {
				$tree_id = $node[$Model->alias][$this->settings[$Model->alias]['tree_id']];
			} else if ($tree_id === null && $Model->data) {
				$tree_id = $Model->data[$Model->alias][$this->settings[$Model->alias]['tree_id']];
			}
		}
		$options = array();
		$options['conditions'] = array(
			$Model->alias.'.'.$this->settings[$Model->alias]['order'].' > '.$node[$Model->alias][$this->settings[$Model->alias]['order']]
		);
		if (!is_null($this->settings[$Model->alias]['parent_id'])) {
			$options['conditions'][$Model->alias.'.'.$this->settings[$Model->alias]['parent_id']] = $node[$Model->alias][$this->settings[$Model->alias]['parent_id']];
		}
		if (!is_null($this->settings[$Model->alias]['tree_id'])) {
			$options['conditions'][$Model->alias.'.'.$this->settings[$Model->alias]['tree_id']] = $tree_id;
		}
		$options['order'] = array($Model->alias.'.'.$this->settings[$Model->alias]['order'] => 'ASC');
		$options['contain'] = array();
		$up = $Model->find('first', $options);
		if($up) {
			$Model->updateAll(
				array(
					$Model->alias.'.'.$this->settings[$Model->alias]['order'] => $up[$Model->alias][$this->settings[$Model->alias]['order']] - 1
				),
				array(
					$Model->alias.'.'.$Model->primaryKey => $up[$Model->alias][$Model->primaryKey]
				)
			);
			$Model->updateAll(
				array(
					$Model->alias.'.'.$this->settings[$Model->alias]['order'] => $node[$Model->alias][$this->settings[$Model->alias]['order']] + 1
				),
				array(
					$Model->alias.'.'.$Model->primaryKey => $node[$Model->alias][$Model->primaryKey]
				)
			);
			return true;
		}
		return false;		
	}
	
	/**
	 * removeFromTree
	 *
	 * Remove a node from the tree and move all the child nodes under it's parent.
	 * @param AppModel $Model
	 * @param mixed $id The id of the node to be removed
	 * @return boolean
	 */
	function removeFromTree($Model, $id, $node = null) {
		if(!$node) {
			$node = $this->getNode($Model, $id);
			if(!$node) {
				return false;
			}
		}
		$conditions = array();
		if (!is_null($this->settings[$Model->alias]['parent_id'])) {
			$conditions[$Model->alias.'.'.$this->settings[$Model->alias]['parent_id']] = $node[$Model->alias][$this->settings[$Model->alias]['parent_id']];
		}
		if (!is_null($this->settings[$Model->alias]['tree_id'])) {
			$conditions[$Model->alias.'.'.$this->settings[$Model->alias]['tree_id']] = $node[$Model->alias][$this->settings[$Model->alias]['tree_id']];
		}
		
		if (!is_null($this->settings[$Model->alias]['tree_id'])) {
			$tree_id = $node[$Model->alias][$this->settings[$Model->alias]['tree_id']];
		} else {
			$tree_id = null;
		}
		if (!is_null($this->settings[$Model->alias]['parent_id'])) {	
			$db =& ConnectionManager::getDataSource($Model->useDbConfig);
			$parentField = $Model->alias.'.'.$this->settings[$Model->alias]['parent_id'];
			$parent_id = $node[$Model->alias][$this->settings[$Model->alias]['parent_id']];
			$Model->updateAll(array($parentField => $db->value($parent_id, $parentField)), $conditions);
		}  else {
			$parent_id = null;
		}
		$subtree = $this->getChildren($Model, $parent_id, $tree_id, array(
			$Model->alias.'.'.$Model->primaryKey,
			$Model->alias.'.'.$this->settings[$Model->alias]['order']
		));
		$this->syncLevel($Model, $subtree);
		return true;
	}
		
	/**
	 * syncLevel
	 * Syncs the order of all the nodes of a level (common parent).
	 * @param AppModel $Model
	 * @param array $subtree The nodes to sync together.
	 * @access private
	 * @return void
	 *
	 */
	function syncLevel($Model, $subtree) {
		$i = 1;
		foreach ($subtree as $key => $node) {
			$Model->updateAll(
				array(
					$Model->alias.'.'.$this->settings[$Model->alias]['order'] => $i
				),
				array(
					$Model->alias.'.'.$Model->primaryKey => $node[$Model->alias][$Model->primaryKey]
				)
			);
			$i++;
		}
	}
	
	function getChildren($Model, $parent_id, $tree_id, $fields = null) {
		$options = array();
		if ($fields) {
			$options['fields'] = $fields;
		}		
		$options['conditions'] = array();
		if (!is_null($this->settings[$Model->alias]['parent_id'])) {
			$options['conditions'][$Model->alias.'.'.$this->settings[$Model->alias]['parent_id']] = $parent_id;
		}
		if (!is_null($this->settings[$Model->alias]['tree_id'])) {
			$options['conditions'][$Model->alias.'.'.$this->settings[$Model->alias]['tree_id']] = $tree_id;
		}
		$options['order'] = array($Model->alias.'.'.$this->settings[$Model->alias]['order'].' ASC');
		return $Model->find('all', $options);
		
	}
	
	/**
	 * generateTree Generates the tree structure for the specified tree scope.
	 * @param AppModel $Model
	 * @param mixed $tree_id The project id to generate the tree for.
	 * @return array The structured tree as an array.
	 */
	function generateTree($Model, $tree_id, $conditions = array(), $parent_id = null) {
		$options = array();
		if (!is_null($this->settings[$Model->alias]['tree_id'])) {
			$conditions = array_merge(array($Model->alias.'.'.$this->settings[$Model->alias]['tree_id'] => $tree_id), $conditions);
		}
		$options['conditions'] = $conditions;
		$options['order'] = array($Model->alias.'.'.$this->settings[$Model->alias]['order'].' ASC');
		$rawtree = $Model->find('all', $options);
		$tree = $this->getTree($Model, $rawtree, $parent_id);
		return $tree;
	}
	
	/**
	 * getTree Format a raw database tree into a structured tree.
	 * The function is recursive.It builds all the children elements.
	 * @param array $rawtree The database raw results
	 * @param mixed $parent_id The parent id to structure for.
	 * @param integer $recursive The level of recursiveness to allow/limit.
	 * @return array The structured tree array.
	 */
	function getTree($Model, $rawtree, $parent_id, $recursive = 0) {
		$tmpTree = array();
		if($recursive > $this->maxRecursive) {
			return $tmpTree;
		}
		if (is_array($rawtree)) {
			foreach($rawtree as $key => $node) {
				if($node[$Model->alias][$this->settings[$Model->alias]['parent_id']] == $parent_id) {
					$node['children'] = $this->getTree($Model, $rawtree, $node[$Model->alias][$Model->primaryKey], $recursive + 1);
					$tmpTree[] = $node;
				}
			}
		}
		return $tmpTree;
	}
	
	/**
	 * getNode
	 * Returns the node that match the provided id
	 * @param AppModel $Model
	 * @param mixed $id The node id to return
	 * @param array $fields The fields to return
	 * @param array $contain Allows using containable if the argument is provided.
	 * @return AppModel The model if found, otherwise will return null.
	 *
	 */
	function getNode($Model, $id, $fields = null, $contain = null) {
		$options = array();
		if (is_array($contain)) {
			$options['contain'] = $contain;  
		}
		if (is_array($fields)) {
			$options['fields'] = $fields;   
		}
		$options['recursive'] = 0;
		$options['conditions'] = array($Model->alias.'.'.$Model->primaryKey => $id);
		return $Model->find('first', $options);		
	}
	
	/**
	 * getOrder
	 * Return the current maximum order value.
	 * @param mixed $tree_id The id of the tree
	 * @param mixed $parent_id The id of the parent
	 * @return integer A the maximum value of order.
	 *
	 */
	function getMax($Model, $tree_id, $parent_id) {
		$db =& ConnectionManager::getDataSource($Model->useDbConfig);
		$options = array();
		$options['conditions'] = array();
		if (!is_null($this->settings[$Model->alias]['parent_id'])) {
			$options['conditions'][$Model->alias.'.'.$this->settings[$Model->alias]['parent_id']] = $parent_id;
		}
		if (!is_null($this->settings[$Model->alias]['tree_id'])) {
			$options['conditions'][$Model->alias.'.'.$this->settings[$Model->alias]['tree_id']] = $tree_id;
		}
		$options['order'] = array($Model->alias.'.'.$this->settings[$Model->alias]['order'] => 'DESC');
		$options['fields'] = $db->calculate($Model, 'max', array($this->settings[$Model->alias]['order']));
		$options['group'] = $Model->alias.'.'.$Model->primaryKey;
		$options['recursive'] = -1;
		list($edge) = $Model->find('first', $options);
		return (empty($edge[$this->settings[$Model->alias]['order']])) ? 0 : $edge[$this->settings[$Model->alias]['order']];
		//$Model->query("SELECT MAX(`order`) AS `order` FROM `".$Model->getDataSource()->config['database']."`.`".$Model->useTable."` AS `".$Model->alias."` ".$conditions." GROUP BY `".$Model->alias."`.`id` ORDER BY `".$Model->name."`.`order` DESC LIMIT 1;");
	}
	
	function getTreeList($Model, $tree_id = null, $conditions = array()) {
		$tree = $this->generateTree($Model, $tree_id, $conditions);
		return $this->getNodeList($Model, $tree, 0);
	}
	
	function getNodeList($Model, $node, $level) {
		$items = array();
		if ($level == 0) {
			$children = $node;
		} else {
			$children = $node['children'];
			unset($node['children']);
			$node['level'] = $level; 
			$items[] = $node;
		}
		if (!empty($children)) {
			$level++;
			foreach ($children as $child) {
				$result = $this->getNodeList($Model, $child, $level);
				foreach ($result as $v) {
					$items[] = $v;
				}
			}
		}
		return $items;
	}
	
	function generateTreeList($Model, $tree_id = null, $keyPath = null, $valuePath = null, $spacer = '_', $conditions = array()) {
		if (!is_null($this->settings[$Model->alias]['tree_id'])) {
			if ($tree_id === null && $Model->data) {
				$tree_id = $Model->data[$Model->alias][$this->settings[$Model->alias]['tree_id']];
			}
		} else {
			$tree_id = null;
		}
		
		if ($keyPath == null) {
			$keyPath = $Model->primaryKey;
		}
		if ($valuePath == null) {
			$valuePath = $Model->displayField;

		}
		$treeList = $this->getTreeList($Model, $tree_id, $conditions);
		$items = array();
		foreach ($treeList as $node) {
			$key = $node[$Model->alias][$keyPath];
			$value = str_repeat($spacer, $node['level'] -1).$node[$Model->alias][$valuePath];
			$items[$key] = $value;
		}
		return $items;
	}
	
	function childCount($Model, $id = null, $direct = false, $tree_id = null) {
		if ($id === null && $Model->id) {
			$id = $Model->id;
		} elseif (!$id) {
			$id = null;
		}
		if (!is_null($this->settings[$Model->alias]['tree_id'])) {
			if ($tree_id === null && $Model->data) {
				$tree_id = $Model->data[$Model->alias][$this->settings[$Model->alias]['tree_id']];
			}
		} else {
			$tree_id = null;
		}
		if ($direct) {
			return $Model->find('count', array('conditions' => array(
				$Model->alias.'.'.$this->settings[$Model->alias]['tree_id'] => $tree_id,
				$Model->alias.'.'.$this->settings[$Model->alias]['parent_id'] => $id
			)));
		}
		if ($id === null) {
			return $Model->find('count', array('conditions' => array(
				$Model->alias.'.'.$this->settings[$Model->alias]['tree_id'] => $tree_id
			)));
		} else {
			$count = 0;
			$children = $this->getChildren($Model, $id, $tree_id);
			foreach ($children as $child) {
				$this->childCount($Model, $child[$Model->alias][$Model->primaryKey], $direct, $tree_id)+1;
			}
			return $count;
		}
	}
	
	function children($Model, $id = null, $direct = false, $tree_id = null) {
		if ($id === null && $Model->id) {
			$id = $Model->id;
		} elseif (!$id) {
			$id = null;
		}
		if ($tree_id === null && $Model->data) {
			$tree_id = $Model->data[$Model->alias][$this->settings[$Model->alias]['tree_id']];
		}
		$directChildren = $this->getChildren($Model, $id, $tree_id);
		if ($direct) {
			return $directChildren;
			
		}
		if (!is_array($directChildren)) {
			foreach ($directChildren as $child) {
				$directChildren = array_merge($directChildren, $this->children($Model, $child[$Model->alias][$Model->primaryKey], $direct, $tree_id));
			}
		}
		return $directChildren;
	}
	
	function getPath($Model, $id = null, $tree_id = null) {
		if ($id === null && $Model->id) {
			$id = $Model->id;
		} elseif (!$id) {
			$id = null;
		}
		if (!is_null($this->settings[$Model->alias]['tree_id'])) {
			if ($tree_id === null && $Model->data) {
				$tree_id = $Model->data[$Model->alias][$this->settings[$Model->alias]['tree_id']];
			}
		} else {
			$tree_id = null;
		}
		$results = array();
		$parent = 0;
		$node = $Model->read(null, $id);
		while (is_numeric($parent)) {
			$result = $this->getParentNode($Model, $id, $tree_id);
			if ($result) {
				$id = $result[$Model->alias][$Model->primaryKey];
				$parent = $result[$Model->alias][$this->settings[$Model->alias]['parent_id']];
				$results[] = $result;
			} else {
				$parent = null;
			}
		}
		$results[] = $node;
		return $results;
	}
	
	function getParentNode($Model, $id = null, $tree_id = null) {
		if ($id === null && $Model->id) {
			$id = $Model->id;
		} elseif (!$id) {
			$id = null;
		}
		if (!is_null($this->settings[$Model->alias]['tree_id'])) {
			if ($tree_id === null && $Model->data) {
				$tree_id = $Model->data[$Model->alias][$this->settings[$Model->alias]['tree_id']];
			}
		} else {
			$tree_id = null;
		}
		$parent_id = $Model->read($this->settings[$Model->alias]['parent_id'], $id);
		if ($parent_id) {
			$parent_id = $parent_id[$Model->alias][$this->settings[$Model->alias]['parent_id']];
			return $Model->find('first', array('conditions' => array($Model->alias.'.'.$Model->primaryKey => $parent_id)));
		}
		return false;
	}
	
	function reorder($Model, $tree_id = null) {
		$options = array();
		if (!is_null($this->settings[$Model->alias]['tree_id'])) {
			if ($tree_id === null && $Model->data) {
				$tree_id = $Model->data[$Model->alias][$this->settings[$Model->alias]['tree_id']];
			}
		} else {
			$tree_id = null;
		}
		if (!is_null($tree_id)) {
			$options['conditions'] = array(
				$Model->alias.'.'.$this->settings[$Model->alias]['tree_id'] => $tree_id
			);
		}
		$options['fields'] = array();
		$options['group'] = array();
		if (!is_null($this->settings[$Model->alias]['tree_id'])) {
			$options['fields'][] = $Model->alias.'.'.$this->settings[$Model->alias]['tree_id'];
			$options['group'][] = $Model->alias.'.'.$this->settings[$Model->alias]['tree_id'];
		}
		if (!is_null($this->settings[$Model->alias]['parent_id'])) {
			$options['fields'][] = $Model->alias.'.'.$this->settings[$Model->alias]['parent_id'];
			$options['group'][] = $Model->alias.'.'.$this->settings[$Model->alias]['parent_id'];
		}
		$nodes = $Model->find('all', $options);
		foreach ($nodes as $node) {
			if (!is_null($this->settings[$Model->alias]['parent_id'])) {
				$parent_id = $node[$Model->alias][$this->settings[$Model->alias]['parent_id']];
			} else {
				$parent_id = null;
			}
			if (!is_null($this->settings[$Model->alias]['tree_id'])) {
				$tree_id = $node[$Model->alias][$this->settings[$Model->alias]['tree_id']];
			} else {
				$tree_id = null;
			}
			$subtree = $this->getChildren($Model, $parent_id, $tree_id, array(
				$Model->alias.'.'.$Model->primaryKey,
				$Model->alias.'.'.$this->settings[$Model->alias]['order']
			));
			$this->syncLevel($Model, $subtree);
		}
		return false;
	}
	
}
?>