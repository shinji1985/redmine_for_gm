<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>CodeIgniter へようこそ</title>
        <link href="<?= base_url(); ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        
    </head>
    <body>

        <div id="container">
            <h1>CodeIgniter へようこそ!</h1>

            <div id="body">
                <p>今ご覧のこのページは、CodeIgniter によって動的に生成されました。</p>

                <p>このページを編集したい場合は、次の場所にあります:</p>
                <code>application/views/welcome_message.php</code>

                <p>このページのコントローラは次の場所にあります:</p>
                <code>application/controllers/welcome.php</code>

                <p>CodeIgniter を使うのが初めてなら、<a href="user_guide_ja/">ユーザガイド</a>を読むことから始めてください。</p>
            </div>

            <p class="footer">このページは、{elapsed_time} 秒でレンダリングされました。</p>
        </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://code.jquery.com/jquery.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?= base_url(); ?>js/bootstrap.min.js"></script>
    </body>
</html>