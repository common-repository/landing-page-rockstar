<?php

// Change height and width of the video code:

$newWidth = 560;
$newHeight = 315;

$embedcode = preg_replace(
   array('/width="\d+"/i', '/height="\d+"/i'),
   array(sprintf('width="%d"', $newWidth), sprintf('height="%d"', $newHeight)),
   $embedcode);

if(get_post_thumbnail_id( $post->ID )) {

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

<?php

  } // end if statement to see if there is a background img
  
?>

		<div id="post-<?php the_ID(); ?>" class="lp3_4 ct_lp lpid_<?php echo $templateid; ?>">
		
      <?php if($logo) : ?>
      <header>
       <div class="clearbox center">
        <img src="<?php echo $logo; ?>" alt="Logo" />
       </div>
      </header>
      <?php endif; ?>
			
			<div class="lp-content">
			
			<div id="ct_top_background">
			
         <div class="clearbox center">

            <h1><?php echo $headline; ?></h1>
            <h2><?php echo $subhead; ?></h2>
          
         </div>
         
         <div class="clearbox relative">
         
           <div id="contentwrapper">
              <?php echo $embedcode; ?>
           </div>
           
           <div id="formwrapper">
           
            <div id="formheader">
              <h3><?php echo $optin_head; ?></h3>
            </div>
           
            <div id="formcontent">
            
              <h4><?php echo $optin_subhead; ?></h4>
              
              <form id="formid_<?php echo $templateid; ?>" action="<?php echo $lprs_parser->forms[0]['action']; ?>" method="<?php echo $lprs_parser->forms[0]['method']; ?>">
                <div id="formfields">
                  <?php
                    echo $lprs_parser->render_elements($optincode);
                  ?>
                </div>
                <input type="submit" class="orangebtn2 button" id="submit_<?php echo $templateid; ?>" value="<?php echo $submit_value; ?>" /><br />
                <p class="privacystatement"><?php echo $submit_note; ?></p>
              </form>
              
            </div>
            
           </div>
         
         </div>
        
        </div>
        
        <?php if($lprsTestimonials) : ?>
        <?php // grab random testimonial
             $countTestimonials = count($lprsTestimonials) - 1;
             $randomNumber = rand(0,$countTestimonials);
             $lprsTestimonial = $lprsTestimonials[$randomNumber]; ?>
         
        <div id="testimonial_bar">
        
          <div class="clearbox">
          
            <div class="ct_testimonialbox">
            
              <p class="ct_quote"><?php echo $lprsTestimonial['testimonial_text']; ?><span class="testimonial_arrow"></span></p>
              
              <?php if(isset($lprsTestimonial['testimonial_image']) && $lprsTestimonial['testimonial_image'] != "") : ?>
                <div class="ct_quote_photo">
                  <img src="<?php echo $lprsTestimonial['testimonial_image']; ?>" alt="Testimonial Photo" />
                </div>
              <?php endif; ?>
              <?php if(isset($lprsTestimonial['testimonial_name']) && $lprsTestimonial['testimonial_name'] != "") : ?>
                <div class="ct_quote_name">
                  <?php echo isset($lprsTestimonial['testimonial_name']) ? $lprsTestimonial['testimonial_name'] : ""; ?>
                </div>
              <?php endif; ?>
              
             </div>
          
          </div>
        
        </div>
        
        <?php endif; ?>
         
			<?php if($lprsFeatures) : ?>
			
			<div class="clearbox">
			
        <div id="featuresbox">
        
          <?php foreach($lprsFeatures as $lprsFeature) : ?>			
          <div class="features">
            <h3><?php echo isset($lprsFeature['feature_headline']) ? $lprsFeature['feature_headline'] : ""; ?></h3>
            <p><?php echo isset($lprsFeature['feature_copy']) ? $lprsFeature['feature_copy'] : ""; ?></p>
          </div>
          <?php endforeach; ?>
        
        </div>
      
      </div>
      
      <?php endif; ?>
			 
			 <div id="footerarea">
			 
          <?php if($lprsSocialImages) : ?>
            <h4><?php echo $socialheadline; ?></h4>
            <p class="socialimg">
              <?php $i = 1; ?>
              <?php foreach($lprsSocialImages as $lprsSocialImage) : ?>
                <img src="<?php echo $lprsSocialImage['image_image']; ?>" alt="Social Image <?php echo $i; ?>" />
                <?php $i++; ?>
              <?php endforeach; ?>
            </p>
          <?php endif; ?>
          
			 </div>

			</div>
			
		</div>
		
		 <?php if ($below_content) : ?>
			<div id="belowContent">
        <?php echo $below_content; ?>
			</div>
		 <?php endif; ?>