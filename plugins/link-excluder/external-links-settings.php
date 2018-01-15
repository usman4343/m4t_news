<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE); 
session_start();
require_once(plugin_dir_path(__FILE__) . 'functions.php');    
?>

<div class="wrap">

        <h2 align="center">All External links from you Site</h2>

        <div id="WtiLikePostOptions" class="postbox">

            <div class="inside">
                <div style="background:#FCF8E3 ; margin-top:10px;padding-left: 10px">
                   <?php if(isset($_SESSION['success']))
                     { ?>
                       <div style="background:#5CB85C; color:#fff; margin-top:10px;padding-left: 10px">
                      <?php   echo "You have deleted links from ".$_SESSION['success']." posts";
                      ?>
                        </div>
                    <?php  session_destroy(); } 
                     elseif(isset($_SESSION['fail']))
                     { ?>
                      <div style="background:#FCF8E3; color:#fff; margin-top:10px;padding-left: 10px">
                       <?php echo "Unable to delete external post links"; ?>
                        </div>
                    <?php  session_destroy(); }
                     ?>
                <?php
                     if(isset($_POST['submit'])){ 

                            if(!empty($_POST['additional-data'])) {
                            // Counting number of checked checkboxes.
                            
                            $checked_count = count($_POST['additional-data']);
                            echo "You have selected following ".$checked_count." option(s) that are deleted: Done <br/>";
                            // Loop to store and display values of individual checked checkbox.
                             $ifdel = array();
                            foreach($_POST['additional-data'] as $selected) {


                                 $ifdel[] = replace_post_links($selected);
                                // header("Location: " . $_SERVER['PHP_SELF']);
                                 //exit;
                                // $br = '<br />';
                                // echo '&nbsp'.'&nbsp'.$ifdel.$br;
                                // echo "waqas".$ifdel.'<br />'."raza";
                            //echo "<p>".$selected ."</p>";
                               }
                               if($ifdel!=Null)
                                     {
                                $_SESSION['success'] = count($ifdel); 
                                }
                                else
                                { 
                                  $_SESSION['fail'] = TRUE;
                                }
                           // echo "<br/><b>Note :</b> <span>Similarily, You Can Also Perform CRUD Operations using These Selected Values.</span>";
                           $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                           
                              wp_redirect("$actual_link");
                             }
                                else{
                                echo "<b>Please Select Atleast One Option.</b>";
                                }

                            
                            

                            }

                    ?>
                </div>

                <form id="infoForm" method="post">

                    <table class="form-table">

                       
                        
                        <tr>

                            <th style="text-align: center"> Delete all:</th>
                            <td><input type="checkbox" name="select-all" id="select_all" /> Check To Select All </td>

                         </tr>  
                         <tr> 
                            
                            <th style="text-align: center"> Delete selected:</th>
                            <td>
                            
                            

                            <?php  
                                global $wpdb;

                                $prefix   = $wpdb->prefix;
                                $poststbl = $prefix.posts;

                                $sql = "select id,post_title,post_content FROM $poststbl";
                                $query = $wpdb->get_results($sql);  
                                //echo "<pre>";

                                foreach($query as $post_object) {
                                    
                                    //$address = $_SERVER['REQUEST_SCHEME'];
                                    $address = "https://";
                                    $address .= $_SERVER['HTTP_HOST'];

                                    
                                                                   
                                    $content = $post_object->post_content;
                                    $result = get_external_links($content);
                                   // var_dump($result);

                                    if($result)
                                    {   
                                      $count = TRUE;
                                        ?>
                                    <label><input type="checkbox" name="additional-data[]" value="<?php echo $post_object->id;  ?>" /> <?php echo "Post title: ".$post_object->post_title ?></label><br/>
                                      <?php
                                        echo "Post # :".$post_object->id.'<br />';
                                        
                                    foreach ($result as $value) {
                                        
                                        echo $value.'<br />';
                                    }
                                }

                                
                             ?>   
                                
                               <?php 
                                       } 

                                       // var_dump($result);
                                       // die;
                                       if(!$count)
                                       {
                                        echo "There are no posts with external links";
                                       }
                                        
                                        ?> 

                            </td>

                            </tr>

                            <tr>

                                <td></td><td><input type="submit"  name="submit" class="button button-primary" value="delete-checked"/></td>

                            </tr>

                        </table>


                </form>
                
            </div>

        </div>

        <h4 align="right">Developed by: <a href="#" target="_blank">Tech Digital</a></h4>

    </div>

<script>
jQuery(function($){  
    $('#select_all').click(function(event) { 
  if(this.checked) {
      // Iterate each checkbox
      $(':checkbox').each(function() {
          this.checked = true;
      });
  }
  else {
    $(':checkbox').each(function() {
          this.checked = false;
      });
  }
});
});

  
    </script>