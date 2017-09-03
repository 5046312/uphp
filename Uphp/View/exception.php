<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>异常报告</title>
</head>
<body>
<h1><?=$title?></h1>
<?php if(APP_DEV):?>
    <h4>错误file: - 行号line:</h4>
<?php endif;?>
</body>
</html>