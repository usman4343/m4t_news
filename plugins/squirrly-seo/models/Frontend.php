<?php

class SQ_Models_Frontend {

    private $_post;
    private $_loaded = false;

    public function __construct() {
        //initiate the post
        $this->_post = false;

        add_filter('sq_post', array($this, 'getWpPost'), 11, 1);
        add_filter('sq_post', array($this, 'getPostDetails'), 12, 1);

        add_filter('sq_post', array($this, 'replacePatterns'), 13, 1);
        add_filter('sq_post', array($this, 'addPaged'), 14, 1);

        //change the buffer
        add_filter('sq_buffer', array($this, 'setMetaInBuffer'), 10, 1);
        //pack html prefix if needed
        add_filter('sq_html_prefix', array($this, 'packPrefix'), 99);
    }

    public function setStart() {
        return "\n\n<!-- Squirrly SEO Plugin " . SQ_VERSION . ", visit: https://plugin.squirrly.co/ -->\n";

    }

    /**
     * End the signature
     * @return string
     */
    public function setEnd() {
        return "<!-- /Squirrly SEO Plugin -->\n\n";

    }

    /**
     * Start the buffer record
     * @return string html
     */
    public function startBuffer() {
        ob_start(array($this, 'getBuffer'));
    }

    /**
     * Get the loaded buffer and change it
     *
     * @param string $buffer
     * @return string
     */
    public function getBuffer($buffer) {
        //prevend from loading again
        if ($this->_loaded) {
            return $buffer;
        }

        return apply_filters('sq_buffer', $buffer);
    }


    /**
     * Change the title, description and keywords in site's buffer
     * @param string $buffer
     * @return string
     */
    public function setMetaInBuffer($buffer) {
        //if is enabled sq for this page
        if ($this->runSEOForThisPage()) {
            if (strpos($buffer, '</head') !== false) {
                if ($header = $this->getHeader()) {

                    //set loaded true
                    $this->_loaded = true;

                    //clear the existing tags to avoid duplicates
                    if (isset($header['sq_title']) && $header['sq_title'] <> '' && SQ_Classes_Tools::getOption('sq_auto_title')) {
                        $buffer = @preg_replace('/<title[^<>]*>([^<>]*)<\/title>/si', '', $buffer, -1);
                    }
                    if (isset($header['sq_description']) && $header['sq_description'] <> '' && SQ_Classes_Tools::getOption('sq_auto_description')) {
                        $buffer = @preg_replace('/<meta[^>]*(name|property)=["\']description["\'][^>]*content=["\'][^"\'>]*["\'][^>]*>[\n\r]*/si', '', $buffer, -1);
                    }
                    if (isset($header['sq_keywords']) && $header['sq_keywords'] <> '' && SQ_Classes_Tools::getOption('sq_auto_keywords')) {
                        $buffer = @preg_replace('/<meta[^>]*(name|property)=["\']keywords["\'][^>]*content=["\'][^"\'>]*["\'][^>]*>[\n\r]*/si', '', $buffer, -1);
                    }
                    if (isset($header['sq_canonical']) && $header['sq_canonical'] <> '' && SQ_Classes_Tools::getOption('sq_auto_canonical')) {
                        $buffer = @preg_replace('/<link[^>]*rel=["\']canonical["\'][^>]*>[\n\r]*/si', '', $buffer, -1);
                        $buffer = @preg_replace('/<link[^>]*rel=["\'](prev|next)["\'][^>]*>[\n\r]*/si', '', $buffer, -1);
                    }
                    if (isset($header['sq_sitemap']) && $header['sq_sitemap'] <> '' && SQ_Classes_Tools::getOption('sq_auto_sitemap')) {
                        $buffer = @preg_replace('/<link[^>]*rel=["\']alternate["\'][^>]*type="application\/rss+xml"[^>]*>[\n\r]*/si', '', $buffer, -1);
                    }
                    if (isset($header['sq_noindex']) && $header['sq_noindex'] <> '' && SQ_Classes_Tools::getOption('sq_auto_noindex')) {
                        $buffer = @preg_replace('/<meta[^>]*name=["\']robots["\'][^>]*>[\n\r]*/si', '', $buffer, -1);
                    }
                    if (isset($header['sq_open_graph']) && $header['sq_open_graph'] <> '' && SQ_Classes_Tools::getOption('sq_auto_facebook')) {
                        $buffer = @preg_replace('/<meta[^>]*(name|property)=["\'](og:|article:)[^"\'>]+["\'][^>]*content=["\'][^"\'>]+["\'][^>]*>[\n\r]*/si', '', $buffer, -1);
                    }
                    if (isset($header['sq_twitter_card']) && $header['sq_twitter_card'] <> '' && SQ_Classes_Tools::getOption('sq_auto_twitter')) {
                        $buffer = @preg_replace('/<meta[^>]*(name|property)=["\'](twitter:)[^"\'>]+["\'][^>]*content=["\'][^"\'>]+["\'][^>]*>[\n\r]*/si', '', $buffer, -1);
                    }
                    if (isset($header['sq_json_ld']) && $header['sq_json_ld'] <> '' && SQ_Classes_Tools::getOption('sq_auto_jsonld')) {
                        $buffer = @preg_replace('/<script[^>]*type=["\']application\/ld\+json["\'][^>]*>[^>]*<\/script>[\n\r]*/si', '', $buffer, -1);
                    }
                    if (isset($header['sq_favicon']) && $header['sq_favicon'] <> '' && SQ_Classes_Tools::getOption('sq_auto_favicon')) {
                        $buffer = @preg_replace('/<link[^>]*rel=["\'](shortcut icon)["\'][^>]*>[\n\r]*/si', '', $buffer, -1);
                    }

                    $buffer = @preg_replace('/(<head(\s[^>]*|)>)/si', sprintf("$1\n%s", join("\n", $header)) . "\n", $buffer, 1);
                    $buffer = @preg_replace('/(<html(\s[^>]*|))/si', sprintf("$1%s", apply_filters('sq_html_prefix', false)), $buffer, 1);

                }
            }
        }

        return $buffer;
    }


