<html>
<head>
<title>Sudoku Challenge</title>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
<link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body>
	<!--input below is used to deselect cells after entering a value-->
<input id="deselectOthers" style="width:0; height:0; position:absolute; left: -100px;"/>
<div id="intro">
<h1>The Great Sudoku Challenge</h1>
<h3>Be the first to beat our classic Sudoku challenge for an all-expenses-paid week-long vacation!</h3>
</div>

<div id="puzzle" ng-app="sudoku" ng-controller="sudokuController">
  <div class="row" ng-repeat="y in puzzle">
    <div class="column" ng-repeat="x in y" ng-click="x.inEdit = true;">
    	<!--static cell-->
    	<span ng-if="!x.editable" style="font-weight:bold;">{{x.value}}</span>
    	<!--dynamic cell-->
    	    <!--Show empty when value = 0-->
    	<span ng-if="x.editable" ng-hide="x.value != 0 || x.inEdit">&nbsp;&nbsp;</span>
    	<!--Show value when 1-9-->
    	<span ng-if="x.editable" ng-hide="x.value == 0 || x.inEdit" ng-bind="x.value" style="color:#2F5B85"></span>
    	<!--Show input cell when activated (clicked on and in focus)-->
    	<input ng-if="x.editable"
    	type="number"
    	style="width: 50px; height: 50px;"
    	ng-model="x.value"
    	ng-show="x.inEdit"
    	ng-mouseover="selectInput($event)"
    	ng-mouseclick="selectInput($event)"
    	ng-blur="x.inEdit = false"
    	ng-change="x.inEdit = false;deselectInput();validEntry(x.value, x.row, x.column);checkGame();" />
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
      
      $scope.selectInput = function($event) {
      	$event.target.select();
      };
      
      $scope.deselectInput = function() {
      	document.getElementById("deselectOthers").select();
      };
      
      $scope.validEntry = function(value,y,x) {
      	if ((value > 0) && (value < 10) && (value % 1 === 0)) {
          //legal input
            //Do we need to test for anything here?
        }
        else {
        	//illegal input
          $scope.puzzle[y-1][x-1].value = 0;
        }
        $scope.puzzle[y-1][x-1].inEdit = false;
      }
      
      $scope.checkGame = function() {
      	if ($scope.movesLeft()) {
      		//notify of legal cells
      		$scope.checkLegalCells();
      	}
      	else {
      		//game finished if all legal
      		if (checkLegalCells()) {
              //win
              saveWin();
              alert("WIN!");
            }
      	}
      };
      
      $scope.movesLeft = function() {
      	var anyLeft = false;
      	angular.forEach($scope.puzzle, function(yrow) {
          angular.forEach(yrow, function(xcell) {
          	//check every row here
          	if (xcell.value == 0) {
          		anyLeft = true;
          	}
          });
        });
      	return anyLeft;
      }
      
      $scope.checkLegalCells = function() {
      	var legal = true;
      	$scope.illegals = [];
      	//rows
      	angular.forEach($scope.puzzle, function(yrow) {
      		var row = [];
          angular.forEach(yrow, function(xcell) {
          	//check every row here
          	if (xcell.value > 0) {
          		row.push(xcell.value);
          	}
          });
          if ($scope.checkDuplicates(row)) {
          	//this row is invalid
          	legal = false;
          	$scope.illegals.push("R" + yrow[0].row);
          	//adjust css to red border
          }
          else {
          	//valid row
          	//adjust css to black border
          }
        });

        
        //columns
        for (var i = 0; i < 9; i++) {
          var column = [];
          angular.forEach($scope.puzzle, function(yrow) {
          	if (yrow[i].value > 0) {
          	  column.push(yrow[i].value);
          	}
          });
          if ($scope.checkDuplicates(column)) {
          	//this column is invalid
          	legal = false;
          	$scope.illegals.push("C" + (i+1));
          	//adjust css to red border
          }
          else {
          	//valid column
          	//adjust css to black border
          }
        }
        
        
        //check 3x3 boxes
        for (var xx = 0;xx < 3;xx++) {
          for (var yy = 0;yy < 3;yy++) {
          	//one of nine cell blocks
        	var box = [];
        	for (var i = 0;i < 3;i++) {
        	  for (var j = 0;j < 3; j++) {
        	  	//one cell in a cell block
        	  	var puzx = (xx*3)+i;
        	  	var puzy = (yy*3)+j;
        	  	var val = $scope.puzzle[puzy][puzx].value;
        	  	if (val != 0) {
        	  	  box.push(val);
        	  	}
        	  }
        	}
        	if ($scope.checkDuplicates(box)) {
        	  //this column is invalid
          	  legal = false;
          	  $scope.illegals.push("B" + (xx+1) + (yy+1))
          	  //adjust css to red border
            }
            else {
          	  //valid column
          	  //adjust css to black border
        	}
          }
        }
      	return legal;
      };
      
      $scope.checkDuplicates = function(arrayVals) {
        arrayVals.sort();
        for (var i=0; i<arrayVals.length-1; i++) {
          if (arrayVals[i+1] == arrayVals[i]) {
            return true;
          }
        }
        return false;
      };
      
      $scope.saveWin = function() {
      	
      }
      
      
    });
});
</script>
</body>
