
<div class="jumbostron">

    <h2>
        Welcome <?php echo $_SESSION['user_email'] ?>

    </h2>
</div>

<h3>Result Table</h3>
<p>This show message from the contact page</p>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Message</th>

        </tr>
        </thead>
        <tbody>
        <?php
        $query = "select * from messages";
        $result = $db->query($query);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row["id"] ?></td>
                    <td><?php echo $row["name"] ?></td>
                    <td><?php echo $row["email"] ?></td>
                    <td><?php echo $row["subject"] ?></td>
                    <td><?php echo $row["message"] ?></td>

                </tr>
            <?php }
        } ?>

        </tbody>
    </table>
</div>


</div><!-- /.container -->

<!-- /.container -->
