<?php

class lprs_init {

  function __construct() {
  
    global $post;
    
    // enqueue necessary scripts
    
    add_action( 'admin_enqueue_scripts', array($this,'add_scripts') );
    
    // create the post type etc
    
    add_action('init', array($this,'codex_init'));
    
    // clean up the post type
    
    add_action( 'admin_menu' , array($this,'admin_menu_init') );
    
    // add the options
    
    add_action( 'admin_init', array($this,'admin_init') );
    
    // update the post type language
    
    add_filter('post_updated_messages', array($this,'lander_updated_messages'));
    
    // add contextual help
    
    add_action( 'contextual_help', array($this,'add_help_text'), 10, 3 );
    
    // add template redirect
    
    add_action("template_redirect", array($this,'template_redirect'));
    
    // add option page capability
    
    add_filter( 'option_page_capability_ctheme_options', array($this,'option_page_capability') );
    
    // get the default color scheme
    
    add_action( 'wp_enqueue_scripts', array($this,'enqueue_color_scheme') );
    
    // add css for the lprs icon
    
    add_action( 'admin_head', array($this,'lprs_icons') );
    
    // change the title text of the landing page post type
    
    add_action( 'gettext', array($this,'lprs_change_title_text') );
    
    // add the copy button to the landing page post type
    
    add_action( 'admin_action_rd_duplicate_post_as_draft', array($this,'rd_duplicate_post_as_draft') );
    add_filter( 'post_row_actions', array($this,'rd_duplicate_post_link'), 10, 2 );
    
    // notice for beta version
    
    add_action( 'admin_notices', array($this,'lprs_beta_notice') );
    
    // add the landing page custom post type
    
    add_filter( 'get_pages',  array($this,'add_cpt') );
    
    // update the landing page editor
    
    add_filter( 'default_content', array($this,'lprs_editor_content'), 10, 2 );
    
    // remove template filters
    
    add_action('wp',array($this,'landingpage_remove_head_filters'));
    add_action('wp',array($this,'landingpage_remove_footer_filters'));
    
    // add admin ajax functions
    
    add_action('wp_ajax_lprs_parse_form', array($this,'parse_form'));
    
  }
  
  
  
  /**
   * REGISTER THE POST TYPE
   */
   
  public function codex_init() 
  {
  
    $labels = array(
      'name' => _x('Landing Pages', 'post type general name'),
      'singular_name' => _x('Landing Page', 'post type singular name'),
      'add_new' => _x('Add New', 'Landing Page'),
      'add_new_item' => __('Add New Landing Page'),
      'edit_item' => __('Edit Landing Page'),
      'new_item' => __('New Landing Page'),
      'all_items' => __('All Landing Pages'),
      'view_item' => __('View Landing Page'),
      'search_items' => __('Search Landing Pages'),
      'not_found' =>  __('No Landing Pages found'),
      'not_found_in_trash' => __('No Landing Pages found in Trash'), 
      'parent_item_colon' => '',
      'menu_name' => 'Landing Pages'

    );
    
    $args = array(
      'labels' => $labels,
      'public' => true,
      'publicly_queryable' => true,
      'show_ui' => true, 
      'show_in_menu' => true, 
      'query_var' => true,
      'rewrite' => array('slug'=>'lp','with_front'=>false),
      'capability_type' => 'page',
      'taxonomies' => array('category'),
      'has_archive' => true,
      'exclude_from_search' => true,
      'hierarchical' => false,
      'menu_position' => null,
      'supports' => array('title','page-attributes','thumbnail')
    ); 
    
    register_post_type('landingpage',$args);
    
    
    // Add new taxonomy, make it hierarchical (like categories)
    
    $labels = array(
      'name'              => _x( 'Groups', 'taxonomy general name' ),
      'singular_name'     => _x( 'Group', 'taxonomy singular name' ),
      'search_items'      => __( 'Search Groups' ),
      'all_items'         => __( 'All Groups' ),
      'parent_item'       => __( 'Parent Group' ),
      'parent_item_colon' => __( 'Parent Group:' ),
      'edit_item'         => __( 'Edit Group' ),
      'update_item'       => __( 'Update Group' ),
      'add_new_item'      => __( 'Add New Group' ),
      'new_item_name'     => __( 'New Group Name' ),
      'menu_name'         => __( 'Group' ),
    );

    $args = array(
      'hierarchical'      => true,
      'labels'            => $labels,
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'rewrite'           => false,
    );
    
    register_taxonomy( 'group', 'landingpage', $args );
    
  }
  
  
  
