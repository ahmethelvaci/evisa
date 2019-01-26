<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Evisa Robot</title>
  <meta name="description" content="Evisa Robot">
  <meta name="author" content="Ahmet Helvaci">

  <!--<link rel="stylesheet" href="css/styles.css?v=1.0">-->

  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->
</head>

<body>
    <div class="">
        <?=3337-$app['session']->get('resourceRow')?>
    </div>
    <form class="" action="" method="post">
        <img src="<?=$search->getCaptchaUrl()?>" /><br>
        <input id="captcha" type="text" name="captcha" value="">
    </form>
    <script>
        document.getElementById("captcha").focus();
    </script>
</body>
</html>
