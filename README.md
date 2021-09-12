# CSV Converter

Application converts CSV file to JSON and XML files. Simple REST API to access the JSON file with filters

## Description

PHP CLI script to convert CSV to JSON and XML files. REST API to access the JSON file with filters (name and pvp)

### Installation

* Move the script to the web root folder of the application
* Create a folder "files" outside the web root, (CSV,JSON and XML files will be stored in this folder) enable write access to it
* Move the "products.csv" to the "files" folder
* Run the CLI command
```
php processcsv.php
```
This will generate the JSON and XML files by parsing the CSV

### Executing REST API

* The application allows to access the product data using two end points (name,pvp)
* To request product with name, replace ```<domain>``` with domain name and ```<name>``` with product name
```
http://<domain>/api/name/<name>
```
* To request product with price, replace <domain> with domain name and <price> with product price
```
http://<domain>/api/pvp/<price>
```
* The URL's are rewritten using .htaccess file, If you not wish to use .htaccess you can access the API using parameters
* Replace ```<domain>``` with domain name,```<name>``` with product name and ```<price>``` with product price
```
http://<domain>/api.php?name=<name>&pvp=<price>
```
This will return products that matches the name as well as the price

## Improvement Ideas

* The API can be improved to match product names that contains the filtered string as substring, to return multiple products
* The price filter can be improved to have conditional filters like price greater than, less than the filtered price
* The API inputs need to be secured in order to use them to filter products from DB
* The API script can be improved by using any PHP framework or by implementing OOP approach
* Can include an installation script which will create pre-requisites of the application
* Can make the filenames and folder names generic and not to use static names
* API requests can be secured by defining number of request per hour/day
* API response should be paginated when we implement filtering multiple products for single request
