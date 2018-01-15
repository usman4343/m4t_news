<?php

class SQ_Controllers_Menu extends SQ_Classes_FrontController {

    /** @var array snippet */
    private $post_type;
    public $post;
    /** @var array snippet */
    var $options = array();


    public function __construct() {
        parent::__construct();
        add_action('admin_bar_menu', array($this, 'hookTopmenu'), 999);
    }

    /**
     * Hook the Admin load
     */
    public function hookInit() {
        /* add the plugin menu in admin */
        if (current_user_can('manage_options')) {
            //check if activated
            if (get_transient('sq_activate') == 1) {
                //Check if there are expected upgrades
                SQ_Classes_Tools::checkUpgrade();

                // Delete the redirect transient
                delete_transient('sq_activate');

                wp_safe_redirect(admin_url('admin.php?page=sq_dashboard'));
                exit();
            } else {
                //Deactivate the QuickSEO plugin
                if (SQ_Classes_Tools::isPluginInstalled('quick-seo')) {
                    $quickSEO = _QSS_ROOT_DIR_ . '/index.php';
                    if (is_plugin_active(plugin_basename($quickSEO))) {
                        delete_transient('qss_activate');

                        deactivate_plugins(plugin_basename($quickSEO), true);
                        SQ_Classes_Error::setMessage(sprintf(__("Good news, %s is integrated in Squirrly SEO now and you don't have to run 2 plugins anymore", _SQ_PLUGIN_NAME_), _QSS_PLUGIN_NAME_));
                    }

                }

                //Deactivate the Premium SEO Pack plugin
                if (SQ_Classes_Tools::isPluginInstalled('premium-seo-pack')) {
                    $phpSEO = _PSP_ROOT_DIR_ . '/index.php';
                    if (is_plugin_active(plugin_basename($phpSEO))) {
                        delete_transient('psp_activate');
                        deactivate_plugins(plugin_basename($phpSEO), true);
                        SQ_Classes_Error::setMessage(sprintf(__("Good news, %s is integrated in Squirrly SEO now and you don't have to run 2 plugins anymore", _SQ_PLUGIN_NAME_), _PSP_PLUGIN_NAME_));

                    }
                }

                //Make sure Squirrly upgrades the settings and seo
                if (SQ_Classes_Tools::getOption('sq_ver') < 8200 && SQ_Classes_Tools::getOption('sq_api') <> '') {
                    wp_redirect('admin.php?page=sq_dashboard&action=sq_dataupgrade&nonce=' . wp_create_nonce(_SQ_NONCE_ID_));
                }
            }

            if (get_transient('sq_rewrite') == 1) {
                // Delete the redirect transient
                delete_transient('sq_rewrite');
                global $wp_rewrite;
                $wp_rewrite->flush_rules();
            }


        }
        //activate the cron job if not exists
        if (!wp_get_schedule('sq_processCron')) {
            wp_schedule_event(time(), 'hourly', 'sq_processCron');
        }

        add_filter('rewrite_rules_array', array(SQ_Classes_ObjController::getClass('SQ_Core_BlockSettingsSeo'), 'rewrite_rules'), 999, 1);


    }

