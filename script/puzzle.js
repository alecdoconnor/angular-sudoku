
var app = angular.module('sudoku', []);
app.controller('sudokuController', function($scope, $http, $rootScope) {
    $http.get("generator.php").then(
    function (response) {
      $scope.puzzle = response.data;
      //fade in puzzle after data load
      fadeIn(document.getElementById("puzzle"));
      
      $rootScope.leaderboards = [];

       $http.get("uploadWin.php").then(function(response) {
	  	$rootScope.leaderboards = response.data;
	  }, function(response) {
        alert("There was an error loading the leaderboard!")
	  });

      $scope.illegals = [];
      //Normally I would not recommend hard-coding, but running a loop for this would be more trouble than needed
      $scope.cellRanges = ["R1","R2","R3","R4","R5","R6","R7","R8","R9",
                           "C1","C2","C3","C4","C5","C6","C7","C8","C9",
                           "B11","B12","B13","B21","B22","B23","B31","B32","B33"];
      
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
      		if ($scope.checkLegalCells()) {
              //win
              $scope.saveWin();
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
      	var myName = (prompt("You win!\nPlease enter your name so that we can add you to the leaderboard.", ""));
      	//in future versions this should be created server-side to prevent javascript injection
      	var payload = [myName];
      	$http.post('uploadWin.php', JSON.stringify(payload)).then(function(response) {
      		$rootScope.leaderboards = response.data;
      	}, function(response) {
      		      		alert("There was an error uploading your completed puzzle. Please email admin@website.com a picture of your completed Sudoku puzzle. " + response.status + response.data);
      	});
      }
      
      
    });
});
app.filter('theIllegals', function() {
	  return function(cellRanges, illegals) {
	  	return cellRanges.filter(function(cell) {
	  		for (var i in illegals) {
	  			if (cell.indexOf(illegals[i]) != -1) {
	  				return true;
	  			}
	  		}
	  		return false;
	  	});
	  };
	});
	
app.controller('leaderboardController', function($scope, $http, $rootScope) {
	$scope.leaderboards = [];
	});
