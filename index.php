<!DOCTYPE html>
<html>
<head>
<title>Sudoku Challenge</title>
<!-- AngularJS Library -->
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Puzzle Styling -->
<link rel="stylesheet" type="text/css" href="style/style.css">
<script>
window.fadeIn = function(obj) {
	$(obj).animate({opacity:1},800)
}
</script>
</head>
<body ng-app="sudoku">
	<!--input below is used to deselect cells after entering a value-->
<input id="deselectOthers" style="width:0; height:0; position:absolute; left: -100px;"/>
<div id="intro">
<h1>The Great Sudoku Challenge</h1>
<h3>Be the first to beat our classic Sudoku challenge for an all-expenses-paid week-long vacation!</h3>
</div>

<div id="puzzle" ng-controller="sudokuController" style="opacity:0;">
  <div class="row" ng-repeat="y in puzzle">
    <div class="column  R{{x.row}} C{{x.column}}  B{{((x.column)+1)/3 | number:0}}{{((x.row)+1)/3 | number:0}}" ng-repeat="x in y" ng-click="x.inEdit = true;">
    	<!--static cell-->
    	<span ng-if="!x.editable" style="font-weight:bold;">{{x.value}}</span>
    	<!--dynamic cell-->
    	    <!--Show empty when value = 0-->
    	<span ng-if="x.editable" ng-hide="x.value != 0 || x.inEdit">&nbsp;&nbsp;</span>
    	<!--Show value when 1-9-->
    	<span ng-if="x.editable" ng-hide="x.value == 0 || x.inEdit" ng-bind="x.value" style="color:#2F5B85"></span>
    	<!--Show input cell when activated (clicked on and in focus)-->
    	<input ng-if="x.editable"
    	class="inputCell"
    	ng-model="x.value"
    	ng-show="x.inEdit"
    	ng-mouseover="selectInput($event)"
    	ng-mouseclick="selectInput($event)"
    	ng-blur="x.inEdit = false"
    	ng-change="x.inEdit = false;deselectInput();validEntry(x.value, x.row, x.column);checkGame();" />
    </div>
    <div class="clear"></div>
  </div>
    <style ng-repeat="cell in cellRanges | theIllegals:illegals" >.{{cell}} {background-color:#FFEAE9;}</style>
</div>

<div style="margin:10px;"></div>

<table id="leaders" ng-show="leaderboards" style="text-align:center;">
	  <tr>
	    <th style="width:50%;">Name</th>
	    <th>Finish Time</th>
	  </tr>
	  <tr ng-repeat="individual in leaderboards">
	  	<td>
	      {{individual[0]}}
	    </td>
	    <td>
	      {{individual[1] | date:medium}}
	    </td>
	  </tr>
</table>

<div id="rules">
<p>The classic sudoku game involves a grid of 81 squares. The grid is divided into nine blocks, each containing nine squares.</p>
<p>The rules of the game are simple: each of the nine blocks must contain all the numbers 1-9 within its squares. Each number can only appear once in a row, column, or box.</p>
<p>The difficulty lies in that each vertical nine-square column, or horizontal nine-square line across, within the larger square, must also contain the numbers 1-9, without repetition or omission.</p>
<p>Every puzzle has just one correct solution.</p>
</div>

<script src="script/puzzle.js"></script>
</body>