    /**
     * Add a menu in Admin Bar
     *
     * @param WP_Admin_Bar $wp_admin_bar
     */
    public function hookTopmenu($wp_admin_bar) {
        global $tag, $wp_the_query;

        if (!is_user_logged_in()) {
            return;
        }

        if (current_user_can('edit_posts')) {
            $wp_admin_bar->add_node(array(
                'id' => 'sq_posts',
                'title' => __('See Your Rank on Google', _SQ_PLUGIN_NAME_),
                'href' => admin_url('admin.php?page=sq_posts'),
                'parent' => false
            ));
        }

        if (is_admin()) {
            $current_screen = get_current_screen();
            SQ_Classes_Tools::dump($current_screen);

            $post = get_post();
            if ('post' == $current_screen->base
                && ($post_type_object = get_post_type_object($post->post_type))
                && current_user_can('edit_post', $post->ID)
                && ($post_type_object->public)) {
            } elseif ('edit' == $current_screen->base
                && ($post_type_object = get_post_type_object($current_screen->post_type))
                && ($post_type_object->show_in_admin_bar)
                && !('edit-' . $current_screen->post_type === $current_screen->id)) {
            } elseif ('term' == $current_screen->base
                && isset($tag) && is_object($tag) && !is_wp_error($tag)
                && ($tax = get_taxonomy($tag->taxonomy))
                && $tax->public) {
            } else {
                return;
            }

            //Add the snippet in all post types
            $this->addMetabox();
        } else {
            //If user set not to load Squirrly in frontend
            if (!SQ_Classes_Tools::getOption('sq_use_frontend')) {
                return;
            }

            if (!current_user_can('manage_options')) {
                $current_object = $wp_the_query->get_queried_object();

                if (empty($current_object))
                    return;

                if (!empty($current_object->post_type)
                    && ($post_type_object = get_post_type_object($current_object->post_type))
                    && current_user_can('edit_post', $current_object->ID)
                    && $post_type_object->show_in_admin_bar
                    && $edit_post_link = get_edit_post_link($current_object->ID)) {
                } elseif (!empty($current_object->taxonomy)
                    && ($tax = get_taxonomy($current_object->taxonomy))
                    && current_user_can('edit_term', $current_object->term_id)
                    && $edit_term_link = get_edit_term_link($current_object->term_id, $current_object->taxonomy)) {
                } else {
                    return;
                }
            }
        }


        $wp_admin_bar->add_node(array(
            'id' => 'sq_bar_menu',
            'title' => '<span class="dashicons-sqlogo"></span> ' . __('Custom SEO', _SQ_PLUGIN_NAME_),
            'parent' => 'top-secondary',
        ));

        $wp_admin_bar->add_menu(array(
            'id' => 'sq_bar_submenu',
            'parent' => 'sq_bar_menu',
            'meta' => array(
                'html' => $this->getView('FrontMenu'),
                'tabindex' => PHP_INT_MAX,
            ),
        ));

        if (is_admin()) {
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('frontmenu');
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('patterns');
        }

    }

