<?php

    if ( isset( $_POST['pclaen_action'] ) && $_POST['pclaen_action'] == "pclaen_all_posts" && !empty( $_POST['pclaen_searchText'] ) ) {
        $all_posts_Text = pclaen_all_posts_check();
    }

    $text = '<p>You’ve got the Lite version of this Link Removal Tool plugin. The Pro version is <strong>FREE</strong> and offers <strong>all these benefits</strong>.</p><ol>';
    $text .= '<li>You can add <strong>unlimited  URLs</strong> as you want</li>';
    $text .= '<li>Future check.  Your site will scan and stop any bad link URLs going onto your site ever again</li>';
    $text .= '<li>Wildcard option. Click <a href="http://www.outsourcingexposed.com/155/free-link-removal-tool/" target="_blank" title="Click here">here</a> for details</li>';
    $text .= '<li><strong>REPLACE URL</strong> option (or delete).  Replace with a good URL.</li>';
    $text .= '<li>Centralized URL list option.  Apply the same URL rules to any or all of your sites.</li>';
    //$text .= '</ol><p>So click this button to get the <strong>FREE Pro version</strong></p>';
    $text .= '</ol>';
?>

<div class="wrap">

    <script language="JavaScript">
    <!--
        function pclaen_all_posts() {

            if ( document.pclaen_searchForm.pclaen_searchText.value == "" )
            {
                alert( 'Please write search text!' );
                document.pclaen_searchForm.pclaen_searchText.focus();
                return false;
            } else {
                document.pclaen_searchForm.pclaen_action.value = "pclaen_all_posts";
                document.pclaen_searchForm.submit();
                return true;
            }
        }

    //-->
    </script>

    <h2>Link Remover</h2>
    <br clear="all"/>
    <br clear="all"/>
    <table>
        <tr>
            <td valign="top" width="285">
                <div>URL to un-link. This will remove all hyperlinks on your site pointing to this URL.<br />Add only the root domain, not a sub page and without the <i>http://www. part.</i>
            <br />For example to remove links to <i>http://www.dodgysite.com/this-page/</i> add only <i>dodgysite.com</i></div><br />
                <form action="" method="post" name="pclaen_searchForm">
                    <input type="hidden" name="pclaen_action" value="" />
                    <input type="hidden" name="pclaen_del_ID" value="" />
                    <input type="text" name="pclaen_searchText" size="50" />
                    <br clear="all"/>
                    <br clear="all"/>
                    <input type="button" onclick="pclaen_all_posts();" value="Clear all posts"/>
                    <br clear="all"/>
                    <br clear="all"/>

                    <?php
                        echo isset( $all_posts_Text ) ? $all_posts_Text : '';
                    ?>
                </form>
            </td>
            <td valign="top">
                <a style="margin-left:480px;" href="http://www.outsourcingexposed.com/im-superhero-quiz/" title="www.outsourcingexposed.com" target="_blank"><img src="<?php echo plugins_url( 'ad.gif' , 'link-removal-tool-lite/link_removal_lite.php' ) ?>" border="0" width="300" height="180" alt="AD"></a>
            </td>
        </tr>
    </table>


    <div id="message" class="updated">
        <div class="squeezer">
            <?php _e( $text, LINKREM_TEXT_DOMAIN ) ?>
            <p class="submit">
                <a href="http://www.outsourcingexposed.com/155/free-link-removal-tool/" class="button-primary">
                    <?php _e( 'Download now', LINKREM_TEXT_DOMAIN ) ?>
                </a>
            </p>
        </div>
    </div>

</div>