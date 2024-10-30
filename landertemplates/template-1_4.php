<?php

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

		<div id="post-<?php the_ID(); ?>" class="lp1_4 ct_lp lpid_<?php echo $templateid; ?>">
		
      <?php if($logo) : ?>
      <header>
        <img src="<?php echo $logo; ?>" alt="Logo" />
      </header>
      <?php endif; ?>
			
			<h1><?php echo $headline; ?></h1>

			<div class="lp-content">
			
			 <div id="contentwrapper">
        
        <h2><?php echo $subhead; ?></h2>
				
				<?php echo $the_content; ?>
				
			 </div>
			 
			 <div id="formwrapper">
			 
        <div id="formheader">
          <h3><?php echo $optin_head; ?></h3>
        </div>
        <div class="arrow-down"></div>
			 
        <div id="formcontent">
        
          <h4><?php echo $optin_subhead; ?></h4>
          
          <form id="formid_<?php echo $templateid; ?>" action="<?php echo $lprs_parser->forms[0]['action']; ?>" method="<?php echo $lprs_parser->forms[0]['method']; ?>">
            <div id="formfields">
              <?php
                echo $lprs_parser->render_elements($optincode);
              ?>
            </div>
            <input type="submit" class="orangebtn" id="submit_<?php echo $templateid; ?>" value="<?php echo $submit_value; ?>" /><br />
            <p style="text-align: center;"><?php echo $submit_note; ?></p>
          </form>
          
        </div>
				
			 </div>
			 
      <?php if($lprsFeatures) : ?>
			
        <div id="featuresbox">
        
          <?php foreach($lprsFeatures as $lprsFeature) : ?>			
          <div class="features">
            <h3><?php echo isset($lprsFeature['feature_headline']) ? $lprsFeature['feature_headline'] : ""; ?></h3>
            <p><?php echo isset($lprsFeature['feature_copy']) ? $lprsFeature['feature_copy'] : ""; ?></p>
          </div>
          <?php endforeach; ?>
        
        </div>
      
      <?php endif; ?>
			 
			 <div id="footerarea">
          <?php if($lprsSocialImages) : ?>
            <h4><?php echo $socialheadline; ?></h4>
            <p class="socialimg">
              <?php $i = 1; ?>
              <?php foreach($lprsSocialImages as $lprsSocialImage) : ?>
                <img src="<?php echo isset($lprsSocialImage['image_image']) ? $lprsSocialImage['image_image'] : ""; ?>" alt="Social Image <?php echo $i; ?>" />
                <?php $i++; ?>
              <?php endforeach; ?>
            </p>
            
          <?php endif; ?>
			 </div>

			</div>
			
		</div>
		
      <div id="belowContent">
        <?php echo $below_content; ?>
			</div>