    /**
     * Creates the Setting menu in Wordpress
     */
    public function hookMenu() {

        $this->post_type = SQ_Classes_Tools::getOption('sq_post_types');

        //Push the Analytics Check
        if (strpos($_SERVER['REQUEST_URI'], '?page=sq_dashboard') !== false) {
            SQ_Classes_Tools::saveOptions('sq_dashboard', 1);
        }
        if (strpos($_SERVER['REQUEST_URI'], '?page=sq_analytics') !== false) {
            SQ_Classes_Tools::saveOptions('sq_analytics', 1);
        }

        $analytics_alert = 0;
        if (SQ_Classes_ObjController::getClass('SQ_Models_Post')->countKeywords() > 0 && !SQ_Classes_Tools::getOption('sq_analytics')) {
            $analytics_alert = 1;
            if (!get_transient('sq_analytics')) {
                set_transient('sq_analytics', time(), (60 * 60 * 24 * 7));
            } else {
                $time_loaded = get_transient('sq_analytics');
                if (time() - $time_loaded > (60 * 60 * 24 * 3) && time() - $time_loaded < (60 * 60 * 24 * 14)) {
                    SQ_Classes_Error::setError(sprintf(__('Check out the Squirrly Analytics section. %sClick here%s', _SQ_PLUGIN_NAME_), '<a href="admin.php?page=sq_posts" title="' . __('Squirrly Analytics', _SQ_PLUGIN_NAME_) . '">', '</a>'));
                }
            }
        }


        //Show bar to go back and finish the help
        if (current_user_can('manage_options') && ($this->is_page('edit') || strpos($_SERVER['REQUEST_URI'], '?page=sq_posts') !== false)) {
            if (SQ_Classes_Tools::getOption('active_help') <> '' && !SQ_Classes_Tools::getOption('ignore_warn')) {
                SQ_Classes_Error::setError(sprintf(__('Go back and complete the Squirrly Tasks for today %sContinue%s', _SQ_PLUGIN_NAME_), '<a href="admin.php?page=sq_' . SQ_Classes_Tools::getOption('active_help') . '" class="sq_button" title="Continue the Help">', '</a>'), 'helpnotice');
            }

            if (strpos($_SERVER['REQUEST_URI'], '?page=sq_posts') !== false) {
                $analytics_alert = 0;
            }
        }

        $dashboard_alert = (int)(SQ_Classes_Tools::getOption('sq_dashboard') == 0);


        ///////////////

        $this->model->addMenu(array(ucfirst(_SQ_NAME_),
            'Squirrly' . (($analytics_alert) ? SQ_Classes_Tools::showNotices($analytics_alert, 'errors_count') : ''),
            'edit_posts',
            'sq_dashboard',
            null,
            _SQ_THEME_URL_ . 'img/settings/menu_icon_16.png'
        ));

        $this->model->addSubmenu(array('sq_dashboard',
            ucfirst(_SQ_NAME_) . __(' Dashboard', _SQ_PLUGIN_NAME_),
            ((SQ_Classes_Tools::getOption('sq_api') == '') ? __('First Step', _SQ_PLUGIN_NAME_) : __('Dashboard', _SQ_PLUGIN_NAME_)) . SQ_Classes_Tools::showNotices($dashboard_alert, 'errors_count'),
            'edit_posts',
            'sq_dashboard',
            array(SQ_Classes_ObjController::getClass('SQ_Core_BlockDashboard'), 'init')
        ));

        //IF SERP PLUGIN IS NOT INSTALLED
        if (SQ_Classes_Tools::getOption('sq_google_serp_active')) {
            $this->model->addSubmenu(array('sq_dashboard',
                ucfirst(_SQ_NAME_) . __(' Advanced Analytics (Business Level)', _SQ_PLUGIN_NAME_),
                __('Advanced Analytics', _SQ_PLUGIN_NAME_) . ($analytics_alert ? SQ_Classes_Tools::showNotices($analytics_alert, 'errors_count') : ''),
                'edit_posts',
                'sq_posts',
                array(SQ_Classes_ObjController::getClass('SQ_Controllers_SerpChecker'), 'init')
            ));
        } else {
            $this->model->addSubmenu(array('sq_dashboard',
                ucfirst(_SQ_NAME_) . __(' Performance Analytics', _SQ_PLUGIN_NAME_),
                __('Performance <br />Analytics', _SQ_PLUGIN_NAME_) . ($analytics_alert ? SQ_Classes_Tools::showNotices($analytics_alert, 'errors_count') : ''),
                'edit_posts',
                'sq_posts',
                array(SQ_Classes_ObjController::getClass('SQ_Core_BlockPostsAnalytics'), 'init')
            ));
        }

        $this->model->addSubmenu(array('sq_dashboard',
            ucfirst(_SQ_NAME_) . __(' Keyword Research', _SQ_PLUGIN_NAME_),
            __('Keyword Research', _SQ_PLUGIN_NAME_),
            'edit_posts',
            'sq_keywordresearch',
            array(SQ_Classes_ObjController::getClass('SQ_Core_BlockKeywordResearch'), 'init')
        ));

        $this->model->addSubmenu(array('sq_dashboard',
            ucfirst(_SQ_NAME_) . __(' Briefcase', _SQ_PLUGIN_NAME_),
            __('Briefcase', _SQ_PLUGIN_NAME_),
            'edit_posts',
            'sq_briefcase',
            array(SQ_Classes_ObjController::getClass('SQ_Core_BlockBriefcaseKeywords'), 'init')
        ));

        $this->model->addSubmenu(array('sq_dashboard',
            ucfirst(_SQ_NAME_) . __(' Live Assistant', _SQ_PLUGIN_NAME_),
            __('Live Assistant', _SQ_PLUGIN_NAME_),
            'edit_posts',
            'sq_liveassistant',
            array(SQ_Classes_ObjController::getClass('SQ_Core_BlockLiveAssistant'), 'init')
        ));
        $this->model->addSubmenu(array('sq_dashboard',
            __(' Copywriting', _SQ_PLUGIN_NAME_),
            __('Copywriting', _SQ_PLUGIN_NAME_),
            'edit_posts',
            'sq_copyright',
            array(SQ_Classes_ObjController::getClass('SQ_Core_BlockCopyright'), 'init')
        ));

        if (current_user_can('manage_options')) {
            $this->model->addSubmenu(array('sq_dashboard',
                ucfirst(_SQ_NAME_) . __(' SEO Audit', _SQ_PLUGIN_NAME_),
                __('Site Audit', _SQ_PLUGIN_NAME_),
                'edit_posts',
                'sq_seoaudit',
                array(SQ_Classes_ObjController::getClass('SQ_Core_BlockAudit'), 'init')
            ));
        }

        $this->model->addSubmenu(array('sq_dashboard',
            ucfirst(_SQ_NAME_) . __(' SEO Settings', _SQ_PLUGIN_NAME_),
            __('SEO Settings', _SQ_PLUGIN_NAME_),
            'manage_options',
            'sq_seo',
            array(SQ_Classes_ObjController::getClass('SQ_Core_BlockSettingsSeo'), 'init')
        ));


        $this->model->addSubmenu(array('sq_dashboard',
            ucfirst(_SQ_NAME_) . __(' Advanced Settings', _SQ_PLUGIN_NAME_),
            __('Advanced Settings', _SQ_PLUGIN_NAME_),
            'manage_options',
            'sq_settings',
            array(SQ_Classes_ObjController::getClass('SQ_Core_BlockSettings'), 'init')
        ));

        $this->model->addSubmenu(array('sq_dashboard',
            ucfirst(_SQ_NAME_) . __(' SEO Patterns', _SQ_PLUGIN_NAME_),
            __('Patterns', _SQ_PLUGIN_NAME_),
            'manage_options',
            'sq_patterns',
            array(SQ_Classes_ObjController::getClass('SQ_Core_BlockPatterns'), 'init')
        ));

        $this->model->addSubmenu(array('sq_dashboard',
            ucfirst(_SQ_NAME_) . __(' Account Info', _SQ_PLUGIN_NAME_),
            __('Account Info', _SQ_PLUGIN_NAME_),
            'manage_options',
            'sq_account',
            array(SQ_Classes_ObjController::getClass('SQ_Core_BlockAccount'), 'init')
        ));

        $this->model->addSubmenu(array('sq_dashboard',
            ucfirst(_SQ_NAME_) . __(' Support', _SQ_PLUGIN_NAME_),
            __('Support', _SQ_PLUGIN_NAME_),
            'edit_posts',
            'sq_customerservice',
            array(SQ_Classes_ObjController::getClass('SQ_Core_BlockCustomerService'), 'init')
        ));

        $this->model->addSubmenu(array('sq_dashboard',
            __('Become an Affiliate with ', _SQ_PLUGIN_NAME_) . ucfirst(_SQ_NAME_),
            __('Become an Affiliate', _SQ_PLUGIN_NAME_),
            'edit_posts',
            'sq_affiliate',
            array(SQ_Classes_ObjController::getClass('SQ_Core_BlockAffiliate'), 'init')
        ));

        if (current_user_can('manage_options')) {
            $this->model->addSubmenu(array('sq_dashboard',
                __('Import SEO ', _SQ_PLUGIN_NAME_),
                __('Import SEO', _SQ_PLUGIN_NAME_),
                'edit_posts',
                'sq_import',
                array(SQ_Classes_ObjController::getClass('SQ_Core_BlockImport'), 'init')
            ));
        }



        foreach ($this->post_type as $type) {
            $this->model->addMeta(array('post' . _SQ_NAME_,
                ucfirst(_SQ_NAME_),
                array(SQ_Classes_ObjController::getClass('SQ_Controllers_Post'), 'init'),
                $type,
                'side',
                'high'
            ));
        }


        //Add the Rank in the Posts list
        $postlist = SQ_Classes_ObjController::getClass('SQ_Controllers_PostsList');
        if (is_object($postlist)) {
            $postlist->init();
        }


    }

