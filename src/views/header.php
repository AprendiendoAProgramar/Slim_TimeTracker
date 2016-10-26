<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $title; ?></title>
    </head>
    <body>
        <nav>
        <ul>
            <li><a href="<?php echo $router->pathFor('home'); ?>">Home</a></li>
            <li><a href="<?php echo $router->pathFor('tasks'); ?>">Tasks</a></li>
            <li><a href="<?php echo $router->pathFor('projects'); ?>">Projects</a></li>
            <!-- <li><a href="<?php //echo $router->pathFor('reports'); ?>"></a></li> -->
        </ul>
        </nav>