    /**
     * Overwrite the header with the correct parameters
     *
     * @return array | false
     */
    public function getHeader() {
        //Build the Header
        $header = array();
        $header['sq_title'] = apply_filters('sq_title', false);


        //Get all header in array
        $header['sq_start'] = $this->setStart();

        $header['sq_noindex'] = apply_filters('sq_noindex', false); //
        //Add description in homepage if is set or add description in other pages if is not home page
        $header['sq_description'] = apply_filters('sq_description', false); //
        $header['sq_keywords'] = apply_filters('sq_keywords', false); //

        $header['sq_canonical'] = apply_filters('sq_canonical', false); //
        $header['sq_prevnext'] = apply_filters('sq_prevnext', false); //

        $header['sq_sitemap'] = apply_filters('sq_sitemap', false);
        $header['sq_favicon'] = apply_filters('sq_favicon', false);
        $header['sq_language'] = apply_filters('sq_language', false);
        $header['sq_dublin_core'] = apply_filters('sq_dublin_core', false);

        $header['sq_open_graph'] = apply_filters('sq_open_graph', false); //
        $header['sq_publisher'] = apply_filters('sq_publisher', false); //
        $header['sq_twitter_card'] = apply_filters('sq_twitter_card', false); //

        /* SEO optimizer tool */
        $header['sq_verify'] = apply_filters('sq_verify', false); //
        $header['sq_google_analytics'] = apply_filters('sq_google_analytics', false); //
        $header['sq_facebook_pixel'] = apply_filters('sq_facebook_pixel', false); //

        /* Structured Data */
        $header['sq_json_ld'] = apply_filters('sq_json_ld', false);
        $header['sq_end'] = $this->setEnd();

        //flush the header
        $header = @array_filter($header);

        if (count($header) == 2) {
            return false;
        }
        return $header;
    }

