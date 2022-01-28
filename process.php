<?php

require 'config.php';

// Get files links
$file1 = $_FILES['source1']['tmp_name'];
$file2 = $_FILES['source2']['tmp_name'];

// Get the handle (shared between both files)
$handle = trim($_POST['handle']);

// Set chosen separator
if(in_array($_POST['sep'], [';',',','|'])){
    $SEPARATOR = $_POST['sep'];
}

$map_layout = [];
foreach ($_POST['fields1'] as $key=>$field){
    if(trim($field) != "" || trim($_POST['fields2'][$key]) != ""){
        $map_layout[$field] = $_POST['fields2'][$key];
    }
}

// Parse files
$source1 = (new File($file1))->parse();
$source2 = (new File($file2))->parse();

// Setting Mapper
$mapper = new Mapper(CSVRecord::prettify($handle), $source1, $source2, $map_layout);
// Map and save result
$link = $mapper->map()->save();

header("location: index.php?q=$link");
die;