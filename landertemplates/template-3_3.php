<?php

// Change height and width of the video code:

$newWidth = 560;
$newHeight = 315;

$embedcode = preg_replace(
   array('/width="\d+"/i', '/height="\d+"/i'),
   array(sprintf('width="%d"', $newWidth), sprintf('height="%d"', $newHeight)),
   $embedcode);
  
?>

		<div id="post-<?php the_ID(); ?>" class="lp3_3 ct_lp lpid_<?php echo $templateid; ?>">
		
      <?php if($logo) : ?>
      <header>
       <div class="clearbox">
        <img src="<?php echo $logo; ?>" alt="Logo" />
       </div>
      </header>
      <?php endif; ?>
			
			<div class="lp-content">
			
        <div class="colourbar">
          
          <div class="clearbox">
			
           <div class="contentwrapper">

              <?php if($headline) : ?><h1><?php echo $headline; ?></h1><?php endif; ?>
              <?php if($subhead) : ?><h2><?php echo $subhead; ?></h2><?php endif; ?>
              
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
         
			<?php if($lprsFeatures) : ?>
			
        <div id="featuresbox" class="clearbox">
        
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
		
		 <?php if ($below_content) : ?>
			<div id="belowContent">
        <?php echo $below_content; ?>
			</div>
		 <?php endif; ?>