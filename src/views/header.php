<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $title; ?></title>
    </head>
    <body>
        <nav>
        <ul>
            <li><a href="<?php echo $router->pathFor('projects'); ?>">Projects</a></li>
            <!-- <li><a href="<?php //$router->pathFor('tasks'); ?>"></a></li> -->
            <!-- <li><a href="<?php //$router->pathFor('reports'); ?>"></a></li> -->
        </ul>
        </nav>
