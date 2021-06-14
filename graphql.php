<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=UTF-8');
require_once __DIR__ . '/vendor/autoload.php';
use GraphQL\GraphQL;
use GraphQL\Utils\BuildSchema;

$resolveEcho = require "echo.php";
$resolveSum = require "sum.php";

try {
  $schema = file_get_contents('schema.graphql');
  $schema    = BuildSchema::build($schema);
  $rootValue = [
    'echo' => $resolveEcho,
    'sum' => $resolveSum,
    'prefix' => 'You said: ',
  ];

  $rawInput       = file_get_contents('php://input');
  $input          = json_decode($rawInput, true);
  $query          = $input['query'];
  $variableValues = $input['variables'] ?? null;

  $result = GraphQL::executeQuery($schema, $query, $rootValue, null, $variableValues);
} catch (Throwable $e) {
  $result = [
    "status"=>0,
    "debug" => [
      "message" => $e->getMessage(),
    ],
  ];
}
echo json_encode($result);
