<?php
/**
 * Created by PhpStorm.
 * User: 15104623
 * Date: 29/03/2016
 * Time: 10:35
 */

if (isset($_POST['delete'])) {
    $_SESSION['sale_price'] = $_POST['sale_price'];
    $_SESSION['product_name'] = $_POST['product_name'];
    $_SESSION['image_filename'] = $_POST['image_filename'];
    $_SESSION['text_desc'] = $_POST['text_desc'];


    $sale_price = mysqli_real_escape_string($db, $_POST['sale_price']);
    $product_name = mysqli_real_escape_string($db, $_POST['product_name']);
    $image_filename = mysqli_real_escape_string($db, $_POST['image_filename']);
    $text_desc = mysqli_real_escape_string($db, $_POST['text_desc']);

    $query = "DELETE FROM products WHERE id='$_POST[id]'";
    $result = $db->query($query);
    //  mysql_query($sql_query);
    header("Location:editStock.php?success=" . urldecode("stock deleted!"));
}