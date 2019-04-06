<?php
function create_post_your_post(){
 register_post_type('your_post',
 array(
 'labels'=>array(
 'name'=>__('Your Post'),
 ),
 'public'=>true,
 'hierarchical'=>true,
 'has_archive'=>true,
 'supports'=>array(
 'title',
'editor',
'excerpt',
'thumbnail',
 ),
 'taxonomies'=>array(
 'post_tag',
'category',
 )
 )
);
 register_taxonomy_for_object_type('category','your_post');
 register_taxonomy_for_object_type('post_tag','your_post');
}
add_action('init','create_post_your_post');
function add_your_fields_meta_box(){
 add_meta_box(
 'your_fields_meta_box',// $id
 'Your Fields',// $title
 'show_your_fields_meta_box',// $callback
 'your_post',// $screen
 'normal',// $context
 'high'// $priority
);
}
add_action('add_meta_boxes','add_your_fields_meta_box');
function show_your_fields_meta_box(){
    global $post;
 $meta=get_post_meta($post->ID , 'your_fields' , true); ?>
<input type="hidden" name="your_meta_box_nonce" value="<?php echo wp_create_nonce(
basename(__FILE__) );?>">
<!-- All fields will go here -->
 <?php}
function save_your_fields_meta( $post_id ) {
// verify nonce
if ( !wp_verify_nonce( $_POST['your_meta_box_nonce'], basename(__FILE__) ) ) {
 return $post_id;
}
// check autosave
if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
 return $post_id;
}
// check permissions
if ( 'page' === $_POST['post_type'] ) {
 if ( !current_user_can( 'edit_page', $post_id ) ) {
 return $post_id;
 } elseif ( !current_user_can( 'edit_post', $post_id ) ) {
 return $post_id;
 }
}

$old = get_post_meta( $post_id, 'your_fields', true );
$new = $_POST['your_fields'];
if ( $new && $new !== $old ) {
 update_post_meta( $post_id, 'your_fields', $new );
} elseif ( '' === $new && $old ) {
 delete_post_meta( $post_id, 'your_fields', $old );
}
}
add_action( 'save_post', 'save_your_fields_meta' );