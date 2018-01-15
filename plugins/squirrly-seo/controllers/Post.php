<?php

class SQ_Controllers_Post extends SQ_Classes_FrontController {

    public $saved;

    /**
     * Initialize the TinyMCE editor for the current use
     *
     * @return void
     */
    public function hookInit() {
        $this->saved = array();

        add_filter('tiny_mce_before_init', array($this->model, 'setCallback'));
        add_filter('mce_external_plugins', array($this->model, 'addHeadingButton'));
        add_filter('mce_buttons', array($this->model, 'registerButton'));

        if (SQ_Classes_Tools::getOption('sq_api') == '')
            return;

        add_action('save_post', array($this, 'hookSavePost'), 99, 1);
        add_action('shopp_product_saved', array($this, 'hookShopp'), 11, 1);
        add_action('edit_attachment', array($this, 'checkSeo'), 99, 1);

        if (SQ_Classes_Tools::getOption('sq_use') && SQ_Classes_Tools::getOption('sq_auto_sitemap')) {
            add_action('transition_post_status', array(SQ_Classes_ObjController::getClass('SQ_Controllers_Sitemaps'), 'refreshSitemap'), 9999, 3);
        }
    }

    /**
     * hook the Head
     *
     * @global integer $post_ID
     */
    public function hookHead() {
        global $post_ID;
        parent::hookHead();

        /**
         * Add the post ID in variable
         * If there is a custom plugin post or Shopp product
         *
         * Set the global variable $sq_postID for cookie and keyword record
         */
        if ((int)$post_ID == 0) {
            if (SQ_Classes_Tools::getIsset('id'))
                $GLOBALS['sq_postID'] = (int)SQ_Classes_Tools::getValue('id');
        } else {
            $GLOBALS['sq_postID'] = $post_ID;
        }
        /*         * ****************************** */

        echo '<script type="text/javascript">(function($) {$.sq_tinymce = { callback: function () {}, setup: function(ed){} } })(jQuery);</script>';
    }

    /**
     * Hook the Shopp plugin save product
     */
    public function hookShopp($product) {
        $this->checkSeo($product->id);
    }

    /**
     * Hook the post save/update
     * @param type $post_id
     */
    public function hookSavePost($post_id) {

        if (!isset($this->saved[$post_id])) {
            $this->saved[$post_id] = false;
        }

        // unhook this function so it doesn't loop infinitely
        remove_action('save_post', array($this, 'hookSavePost'), 99);

        //If the post is a new or edited post
        if ((SQ_Classes_Tools::getValue('action')) == 'editpost' &&
            wp_is_post_autosave($post_id) == '' &&
            get_post_status($post_id) != 'auto-draft' &&
            get_post_status($post_id) != 'inherit' &&
            SQ_Classes_Tools::getValue('autosave') == ''
        ) {

            if ($this->saved[$post_id] === false) {
                //check the SEO from Squirrly Live Assistant
                $this->checkSeo($post_id, get_post_status($post_id));
                //check the remote images
                $this->checkImage($post_id);
                //check sq mark remained
                $this->removeHighlight($post_id);
            }
            $this->saved[$post_id] = true;
        }


        add_action('save_post', array($this, 'hookSavePost'), 99);
    }

    /**
     * Remove the Squirrly Highlights in case there are some left
     * @param $post_id
     */
    public function removeHighlight($post_id) {
        $content = SQ_Classes_Tools::getValue('post_content', '', true); //get the content in html format

        if (strpos($content, '<mark') !== false) {
            $content = preg_replace('/<mark[^>]*data-markjs="true"[^>]*>([^<]*)<\/mark>/i', '$1', $content);
            wp_update_post(array(
                    'ID' => $post_id,
                    'post_content' => $content)
            );
        }
    }

    /**
     * Check if the image is a remote image and save it locally
     *
     * @param integer $post_id
     * @return false|void
     */
    public function checkImage($post_id) {

        //if the option to save the images locally is set on
        if (SQ_Classes_Tools::getOption('sq_local_images')) {

            @set_time_limit(90);
            $local_file = false;

            $content = SQ_Classes_Tools::getValue('post_content', '', true); //get the content in html format
            $tmpcontent = trim(html_entity_decode($content), "\n");
            $urls = array();

            if (function_exists('preg_match_all')) {

                @preg_match_all('/<img[^>]*src=[\'"]([^\'"]+)[\'"][^>]*>/i', $tmpcontent, $out);
                if (is_array($out)) {

                    if (!is_array($out[1]) || count($out[1]) == 0)
                        return;

                    if (get_bloginfo('wpurl') <> '') {
                        $domain = parse_url(get_bloginfo('wpurl'));

                        foreach ($out[1] as $row) {
                            if (strpos($row, '//') !== false &&
                                strpos($row, $domain['host']) === false
                            ) {
                                if (!in_array($row, $urls)) {
                                    $urls[] = $row;
                                }
                            }
                        }
                    }
                }
            }

            if (!is_array($urls) || (is_array($urls) && count($urls) == 0))
                return;

            $urls = @array_unique($urls);

            $time = microtime(true);
            foreach ($urls as $url) {
                if ($file = $this->model->upload_image($url)) {
                    if (!file_is_valid_image($file['file']))
                        continue;

                    $local_file = $file['url'];
                    if ($local_file !== false) {
                        $content = str_replace($url, $local_file, $content);

                        if (!$this->model->findAttachmentByUrl(basename($url))) {
                            $attach_id = wp_insert_attachment(array(
                                'post_mime_type' => $file['type'],
                                'post_title' => SQ_Classes_Tools::getValue('sq_keyword', preg_replace('/\.[^.]+$/', '', $file['filename'])),
                                'post_content' => '',
                                'post_status' => 'inherit',
                                'guid' => $local_file
                            ), $file['file'], $post_id);

                            $attach_data = wp_generate_attachment_metadata($attach_id, $file['file']);
                            wp_update_attachment_metadata($attach_id, $attach_data);
                        }
                    }
                }

                if (microtime(true) - $time >= 20) {
                    break;
                }

            }


            if ($local_file !== false) {
                wp_update_post(array(
                        'ID' => $post_id,
                        'post_content' => $content)
                );
            }
        }
    }


