<?php
class MultipleDisplayFieldsBehavior extends ModelBehavior {
	var $config = array ();

	function setup(& $model, $config = array ()) {
		$default = array (
			'fields' => array (
				$model->name => array (
					'Model.first_name',
					'Model.last_name'
				)
			),
			'pattern' => '%s %s'
		);
		$this->config[$model->name] = $default;
		if (isset ($config['fields'])) {
			$myFields = array ();
			foreach ($config['fields'] as $key => $val) {
				$modelField = explode(".", $val);
				if (empty ($myFields[$modelField[0]]))
					$myFields[$modelField[0]] = array ();
				$myFields[$modelField[0]][] = $modelField[1];
			}
			$this->config[$model->name]['fields'] = $myFields;
		}
		if (isset ($config['pattern'])) {
			$this->config[$model->name]['pattern'] = $config['pattern'];
		}
	}

	function afterFind(& $model, $results) {
		foreach ($results as $key => $result) {
			$displayFieldValues = array ();
			$fields_present = true;

			foreach ($this->config[$model->name]['fields'] as $mName => $mFields) {
				if (isset ($result[$mName])) {
					foreach ($mFields as $mField) {
						if (array_key_exists($mField, $result[$mName])) {
							$fields_present = $fields_present && true;
							$displayFieldValues[] = $result[$mName][$mField];
						} else {
							$fields_present = false;
						}
					}
				} else {
					$fields_present = false;
				}
			}

			if ($fields_present) {
				$params = array_merge(array (
					$this->config[$model->name]['pattern']
				), $displayFieldValues);
				$results[$key][$model->name][$model->displayField] = call_user_func_array('sprintf', $params);
			}
		}
		return $results;
	}

	function beforeFind(& $model, & $queryData) {
		if (isset ($queryData["list"])) {
			$queryData['fields'] = array ();
			array_push($queryData['fields'], substr($queryData['list']['keyPath'], 4));
			foreach ($this->config[$model->name]['fields'] as $mName => $mFields) {
				foreach ($mFields as $mField) {
					array_push($queryData['fields'], $mName . "." . $mField);
				}
			}
		}
		return $queryData;
	}
}
?>