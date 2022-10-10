<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
include_once '../classes/User.php';

$user = new User();

$data = json_decode(file_get_contents("php://input"));

$user->setid($data->id);
$user->setName($data->name);
$user->setLastName($data->lastname);

$result = $user->update();

if ($result == 0) {
    echo json_encode("Zaktualizowano użytkownika");
} else {
    echo json_encode("Nie udało się zaktualizować użytkownika:(");
    // Tutaj można pobrać dokładny opis błędu
    // $errorMessage = $user->getErrorMessage();
}
