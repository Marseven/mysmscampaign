<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?=$titre?></title>
        <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
        <style>
            th{
                border: 1px solid black;
            }

            td{
                border: 1px dashed black;
            }
        </style>
    </head>
    <body style="font-family: 'Raleway', sans-serif;">
        <?= $this->fetch('content') ?>
    </body>
</html>