    /**
     * Show in footer
     */
    public function getFooter() {

        $footer = array();

        if ($this->_post && $this->_post->sq->doseo) {
            SQ_Classes_ObjController::getClass('SQ_Models_Services_Analytics');
            $footer['sq_google_analytics'] = apply_filters('sq_google_analytics_amp', false);

            SQ_Classes_ObjController::getClass('SQ_Models_Services_Pixel');
            $footer['sq_facebook_pixel'] = apply_filters('sq_facebook_pixel_amp', false);
        }

        $footer = @array_filter($footer);

        if (count($footer) > 0) {
            return join("\n", $footer);
        }

        return false;
    }
    /**************************************************************************************************/

    /**
     * Load all SEO classes
     */
    public function loadSeoLibrary() {
        if ($this->_post && $this->_post->sq->doseo) {
            //load all services
            if (SQ_Classes_Tools::getOption('sq_auto_title')) SQ_Classes_ObjController::getClass('SQ_Models_Services_Title');
            if (SQ_Classes_Tools::getOption('sq_auto_description')) SQ_Classes_ObjController::getClass('SQ_Models_Services_Description');
            if (SQ_Classes_Tools::getOption('sq_auto_keywords')) SQ_Classes_ObjController::getClass('SQ_Models_Services_Keywords');
            if (SQ_Classes_Tools::getOption('sq_auto_canonical')) SQ_Classes_ObjController::getClass('SQ_Models_Services_Canonical');
            if (SQ_Classes_Tools::getOption('sq_auto_canonical')) SQ_Classes_ObjController::getClass('SQ_Models_Services_PrevNext');
            if (SQ_Classes_Tools::getOption('sq_auto_sitemap')) SQ_Classes_ObjController::getClass('SQ_Models_Services_Sitemap');
            if (SQ_Classes_Tools::getOption('sq_auto_noindex')) SQ_Classes_ObjController::getClass('SQ_Models_Services_Noindex');
            if (SQ_Classes_Tools::getOption('sq_auto_facebook')) {
                SQ_Classes_ObjController::getClass('SQ_Models_Services_OpenGraph');
                SQ_Classes_ObjController::getClass('SQ_Models_Services_Publisher');

            }
            if (SQ_Classes_Tools::getOption('sq_auto_twitter')) SQ_Classes_ObjController::getClass('SQ_Models_Services_TwitterCard');
            if (SQ_Classes_Tools::getOption('sq_auto_favicon')) SQ_Classes_ObjController::getClass('SQ_Models_Services_Favicon');

            if (SQ_Classes_Tools::getOption('sq_auto_meta')) {
                SQ_Classes_ObjController::getClass('SQ_Models_Services_DublinCore');
            }

            //SQ_Models_Services_Favicon
            SQ_Classes_ObjController::getClass('SQ_Models_Services_Verify');
            SQ_Classes_ObjController::getClass('SQ_Models_Services_Pixel');
            SQ_Classes_ObjController::getClass('SQ_Models_Services_Analytics');

            if (SQ_Classes_Tools::getOption('sq_auto_jsonld')) SQ_Classes_ObjController::getClass('SQ_Models_Services_JsonLD');
        }
    }

    /**
     * Set the post for the frontend
     * @param WP_Post $curpost
     * @return SQ_Models_Frontend
     */
    public function setPost($curpost = null) {
        //Load the post with all the filters applied
        if ($this->_post = apply_filters('sq_post', $curpost)) {
            SQ_Classes_Tools::dump($this->_post);
            SQ_Classes_Tools::dump($this->_post->sq);
            //SQ_Classes_Tools::dump('Show Squirrly', 'isHomePage: ' . $this->isHomePage(), 'is_single: ' . is_single(), 'is_preview: ' . is_preview(), 'is_page: ' . is_page(), 'is_archive: ' . is_archive(), 'is_author: ' . is_author(), 'is_category: ' . is_category(), 'is_tag: ' . is_tag(), 'is_tax: ' . is_tax(), 'is_search: ' . is_search(), 'in_array: ' . (!empty($this->post_types) && in_array($this->post_type, $this->post_types)));
        }

        //Load the SEO Library before calling the filters
        if ($this->runSEOForThisPage()) {
            $this->loadSeoLibrary();
        }

        return $this;
    }

