<html>
<head>
<title>Sudoku Challenge</title>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>

</head>
<body>
<div ng-app="sudoku" ng-controller="sudokuController">
  <div ng-repeat="y in puzzle">
    <div ng-repeat="x in y">
    
    </div>
  </div>
</div>

<table>
  <tr ng-repeat="x in puzzle">
    <td>{{ x.Name }}</td>
  </tr>
</table>


<script>
var app = angular.module('myApp', []);
app.controller('sudokuController', function($scope, $http) {
    $http.get("generator.php").then(
    function (response) {
      $scope.puzzle = response.data;
    });
});
</script>
</body>
