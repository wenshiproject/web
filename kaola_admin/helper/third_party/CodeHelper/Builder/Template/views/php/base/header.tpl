<!DOCTYPE html>
<html lang="en">
<head>
<title>{{ project_name }}</title>
<meta charset="utf-8">
<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="<?php echo site_url('assets/lib/bootstrap/css/bootstrap.css');?>">
<link rel="stylesheet" href="<?php echo site_url('assets/stylesheets_schoolpainting/theme.css');?>">
<link rel="stylesheet" href="<?php echo site_url('assets/lib/font-awesome/css/font-awesome.css');?>">
<link rel="stylesheet" href="<?php echo site_url('assets/css/other.css');?>">
<script src="<?php echo site_url('assets/lib/jquery/jquery-1.8.1.min.js');?>"></script>
<script src="<?php echo site_url('assets/lib/bootstrap/js/bootstrap.min.js');?>"></script>
<script src="<?php echo site_url('assets/lib/bootstrap/js/bootbox.min.js');?>"></script>
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>

<!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
<!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
<!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
<!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<body class=""><!--<![endif]-->
<div class="navbar">
    <div class="navbar-inner">
        <a class="brand" href="<?php echo site_url('');?>"><span class="second">{{ project_name }}</span></a>
        <ul class="nav pull-right">
            <li id="fat-menu" class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i> <?php echo $sys_user['nickname'];?></a>
            </li>
            <li id="fat-menu"><a href="<?php echo site_url('login/logout');?>"><i class="icon-off"></i></a></li>
        </ul>
    </div>
</div>

<?php $this->load->view('base/sidebar');?>