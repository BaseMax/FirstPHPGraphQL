<?php
declare(strict_types=1);

require_once __DIR__ . "/vendor/autoload.php";
use GraphQL\GraphQL;
use GraphQL\Utils\BuildSchema;

try {
  $resolveEcho = require "echo.php";
  $resolveSum = require "sum.php";

  $schema = file_get_contents("schema.graphql");
  $schema = BuildSchema::build($schema);
  $rootValue = [
    "echo" => $resolveEcho,
    "sum" => $resolveSum,
    "prefix" => "",
  ];

  if(isset($_POST["submit"])) {
    $query          = $_POST["query"] ?? null;
    $variableValues = $_POST["variables"] ?? null;
    if($variableValues === "") $variableValues = null;
  } else {
    $rawInput       = file_get_contents("php://input");
    $input          = json_decode($rawInput, true);
    $query          = $input["query"] ?? null;
    $variableValues = $input["variables"] ?? null;
  
    if($input === null) {
      print "<form action="" method="POST">";
      print "<b>Query:</b><br>";
      print "<textarea name="query"></textarea>";
      print "<br>";
      print "<b>Variables:</b><br>";
      print "<textarea name="variables"></textarea>";
      print "<br>";
      print "<button name="submit">Submit</button>";
      print "</form>";
      exit();
    }
  }

  header("Content-Type: application/json; charset=UTF-8");

  $result = GraphQL::executeQuery($schema, $query, $rootValue, null, $variableValues);
} catch (Throwable $e) {
  $result = [
    "status"=>0,
    "debug" => [
      "message" => $e->getMessage(),
    ],
    "data"=>[],
  ];
}

echo json_encode($result);
