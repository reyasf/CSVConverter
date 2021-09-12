<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once "LoadData.php";

class Converter extends LoadData {
    
    // File path for the CSV file
    static private $_csv_file = "/files/products.csv";
    
    // Delimiter used in the CSV
    static private $_csv_delimiter = ",";
    
    // CSV Header length
    static private $_csv_header_length = 1024;
    
    /*
     * Function Name: convertCSV
     * Arguments: No
     * Function: To process the CSV, To check the product already exists in JSON or XML, Create product array combining existing and current products
     */
    public static function convertCSV() {
        LoadData::$_file_path = dirname(__DIR__, 2);
        if (!($f = fopen(LoadData::$_file_path.self::$_csv_file, 'r'))) {
            die("Error reading the file");
        } else {
            $products_json = LoadData::LoadJSONData();
            $products_xml = LoadData::LoadXMLData();
        }
        $header = fgetcsv($f,self::$_csv_header_length,self::$_csv_delimiter);
        while ($row = fgetcsv($f,self::$_csv_header_length,self::$_csv_delimiter)) {
            //Check whether the sku already available in the array extracted from JSON file
            if(array_search($row[2], array_column($products_json, 'sku')) === false) {
                $products_json[] = array_combine($header, $row);
            }
            //Check whether the sku already available in the array extracted from XML file
            if(array_search($row[2], array_column($products_xml, 'sku')) === false) {
                $products_xml[] = array_combine($header, $row);
            }
        }
        fclose($f);
        self::writeJSON($products_json);
        self::writeXML($products_xml);
    }
    
    /*
     * Function Name: writeJSON
     * Arguments: products Type: array
     * Function: To write the products to JSON file
     */
    public static function writeJSON($products) {
        $json_file = fopen(LoadData::$_file_path.LoadData::$_json_file, 'w');
        fwrite($json_file, json_encode($products));
        fclose($json_file);
        
        echo "JSON File created successfully \n";
    }
    
    /*
     * Function Name: writeXML
     * Arguments: products Type: array
     * Function: To write the products to XML file
     */
    public static function writeXML($products) {
        $product_xml = new DomDocument('1.0', 'UTF-8'); 
        $root = $product_xml->createElement('root');
        $product_xml->appendChild($root);

        foreach($products as $key => $product) 
        {	
            $product_node = $product_xml->createElement('product');
            $root->appendChild($product_node);
            foreach($product as $field_name => $field_value) 
            {	
                $name = $product_node->appendChild($product_xml->createElement($field_name)); 
                $name->appendChild($product_xml->createCDATASection($field_value)); 
            }
        }
        $product_xml->formatOutput = true; 
        $product_xml->save(LoadData::$_file_path.LoadData::$_xml_file);
        
        echo "XML File created successfully \n";
    }
}