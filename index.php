<?php

require 'config.php';

$source1 = (new File("organization.csv"))->parse();
$source2 = (new File("account.csv"))->parse();

$mapper = new Mapper(CSVRecord::prettify("Name"), $source1, $source2, [
    "Phone" => "Phone"
]);
$mapper->map()->save();