    /**
     * Check the SEO from Squirrly Live Assistant
     *
     * @param integer $post_id
     * @param void
     */
    public function checkSeo($post_id, $status = '') {
        $args = array();

        $seo = SQ_Classes_Tools::getValue('sq_seo');

        if (is_array($seo) && count($seo) > 0)
            $args['seo'] = implode(',', $seo);

        $args['keyword'] = SQ_Classes_Tools::getValue('sq_keyword');

        $args['status'] = $status;
        $args['permalink'] = get_permalink($post_id);
        $args['permalink'] = $this->getPaged($args['permalink']);
        $args['author'] = (int)SQ_Classes_Tools::getUserID();
        $args['post_id'] = $post_id;


        if (SQ_Classes_Tools::getOption('sq_force_savepost')) {
            SQ_Classes_Action::apiCall('sq/seo/post', $args, 10);
        } else {
            $process = array();
            if (get_option('sq_seopost') !== false) {
                $process = json_decode(get_option('sq_seopost'), true);
            }

            $process[] = $args;

            //save for later send to api
            update_option('sq_seopost', json_encode($process));
            wp_schedule_single_event(time(), 'sq_processApi');

            //If the queue is too big ... means that the cron is not working
            if(count($process) > 5){
                SQ_Classes_Tools::saveOptions('sq_force_savepost',1);
            }
        }

        //Save the keyword for this post
        if ($json = $this->model->getKeyword($post_id)) {
            $json->keyword = addslashes(SQ_Classes_Tools::getValue('sq_keyword'));
            $this->model->saveKeyword($post_id, $json);
        } else {
            $args = array();
            $args['keyword'] = addslashes(SQ_Classes_Tools::getValue('sq_keyword'));
            $this->model->saveKeyword($post_id, json_decode(json_encode($args)));
        }

        //Save the snippet in case is edited in backend and not saved
        SQ_Classes_ObjController::getClass('SQ_Controllers_FrontMenu')->saveSEO();
        //check for custom SEO
        $this->_checkBriefcaseKeywords($post_id);
    }

    public function getPaged($link) {
        $page = (int)get_query_var('paged');
        if ($page && $page > 1) {
            $link = trailingslashit($link) . "page/" . "$page" . '/';
        }
        return $link;
    }

    /**
     * Called when Post action is triggered
     *
     * @return void
     */
    public function action() {
        parent::action();

        switch (SQ_Classes_Tools::getValue('action')) {
            case 'sq_save_ogimage':
                if (!empty($_FILES['ogimage'])) {
                    $return = $this->model->addImage($_FILES['ogimage']);
                }
                if (isset($return['file'])) {
                    $return['filename'] = basename($return['file']);
                    $local_file = str_replace($return['filename'], urlencode($return['filename']), $return['url']);
                    $attach_id = wp_insert_attachment(array(
                        'post_mime_type' => $return['type'],
                        'post_title' => preg_replace('/\.[^.]+$/', '', $return['filename']),
                        'post_content' => '',
                        'post_status' => 'inherit',
                        'guid' => $local_file
                    ), $return['file'], SQ_Classes_Tools::getValue('post_id'));

                    $attach_data = wp_generate_attachment_metadata($attach_id, $return['file']);
                    wp_update_attachment_metadata($attach_id, $attach_data);
                }
                SQ_Classes_Tools::setHeader('json');
                echo json_encode($return);
                SQ_Classes_Tools::emptyCache();

                break;
            case 'sq_get_keyword':
                SQ_Classes_Tools::setHeader('json');
                if (SQ_Classes_Tools::getIsset('post_id')) {
                    echo json_encode($this->model->getKeywordsFromPost(SQ_Classes_Tools::getValue('post_id')));
                } else {
                    echo json_encode(array('error' => true));
                }
                SQ_Classes_Tools::emptyCache();
                break;
        }
        exit();
    }

    /**
     * Save the keywords from briefcase into the meta keywords if there are no keywords saved
     * @param $post_id
     */
    private function _checkBriefcaseKeywords($post_id) {
        if (SQ_Classes_Tools::getIsset('sq_hash')) {
            $keywords = SQ_Classes_Tools::getValue('sq_briefcase_keyword', array());
            if (!empty($keywords)) {
                $sq_hash = SQ_Classes_Tools::getValue('sq_hash', md5($post_id));
                $url = SQ_Classes_Tools::getValue('sq_url', get_permalink($post_id));
                $sq = SQ_Classes_ObjController::getClass('SQ_Models_Frontend')->getSqSeo($sq_hash);

                if ($sq->doseo && $sq->keywords == '') {
                    $sq->keywords = join(',', $keywords);

                    SQ_Classes_ObjController::getClass('SQ_Models_BlockSettingsSeo')->db_insert(
                        $url,
                        $sq_hash,
                        (int)$post_id,
                        maybe_serialize($sq->toArray()),
                        gmdate('Y-m-d H:i:s')
                    );
                }
            }
        }
    }

    public function hookFooter() {
        if (!defined('DISABLE_WP_CRON') || DISABLE_WP_CRON) {
            global $pagenow;
            if (in_array($pagenow, array('post.php', 'post-new.php'))) {
                SQ_Classes_ObjController::getClass('SQ_Controllers_Cron')->processSEOPostCron();
            }
        }
    }

}
