<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title><?= SYS_NM; ?></title>
        <link href="<?= base_url(); ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url(); ?>css/login.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>

        <div class="container">

            <?= form_open(base_url() . 'index/login', array('class' => 'form-signin', 'role' => 'form')) ?>
            <h2 class="form-signin-heading"><?= SYS_NM; ?></h2>

            <input type="text" class="form-control" placeholder="Login" name="login" value="<?= set_value('login'); ?>" required autofocus>
            <input type="password" class="form-control" placeholder="Password" name="password" value="<?= set_value('password'); ?>" required>
            <?= $result_text; ?>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
            <?= form_close() ?>

        </div> <!-- /container -->


        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://code.jquery.com/jquery.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?= base_url(); ?>js/bootstrap.min.js"></script>
    </body>
</html>