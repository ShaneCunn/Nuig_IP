<body xmlns="http://www.w3.org/1999/html">
<h2>
    Welcome <?php echo $_SESSION['user_email'] ?>

</h2>

<div class="col-xs-12 col-sm-6 col-lg-10">
    <h3>Result Table</h3>
    <p>This show message from the contact page</p>
    <div class="table-responsive">
        <table class="table table-bordered table-striped " id="mytable">
            <thead>
            <tr>
                <th>ID</th>
                <th>Sale Price</th>
                <th>Product Name</th>
                <th>Product Description</th>
                <th>Image File name</th>

            </tr>
            </thead>
            <tbody>
            <?php
            global $db;

            $query = "SELECT * FROM products LIMIT 0,20";
            $result = $db->query($query);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<form action=/lab7/editStock.php method=post>";
                    echo "<tr>";
                    echo "<td class=\"col-sm-1\">" . "<input type=text  class=\"form-control\" readonly name=id value=" . $row['id'] . " </td>";
                    echo "<td class=\"col-sm-2\">" . "<input type=number class=\"form-control\" name=sale_price value=" . $row['sale_price'] . " </td>";
                    echo "<td class=\"col-sm-2\">" . "<input type=text class=\"form-control\" name=product_name value=" . $row['product_name'] . " </td>";
                    echo "<td class=\"col-sm-4\">" . "<input type=text class=\"form-control\" name=text_desc value=" . $row['text_desc'] . " </td>";
                    echo "<td class=\"col-sm-3\">" . "<input type=text class=\"form-control\" name=image_filename value=" . $row['image_filename'] . " </td>";

                    echo "<td><p data-placement=\"top\" data-toggle=\"tooltip\" title=\"Edit\"><button class=\"btn btn-primary btn-xs\" data-title=\"Edit\" type=submit name=update data-toggle=\"modal\" data-target=\"#edit\" ><span class=\"glyphicon glyphicon-pencil\"></span></button></p></td>";
                    echo "<td><p data-placement=\"top\" data-toggle=\"tooltip\" title=\"Delete\"><button class=\"btn btn-danger btn-xs\" type=submit name=delete data-title=\"Delete\" data-toggle=\"modal\" data-target=\"#delete\" ><span class=\"glyphicon glyphicon-trash\"></span></button></p></td>";

                    echo "</form>";
                    echo "</tr>";
                }
            } else {
                echo "Zero record found";
            } ?>

            <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-success fade-in"><a href="#" class="close" data-dismiss="alert"
                                                        aria-label="close">&times;</a><?php echo $_GET['success'] ?>
            </div>
    </div>
    </div>
    </tbody> </table>
    </table>
<?php } ?>