    /**
     * Add Post Editor Meta Box
     */
    public function addMetabox() {
        $this->model->addMeta(array('sq_blocksnippet',
            ucfirst(_SQ_NAME_) . ' ' . __('SEO Snippet', _SQ_PLUGIN_NAME_),
            array(SQ_Classes_ObjController::getClass('SQ_Controllers_FrontMenu'), 'show'),
            null,
            'normal',
            'high'
        ));
    }

    /**
     * Hook the Head sequence in frontend when user is logged in
     */
    public function hookFronthead() {
        if (current_user_can('edit_posts')) {
            //prevent some compatibility errors with other plugins
            remove_all_actions('print_media_templates');

            //loade the media library
            wp_enqueue_media();

            //Set the current post domain with all the data
            $this->post = SQ_Classes_ObjController::getClass('SQ_Models_Frontend')->getPost();
        }
    }

    /**
     * Called when Post action is triggered
     *
     * @return void
     */
    public function action() {
        parent::action();

        if (!current_user_can('edit_posts')) {
            return;
        }

        SQ_Classes_Tools::setHeader('json');

        switch (SQ_Classes_Tools::getValue('action')) {
            case 'sq_getfrontmenu':
                $json = array();
                $post_id = (int)SQ_Classes_Tools::getValue('post_id', 0);
                $term_taxonomy_id = (int)SQ_Classes_Tools::getValue('term_taxonomy_id', 0);
                $taxonomy = SQ_Classes_Tools::getValue('taxonomy', 'category');

                if ($post_id > 0) {
                    if ($this->setPostByID($post_id)) {
                        $json['html'] = $this->getView('FrontMenu');
                    }
                } elseif ($term_taxonomy_id > 0) {
                    if ($this->setPostByTaxID($term_taxonomy_id, $taxonomy)) {
                        if (get_term_link($term_taxonomy_id) == $this->post->url) {
                            $json['html'] = $this->getView('FrontMenu');
                        }
                    }
                }
                echo json_encode($json);
                exit();
        }
    }