    /**
     * Return the post
     * @return SQ_Models_Domain_Post
     */
    public function getPost() {
        return $this->_post;
    }

    /**
     * Get the current post from Wordpress
     * @param integer $current_post
     * @return WP_Post
     */
    public function getWpPost($current_post) {
        global $post;

        if ($current_post instanceof WP_Post) {
            $post = $current_post;
        } else {
            if (function_exists('is_shop') && is_shop()) {
                $current_post = get_post(wc_get_page_id('shop'));
            } elseif ((is_single() || is_singular()) && isset($post->ID)) {
                $current_post = get_post($post->ID);
            }
        }

        $current_post = apply_filters('sq_current_post', $current_post);

        return $current_post;
    }


    /**
     * Replace the patterns from tags
     *
     * @param SQ_Models_Domain_Post $post
     * @return SQ_Models_Domain_Post | false
     */
    public function replacePatterns($post) {
        if ($post instanceof SQ_Models_Domain_Post) {
            $patterns = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_Patterns', $post->toArray());

            if ($sq_array = $post->sq->toArray()) {
                if (!empty($sq_array)) {
                    foreach ($sq_array as $name => $value) {
                        if ($name == 'sep' && $value <> '') {
                            //set the current post type sep loded in SQ_Models_Domain_Post domain
                            $patterns->sep = $value;
                        }

                        if (strpos($value, '{{') !== false && strpos($value, '}}') !== false) {
                            $sq_with_patterns[$name] = $value;
                        }
                    }

                    if (!empty($sq_with_patterns)) {
                        foreach ($patterns->getPatterns() as $key => $pattern) {
                            foreach ($sq_with_patterns as $name => $value) {
                                if (strpos($value, $pattern) !== false) {
                                    $post->sq->$name = str_replace($pattern, $patterns->$key, $post->sq->$name);
                                }
                            }
                        }
                    }

                    // SQ_Classes_Tools::dump($post, $patterns);
                    return $post;
                }
            }
        }
        return false;
    }


