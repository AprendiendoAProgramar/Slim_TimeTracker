<?php
$title = 'List Projects';

include 'header.php';
?>

<h1>Projects</h1>
<?php
if (isset($msg)) {
    foreach ($msg as $key => $item) {
        echo "<p class='$key'>$item[0]</p>";
    }
}
?>
<a href="<?php echo $router->pathFor('newproject')?>">Add Project</a>
<ul>
<?php
    foreach ($projects as $item) {
        echo "<li><a href='" .$router->pathFor('projects')."/".$item['project_id']. "'>" .$item['title']. "</a></li>";
    }
?>
</ul>

<?php include 'footer.php' ?>
