<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../classes/User.php';

$user = new User();
$result = $user->index();

$itemCount = count($result);

if ($itemCount > 0) {
    echo json_encode($result);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "Brak danych.")
    );
}