    /**
     * Build the current post with all the data required
     * @param WP_Post $post
     * @return SQ_Models_Domain_Post | false
     */
    public function getPostDetails($post) {
        if ($post instanceof WP_Post) {
            $post = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_Post', $post);
            SQ_Classes_Tools::dump($post);

            if ($post->ID > 0 && $post->post_type <> '') {
                //If it's front page
                if ($post->ID == get_option('page_on_front')) {
                    $post->debug = 'page_on_front:' . $post->ID;
                    $post->post_type = 'home';
                    $post->hash = md5($post->ID);
                    $post->url = home_url();
                    return $post;
                }

                //If it's front post
                if ($post->ID == get_option('page_for_posts')) {
                    $post->debug = 'page_for_posts:' . $post->ID;
                    $post->post_type = 'home';
                    $post->hash = md5($post->ID);
                    $post->url = home_url();
                    return $post;
                }

                //If it's a product
                if ($post->post_type == 'product') {
                    $post->debug = 'product:' . $post->ID;

                    $post->post_type = 'product';
                    $post->hash = md5($post->ID);
                    $post->url = get_permalink($post->ID);
                    $cat = get_the_terms($post->ID, 'product_cat');
                    if (!empty($cat) && count($cat) > 0) {
                        $post->category = $cat[0]->name;
                        if (isset($cat[0]->description)) $post->category_description = $cat[0]->description;
                    }
                    return $post;
                }

                //If it's a shop
                if ($post->post_type == 'page' && function_exists('wc_get_page_id') && $post->ID == wc_get_page_id('shop')) {
                    $post->debug = 'shop:' . $post->post_type . $post->ID;
                    $post->post_type = 'shop';
                    $post->hash = md5($post->ID);
                    $post->url = get_permalink($post->ID);
                    return $post;
                }

                if ($post->post_type == 'post' || $post->post_type == 'page' || $post->post_type == 'product') {
                    $post->debug = 'post/page/product:' . $post->ID;
                    $post->hash = md5($post->ID);
                    $post->url = get_permalink($post->ID);
                    return $post;
                }


                if ($post->post_type == 'attachment') {
                    $post->debug = 'attachment:' . $post->ID;
                    $post->hash = md5($post->ID);
                    $post->url = get_permalink($post->ID);
                    return $post;
                }

                if ($post->post_type = $this->getCutomPostType()) {
                    SQ_Classes_Tools::dump($post->post_type);

                    $post->debug = 'getCutomPostType1:' . $post->post_type . $post->ID;
                    $post->hash = md5($post->post_type . $post->ID);
                    $post->url = get_permalink($post->ID);
                    return $post;
                }

            }

            if ($post->post_type = $this->getCutomPostType()) {
                if ($post->post_name <> '') {
                    $post->debug = 'getCutomPostType2:' . $post->post_type . $post->post_name;
                    $post->hash = md5($post->post_type . $post->post_name);
                } else {
                    $post->debug = 'getCutomPostType3:' . $post->post_type;
                    $post->hash = md5($post->post_type);
                }

                $post->url = get_post_type_archive_link($post->post_type);
                return $post;
            }
        } else {
            if ($post instanceof SQ_Models_Domain_Post) {
                return $post;
            }

            SQ_Classes_Tools::dump('No WP Post');
            $post = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_Post', $post);
        }


        if ($this->isHomePage()) {
            $post->debug = 'isHomePage';
            $post->post_type = 'home';
            $post->hash = md5('wp_homepage');
            $post->post_title = get_bloginfo('name');
            $post->post_excerpt = get_bloginfo('description');
            $post->url = home_url();
            return $post;
        }

        if (is_tag()) {
            $tag = $this->getTagDetails();
            $post->post_type = 'tag';
            if (isset($tag->term_id)) {
                $post->post_title = $tag->name;
                $post->url = get_tag_link($tag->term_id);
                $post->debug = 'is_tag:' . $post->post_type . $tag->term_id;
                $post->hash = md5($post->post_type . $tag->term_id);
                $post->url = get_tag_link($tag->term_id);
                //
                $post->term_taxonomy_id = $tag->term_id;
                $post->taxonomy = $tag->taxonomy;
            }

            return $post;
        }

        if (is_tax()) {
            if ($tax = $this->getTaxonomyDetails()) {
                if (isset($tax->taxonomy) && $tax->taxonomy <> '') {
                    $post->post_type = 'tax-' . $tax->taxonomy;
                    if (isset($tax->term_id)) {
                        $post->debug = 'is_tax:' . $post->post_type . $tax->term_id;
                        $post->hash = md5($post->post_type . $tax->term_id);
                        $post->url = get_term_link($tax->term_id);
                        $post->post_title = ((isset($tax->name)) ? $tax->name : '');
                        $post->post_excerpt = ((isset($tax->description)) ? $tax->description : '');
                        //
                        $post->term_taxonomy_id = $tax->term_id;
                        $post->taxonomy = $tax->taxonomy;
                    }
                    return $post;
                }
            }

        }

        if (is_category()) {
            $category = $this->getCategoryDetails();
            $post->post_type = 'category';
            if (isset($category->term_id)) {
                $post->debug = 'is_category:' . $post->post_type . $category->term_id;

                $post->hash = md5($post->post_type . $category->term_id);
                $post->guid = $category->slug;
                $post->url = get_term_link($category->term_id);
                $post->post_title = $category->cat_name;
                $post->post_excerpt = $category->description;
                $post->category = $category->cat_name;
                $post->category_description = $category->description;
                //
                $post->term_taxonomy_id = $category->term_id;
                $post->taxonomy = 'category';
            }
            return $post;
        }

        if (is_search()) {
            $post->debug = 'is_search:' . $post->guid;
            $post->post_type = 'search';
            $post->hash = md5($post->post_type);

            //Set the search guid
            $post->url = home_url() . '/' . $post->post_type . '/';
            $search = get_query_var('s');
            if ($search !== '') {
                $post->url .= $search;
                $post->hash = md5($post->post_type . $search);
            }

            if ($post->post_name <> '') {
                $post->hash = md5($post->guid);
            }
            return $post;
        }

        if (is_author()) {
            if ($author = $this->getAuthorDetails()) {
                $post->post_type = 'profile';
                if (isset($author->ID)) {
                    $post->debug = 'is_author:' . $post->post_type . $author->ID;

                    $post->hash = md5($post->post_type . $author->ID);
                    $post->post_author = $author->display_name;
                    $post->post_title = $author->display_name;
                    $post->post_excerpt = $author->description;

                    //If buddypress installed
                    if (function_exists('bp_core_get_user_domain')) {
                        $post->url = bp_core_get_user_domain($author->ID);
                    } else {
                        $post->url = get_author_posts_url($author->ID);
                    }

                }
                return $post;
            }

        }

        //In case of post type in archieve like gurutheme
        if ($post->post_type = $this->getCutomPostType()) {
            $post->debug = 'cutomPostType:' . $post->post_type;
            SQ_Classes_Tools::dump($post);
            $post->hash = md5($post->post_type);

            if ((int)$post->term_taxonomy_id > 0) {
                $post->url = get_term_link($post->term_taxonomy_id);
            } else {
                $post->url = get_post_type_archive_link($post->post_type);
            }
            return $post;
        }

        if (is_archive()) {
            if ($archive = $this->getArchiveDetails()) {
                $post->post_type = 'archive';
                if ($archive->path <> '') {
                    $post->debug = 'is_archive:' . $post->post_type . $archive->path;

                    $post->hash = md5($post->post_type . $archive->path);
                    $post->url = $archive->url;
                    $post->post_date = date(get_option('date_format'), strtotime($archive->path));
                }

                return $post;
            }
        }

        if (is_404()) {
            $post->debug = 'is_404:' . $post->post_type;
            $post->post_type = '404';
            $post->hash = md5($post->post_type);
            if ($post->post_name <> '') {
                $post->hash = md5($post->post_type . $post->post_name);
            }
            return $post;
        }

        return false;
    }


