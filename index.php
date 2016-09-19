<html>
<head>
<title>Sudoku Challenge</title>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
<link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body>

<div id="intro">
<h1>The Great Sudoku Challenge</h1>
<h3>Be the first to beat our classic Sudoku challenge for an all-expenses-paid week-long vacation!</h3>
</div>

<div id="puzzle" ng-app="sudoku" ng-controller="sudokuController">
  <div class="row" ng-repeat="y in puzzle">
    <div class="column" ng-repeat="x in y" ng-init="column=$index+1,row=y.">
      {{x}}
    </div>
    <div class="clear"></div>
  </div>
</div>

<div id="rules">
<p>The classic sudoku game involves a grid of 81 squares. The grid is divided into nine blocks, each containing nine squares.</p>
<p>The rules of the game are simple: each of the nine blocks must contain all the numbers 1-9 within its squares. Each number can only appear once in a row, column, or box.</p>
<p>The difficulty lies in that each vertical nine-square column, or horizontal nine-square line across, within the larger square, must also contain the numbers 1-9, without repetition or omission.</p>
<p>Every puzzle has just one correct solution.</p>
</div>

<script>
var app = angular.module('sudoku', []);
app.controller('sudokuController', function($scope, $http) {
    $http.get("generator.php").then(
    function (response) {
      $scope.puzzle = response.data;
      $scope.checkLegalEntries = function() {
        
      };
      $scope.checkLegalEntries = function() {
        
      };
      
    });
});
</script>
</body>
