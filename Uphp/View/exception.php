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
    <h4>有关的错误位置：</h4>
    <table cellpadding="4">
        <tr>
            <td>错误file</td>
            <td>错误line</td>
        </tr>
        <?php foreach($trace as $v):?>
            <tr>
                <td><b><?=$v["file"]?></b></td>
                <td><b><?=$v["line"]?></b></td>
            </tr>
        <?php endforeach;?>
    </table>
<?php endif;?>
</body>
</html>