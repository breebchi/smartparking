<?php
/**
 * Created on Oct 30, 2010 6:06:54 PM
 *
 *
 * @package		BZ_MB
 * @subpackage  ArrayToXML.php
 * @version		1.1.1
 * @author		
 * @copyright	Copyright (C) 2010 DOT IT
 * @license		LGPLv3 (lgpl.txt)
 */

class ArrayToXML
{
    /**
     * The main function for converting to an XML document.
     * Pass in a multi dimensional array and this recrusively loops through and builds up an XML document.
     *
     * @param array $data
     * @param string $rootNodeName - what you want the root node to be - defaultsto data.
     * @param SimpleXMLElement $xml - should only be used recursively
     * @return string XML
     */
    public static function toXml($data, $rootNodeName = 'data', &$xml=null)
    {
        // turn off compatibility mode as simple xml throws a wobbly if you don't.
        if (ini_get('zend.ze1_compatibility_mode') == 1)
        {
            ini_set ('zend.ze1_compatibility_mode', 0);
        }

        if (is_null($xml))
        {
            $xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
        }

        // loop through the data passed in.
        foreach($data as $key => $value)
        {
            // if numeric key, assume array of rootNodeName elements
            if (is_numeric($key))
            {
                $key = $rootNodeName;
            }

            // delete any char not allowed in XML element names
            $key = preg_replace('/[^a-z0-9\-\_\.\:]/i', '', $key);

            // if there is another array found recrusively call this function
            if (is_array($value))
            {
                // create a new node unless this is an array of elements
                $node = ArrayToXML::isAssoc($value) ? $xml->addChild($key) : $xml;

                // recrusive call - pass $key as the new rootNodeName
                ArrayToXML::toXml($value, $key, $node);
            }
            else
            {
                // add single node.
                //$value = utf8_encode($value);
		$value = html_entity_decode($value, ENT_COMPAT, 'UTF-8');
		$value = str_replace(' &', '&amp;', $value);
		$value = str_replace('& ', '&amp;', $value);
                $xml->addChild($key, $value);
            }

        }
        // pass back as string. or simple xml object if you want!
        return ($xml->asXML());
    }

    // determine if a variable is an associative array
    public static function isAssoc( $array ) {
        return (is_array($array) && 0 !== count(array_diff_key($array, array_keys(array_keys($array)))));
    }
    
}

?>
