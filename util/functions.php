<?php
/*
item_exists(): function to check if an object with the same attribute already exists in the database (using attributes, NOT keys!)
               exmaple: checking if a book isbn already exists among the books in the DB
parameters:   $attribute: the attribute to check for
              $db: to pass $database for querying
              $ref_table: the database tale to look in
              $col_name: column name in the ref_table
returns true if the passed attribute already exists, false otherwise
*/
function item_exists($attribute, $db, $ref_table, $col_name)
{
    $fetch_item = $db->getReference($ref_table)->getValue();

    foreach ($fetch_item as $row) {
        if ($row[$col_name] == $attribute) {
            return true;
        }
    }
    return false;
}

/*
object_exists(): function to check if an object with the same attribute, but not the key already exists in the database
                 example: checking if a book with the same ISBN but not the same key exists in the DB
parameters:   $obj_key: key of the obj to compare with
              $attribute: the attribute to check for
              $db: to pass $database for querying
              $ref_table: the database tale to look in
              $col_name: column name in the ref_table
returns true only if the passed attribute matches the attribute of another object with a different key, false otherwise
*/
function object_exists($obj_key, $attribute, $db, $ref_table, $col_name)
{
    $fetch_item = $db->getReference($ref_table)->getValue();

    foreach ($fetch_item as $fetched_key => $row) {
        if (($row[$col_name] == $attribute) && !($fetched_key == $obj_key)) {
            return true;
        }
    }
    return false;
}
?>