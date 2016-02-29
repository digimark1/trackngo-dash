<!doctype html>
<html>
    <head>
        <title>Track'n Go</title>
        <link rel="stylesheet" href="<?php echo base_url() ?>public/third-party/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>public/css/style.css">

        <script src="<?php echo base_url() ?>public/third-party/js/jquery.js"></script>
        <script src="<?php echo base_url() ?>public/third-party/js/bootstrap.js"></script>
        <script src="<?php echo base_url() ?>public/js/dashboard/result.js"></script>
        <script src="<?php echo base_url() ?>public/js/dashboard/event.js"></script>
        <script src="<?php echo base_url() ?>public/js/dashboard/template.js"></script>
        <script src="<?php echo base_url() ?>public/js/dashboard.js"></script>
        <link rel="stylesheet" href="<?php echo base_url() ?>public/css/css/cusel.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>public/css/css/animate.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>public/css/css/chosen.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>public/css/css/jquery-ui-1.8.20.custom.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>public/css/css/jplayer.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>public/css/css/jslider.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>public/css/css/prettyPhoto.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>public/css/css/video-js.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>public/css/css/style.css">

        <script>
            $(function () {
                // Init the Dashboard Application
                var dashboard = new Dashboard();
            });
        </script>        

    </head>
    <body>

        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <span class="brand">Track'n Go</span>
                    <ul class="nav">
                        <li><a href="#">Dashboard</a></li>
                        <li><a href="user">User</a></li>
                        <li><a href="<?php echo site_url('dashboard/logout'); ?>">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!--Start wrapper-->
        <div class="container">

            <div id="error" class="alert alert-error hide"></div>
            <div id="success" class="alert alert-success hide"></div>
