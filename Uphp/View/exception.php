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
<?php

?>
<h1><?=$error['title']?></h1>
<?php if(config("app.debug")):?>
    <h3><?=$error['file']?> : <?=$error['line']?></h3>
    <h4>trace错误追踪：</h4>
    <table cellpadding="4">
        <tr>
            <td>错误file</td>
            <td>错误line</td>
        </tr>
        <?php foreach($error['trace'] as $v):?>
            <tr>
                <td><b><?=$v?></b></td>
            </tr>
        <?php endforeach;?>
    </table>
    <div>
        <?=$error['trace']?>
    </div>
<?php endif;?>
</body>
</html>