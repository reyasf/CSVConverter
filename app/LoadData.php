<?php

/* 
 * DATA LOADER
 */

class LoadData {
    
    // File path for the JSON file
    public static $_json_file = "/files/products.json";
    
    // File path for the XML file
    public static $_xml_file = "/files/products.xml";
    
    public static $_file_path;
    
    public static function LoadJSONData() {
        $products_json = file_exists(self::$_file_path.self::$_json_file) ? json_decode(file_get_contents(self::$_file_path.self::$_json_file), true) : array();
        return $products_json;
    }
    public static function LoadXMLData() {
        $products_xml = file_exists(self::$_file_path.self::$_xml_file) ? json_decode(json_encode(simplexml_load_file(self::$_file_path.self::$_xml_file, "SimpleXMLElement", LIBXML_NOCDATA)), true)["product"] : array();
        return $products_xml;
    }
    
}

