<?php

// Template Name: KichuEkta



global $wpdb;

$prefix = $wpdb->prefix;

$tablename = $prefix . 'users';

$userposts = $prefix . 'posts';

echo "<pre>";
$posts = ($wpdb->get_results("SELECT * FROM $userposts WHERE post_type = 'post' AND post_status = 'publish' ", OBJECT_K));

foreach($posts as $post){
    echo $post->post_title . "<br />";
} ?>



<?php 
    if(current_user_can('activate_plugins')) : ?>

    <form action="" method="POST">
        <input type="text" name="naam" placeholder="Name">
        <input type="submit" name="submit" value="Submit">
    </form>

<?php endif; ?>

<br>
<hr>

<?php 
    global $wpdb;

    $nametable = $wpdb->prefix . 'jakir';

    $infos = $wpdb->get_results("SELECT * FROM $nametable");

    foreach($infos as $info){
        $id = $info->id;
        $editlink = '?edit='.$id;
        $deletelink = '?delete='.$id;
        echo $id.' '. $info->name . ' <a href="'.$editlink.'">Edit</a>'. ' <a href="'.$deletelink.'">Delete</a>'.'<br />';
    }

?>

<hr>

<?php if(isset($_GET['edit'])) : ?>
<?php
    $id = $_GET['edit'];
    $value = $wpdb->get_var("SELECT name FROM $nametable WHERE id = $id");
?>
<form action="" method="POST">
    <input type="text" name="naam" placeholder="Name" value="<?php echo $value; ?>">
    <input type="submit" name="submit" value="Submit">
</form>
<?php endif; ?>


<?php

    $deleteid = isset($_GET['delete']) ? $_GET['delete'] : '';

    if(!empty($deleteid)){
        $wpdb->delete($nametable, array(
            'id'    => $deleteid
        ));

        global $post;
        $id = $post->ID;
        wp_redirect(get_page_link($id));
    }


?>