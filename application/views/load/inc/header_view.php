<!doctype html>
<html>
    <head>
        <title><?php echo ucfirst($class) ?> - Track'n Go</title>
        <link rel="stylesheet" href="<?php echo base_url() ?>public/third-party/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>public/css/style.css">

        <!--<script src="http://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js"></script>-->
        <script src="<?php echo base_url() ?>public/third-party/js/jquery.js"></script>
        <script src="<?php echo base_url() ?>public/third-party/js/bootstrap.js"></script>
        <script src="<?php echo base_url() ?>public/js/<?php echo $class ?>/result.js"></script>
        <script src="<?php echo base_url() ?>public/js/<?php echo $class ?>/event.js"></script>
        <script src="<?php echo base_url() ?>public/js/<?php echo $class ?>/template.js"></script>
        <script src="<?php echo base_url() ?>public/js/<?php echo $class ?>.js"></script>

        <script>
            $(function () {
                // Init the class name Application
                var <?php echo $class ?> = new  <?php echo ucfirst($class)?>();
            });
        </script>        

    </head>
    <body>

        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <span class="brand">Track'n Go</span>
                    <ul class="nav">
                        <li><a href="load">load</a></li>
                        <li><a href="user">User</a></li>
                        <li><a href="<?php echo site_url('dashboard/logout'); ?>">Logout</a></li>
                    </ul>
                    <span class="brand" style="float: right">Welcome, <?php echo $user?></span>
                </div>
            </div>
        </div>
        <!--Start wrapper-->
        <div class="container">

            <div id="error" class="alert alert-error hide"></div>
            <div id="success" class="alert alert-success hide"></div>