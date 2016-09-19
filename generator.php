<?php
//Puzzle generator
//This puzzle is status
//May consider using an array of only filled cells in future releases to reduce file output size

//init puzzle array
$puzzle = array();

//add columns individually to array
array_push($puzzle,
array('',2,'',1,7,8,'',3,''),
array('',4,'',3,'',2,'',9,''),
array(1,'','','','','','','',6),
array('','',8,6,'',3,5,'',''),
array(3,'','','','','','','',4),
array('','',6,7,'',9,2,'',''),
array(9,'','','','','','','',2),
array('',8,'',9,'',1,'',6,''),
array('',1,'',4,3,6,'',5,'')
);

//output JSON
echo json_encode($puzzle, JSON_FORCE_OBJECT);

?>
