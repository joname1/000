<?php require_once'inc/info.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	 <!--[if lt IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<![endif]-->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <meta name="HandheldFriendly" content="True"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0, maximum-scale=1.0,user-scalable=no"/>
    <meta name="keywords" content="<?php echo $keyw_ords;?>">
    <meta name="description" content="<?php echo $descr_iption;?>">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="favicon.ico"> 
    <title><?php echo $title;?> - 让世界没有距离 想看什么就搜什么</title>
    <script src="//cdn.bootcss.com/jquery/1.9.1/jquery.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="//cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header" style="z-index:1000">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" >
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/"><i class="fa fa-youtube fa-2"></i> <?php echo $title; ?></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="right.php" target="_blank">免责声明</a>
                    </li>
                    <li>
                        <a href="use.php" target="_blank">用户须知</a>
                    </li>
                </ul>
        <div class="col-sm-3 col-md-3 pull-right">
        <form action="search.php" method="get" class="navbar-form" role="search">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="搜Youtube" name="q" id="srch-term">
            <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
            </div>
        </div>
        </form>
        </div>  
            </div>
          </div>
    </nav>