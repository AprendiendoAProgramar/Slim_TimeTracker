<?php
$title = 'List Tasks';

include 'header.php';
?>

<h1>Tasks</h1>
<?php
if (isset($msg)) {
    foreach ($msg as $key => $item) {
        echo "<p class='$key'>$item[0]</p>";
    }
}
?>
<a href="<?php echo $router->pathFor('newtask')?>">Add Task</a>
<ul>
<?php
    foreach ($tasks as $item) {
        echo "<li><a href='" .$router->pathFor('tasks')."/".$item['task_id']. "'>" .$item['title']. "</a></li>";
    }
?>
</ul>

<?php include 'footer.php' ?>
