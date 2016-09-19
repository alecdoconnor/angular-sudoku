<?php
//Puzzle generator
//This puzzle is status
//May consider using an array of only filled cells in future releases to reduce file output size

//init puzzle array
$puzzle = array();

//add columns individually to array
array_push($puzzle,
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

//output JSON
echo json_encode($puzzle);

?>