    /**
     * Get the Sq from database
     * @param string $hash
     * @param integer $post_id
     * @return mixed|null
     */
    public function getSqSeo($hash = null, $post_id = 0, $meta = null) {
        global $wpdb;
        $metas = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_Sq');
        if (isset($hash) && $hash <> '') {
            $blog_id = get_current_blog_id();

            $query = "SELECT * FROM " . $wpdb->prefix . strtolower(_SQ_DB_) . " WHERE blog_id = '" . (int)$blog_id . "' AND url_hash = '" . $hash . "';";

            if ($row = $wpdb->get_row($query, OBJECT)) {
                $metas = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_Sq', maybe_unserialize($row->seo));
            }
        } elseif ((int)$post_id > 0) {
            $blog_id = get_current_blog_id();

            $query = "SELECT * FROM " . $wpdb->prefix . strtolower(_SQ_DB_) . " WHERE blog_id = '" . (int)$blog_id . "' AND post_id = '" . (int)$post_id . "';";

            if ($row = $wpdb->get_row($query, OBJECT)) {
                $metas = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_Sq', maybe_unserialize($row->seo));
            }
        }

        if (isset($meta) && isset($metas->$meta)) {
            return $metas->$meta;
        }
        return $metas;
    }

    /**
     * Check if other plugin are/were installed and don't change the SEO
     *
     * @param integer $post_id
     * @param string $meta
     * @return boolean
     */
    public function getAdvancedMeta($post_id, $meta = null) {
        return $this->getSqSeo(null, $post_id, $meta);
    }

    /**
     * Add page if needed
     * @param $url
     * @return string
     */
    public function addPaged($post) {
        if (is_paged() && isset($post->url) && $post->url <> '') {
            $page = (int)get_query_var('paged');
            if ($page && $page > 1) {
                $post->url = trailingslashit($post->url) . "page/" . "$page/";
            }
        }
        return $post;
    }

