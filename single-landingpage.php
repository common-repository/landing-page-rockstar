<?php

// Template file for displaying landing pages on ctheme
// All rights reserved
// Out From The Crowd Inc.

// Get all of the variables from your admin screen

// Don't Display PHP Errors
error_reporting(-1);
ini_set('display_errors', -1);

// load the landingpage builder class

require_once("class/build.php");
require_once("class/form-parser.php");

$lprs_lp = new lprs_build_landing_page();

// Get page options

$templatestyle = $lprs_lp->get_custom_field('_lprs_style')?$lprs_lp->get_custom_field('_lprs_style'):'1'; // grab the style of the page - default: 1
$themeoption = $lprs_lp->get_custom_field('_lprs_themeoption'); // grab the theme choice
$templateid = $themeoption;

$includeheader = $lprs_lp->get_custom_field('_lprs_inchead'); // display the header?
$includemenu = $lprs_lp->get_custom_field('_lprs_incmenu'); // display the menu?
$includefooter = $lprs_lp->get_custom_field('_lprs_incfooter'); // display the footer?
$includecss = $lprs_lp->get_custom_field('_lprs_cstyles'); // display a custom css sheet?
$includeheadercode = $lprs_lp->get_custom_field('_lprs_head_code'); // display header code?
$includefootercode = $lprs_lp->get_custom_field('_lprs_foot_code'); // display footer code?

// Get content of the page

$warning = htmlspecialchars_decode($lprs_lp->get_custom_field('_lprs_warning')); // the warning
$the_content = htmlspecialchars_decode($lprs_lp->get_custom_field('_lprs_wysiwyg')); // the main content section
$headline = htmlspecialchars_decode($lprs_lp->get_custom_field('_lprs_headline')); // the headline
$headline_color = $lprs_lp->get_custom_field('_lprs_headline_color'); // the headline
$subhead = htmlspecialchars_decode($lprs_lp->get_custom_field('_lprs_subhead')); // The sub headline
$subhead_color = $lprs_lp->get_custom_field('_lprs_subhead_color'); // The sub headline
$lprsTestimonials = $lprs_lp->get_custom_field('_lprs_testimonials'); // get alltestimonials
$below_content = htmlspecialchars_decode($lprs_lp->get_custom_field('_lprs_below_content'));

$lprsFeatures = $lprs_lp->get_custom_field('_lprs_features'); // get all features

$optin_head = $lprs_lp->get_custom_field('_lprs_optin_headline'); // the optin headline
$optin_subhead = $lprs_lp->get_custom_field('_lprs_optin_subhead'); // the optin sub headline
$optin_description = $lprs_lp->get_custom_field('_lprs_optin_description'); // the optin sub headline
$submit_note = $lprs_lp->get_custom_field('_lprs_optin_submit_note'); // the submit note
$submit_value = $lprs_lp->get_custom_field('_lprs_optin_submit'); // the value of your submit button
$incentive = $lprs_lp->get_custom_field('_lprs_incentive'); // display a time limit?
$embedcode = $lprs_lp->get_custom_field('_lprs_video'); // grab the video code
$embedcode = htmlspecialchars_decode($embedcode); // undecode from wordpress

$product_image = $lprs_lp->get_custom_field('_lprs_product_image'); // Product Image

$socialheadline = htmlspecialchars_decode($lprs_lp->get_custom_field('_lprs_socialheadline')); // the warning
$lprsSocialImages = $lprs_lp->get_custom_field('_lprs_socialimages'); // get all social images

$logo = $lprs_lp->get_custom_field('_lprs_logo');
$bgcolour = $lprs_lp->get_custom_field('_lprs_bg_colour');

$mainfont = $lprs_lp->get_custom_field('_lprs_main_font');
$headline_font = $lprs_lp->get_custom_field('_lprs_headline_font');
$subhead_font = $lprs_lp->get_custom_field('_lprs_sub_headline_font');

$widthpattern = "/width=\"[0-9]*\"/i";
$heightpattern = "/height=\"[0-9]*\"/i";

$finalembed = preg_replace($heightpattern,"height='320'",$embedcode);
$finalembed = preg_replace($widthpattern,"width='550'",$finalembed);

// GRAB ONLY THE INPUTS AND AND FORM TAGS FROM THE OPTIN FORM

$optincode = $lprs_lp->get_custom_field('_lprs_optin');
$optincode_clean = html_entity_decode($optincode['textarea']);

$lprs_parser = new lprs_form_parser($optincode_clean);

// load the header template

$lprs_lp->get_landing_page_header($templateid,$includeheadercode,$includecss,$headline,$optincode,$lprs_parser); 

?>

<a name="top"></a>

  <style type="text/css">
  
    <?php if($mainfont == "Roboto" || $headline_font == "Roboto" || $subhead_font == "Roboto") : ?>
      @import url(http://fonts.googleapis.com/css?family=Roboto:300,300italic,400,700,700italic,400italic);
    <?php endif; ?>
    
    <?php if($mainfont == "Roboto Condensed" || $headline_font == "Roboto Condensed" || $subhead_font == "Roboto Condensed") : ?>
      @import url(http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,700italic,400italic);
    <?php endif; ?>
    
    <?php if($mainfont == "Roboto Slab" || $headline_font == "Roboto Slab" || $subhead_font == "Roboto Slab") : ?>
      @import url(http://fonts.googleapis.com/css?family=Roboto+Slab:300,400,700,300italic,400italic,700italic);
    <?php endif; ?>
  
    <?php if($mainfont) : ?>
      html {font-family: "<?php echo $mainfont; ?>", sans-serif;}
    <?php endif; ?>
    
    <?php if($headline_font) : ?>
      h1 {font-family: "<?php echo $headline_font; ?>", sans-serif;}
    <?php endif; ?>
    
    <?php if($subhead_font) : ?>
      h2 {font-family: "<?php echo $subhead_font; ?>", sans-serif;}
    <?php endif; ?>
  
    <?php if($headline_color || $subhead_color) { ?>
        h1 {color: <?php echo $headline_color; ?>;}
        h2 {color: <?php echo $subhead_color; ?>;}
    <?php } ?>
  </style>

<?php if($bgcolour) { ?>
  <style type="text/css">
  
    <?php echo "html {background-color: {$bgcolour};}"; ?>
  
  </style>
<?php } ?>

<?php if($includecss) { ?>

  <style type="text/css">
  
    <?php echo $includecss; ?>
  
  </style>

<?php } ?>
  
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <?php require_once(dirname(dirname(__FILE__)) . "/" . $templateid); ?>

	<?php endwhile; endif; ?>  
	
<a name="footer"></a>

<?php $lprs_lp->get_landingpage_footer($includefootercode,$optincode,$lprs_parser); ?>