<?php
/**
 * Created by SUR-SER.
 * User: SURO
 * Date: 16.08.2015
 * Time: 15:21
 */
require './BarmapartsService.php';

$service = new BarmapartsService();
$response = $service->findDetail('4851049017');
var_dump($response);
//$response = $service->getPriceList('4851049017');
//var_dump($response);
//$response = $service->getCatalogList('4851049017');
//var_dump($response);