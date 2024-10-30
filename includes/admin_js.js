jQuery(document).ready(function() {


  // Update the webform meta box when the render type is changed
  

  jQuery("#lprs_render_type").on('change',function() {
  
    if(jQuery(this).find('option:selected').val() == 'exact') {
    
      jQuery('.embed_form_elements').fadeOut();
    
    } else {
    
      jQuery('.embed_form_elements').fadeIn();
    
    }
  
  });
  
  
  // tab functionality
  

  jQuery('#lprs_tabs').tabs({
    activate: function(event, ui) {
    
       window.location.hash='tab_' + jQuery("#lprs_tabs").tabs('option','active'); 
       
    }
  });
  
  if(window.location.hash && window.location.hash.substr(0,5) == '#tab_') {
  
    jQuery("#lprs_tabs").tabs('option','active', window.location.hash.substr(5));
  
  }
  
  
  // get the fields from the form parser
  
  
  jQuery('#_lprs_optin').on('change',function() {
  
    jQuery('.embed_form_elements').html('<div style="text-align: center; padding: 40px;"><img src="/wp-includes/js/tinymce/skins/lightgray/img/loader.gif" alt="Loading..."></div>');
  
    var content = jQuery(this).val();
    var data = {
      'action': 'lprs_parse_form',
      'content': content
    };
    
    jQuery.post(ajaxurl,data,function(response) {
    
      response = JSON.parse(response);
    
      jQuery(".embed_form_elements").html(response.html);
    
    });
  
  });
  
  
  // hide or show the various landing page features
  
  
  function hideHeadlines(selection) {
  
    var selectionId = selection.substring(selection.indexOf("template-") + 9, selection.indexOf(".php"));
    jQuery(".showfor").removeClass('showfor_active'); // reset all showfor divs
    jQuery(".hidefor").removeClass('hidefor_active'); // reset all hidefor divs
    jQuery(".hidefor." + selectionId).addClass('hidefor_active');
    jQuery(".showfor." + selectionId).addClass('showfor_active');
    //jQuery('.toggleLink').next().hide();
  
  }

  jQuery(".themethumbnail").click(function() {
    jQuery(".themethumbnail").removeClass('active');
    jQuery(this).addClass('active');
    
    var picked = jQuery(this).attr('id');
    jQuery("#"+inputName).val(picked);
    hideHeadlines(picked);
  });
  jQuery(".theme_thumb_preview").click(function() {
    var preview_image = jQuery(this).attr("rel");
    
    jQuery("#ct_theme_preview .ct_preview_img").html("<img src='"+pluginsURL+"/lprockstar/landertemplates/images/preview/"+preview_image+".jpg' />");
    jQuery("#ct_theme_preview").show();
    
  });
  jQuery("#ct_theme_preview").click(function() {
    jQuery("#ct_theme_preview").hide();
  });
  jQuery("#theme_choice_select").change(function() {
    var id = jQuery(this).val();
    jQuery(".theme_series").hide();
    jQuery("#buynow").hide();
    if(jQuery("#"+id).length) {
      jQuery("#"+id).show();
    } else {
      jQuery("#buynow").show();
    }
  });
  jQuery("option[value='series_"+pickedThemeExt+"']").prop('selected',true);
  hideHeadlines(pickedTheme);
  
  jQuery(".lprs_theme_filter_choice").on('click',function() {
  
    var thisFilter = jQuery(this).attr('id');
    thisFilter = thisFilter.substring(18);
    
    jQuery(".lprs_theme_filter_choice").removeClass("lprs_theme_filter_active");
    jQuery(this).addClass("lprs_theme_filter_active");
    
    if(thisFilter != 0) {
      jQuery(".theme_thumb_box").hide();
      jQuery(".category-"+thisFilter).show();
    } else {
      jQuery(".theme_thumb_box").show();
    }
  
  });
  
});