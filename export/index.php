<?php
$data = include 'data.php';
?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.bootcss.com/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div style="margin: 3rem">
        <a class="btn btn-info" href="export.php">导出</a>
    </div>
    <table class="table">
        <tr>
            <th>ID</th>
            <th>姓名</th>
            <th>手机号</th>
        </tr>
    <?php foreach($data as $value):?>
        <tr>
            <td><?= $value['id']?></td>
            <td><?= $value['name']?></td>
            <td><?= $value['phone']?></td>
        </tr>
    <?php endforeach;?>
    </table>
</div>

</body>
</html>