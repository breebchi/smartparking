<?php 

class ThumbComponent extends Component {
	
	var $name = 'ThumbComponent';
	//var $error;
	
    /**
     * Contructor function
     * @param Object &$controller pointer to calling controller
    */
    function startup($controller) {
        $this->controller = $controller;
        $this->error = '';
	}
    
	function resize($sourceFilename, $destinationFilename, $new_width, $quality = 80, $imageType = 'jpg') {
		
		if (!is_file($sourceFilename) && !is_null($destinationFilename)) {
			$this->setError(__('No such file ', true).$sourceFilename);
			return false;
		}
		
		list ($width, $height, $type, $params) = getimagesize($sourceFilename);
		$new_height = round(($new_width*$height)/$width);
		
		if (is_readable($sourceFilename) || is_null($destinationFilename)) {
			if (!is_file($destinationFilename)) {
				
				switch ($type) {
					case IMAGETYPE_JPEG:
         				$img = imagecreatefromjpeg($sourceFilename);
         			break;
					case IMAGETYPE_GIF:
         				$img = imagecreatefromgif ($sourceFilename);
         			break;
					case IMAGETYPE_PNG:
         				$img = imagecreatefrompng($sourceFilename);
         			break;
				}
				
				$new_img = imagecreatetruecolor($new_width, $new_height);
 
				if (($type == IMAGETYPE_GIF) || ($type == IMAGETYPE_PNG)) {
					$trnprt_indx = imagecolortransparent($img);
					if ($trnprt_indx >= 0) {
						$trnprt_color = imagecolorsforindex($img, $trnprt_indx);
						$trnprt_indx = imagecolorallocate($new_img, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
						imagefill($new_img, 0, 0, $trnprt_indx);
						imagecolortransparent($new_img, $trnprt_indx);
					} elseif ($type == IMAGETYPE_PNG) {
						imagealphablending($new_img, false);
						$color = imagecolorallocatealpha($new_img, 0, 0, 0, 127);
						imagefill($new_img, 0, 0, $color);
						imagesavealpha($new_img, true);
					}
				}
				
				imagecopyresampled($new_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				
				if (is_null($destinationFilename)) {
					header('Content-type: image/'.$imageType);
				}
				
				switch ($imageType) {
					case 'jpg':
						$result = imagejpeg($new_img, $destinationFilename, $quality);
					break;
					case 'png':
						$result = imagepng($new_img, $destinationFilename);
					break;
					case 'gif':
						$result = imagegif($new_img, $destinationFilename);
					break;
					case 'wbmp':
						$result = imagewbmp($new_img, $destinationFilename);
					break;
				}
				
				if ($result) {
					imagedestroy($img);
					imagedestroy($new_img);
					return true;
				} else {
					$this->setError(__('Can\'t create image file ', true).$destinationFilename);
					return false;
				}
			}
		} else {
			$this->setError(__('Not readable file ', true).$sourceFilename);
			return false;
		}
		
	}
	
	function setError($error) {
		return  $this->error .= $error."\n";
	}
	
	function getError() {
		return  $this->error;
	}
	
}
?>