  /**
   * ADMIN MENU INIT HOOK
   */
   
  
  
  public function admin_menu_init() {
  
    // remove page fields
  
    remove_meta_box( 'commentstatusdiv' , 'landingpage' , 'normal' ); //removes comments status
    remove_meta_box( 'commentsdiv' , 'landingpage' , 'normal' ); //removes comments
    remove_meta_box( 'postexcerpt' , 'landingpage' , 'normal' );
    remove_meta_box( 'trackbacksdiv' , 'landingpage' , 'normal' );
    remove_meta_box( 'authordiv' , 'landingpage' , 'normal' );
    remove_meta_box( 'postcustom' , 'landingpage' , 'normal' );
    remove_meta_box( 'revisionsdiv'	, 'landingpage' , 'normal' );
    remove_meta_box( 'tagsdiv-post_tag', 'landingpage', 'normal' );
    
    // add submenu page
    
    add_submenu_page('edit.php?post_type=landingpage', 'Landing Page Options', 'Landing Page Options', 'edit_posts', basename(__FILE__), array($this,'build_lprs_options'));
    
  }
  
  
  
  /**
   * BUILD THE LPRS OPTIONS
   */
   
  
  
  public function build_lprs_options() { 
  
      ?>

      <div class="wrap">
      
          <style type="text/css">
          
            textarea {width: 500px; height: 200px;}
            #ct_options_form {max-width: 800px;}
          
          </style>

          <h3>Landing Page Rockstar Options</h3>     
          <p>Thank you for using Landing Page Rockstar. Below are the universal settings for the plugin.</p>

          <form id="ct_options_form" method="post" action="options.php" enctype="multipart/form-data">

              <?php settings_fields('plugin_options'); ?>
              <?php do_settings_sections(__FILE__); ?>
              <p class="submit">
                  <input type="submit" class="button-primary" value="Save Changes" />
              </p>

          </form>

      </div>

      <?php 
      
  }
  
  
  /**
   * UPDATE THE LANDING PAGE POST TYPE LANGUAGE
   */
   
   
  function lander_updated_messages( $messages ) {
    global $post, $post_ID;

    $messages['landingpage'] = array(
      0 => '', // Unused. Messages start at index 1.
      1 => sprintf( __('Landing Page updated. <a href="%s">View landing page</a>'), esc_url( get_permalink($post_ID) ) ),
      2 => __('Custom field updated.'),
      3 => __('Custom field deleted.'),
      4 => __('Landing Page updated.'),
      /* translators: %s: date and time of the revision */
      5 => isset($_GET['revision']) ? sprintf( __('Landing page restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
      6 => sprintf( __('Landing Page published. <a href="%s">View Landing Page</a>'), esc_url( get_permalink($post_ID) ) ),
      7 => __('Landing Page saved.'),
      8 => sprintf( __('Landing Page submitted. <a target="_blank" href="%s">Preview Landing Page</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
      9 => sprintf( __('Landing Page scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Landing Page</a>'),
        // translators: Publish box date format, see http://php.net/date
        date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
      10 => sprintf( __('Landing Page draft updated. <a target="_blank" href="%s">Preview Landing Page</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    );

    return $messages;
  }
  
  
  
  /**
   * ADD CONTEXTUAL HELP
   */
   
  
  function add_help_text($contextual_help, $screen_id, $screen) { 
    //$contextual_help .= var_dump($screen); // use this to help determine $screen->id
    if ('landingpage' == $screen->id ) {
      $contextual_help =
        '<p>' . __('Things to remember when adding or editing a Landing Page:') . '</p>' .
        '<ul>' .
        '<li>' . __('Specify a category and a group if you intend on split testing the campaign.') . '</li>' .
        '<li>' . __('Make sure to preview your landing pages before publishing') . '</li>' .
        '</ul>' .
        '<p>' . __('If you want to schedule the Landing Page review to be published in the future:') . '</p>' .
        '<ul>' .
        '<li>' . __('Under the Publish module, click on the Edit link next to Publish.') . '</li>' .
        '<li>' . __('Change the date to the date to actual publish this article, then click on Ok.') . '</li>' .
        '</ul>' .
        '<p><strong>' . __('For more information:') . '</strong></p>' .
        '<p>' . __('<a href="http://codex.wordpress.org/Posts_Edit_SubPanel" target="_blank">Edit Posts Documentation</a>') . '</p>' .
        '<p>' . __('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>') . '</p>' ;
    } elseif ( 'edit-landingpage' == $screen->id ) {
      $contextual_help = 
        '<p>' . __('This is the help screen displaying the table of landing pages blah blah blah.') . '</p>' ;
    }
    return $contextual_help;
  }
  
  
  
  /**
   * ADD TEMPLATE REDIRECT
   */
   
  private function do_theme_redirect($url) {
      global $post, $wp_query;
      if (have_posts()) {
          include($url);
          die();
      } else {
          $wp_query->is_404 = true;
      }
  }
   
  
  function template_redirect() {
      global $wp;
      $plugindir = dirname(dirname( __FILE__ ));

      //A Specific Custom Post Type
      if ($wp->query_vars["post_type"] == 'landingpage') {
          $templatefilename = 'single-landingpage.php';
          if (file_exists(TEMPLATEPATH . '/' . $templatefilename)) {
              $return_template = TEMPLATEPATH . '/' . $templatefilename;
          } else {
              $return_template = $plugindir . '/' . $templatefilename;
          }
          $this->do_theme_redirect($return_template);
      }
          
  }
  
  
  /**
   * ENQUEUE ADMIN SCRIPTS
   */
  
  
  public function add_scripts($hook) {
  
    if(is_admin()) {
    
      // add scripts
  
      wp_enqueue_script('jquery-ui-tabs');
      wp_enqueue_script( 'jquery-ui-core' );
      wp_enqueue_script( 'media-upload' );
      wp_enqueue_script( 'thickbox' );
      
      wp_register_script( 'lprs_admin', LPRS_DIR . '/includes/admin_js.js', array(), '0.5',true);
      wp_enqueue_script( 'lprs_admin' );
      
      // add styles
      
      wp_enqueue_style( 'thickbox' );
      wp_enqueue_style( 'jquery-custom-ui' );
      
      wp_register_style( 'cmb-custom-styles', LPRS_DIR . '/metabox/custom_styles.css', array(), '0.5');
      wp_enqueue_style( 'cmb-custom-styles' );
      
    }
    
  }
  
  
  /**
   * ADD OPTIONS
   */
  
  
  public function admin_init() {

    // If we have no options in the database, let's add them now.
    if ( false === $this->get_theme_options() )
      add_option( 'ctheme_theme_options', array($this,'ctheme_get_default_theme_options') );

    register_setting(
      'ctheme_options',               // Options group, see settings_fields() call in theme_options_render_page()
      'ctheme_theme_options',         // Database option, see ctheme_get_theme_options()
      'ctheme_theme_options_validate' // The sanitization callback, see ctheme_theme_options_validate()
    );
    
    // register settings and build the fields
    
    register_setting('plugin_options', 'plugin_options', array($this,'validate_setting'));
    add_settings_section('main_section', '', null, __FILE__);
    add_settings_field('include_lprs', 'Include Landing Page Rockstar Link:', array($this,'include_lprs'), __FILE__, 'main_section');
    add_settings_field('privacy_statement', 'Privacy Statement:', array($this,'privacy_statement'), __FILE__, 'main_section');
    add_settings_field('header_code', 'Header Code:', array($this,'header_code'), __FILE__, 'main_section');
    add_settings_field('footer_code', 'Footer Code:', array($this,'footer_code'), __FILE__, 'main_section');
    
    // flush the rewrite rules if necessary
    
    if( is_admin() && get_option( 'lprs_activation' ) == 'activated' ) {
        delete_option( 'lprs_activation' );
        flush_rewrite_rules();
    }
    
  }
  
  
  
  /**
   * OPTIONS FIELDS TEMPLATE FUNCTIONS
   */
   
  
  public function include_lprs() {  
      $options = get_option('plugin_options');  
      if($options['include_lprs'] === true || !isset($options['include_lprs'])) {
        echo "<input name='plugin_options[include_lprs]' type='hidden' value='0' />";
        echo "<input name='plugin_options[include_lprs]' type='checkbox' checked='checked' />";
      } else {
        echo "<input name='plugin_options[include_lprs]' type='hidden' value='0' />";
        echo "<input name='plugin_options[include_lprs]' type='checkbox' />";
      }
  }

  public function privacy_statement() {  
      $options = get_option('plugin_options');
      $thisoption = htmlspecialchars($options['privacy_statement'], ENT_QUOTES);
      echo "<input name='plugin_options[privacy_statement]' type='text' value='{$thisoption}' />";
  }

  public function header_code() {  
      $options = get_option('plugin_options');
      $thisoption = htmlspecialchars($options['header_code'], ENT_QUOTES);
      echo "<p><em>Any extra code you want to appear in the <head> section of every landing page (This is a good place to put your analytics code).</em></p>";
      echo "<textarea name='plugin_options[header_code]'>{$thisoption}</textarea>";
  }

  public function footer_code() {  
      $options = get_option('plugin_options');
      $thisoption = htmlspecialchars($options['footer_code'], ENT_QUOTES);
      echo "<p><em>Any extra code you want to appear below all of the content on every landing page (This is a good place to put any tracking pixels).</em></p>";
      echo "<textarea name='plugin_options[footer_code]'>{$thisoption}</textarea>";
  }
  
  public function validate_setting($plugin_options) {  
    $keys = array_keys($_FILES); 
    $i = 0; 
    foreach ( $_FILES as $image ) {   
      // if a files was upload   
      if ($image['size']) {     
        // if it is an image     
        if ( preg_match('/(jpg|jpeg|png|gif)$/', $image['type']) ) {       
            $override = array('test_form' => false);       
            // save the file, and store an array, containing its location in $file       
            $file = wp_handle_upload( $image, $override );       
            $plugin_options[$keys[$i]] = $file['url'];
        } else {       
            // Not an image.        
            $options = get_option('plugin_options');       
            $plugin_options[$keys[$i]] = $options[$logo];       
            // Die and let the user know that they made a mistake.       
            wp_die('No image was uploaded.');
        }
      } else {
        // Else, the user didn't upload a file.   
        // Retain the image that's already on file.   
        $options = get_option('plugin_options');     
        $plugin_options[$keys[$i]] = $options[$keys[$i]];   
      }   
      $i++; 
    } 
    return $plugin_options;
  }
  
  public function logo_setting() {  echo '<input type="file" name="logo" />';}
  
  
  /**
   * OPTION PAGE CAPABILITY
   */
  
  
  public function option_page_capability( $capability ) {
    return 'edit_theme_options';
  }
  
  
  
  public function color_schemes() {
    $color_scheme_options = array(
      'light' => array(
        'value' => 'light',
        'label' => __( 'Light', 'ctheme' ),
        'thumbnail' => get_template_directory_uri() . '/inc/images/light.png',
        'default_link_color' => '#1b8be0',
      ),
      'dark' => array(
        'value' => 'dark',
        'label' => __( 'Dark', 'ctheme' ),
        'thumbnail' => get_template_directory_uri() . '/inc/images/dark.png',
        'default_link_color' => '#e4741f',
      ),
    );
    return apply_filters( 'ctheme_color_schemes', $color_scheme_options );
  }


  public function layouts() {
    $layout_options = array(
      'content-sidebar' => array(
        'value' => 'content-sidebar',
        'label' => __( 'Content on left', 'ctheme' ),
        'thumbnail' => get_template_directory_uri() . '/inc/images/content-sidebar.png',
      ),
      'sidebar-content' => array(
        'value' => 'sidebar-content',
        'label' => __( 'Content on right', 'ctheme' ),
        'thumbnail' => get_template_directory_uri() . '/inc/images/sidebar-content.png',
      ),
      'content' => array(
        'value' => 'content',
        'label' => __( 'One-column, no sidebar', 'ctheme' ),
        'thumbnail' => get_template_directory_uri() . '/inc/images/content.png',
      ),
    );

    return apply_filters( 'ctheme_layouts', $layout_options );
  }
    
    
  public function get_default_link_color( $color_scheme = null ) {
    if ( null === $color_scheme ) {
      $options = $this->get_theme_options();
      $color_scheme = $options['color_scheme'];
    }

    $color_schemes = $this->color_schemes();
    if ( ! isset( $color_schemes[ $color_scheme ] ) )
      return false;

    return $color_schemes[ $color_scheme ]['default_link_color'];
  }
  
  
  /**
   * GET THE THEME OPTIONS 
   */
  
  
  public function get_theme_options() {
    return get_option( 'ctheme_theme_options', array($this,'get_default_theme_options') );
  }
  
  
  
  /**
   * Returns the default options for LP Rockstar
   *
   */
   
   
  public function get_default_theme_options() {
    $default_theme_options = array(
      'color_scheme' => 'light',
      'link_color'   => $this->get_default_link_color( 'light' ),
      'theme_layout' => 'content-sidebar',
    );

    if ( is_rtl() )
      $default_theme_options['theme_layout'] = 'sidebar-content';

    return apply_filters( 'ctheme_default_theme_options', $default_theme_options );
  }
  
  
  
  /**
   * ENQUEUE THE COLOR SCHEME
   */
  
  
  public function enqueue_color_scheme() {
    $options = $this->get_theme_options();
    $color_scheme = $options['color_scheme'];

    if ( 'dark' == $color_scheme )
      wp_enqueue_style( 'dark', get_template_directory_uri() . '/colors/dark.css', array(), null );

    do_action( 'ctheme_enqueue_color_scheme', $color_scheme );
  }
  
  
  
  /**
   * RECORD WHEN ACTIVATED
   */
   
  
  public function lprs_activated() {
  
    add_option( 'lprs_activation', 'activated' );
  
  }
  
  
  
  
  /**
   * FLUSH THE PERMALINKS
   */
   
  
  public function lprs_flush() {
  
    global $wp_rewrite;
  
    flush_rewrite_rules();
    $wp_rewrite->flush_rules();
  
  }
  
  
  
  /**
   * SETUP THE LPRS MENU ICON CSS
   */
   
  
  
  public function lprs_icons() {
  
    ?>
    <style type="text/css" media="screen">
      #menu-posts-landingpage .wp-menu-image {background: url(<?php echo plugins_url(); ?>/landing-page-rockstar/lprs-icon.png) no-repeat 0px 0px !important;}
          #menu-posts-landingpage .wp-menu-image:before {content: normal!important;}
    </style>
    <?php 
    
  }
  
  
  /**
   * CHANGE THE TITLE TEXT OF THE LANDING PAGE POST TYPE
   */
  
  
  public function lprs_change_title_text( $translation ) {
    global $post;
    if( isset( $post ) ) {
      switch( $post->post_type ){
        case 'landingpage' :
          if( $translation == 'Enter title here' ) return 'Enter Landing Page Name Here';
        break;
      }
    }
    return $translation;
  }
  
  
  /**
   * Function creates post duplicate as a draft and redirects then to the edit post screen
   */
  
  
  public function rd_duplicate_post_as_draft(){
    global $wpdb;
    if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
      wp_die('No post to duplicate has been supplied!');
    }
   
    /*
     * get the original post id
     */
    $post_id = (isset($_GET['post']) ? $_GET['post'] : $_POST['post']);
    /*
     * and all the original post data then
     */
    $post = get_post( $post_id );
   
    /*
     * if you don't want current user to be the new post author,
     * then change next couple of lines to this: $new_post_author = $post->post_author;
     */
    $current_user = wp_get_current_user();
    $new_post_author = $current_user->ID;
   
    /*
     * if post data exists, create the post duplicate
     */
    if (isset( $post ) && $post != null) {
   
      /*
       * new post data array
       */
      $args = array(
        'comment_status' => $post->comment_status,
        'ping_status'    => $post->ping_status,
        'post_author'    => $new_post_author,
        'post_content'   => $post->post_content,
        'post_excerpt'   => $post->post_excerpt,
        'post_name'      => $post->post_name,
        'post_parent'    => $post->post_parent,
        'post_password'  => $post->post_password,
        'post_status'    => 'draft',
        'post_title'     => $post->post_title,
        'post_type'      => $post->post_type,
        'to_ping'        => $post->to_ping,
        'menu_order'     => $post->menu_order
      );
   
      /*
       * insert the post by wp_insert_post() function
       */
      $new_post_id = wp_insert_post( $args );
   
      /*
       * get all current post terms ad set them to the new post draft
       */
      $taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
      foreach ($taxonomies as $taxonomy) {
        $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
        wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
      }
   
      /*
       * duplicate all post meta
       */
      $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
      if (count($post_meta_infos)!=0) {
        $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
        foreach ($post_meta_infos as $meta_info) {
          $meta_key = $meta_info->meta_key;
          $meta_value = addslashes($meta_info->meta_value);
          $sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
        }
        $sql_query.= implode(" UNION ALL ", $sql_query_sel);
        $wpdb->query($sql_query);
      }
   
   
      /*
       * finally, redirect to the edit post screen for the new draft
       */
      wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
      exit;
    } else {
      wp_die('Post creation failed, could not find original post: ' . $post_id);
    }
  }
  
  
  
  /**
   * Add the duplicate link to action list for post_row_actions
   */
  
  
  public function rd_duplicate_post_link( $actions, $post ) {
    if($post->post_type == "landingpage") {
      if (current_user_can('edit_posts')) {
        $actions['duplicate'] = '<a href="admin.php?action=rd_duplicate_post_as_draft&amp;post=' . $post->ID . '" title="Duplicate this item" rel="permalink">Copy</a>';
      }
      return $actions;
    }
  }
  
  
  
  /**
   * ADD CUSTOM POST TYPES
   */
  
  
  
  public function add_cpt( $pages )
  {
       $cpt_pages = new WP_Query( array( 'post_type' => 'landingpage' ) );
       if ( $cpt_pages->post_count > 0 )
       {
           $pages = array_merge( $pages, $cpt_pages->posts );
       }
       return $pages;
  }
  
  
  /**
   * NOTIFY USERS OF BETA STATUS
   */
  
  
  public function lprs_beta_notice() {

    if($_GET['post_type'] == "landingpage") {
    
      $class = "error";
      $message = "Error in saving";
            echo"<div class=\"$class\">" .
                 "<p><strong>Please Note:</strong> This is a beta testing version of this plugin. Therefore there may be some bugs that you come across. Please report any bugs through my <a href='http://www.ericsestimate.com/contact-eric/'>contact form here</a>.</p>" . 
                 "<p>Your feedback will help me to improve the plugin in future releases!</p>" . 
                 "</div>"; 
                 
     }
     
  }
  
  
  
  /**
   * CHANGE THE CONTENT OF THE PRIMARY EDITOR FOR LANDING PAGE POST TYPES
   */
  
  
  public function lprs_editor_content( $content, $post ) {

      switch( $post->post_type ) {
          case 'landingpage':
              $content = '<p>This is the beginning of the main content. You should include 2 or 3 sentences to hook the reader, then use the bullet points to explain some of the benefits of your offer...</p><ul><li>Bullet List Of Features &amp; Benefits</li><li>Bullet List Of Features &amp; Benefits</li><li>Bullet List Of Features &amp; Benefits</li></ul><p>After the list, make sure you quickly mention a call to action such as "Fill out the form to get instant access!"';
          break;
      }

      return $content;
  }
  
  
  
  /**
   * REMOVE HEAD FILTERS FROM THE TEMPLATE
   */
  
  
  
  public function landingpage_remove_head_filters() {
    global $wp;
    if ($wp->query_vars["post_type"] == 'landingpage') {
        //remove_filter('wp_head','twentytwelve_header_style');
        remove_all_filters('wp_head');
    }
  }
  
  
  
  /**
   * REMOVE FOOTER FILTERS FROM THE TEMPLATE
   */
  
  
  
  public function landingpage_remove_footer_filters() {
    global $wp;
    if ($wp->query_vars["post_type"] == 'landingpage') {
        //remove_filter('wp_head','twentytwelve_header_style');
        remove_all_filters('wp_footer');
    }
  }
  
  
  
  /**
   * REMOVE PLUGIN FILTERS FROM THE TEMPLATE
   */
  
  
  
  public function landingpage_remove_plugin_filters() {
      global $wp_filter;
      global $wp;
      if ($wp->query_vars["post_type"] == 'landingpage') {
          remove_all_filters('the_content', 'plugin_filters');
          add_filter('the_content', 'do_shortcode');
      }
  }
  
  
  
  /**
   * PARSE FORM CODE
   *
   * @output html for DOM output on landing page editor page
   * @format JSON
   */
  
  
  
  public function parse_form() {
  
    $output = "";
  
    $form = new lprs_form_parser(stripslashes($_POST['content']));
      
    $output .= "<p><strong>Action:</strong> " . $form->forms[0]['action'] . "</p>";
    $output .= "<p><strong>Method:</strong> " . $form->forms[0]['method'] . "</p>";
    
    if(!empty($form->forms[0]['formElements'])) {
    
      // create a table of all form elements for removal if necessary
    
      $output .= "<table class='wp-list-table widefat fixed striped'>";
      
      $output .= "<tr><td><strong>Scripts &amp; Stylesheets:</strong></td><td width='50' style='text-align: center;'></td><td width='50' style='text-align: center;'>Remove</td></tr>";
      
      $output .= "<tr><td>Stylesheets: [" . count($form->forms[0]['stylesheets']) . "]</td><td></td><td style='text-align: center;'>";
      
      $output .= count($form->forms[0]['stylesheets']) > 0 ? "<input type='checkbox' name='_lprs_optin[lprs_stylesheets][remove]'></td></tr>" : "<em>None</em></td></tr>";
      
      $output .= "<tr><td>Scripts: [" . count($form->forms[0]['scripts']) . "]</td><td></td><td style='text-align: center;'>";
      
      $output .= count($form->forms[0]['scripts']) > 0 ? "<input type='checkbox' name='_lprs_optin[lprs_scripts][remove]'></td></tr>" : "<em>None</em></td></tr>";
      
      $output .= "<tr><td><strong>Form Fields:</strong></td><td width='50' style='text-align: center;'>Hide</td><td width='50' style='text-align: center;'>Remove</td></tr>";
    
      foreach($form->forms[0]['formElements'] as $element) {
      
        $is_hidden = "";
        
        if($element['type'] == 'hidden')
          $is_hidden = 'checked disabled';
        
      
        $output .= "<tr>";
      
        $output .= "<td>" . $element['name'] . " [type='" . $element['type'] . "']</td>";
        $output .= "<td style='text-align: center;'><input type='checkbox' name='_lprs_optin[" . urlencode($element['name']) . "][hide]' {$is_hidden}></td>";
        $output .= "<td style='text-align: center;'><input type='checkbox' name='_lprs_optin[" . urlencode($element['name']) . "][remove]'></td>";
        
        $output .= "</tr>";
      
      }
      
      $output .= "</table>";
      
    } else {
    
      // no form fields found in the code
    
      $output .= "<p class='error'>No Fields Found</p>";
    
    }
    
    
    echo json_encode(['html' => $output]);
    
    wp_die();
      
  }


}