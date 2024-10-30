<?php

$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
   
?>

<style type="text/css">
  html {
    background: url('<?php echo $image[0]; ?>') center top no-repeat;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='.myBackground.jpg', sizingMethod='scale');
  -ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='myBackground.jpg', sizingMethod='scale')";
  }
</style>
		
		
		<div id="post-<?php the_ID(); ?>" class="lp1_7 ct_lp lpid_<?php echo $templateid; ?>">
			
      <?php if($logo) : ?>
       <div class="logospot">
        <img src="<?php echo $logo; ?>" alt="Logo" />
       </div>
      <?php endif; ?>
			
			<h1><?php echo $headline; ?></h1>

			<div class="lp-content">
			 
			 
			 <div id="contentwrapper">
          <?php echo $the_content; ?>
			 </div>
			 
			 
			 <div id="formwrapper">
			 
			  <h3><?php echo $optin_head; ?></h3>
				
				<form id="formid_<?php echo $templateid; ?>" action="<?php echo $lprs_parser->forms[0]['action']; ?>" method="<?php echo $lprs_parser->forms[0]['method']; ?>">
				  <div id="formfields">
            <?php
              echo $lprs_parser->render_elements($optincode);
            ?>
          </div>
          <input type="submit" class="orangebtn button" id="submit_<?php echo $templateid; ?>" value="<?php echo $submit_value; ?>" />
				</form>
				
			 </div>
			 
			 
			 <?php if(isset($lprsTestimonials)) : ?>
			 <?php // grab random testimonial
             $countTestimonials = count($lprsTestimonials) - 1;
             $randomNumber = rand(0,$countTestimonials);
             $lprsTestimonial = $lprsTestimonials[$randomNumber]; ?>
			 <div class="ct_testimonialbox">
        <p class="ct_quote"><?php echo $lprsTestimonial['testimonial_text']; ?><span class="testimonial_arrow"></span></p>
        <?php if(isset($lprsTestimonial['testimonial_image']) && $lprsTestimonial['testimonial_image'] != "") : ?><div class="ct_quote_photo"><img src="<?php echo $lprsTestimonial['testimonial_image']; ?>" alt="Testimonial Photo" /></div><?php endif; ?>
        <?php if(isset($lprsTestimonial['testimonial_name']) && $lprsTestimonial['testimonial_name'] != "") : ?><div class="ct_quote_name"><?php echo $lprsTestimonial['testimonial_name']; ?></div><?php endif; ?>
			 </div>
			 <?php endif; ?>

			</div>
			
		</div>
		
		<p style="text-align: center;"><?php echo $submit_note; ?></p>