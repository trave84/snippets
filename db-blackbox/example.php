<?php

require_once 'lib/DBBlackbox.php';

// insert
$id = insert([
    'name' => 'Joe',
    'surname' => 'Black',
    'yob' => 1982
]);

// update
update(1, [
    'yob' => 1963
]);

// select all
$all_records = select();

// find one
$joe = find(1);

// delete
delete(1);