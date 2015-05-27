<?php

class I18nBehavior extends ModelBehavior {
	
	function afterFind(& $model, $results) {
		foreach ($results as $key => $result) {
			foreach ($result as $modelName => $data) {
				if (is_array($data) && $modelName != $model->name) {
					if (isset($data['id'])) {
						$row = $model->{$modelName}->read(null, $data['id']);
						$results[$key][$modelName] = $row[$modelName];
					}
				}
			}
		}
		return $results;
	}
	
}

?>