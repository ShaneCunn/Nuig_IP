<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/lab7/login.php">Administrator page for NUIG Shop</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">

                <li>
                    <a href="/lab7/index.html">Home</a>
                </li>

                <li>
                    <a href="/lab7/about.html">About</a>
                </li>

                <li>
                    <a href="/lab7/contact.php">Contact</a>
                </li>

                <li>
                    <a href="/lab7/special_offers.html">Special Offers</a>
                </li>

                <li>
                    <a href="/lab7/links.html">Useful links</a>
                </li>
                <li>
                    <a href="/lab7/clock.html">Clock</a>
                </li>
                <li <?php echo $link1; ?>>
                    <a href="/lab7/editStock.php">Stock</a>
                </li>

                <li <?php echo $link2; ?>>
                    <a href="/lab7/showContactUs.php">Administrator panel</a>
                </li>

                <?php if (!isset($_SESSION['user_email'])) { ?>
                    <li <?php echo $link3; ?>><a href="/lab7/login.php">Login</a></li>
                    <li <?php echo $link4; ?>><a href="/lab7/register.php">Register</a></li>
                <?php } ?>

                <?php if (isset($_SESSION['user_email'])) { ?>
                    <li><a href="/lab7/logout.php">Logout</a></li>
                <?php } ?>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-xs-6 col-lg-2">
            <p class="lead">NUIG Shop</p>

            <div class="list-group">
                <a class="list-group-item" href="/lab7/index.html">Home</a>
                <a class="list-group-item" href="/lab7/about.html">About</a>
                <a class="list-group-item" href="/lab7/contact.php">Contact</a>
                <a class="list-group-item" href="/lab7/special_offers.html">Special Offers</a>
                <a class="list-group-item" href="/lab7/links.html">Useful links</a>
                <a class="list-group-item" href="/lab7/clock.html">Clock</a>
            </div>
        </div>