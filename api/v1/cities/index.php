<?php
include_once "C:/xampp/htdocs/temp/Iran/loader.php";
use \App\Services\CityService;
use \App\Utilities\Response;

$request_method = $_SERVER['REQUEST_METHOD'];
$request_body = json_decode(file_get_contents('php://input'),true);
$city_service = new CityService();


switch ($request_method){
    case 'GET':
        $province_id  = $_GET['province_id'] ?? null;
        $request_data = [
            'province_id' => $province_id,
            'fields' => $_GET['fields'] ?? null,
            'orderby' => $_GET['orderby'] ?? null,
            'page' => $_GET['page'] ?? null,
            'pagesize' => $_GET['pagesize'] ?? null,
        ];
        $response = getCities($request_data);
        if (empty($response))
            Response::respondAndDie($response,Response::HTTP_NOT_FOUND);
        Response::respondAndDie($response,Response::HTTP_OK);
    case 'POST':
        if(!isValidCity($request_body))
            Response::respondAndDie(['Invalid City Data ..'],Response::HTTP_NOT_ACCEPTABLE);
        $response = $city_service->creatCitY($request_body);
        Response::respondAndDie($response,Response::HTTP_CREATED);
    case 'PUT':
        [$city_id,$city_name] = [$request_body['city_id'],$request_body['name']];
        if(!is_numeric($city_id) or empty($city_name))
            Response::respondAndDie(['Invalid City Data ..'],Response::HTTP_NOT_ACCEPTABLE);
        $result = $city_service->updateCityName($city_id,$city_name);
        Response::respondAndDie($result,Response::HTTP_OK);
    case 'DELETE':
        $city_id = $_GET['city_id'] ?? null;
        if(!is_numeric($city_id) or is_null($city_id))
            Response::respondAndDie(['Invalid City id ..'],Response::HTTP_NOT_ACCEPTABLE);
        $result = $city_service->deleteCity($city_id);
        Response::respondAndDie($result,Response::HTTP_OK);
    default:
        Response::respondAndDie(['Invalid request Method'],Response::HTTP_METHOD_NOT_ALLOWED);
}

//$cs = new CityService();
//$result = $cs->getCities((object)[1,2,33,444,55]);
//Response::respondAndDie($result,Response::HTTP_OK);