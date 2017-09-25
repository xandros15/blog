<?php
/** @var $this \Xandros15\Blog\Renderer */
/** @var $content string */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $this->getAttribute('title') ?></title>
</head>
<body>
<main>
    <?= $content ?>
</main>
</body>
</html>