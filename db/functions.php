<?php

/*
item_exists(): function to check if an item already exists in the database
parameters:   $cat: the category to check for
              $db: to pass $database for querying
              $ref_table: the database tale to look in
              $col_name: column name in the ref_table
returns true if the passed item already exists, false otherwise
*/
function item_exists($item, $db, $ref_table, $col_name)
{
    $fetch_categories = $db->getReference($ref_table)->getValue();

    foreach ($fetch_categories as $category_key => $row) {
        if ($row[$col_name] == $item) {
            return true;
        }
    }
    return false;
}

?>