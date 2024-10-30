<?php
   
  echo'<h2>'.$meta_box['title'].'</h2>';
   
  echo'<input type="text" name="'.$meta_box['name'].'_value" value="'.$meta_box_value.'" size="55" /><br />';
   
  echo'<p><label for="'.$meta_box['name'].'_value">'.$meta_box['description'].'</label></p>';