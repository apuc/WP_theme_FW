<html>
    <head>
        <meta charset="UTF-8">
        <?php AppAssets::getCss(); ?>
        <title><?=$title?></title>
        <?php AppAssets::getJs(); ?>
    </head>
    <body>
        <div class="wrap" flag="0">
            <?=$content?>
        </div>
    </body>
</html>
