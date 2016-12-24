<?php
error_reporting(0);
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['install_step']))
    $_SESSION['install_step'] = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Job Feeder - Installer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/install/style/images/favicon.png">
    <link href="/install/style/css/bootstrap.min.css" rel="stylesheet">
    <link href="/install/style/css/style.css" rel="stylesheet">
    <script src="/install/style/js/jquery-1.9.1.min.js"></script>
    <script src="/install/style/js/bootstrap.js"></script>
</head>

<body>
<div class="hidden-xs">
    <div class="logo">
        <img style="width:100px;" src="/install/style/images/logo-sm.png">
    </div>
    <div class="sub-logo">
        Job Feeder
    </div>
</div>
<div class="visible-xs logo-sm">
    <img style="width:50px;" src="/install/style/images/logo-sm.png">
</div>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Thank you for Purchasing <a href="http://www.codecanyon.net/user/kodeinfo">KodeInfo's</a>
                        Product</strong>

                    <div class="pull-right">
                        <span class="badge badge-warning">Begin</span>
                    </div>
                </div>
                <div class="panel-body">
                    <h1>Job Feeder 1.0</h1>
                    <h4>Installation Wizard</h4>
                    <br/>

                    <p>Welcome to Installation Wizard  . For any problem during installation <a
                            href="http://www.codecanyon.net/user/kodeinfo">Contact Our Support</a>.</p>
                    <br>

                    <p>
                        <a href="/install/requirements.php?<?php echo(time()); ?>" class="btn btn-success btn-lg"
                           role="button">Install</a>
                    </p>
                </div>
                <div class="hidden-xs hidden-sm">
                    <center>All Rights Reserved <a href="http://www.kodeinfo.com">
                            kodeinfo.com</center>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>