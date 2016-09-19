<?php
//Puzzle generator
//This puzzle is status
//May consider using an array of only filled cells in future releases to reduce file output size

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

//Create a class for the data to be stored for each individual cell
class Piece {
  public $editable;
  public $inEdit;
  public $row;
  public $column;
  public $value;

  public function __construct($row, $column, $value) {
    if ($value > 0) {
      $this->editable = false;
    }
    else {
      $this->editable = true;
    }
    $this->inEdit = false;
    $this->row = $row;
    $this->column = $column;
    $this->value = $value;
  }
}

//Initial puzzle array
  $initpuzzle = array();
//add columns individually to array
  array_push($initpuzzle,
  array(0,2,0,1,7,8,0,3,0),
  array(0,4,0,3,0,2,0,9,0),
  array(1,0,0,0,0,0,0,0,6),
  array(0,0,8,6,0,3,5,0,0),
  array(3,0,0,0,0,0,0,0,4),
  array(0,0,6,7,0,9,2,0,0),
  array(9,0,0,0,0,0,0,0,2),
  array(0,8,0,9,0,1,0,6,0),
  array(0,1,0,4,3,6,0,5,0)
  );

//Real puzzle array
 $puzzle = array();

$y = 0;
foreach ($initpuzzle as $row) {
  $y++;
  $x = 0;
  $temprow = array();
  foreach ($row as $column) {
    $x++;
    array_push($temprow, new Piece($y,$x,$initpuzzle[$y-1][$x-1]));
  }
  array_push($puzzle,$temprow);
}


//output JSON
echo json_encode($puzzle, JSON_FORCE_OBJECT);

?>
