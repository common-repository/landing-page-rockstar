		<div id="post-<?php the_ID(); ?>" class="lp1_6 ct_lp lpid_<?php echo $templateid; ?>">
		
      <?php if($logo) : ?>
      <header>
        <img src="<?php echo $logo; ?>" alt="Logo" />
      </header>
      <?php endif; ?>
			
			<div id="h1container"><span class="leftbookend"></span><h1<?php if(strlen($headline) > 55) echo " Class='longheadline'"; ?>><?php echo $headline; ?></h1><span class="rightbookend"></span></div>
			<h2><?php echo $subhead; ?></h2>

			<div class="lp-content">
			
			 <div id="contentwrapper">
				
				<?php echo $the_content; ?>
				
			 </div>
			 
			 <div id="sidebar_r">
			 
         <div id="formwrapper">
         
          <h3><?php echo $optin_head; ?></h3>
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
           
          <?php if($lprsTestimonials) : ?>
           
          <div id="testimonial_area">
             <?php 
             
             $numberTestimonials = count($lprsTestimonials) - 1;
             $randomNumber = rand(0,$numberTestimonials);
             echo "<p>" . $lprsTestimonials[$randomNumber]['testimonial_text'] . "<br /><strong> - " . $lprsTestimonials[$randomNumber]['testimonial_name'] . "</strong></p>";
             if($numberTestimonials > 0) {
              while( in_array( ($randomNumber2 = rand(0,$numberTestimonials)), array($randomNumber) ) );
              echo "<p>" . $lprsTestimonials[$randomNumber2]['testimonial_text'] . "<br /><strong> - " . $lprsTestimonials[$randomNumber2]['testimonial_name'] . "</strong></p>";
             }

              ?>
          </div>
          
          <?php endif; ?>
			 
			 </div>

			</div>
			
			<?php if(isset($lprsFeatures)) : ?>
			
        <div id="featuresbox">
        
        	<?php foreach($lprsFeatures as $lprsFeature) : ?>
          
            <div class="features">
              <h3><?php echo isset($lprsFeature['feature_headline']) ? $lprsFeature['feature_headline'] : ""; ?></h3>
              <p><?php echo isset($lprsFeature['feature_copy']) ? $lprsFeature['feature_copy'] : ""; ?></p>
            </div>
          
          <?php endforeach; ?>
        
        </div>
      
      <?php endif; ?>
			
			<div id="belowContent">
        <?php echo $below_content; ?>
			</div>
			
			</div>
			
		</div>