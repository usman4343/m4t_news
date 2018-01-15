
 <?php

/*
Plugin Name: Adeel
*/
//add_action('init', 'mine_register_shortcodes1');

// function mine_register_shortcodes1()
//   {
//   add_shortcode('delpost','delete_post');
//  }

//add_action("wp_loaded", "delete_post");

 

 function replace_post_links($id)
 
     {
        global $wpdb;
        
        $prefix   = $wpdb->prefix;
        $poststbl = $prefix.posts;

        $sql = "select id,post_content FROM $poststbl WHERE id=$id ";
         // $query = $wpdb->get_row($sql);
        $query = $wpdb->get_row($sql);

        $content = $query->post_content;

       preg_match_all('~(?i)(<a[^>]+>)(.+?)</a>~', $content, $matches);  //~(https?://.[^ "]+)"~
     //  var_dump($matches[1]);   (?i)<a([^>]+)>(.+?)</a>
      // die;
      $address = $_SERVER['HTTP_HOST'];
      $address =  $link = preg_quote($address, "/");

        foreach($matches[1] as $link) {
            if(preg_match('~'. $address .'~', $link) == 1) {
                continue;
            }
            $link = preg_quote($link, "/");
            $content = preg_replace('/' . $link . '/', "", $content);
            
        }
           
       // echo htmlspecialchars($content);
       //  die;
         
        //   $result = $wpdb->update( 'wp_posts', array( 'post_content' => '$content'), array( 'ID' => '$id'), array( '%s'), array( '%d' ) );
        // if ( false === $result ) {
        //         echo "There was an error";
        //     } else {
        //          echo "No error. You can check updated to see how many rows were changed.";
        //     }
        //     die;

        global $post;
       //$data_content = $_POST['description'];

        $my_post = array();
        $my_post['ID'] = $id;
        $my_post['post_content'] = $content;
        wp_update_post( $my_post );

       // echo "done";
        return true;
       
     }

function get_external_links($content)
{
          preg_match_all('~(?i)(<a[^>]+>)(.+?)</a>~', $content, $matches);  // '~(https?://.[^ "]+)"~' (?i)<a([^>]+)>(.+?)</a>
          
          //preg_match_all('~(https?://.[^ "]+)~', $content, $matches); // failry good to take this expression for http or https code but in img src tag" " we also got "http//:bla bala" so it will get those links and shows in the link excluder settings page. another thing in the above fuction which will get <a href= from the start, if we catch those strings, they will not appear on the browser although so i start from href instead.
             //   var_dump($matches);
            $address = $_SERVER['HTTP_HOST'];
            $address =  $link = preg_quote($address, "/");  
               

                    foreach($matches[1] as $link) {
                        if(preg_match('~'. $address .'~', $link) == 1) {
                            continue;

                        }

                        $rem_elem[] = $link;
                        $rem_elem = str_replace("<a", "<", $rem_elem);
                        
                     
                    }
                  

                       if(!empty($rem_elem))
                    {
                        $result = $rem_elem;
                    }
                    else
                    {
                        $result = NULL; 
                    }

                    
                    return $result;
}