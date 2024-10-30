<style type="text/css">

</style>

<script>

  $(function() {
    
    var warningLength = $(".warningContent").text().length;
    warningLength = (warningLength * 11 / 2) + 146;
    $("#warning").css("width",warningLength);
    
  
  });

</script>
		
		
		<div id="post-<?php the_ID(); ?>" class="lp1_3 ct_lp lpid_<?php echo $templateid; ?>">
		
      <div id="warning">
        <span class="warningTitle">Warning:</span>
        <span class="warningContent"><?php echo $warning; ?></span>
        <div style="clear:both;"></div>
      </div>
			
			<h1><?php echo $headline; ?></h1>
			<h2><?php echo $subhead; ?></h2>

			<div class="lp-content">
			 
			 <div id="formwrapper">
			 
			  <h3><?php echo $optin_head; ?></h3>
			  
			  <?php if($optincode['lprs_render_type'] == 'exact') { ?>
			  
        <?php echo do_shortcode($optincode['textarea']); ?>
			  
			  <?php } else { ?>
				
				<form id="formid_<?php echo $templateid; ?>" action="<?php echo $lprs_parser->forms[0]['action']; ?>" method="<?php echo $lprs_parser->forms[0]['method']; ?>">
				  <div id="formfields">
            <?php
              echo $lprs_parser->render_elements($optincode);
            ?>
          </div>
          <input type="submit" class="orangebtn button" id="submit_<?php echo $templateid; ?>" value="<?php echo $submit_value; ?>" />
				</form>
				
				<?php } ?>
				
			 </div>

			</div>
			
		</div>
		
		<?php echo ($submit_note) ? '<p style="text-align: center;">' . $submit_note . '</p>' : ''; ?>