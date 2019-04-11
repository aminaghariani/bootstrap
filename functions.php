<?php
function create_post_student(){
 register_post_type('student',
 array(
 'labels'=>array(
 'name'=>__('Students'),
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
 register_taxonomy_for_object_type('category','student');
 register_taxonomy_for_object_type('post_tag','student');
}
add_action('init','create_post_student');
function add_cv_meta_box(){
 add_meta_box(
 'cv_meta_box',// $id
 'cv',// $title
 'show_cv_meta_box',// $callback
 'student',// $screen
 'normal',// $context
 'high'// $priority
);
}
add_action('add_meta_boxes','add_cv_meta_box');
function show_cv_meta_box(){
global $post;
 $meta=get_post_meta($post->ID , 'cv' , true); ?>
<input type="hidden" name="your_meta_box_nonce" value="
 <?php echo wp_create_nonce(basename(__FILE__) );?>">
<!-- All fields will go here -->
 <?php
}
function save_cv_meta( $post_id ) {
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

$old = get_post_meta( $post_id, 'cv', true );
$new = $_POST['cv'];
if ( $new && $new !== $old ) {
 update_post_meta( $post_id, 'cv', $new );
} elseif ( '' === $new && $old ) {
 delete_post_meta( $post_id, 'cv', $old );
}
}
add_action( 'save_post', 'save_cv_meta' );

