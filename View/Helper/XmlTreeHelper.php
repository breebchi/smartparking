<?php 
	class XmltreeHelper extends AppHelper {
		
		public $helpers = array('Xml');
		 
		function serialize($treeData, $containerName = NULL){
			debug($treeData);
			$this->normalize($treeData, $containerName);
			return $this->Xml->serialize($treeData);
		}
		 
		function normalize(&$children, $containerName){
			if(sizeof($children) > 0){
				foreach($children as &$node){
					$this->normalize($node["children"], $containerName);
	
					if(sizeof($node["children"]) > 0){
						$node[$containerName][$containerName] = array();
							
						foreach($node["children"] as &$child){
							$node[$containerName][$containerName][] = $child[$containerName];
						}
					}
	
					unset($node["children"]);
				}
			}
		}
		 
	}
?>
