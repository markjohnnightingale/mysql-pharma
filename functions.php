<?php 

// Function to parse SQL timestamps
function parse_sql_timestamp($timestamp, $format = "d M y à H\hi")
{
    $date = strtotime($timestamp);
    return date($format,$date);
}
?>