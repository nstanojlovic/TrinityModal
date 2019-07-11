<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form method="post" action="<?php echo esc_html( admin_url( 'admin-post.php' ) ); ?>">
        <h2>Modal will apear on selected posts</h2>
        <?php
        $postTypes = 0;
        $allPosts = get_posts(array('post_type'=> 0, 'post_status'=> 'publish', 'suppress_filters' => false, 'posts_per_page'=>-1));
        $allPostsCategories = get_posts(array('post_type'=> 0, 'post_status'=> 'publish', 'suppress_filters' => false, 'posts_per_page'=>-1));
        $categories = [];
        $getPosts = $this->deserializer->get_value( 'trinity-modal-data' );
        foreach ($allPostsCategories as $single) {
            $categories[] = $single->post_type;
        }
        $categories = array_unique($categories);
        echo '<div class="inputs">';
        echo '<div>Title</div>';
        echo '<input id="title" type="text" name="title" value="'.$getPosts['title'].'">';
        echo '</div>';
        echo '<div class="inputs">';
        echo '<div>Text</div>';
        echo '<textarea name="text" rows="4" cols="50">'.$getPosts['text'].'</textarea>';
        echo '</div>';
        echo '<hr>';
        foreach ( $categories as $cat ) {
            echo    '<div class="checkbox-holder">';
            echo    '<div>'.$cat.'</div>';
            echo    '<input class="checkbox" name="'.$cat.'-check" type="checkbox" value="'.$cat.'">';
            echo    '</div>';
        }
        echo "<br><br>";
        if ( $postTypes !== -1 ) {
            $post_type_object = get_post_type_object($post_type);
            echo '<select class="post-ids" name="post_ids[]" multiple>';
            foreach ($allPosts as $post) {
                if (in_array($post->ID, $getPosts['ids'])) {
                    echo '<option class="option" post-type="'.$post->post_type.'" value="', $post->ID, '" selected>', $post->post_title, '</option>';
                }else  echo '<option class="option" post-type="'.$post->post_type.'" value="', $post->ID, '">', $post->post_title, '</option>';
            }
            echo '</select>';
            wp_nonce_field( 'acme-settings-save',  array('post_ids[]','title','text'));
            submit_button();
        }else echo '<h3>No posts selected</h3>';
        ?>
    </form>
</div><!-- .wrap -->