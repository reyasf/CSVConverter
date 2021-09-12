#!/usr/bin/php
<?php 
/* 
 * BASH FILE EXECUTED FROM CLI
 */

define('APP_ROOT', getcwd());

$converter = APP_ROOT . '/app/Converter.php';

require_once $converter;

Converter::convertCSV();