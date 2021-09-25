<?php
/**
 * @var \Moon\View $this
 * @var string $content
 */
?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $this->e($this->title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//unpkg.com/layui@2.6.8/dist/css/layui.css">
    <style>
        .copy-right{
            font-size: 1.5rem;
            text-align: center;
        }
    </style>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
<script src="//unpkg.com/layui@2.6.8/dist/layui.js"></script>

<?= $content ?>

<!--
<footer>
    <div class="copy-right">
        <span>&copy; 2021 <a href="#">https://xxxx.com</a></span>
    </div>
</footer>
-->

</body>
</html>