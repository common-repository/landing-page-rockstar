<?php

class lprs_landing_page {

  
  /**
   * GET A CUSTOM FIELD FROM WORDPRESS
   */
   

  public function get_custom_field($field) {
  
    global $post;
    $value = get_post_meta($post->ID, $field, true);
    if ($value) {
      if (is_array($value)) return $value;
      else return esc_attr( $value );
    } else {
      return false;
    }
    
  }

}