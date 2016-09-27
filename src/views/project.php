<?php
$project_name = $cat_id = $method = '';

if (isset($project)) {
    $title = $project_name = $project['title'];
    $cat_id = $project['category_id'];
    $action = $router->pathFor('project', ['id' => $project['project_id']]);
} else {
    $title = 'New project';
    $action = $router->pathFor('newproject');
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
    <input type="text" name="title" value="<?php echo $project_name ?>">
    <select class="" name="category_id">
        <option value="">Select one</option>
        <?php
        foreach ($categories as $item) {
            echo "<option value='" .$item['category_id']. "'";
            if ($cat_id == $item['category_id']) {
                echo ' selected';
            }
            echo ">";
            echo $item['title'];
            echo "</option>";
        }
        ?>
    </select>
    <?php if (isset($project)) {?>
        <input type="hidden" name="_METHOD" value="PUT">
        <!-- <input type="hidden" name="project_id" value="<?php //echo $project['project_id'] ?>"> -->
    <?php } ?>
    <input type="submit" name="submit" value="Save">
</form>

<?php if (isset($project)) { ?>
<form class="" action="<?php echo $action ?>" method="post">
    <input type="hidden" name="_METHOD" value="DELETE">
    <input type="submit" name="submit" value="Delete">
</form>
<?php } ?>

<?php include 'footer.php' ?>
