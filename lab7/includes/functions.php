<?php


function isUnique($email)
{

    $query = "select * from users where email = '$email' ";

    global $db;

    $result = $db->query($query);

    if ($result->num_rows > 0) {

        return false;

    } else return true;
}
