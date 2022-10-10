<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/classes/DBTables.php';

$tables = new DBTables();
$tables->createTables();
