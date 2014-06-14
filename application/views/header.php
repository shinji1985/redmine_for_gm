<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title; ?>｜<?= SYS_NM; ?></title>
        <meta name="description" content="REDMINE VIEWER">
        <meta name="author" content="Shinji Yamaguchi">

        <!-- original -->
        <link href="<?= base_url(); ?>css/all.css" rel="stylesheet" type="text/css" />
        <?php if (isset($flexible)): ?>
            <script type="text/javascript">
                <!--
                var imgpathurl = "global";
                -->
            </script> 
            <link rel="stylesheet" href="<?= base_url(); ?>css/flexiblegantt/bootstrap.css" type="text/css">
            <link href="<?= base_url(); ?>css/dashboard.css" rel="stylesheet" type="text/css" />
            <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">


            <link rel="stylesheet" href="<?= base_url(); ?>css/flexiblegantt/platform.css" type="text/css">
            <link rel="stylesheet" href="<?= base_url(); ?>css/flexiblegantt/jquery.dateField.css" type="text/css">

            <link rel="stylesheet" href="<?= base_url(); ?>css/flexiblegantt/gantt.css" type="text/css">
            <link rel="stylesheet" href="<?= base_url(); ?>css/flexiblegantt/print.css" type="text/css" media="print">
            <link rel="stylesheet" href="<?= base_url(); ?>css/flexiblegantt/jquery.svg.css" type="text/css">

            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
            <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

            <script src="<?= base_url(); ?>js/flexiblegantt/libs/jquery.livequery.min.js"></script>
            <script src="<?= base_url(); ?>js/flexiblegantt/libs/jquery.timers.js"></script>
            <script src="<?= base_url(); ?>js/flexiblegantt/libs/platform.js"></script>
            <script src="<?= base_url(); ?>js/flexiblegantt/libs/date.js"></script>
            <script src="<?= base_url(); ?>js/flexiblegantt/libs/i18nJs.js"></script>
            <script src="<?= base_url(); ?>js/flexiblegantt/libs/dateField/jquery.dateField.js"></script>
            <script src="<?= base_url(); ?>js/flexiblegantt/libs/JST/jquery.JST.js"></script>

            <script type="text/javascript" src="<?= base_url(); ?>js/flexiblegantt/libs/jquery.svg.min.js"></script>


            <!--In case of jquery 1.8-->
            <script type="text/javascript" src="<?= base_url(); ?>js/flexiblegantt/libs/jquery.svgdom.1.8.js"></script>


            <script src="<?= base_url(); ?>js/flexiblegantt/ganttUtilities.js"></script>
            <script src="<?= base_url(); ?>js/flexiblegantt/ganttTask.js"></script>
            <script src="<?= base_url(); ?>js/flexiblegantt/ganttDrawerSVG.js"></script>
            <script src="<?= base_url(); ?>js/flexiblegantt/ganttGridEditor.js"></script>
            <script src="<?= base_url(); ?>js/flexiblegantt/ganttMaster.js"></script>

        <?php else: ?>
            <link href="<?= base_url(); ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
            <link href="<?= base_url(); ?>css/dashboard.css" rel="stylesheet" type="text/css" />
            <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">

            <!-- jquery gantt -->
            <link href="<?= base_url(); ?>css/gantt/css/style.css" rel="stylesheet" type="text/css" />

            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>


            <!-- for gantt -->
            <script src="<?= base_url(); ?>js/gantt/jquery.fn.gantt.js"></script>
            <script src="http://taitems.github.com/UX-Lab/core/js/prettify.js"></script>

            <!-- for attendance -->
            <script src="<?= base_url(); ?>js/jquery.mousewheel.js"></script>
        <?php endif; ?>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?= base_url(); ?>js/bootstrap.min.js"></script>
        <script src="<?= base_url(); ?>js/docs.min.js"></script>



        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript">
            <!--
            $(document).ready(function(){
                //header project dropdown
                $('.dropdown-toggle').dropdown();
                
                //change user group
                $('.user-group').bind('change', function() {
                    $(location).attr("href", '<?= base_url() . $this->uri->uri_string(); ?>?group_id='+$('.user-group').val());
                });
            });
            
            -->
        </script> 

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
                    <a class="navbar-brand" href="<?= base_url(); ?>"><?= SYS_NM; ?></a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?= base_url(); ?>">Dashboard</a></li>
                        <li><a href="<?= base_url(); ?>attendance<?= $group_get_query; ?>">Attendance</a></li>
                        <li><a href="<?= base_url(); ?>resources<?= $group_get_query; ?>">Resources</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Projects <b class="caret"></b></a>
                            <ul class="dropdown-menu scrollable-menu">
                                <?php foreach ($dropdown_projects as $row): ?>
                                    <li><a href="<?= base_url(); ?>projects/<?= $row['identifier']; ?>"><?= $row['name']; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Setting <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li role="presentation"><a role="menuitem" tabindex="-1" target="_blank" href="<?= REDMINE_URL; ?>admin/projects" >Projects</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" target="_blank" href="<?= REDMINE_URL; ?>users" >Users</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" target="_blank" href="<?= REDMINE_URL; ?>groups" >Groups</a></li>
                            </ul>
                        </li>
                        <li><a href="<?= base_url(); ?>index/logout">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container">

            <h1 class="page-header"><?= $title; ?><div class="rSidePosition"><?= $dropdown_groups; ?></div></h1>