<?php
$task_name = $date = $time = $notes = $project_id = $method = '';

if (isset($task)) {
    $title = $task_name = $task['title'];
    $date = $task['date'];
    $time = $task['time'];
    $notes = $task['notes'];
    $project_id = $task['project_id'];
    $action = $router->pathFor('task', ['id' => $task['task_id']]);
} else {
    $title = 'New task';
    $action = $router->pathFor('newtask');
}

include 'header.php';
?>

<h1><?php echo $title ?></h1>

<?php
if (isset($msg)) {
    foreach ($msg as $key => $item) {
        echo "<p class='$key'>$item[0]</p>";
    }
}
?>

<form class="" action="<?php echo $action ?>" method="post">
    <label for="name">Titulo:</label>
    <input type="text" name="title" value="<?php echo $task_name ?>">
    <input type="date" name="date" value="<?php echo $date ?>">
    <input type="time" name="time" value="<?php echo $time ?>">
    <textarea name="notes"><?php echo $notes ?></textarea>
    <select class="" name="project_id">
        <option value="">Select one</option>
        <?php
        foreach ($projects as $item) {
            echo "<option value='" .$item['project_id']. "'";
            if ($project_id == $item['project_id']) {
                echo ' selected';
            }
            echo ">";
            echo $item['title'];
            echo "</option>";
        }
        ?>
    </select>
    <?php if (isset($task)) {?>
        <input type="hidden" name="_METHOD" value="PUT">
        <!-- <input type="hidden" name="project_id" value="<?php //echo $project['project_id'] ?>"> -->
    <?php } ?>
    <input type="submit" name="submit" value="Save">
</form>

<?php if (isset($task)) { ?>
<form class="" action="<?php echo $action ?>" method="post">
    <input type="hidden" name="_METHOD" value="DELETE">
    <input type="submit" name="submit" value="Delete">
</form>
<?php } ?>

<?php include 'footer.php' ?>
