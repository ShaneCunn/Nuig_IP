<form class="form-signin" action="register.php" method="post">
    <h2 class="form-signin-heading">Register Here</h2>

    <?php if (isset($_GET['err'])) { ?>
        <div class="alert alert-danger fade-in"><a href="#" class="close" data-dismiss="alert"
                                                   aria-label="close">&times;</a><?php echo $_GET['err'] ?>
        </div>
    <?php } ?>

    <div class="form-group">
        <label for="exampleInputEmail1" class="sr-only">Name</label>
        <input type="name" name="name" class="form-control" placeholder="Name" required autofocus
               value="<?php echo @$_SESSION['name']; ?>">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1" class="sr-only">Email address</label>
        <input type="email" name="email" class="form-control" placeholder="Email" required
               value="<?php echo @$_SESSION['email']; ?>">
    </div>

    <div class="form-group">
        <label for="exampleInputPassword1" class="sr-only">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Password" required
               value="<?php echo @$_SESSION['password']; ?>">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1" class="sr-only">Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control"
               placeholder="Confirm Password" required value="<?php echo @$_SESSION['confirm_password']; ?>">
    </div>


    <button class="btn btn-lg btn-primary btn-block" type="submit" class="btn btn-default" name="register">
        Register
    </button>
</form>

</div>

</div><!-- /.container -->