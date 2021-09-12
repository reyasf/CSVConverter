<?php

/* 
 * API Handler
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application / xml; charset=UTF-8");

define('APP_ROOT', getcwd());

$dataloader = APP_ROOT . '/app/LoadData.php';

require_once $dataloader;

LoadData::$_file_path = dirname(__DIR__, 1);

//Store request variables
$product_name = (isset($_GET['name']) && $_GET['name']) ? $_GET['name'] : null;
$product_pvp = (isset($_GET['pvp']) && $_GET['pvp']) ? $_GET['pvp'] : 0;

//Load all the products from JSON file
$product_list = LoadData::LoadJSONData();
$product_keys = array();
$response = array();
$responsexml = new SimpleXMLElement('<root/>');

//Filter products usind the $_GET['name'] or $_GET[pvp]
if(isset($_GET['name']) || isset($_GET['pvp'])) {
    if(isset($_GET['name'])) {
        $product_keys[] = array_search($product_name, array_column($product_list, 'name')) !== false ? array_search($product_name, array_column($product_list, 'name')) : null;
    } 
    if(isset($_GET['pvp'])) {
        $product_keys[] = array_search($product_pvp, array_column($product_list, 'pvp')) !== false ? array_search($product_pvp, array_column($product_list, 'pvp')) : null;
    }
    //Loop through all the filtered keys
    foreach($product_keys as $key) {
        if($key !== null) {
            $response[] = array($product_list[$key]["name"] => "name",$product_list[$key]["sku"] => "sku",$product_list[$key]["pvp"] => "pvp",$product_list[$key]["discount"] => "discount");
        }
    }
    if(count($response) > 0) {
        //convert the response to XML
        array_walk_recursive($response, array ($responsexml, 'addChild'));
    } else {
        //if the response is empty no product match the filter
        $response = array(200 => "code","No product found" => "description");
        array_walk_recursive($response, array ($responsexml, 'addChild'));
    }
}
print $responsexml->asXML();