<?php

// include the parent class

require_once(dirname(__FILE__) . '/landing-page.php');

/**
 * CLASS TO BUILD THE LANDING PAGE
 */

class lprs_build_landing_page extends lprs_landing_page {



    /**
     * BUILD THE HEADER SECTION OF THE LANDING PAGE
     */



    public function get_landing_page_header($templateid,$headercode,$customstyles,$title,$optincode,$lprs_parser) {
    
      ?>

      <!DOCTYPE html>
      <!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
      <!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
      <!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
      <!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
      <head>
      
          <?php if($headercode) echo htmlspecialchars_decode (html_entity_decode ($headercode), ENT_QUOTES); ?>
          <?php $options = get_option('plugin_options'); ?>
          <?php if($options["header_code"]) echo htmlspecialchars_decode (html_entity_decode ($options["header_code"]), ENT_QUOTES); ?>
      
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
          <title><?php echo strip_tags($title); ?></title>
          <meta name="description" content="">
          <meta name="viewport" content="width=device-width">

          <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
          
          <?php wp_head(); ?>

          <link rel="stylesheet" href="<?php echo plugins_url(); ?>/landing-page-rockstar/landertemplates/css/normalize.css">
          <link rel="stylesheet" href="<?php echo plugins_url(); ?>/landing-page-rockstar/landertemplates/css/main.css?v=<?= microtime(); ?>">
          <link rel="stylesheet" href="<?php echo plugins_url(); ?>/<?php echo substr($templateid,0,strpos($templateid,"template-")); ?>css/<?php echo substr($templateid,strpos($templateid,"template-"),-4); ?>.css?v=<?= microtime(); ?>">
          
          <?php
          
            if((!isset($optincode['lprs_stylesheets']) || $optincode['lprs_stylesheets'] !== 'on') && !empty($lprs_parser->forms[0]['stylesheets'])) {
            
              foreach($lprs_parser->forms[0]['stylesheets'] as $stylesheet) {
              
                echo $stylesheet;
              
              }
            
            }
          
          ?>
          
          <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
          
          <script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
          
          <style type="text/css">
            <?php if($customstyles) echo $customstyles; ?>
          </style>
          
      </head>
      <body>
      
      <?php
    
    }
    
    
    
    /**
     * BUILD THE FOOTER SECTION OF THE LANDING PAGE
     */
     
     
    
    public function get_landingpage_footer($footercode,$optincode,$lprs_parser) {

      ?>
      
        <?php
          
          if((!isset($optincode['lprs_scripts']) || $optincode['lprs_scripts'] !== 'on') && !empty($lprs_parser->forms[0]['scripts'])) {
          
            foreach($lprs_parser->forms[0]['scripts'] as $stylesheet) {
            
              echo $stylesheet;
            
            }
          
          }
        
        ?>

        <?php echo htmlspecialchars_decode (html_entity_decode ($footercode), ENT_QUOTES); ?>
        <?php $options = get_option('plugin_options'); ?>
        <?php if($options['include_lprs'] === true || !isset($options['include_lprs'])) : ?><div id="ct_poweredby">Powered by <a href="http://www.lprockstar.com" rel="nofollow" target="_blank">Landing Page Rockstar</a></div><?php endif; ?>
        <?php wp_footer(); ?>
        <?php if($options["footer_code"]) echo htmlspecialchars_decode (html_entity_decode ($options["footer_code"]), ENT_QUOTES); ?>
        </body>
        </html>
        
      <?php

    }
    
    

}