<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title; ?>｜<?= SYS_NM; ?></title>
        <meta name="description" content="REDMINE VIEWER">
        <meta name="author" content="Shinji Yamaguchi">
        <link href="<?= base_url(); ?>css/bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url(); ?>css/dashboard.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url(); ?>css/jquery.handsontable.full.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url(); ?>css/ui-bootstrap/jquery-ui.custom.css" rel="stylesheet" type="text/css" />
        <!-- for gantt -->
        <link href="<?= base_url(); ?>css/gantt/css/style.css" rel="stylesheet" type="text/css" />

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?= base_url(); ?>js/bootstrap.min.js"></script>
        <script src="<?= base_url(); ?>js/docs.min.js"></script>
        <script src="<?= base_url(); ?>js/jquery.handsontable.full.js"></script>
        <script src="<?= base_url(); ?>js/jquery-ui/js/jquery-ui.custom.min.js"></script>
        <!-- for gantt -->
	<script src="<?= base_url(); ?>js/gantt/jquery.fn.gantt.js"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript">
            <!--
            $('.dropdown-toggle').dropdown()
            // -->
        </script>
        <style type="text/css">  
            <!-- 
            .scrollable-menu {
                height: auto;
                max-height: 500px;
                overflow-x: hidden;
            }
            -->  
        </style>  

    </head>
    <body>

        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= base_url(); ?>"><?=SYS_NM;?></a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?= base_url(); ?>">Dashboard</a></li>
                        <li><a href="<?= base_url(); ?>resources">Resources</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Projects <b class="caret"></b></a>
                            <ul class="dropdown-menu scrollable-menu">
                                <?php foreach ($dropdown_projects as $row): ?>
                                    <li><a href="<?= base_url(); ?>projects/<?= $row['identifier']; ?>"><?= $row['name']; ?></a></li>
                                <?php endforeach; ?>
                                <li class="divider"></li>
                                <li class="dropdown-header">Nav header</li>
                                <li><a href="#">Separated link</a></li>
                                <li><a href="#">One more separated link</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container">