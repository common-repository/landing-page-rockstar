<?php

// Change height and width of the video code:

$newWidth = 800;
$newHeight = 450;

$embedcode = preg_replace(
   array('/width="\d+"/i', '/height="\d+"/i'),
   array(sprintf('width="%d"', $newWidth), sprintf('height="%d"', $newHeight)),
   $embedcode);
   
?>
		
		
		<div id="post-<?php the_ID(); ?>" class="lp3_1 ct_lp lpid_<?php echo $templateid; ?>">
			
			<h1><?php echo $headline; ?></h1>

			<div class="lp-content">
			
			 <div id="videobox">
          <?php echo $embedcode; ?>
			 </div>
			 
       <h2><?php echo $subhead; ?></h2>
			 
			 <?php if(isset($optin_head)) : ?><h3 style="text-align: center;"><?php echo $optin_head; ?></h3><?php endif; ?>
			 <?php if(isset($optin_subhead)) : ?><h4 style="text-align: center;"><?php echo $optin_subhead; ?></h4><?php endif; ?>
			 
			 <div id="formwrapper">
			 		
				<form id="formid_<?php echo $templateid; ?>" action="<?php echo $lprs_parser->forms[0]['action']; ?>" method="<?php echo $lprs_parser->forms[0]['method']; ?>">
				  <div id="formfields">
            <?php
              echo $lprs_parser->render_elements($optincode);
            ?>
          </div>
          <input type="submit" class="orangebtn button" id="submit_<?php echo $templateid; ?>" value="<?php echo $submit_value; ?>" />
				</form>
				
			 </div>
			 <p style="text-align: center;"><?php echo $submit_note; ?></p>

			</div>
			
		</div>