    /**
     * Get information about the Archive
     * @return array|bool|mixed|object
     */
    private function getArchiveDetails() {
        if (is_date()) {
            $archive = false;
            if (is_day()) {
                $archive = array(
                    'path' => get_query_var('year') . '-' . get_query_var('monthnum') . '-' . get_query_var('day'),
                    'url' => get_day_link(get_query_var('year'), get_query_var('monthnum'), get_query_var('day')),
                );
            } elseif (is_month()) {
                $archive = array(
                    'path' => get_query_var('year') . '-' . get_query_var('monthnum'),
                    'url' => get_month_link(get_query_var('year'), get_query_var('monthnum')),
                );
            } elseif (is_year()) {
                $archive = array(
                    'path' => get_query_var('year'),
                    'url' => get_year_link(get_query_var('year')),
                );
            }

            if (!empty($archive)) {
                return json_decode(json_encode($archive));
            }
        }

        return false;
    }

    /**
     * Get the keyword fof this URL
     * @return array|bool|false|mixed|null|object|string|WP_Error|WP_Term
     */
    private function getTagDetails() {
        global $tag;
        $temp = str_replace('&#8230;', '...', single_tag_title('', false));

        foreach (get_taxonomies() as $tax) {
            if ($tax <> 'category') {
                if ($tag = get_term_by('name', $temp, $tax))
                    break;
            }
        }

        return $tag;
    }

    /**
     * Get the taxonomies details for this URL
     * @return array|bool|false|mixed|null|object|string|WP_Error|WP_Term
     */
    private function getTaxonomyDetails() {
        $term = false;

        if ($id = get_queried_object_id()) {
            $term = get_term($id);
            SQ_Classes_Tools::dump($id, $term);
        }
        return $term;
    }

    /**
     * Get the category details for this URL
     * @return array|null|object|WP_Error
     */
    private function getCategoryDetails() {
        return get_category(get_query_var('cat'), false);
    }

    /**
     * Get the profile details for this URL
     * @return object
     */
    public function getAuthorDetails() {
        $author = false;
        global $authordata;
        if (isset($authordata->data)) {
            $author = $authordata->data;
            $author->description = get_the_author_meta('description');
            SQ_Classes_Tools::dump($author);
        }
        return $author;
    }


    /**
     * Get the custom post type
     * @return object
     */
    public function getCutomPostType() {
        if ($post_type = get_query_var('post_type')) {
            if (is_array($post_type) && !empty($post_type)) {
                $post_type = current($post_type);
            }
        }

        if ($post_type <> '') {
            return $post_type;
        }

        return false;
    }

    /**
     * Check if is the homepage
     *
     * @return bool
     */
    public function isHomePage() {
        global $wp_query;

        return (is_home() || (isset($wp_query->query) && empty($wp_query->query) && !is_preview()));
    }

    /**
     * Check if the header is an HTML Header
     * @return bool
     */
    public function isHtmlHeader() {
        $headers = headers_list();

        foreach ($headers as $index => $value) {
            if (strpos($value, ':') !== false) {
                $exploded = @explode(': ', $value);
                if (count($exploded) > 1) {
                    $headers[$exploded[0]] = $exploded[1];
                }
            }
        }
        if (isset($headers['Content-Type'])) {
            if (strpos($headers['Content-Type'], 'text/html') !== false) {
                return true;
            }
        } else {
            return false;
        }

        return false;
    }

    /**
     * Is Quick SEO enabled for this page?
     * @return bool
     */
    public function runSEOForThisPage() {

        if (SQ_Classes_Tools::getValue('sq_use') == 'off') {
            return false;
        }

        if (!$this->isHtmlHeader()) {
            return false;
        }

        if ($this->_post && isset($this->_post->hash)) {
            return true;
        }

        return false;
    }

    /**
     * Pack HTML prefix if exists
     * @param $prefix
     * @return string
     */
    public function packPrefix($prefix) {
        if ($prefix <> '') {
            return ' prefix="' . $prefix . '"';
        }
        return '';
    }

}