    public function getPostType($for, $post_type = null) {
        switch ($for) {
            case 'og:type':
                if (isset($this->post->sq) && $this->post->sq->og_type <> '') {
                    if ($this->post->sq->og_type == $post_type) return 'selected="selected"';
                } else {
                    switch ($post_type) {
                        case 'website':
                            if ($this->post->post_type == 'home') return 'selected="selected"';
                            break;
                        default:
                            if ($this->post->post_type == $post_type) return 'selected="selected"';
                    }
                }
                break;
        }
        return false;
    }

    public function getImportList() {
        return apply_filters('sq_importList', false);
    }

    public function setPostByURL($url) {
        $post_id = url_to_postid($url);
        $this->post = get_post($post_id);

        if ($post_id > 0) {
            add_filter('sq_current_post', array($this, 'setCurrentPost'), 10);
            SQ_Classes_ObjController::getClass('SQ_Models_Frontend')->setPost();
            $this->post = SQ_Classes_ObjController::getClass('SQ_Models_Frontend')->getPost();
            return $this->post;
        }

        return false;
    }

    public function setPostByID($post = 0, $taxonomy = 'post') {
        if ($post instanceof WP_Post) {
            $this->post = $post;
        } else {
            $post_id = (int)$post;
            if ($post_id > 0) {
                $this->post = get_post($post_id);
            }
        }

        if ($this->post) {
            set_query_var('post_type', $this->post->post_type);
            $this->post = SQ_Classes_ObjController::getClass('SQ_Models_Frontend')->setPost($this->post)->getPost();

            SQ_Classes_Tools::dump($this->post);
            return $this->post;
        }
        return false;
    }

    public function setPostByTaxID($term_taxonomy_id = 0, $taxonomy = 'category') {
        if ($term_taxonomy_id > 0) {
            global $wp_query;

            $term = get_term($term_taxonomy_id, $taxonomy);
            if ($taxonomy == 'category') {
                $args = array('posts_per_page' => '1', 'cat' => $term_taxonomy_id);
            } elseif ($taxonomy == 'post_tag') {
                $args = array('posts_per_page' => 1, 'tag_id' => $term_taxonomy_id);
            } else {
                $args = array('posts_per_page' => 1, $taxonomy => $term->slug, 'term_id' => $term_taxonomy_id);
            }

            $tax_query = array(
                array(
                    'taxonomy' => $taxonomy,
                    'terms' => $term->slug,
                    'field' => 'slug',
                    'include_children' => true,
                    'operator' => 'IN'
                ),
                array(
                    'taxonomy' => $taxonomy,
                    'terms' => $term->slug,
                    'field' => 'slug',
                    'include_children' => false,
                )
            );

            $args['tax_query'] = $tax_query;
            $wp_query->query($args);
            set_query_var('post_type', $taxonomy);

            if ($this->post = SQ_Classes_ObjController::getClass('SQ_Models_Frontend')->setPost($term)->getPost()) {
                return $this->post;
            }
        }
        return false;
    }

    public function setCurrentPost() {
        return $this->post;
    }

    /**
     * Is the user on page name? Default name = post edit page
     * name = 'quirrly'
     *
     * @global array $pagenow
     * @param string $name
     * @return boolean
     */
    public function is_page($name = '') {
        global $pagenow;
        $page = array();
        //make sure we are on the backend
        if (is_admin() && $name <> '') {
            if ($name == 'edit') {
                $page = array('post.php', 'post-new.php');
            } else {
                array_push($page, $name . '.php');
            }

            return in_array($pagenow, $page);
        }

        return false;
    }

}
