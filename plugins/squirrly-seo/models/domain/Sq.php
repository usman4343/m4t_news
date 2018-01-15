<?php

class SQ_Models_Domain_Sq extends SQ_Models_Abstract_Domain {

    protected $_doseo;
    protected $_noindex;
    protected $_nofollow;
    protected $_nositemap;
    //
    protected $_title;
    protected $_description;
    protected $_keywords;
    protected $_canonical;

    protected $_robots;
    protected $_cornerstone;
    //
    protected $_tw_media;
    protected $_tw_title;
    protected $_tw_description;
    protected $_tw_type;
    //
    protected $_og_title;
    protected $_og_description;
    protected $_og_author;
    protected $_og_type;
    protected $_og_media;

    //
//    protected $_jsonld_title;
//    protected $_jsonld_description;
//    protected $_jsonld_type;
//    protected $_jsonld_media;

    // lengths
    protected $_title_maxlength = 75;
    protected $_description_maxlength = 165;
    protected $_og_title_maxlength = 75;
    protected $_og_description_maxlength = 110;
    protected $_tw_title_maxlength = 75;
    protected $_tw_description_maxlength = 100;
    protected $_jsonld_title_maxlength = 75;
    protected $_jsonld_description_maxlength = 110;

    // for sq_adm patterns
    protected $_patterns;
    //get custom post type separator
    protected $_sep;


    public function getDoseo() {
        if (!isset($this->_doseo)) {
            $this->_doseo = 1;
        }

        return (int)$this->_doseo;
    }

    public function getNoindex() {
        if (!isset($this->_noindex)) {
            $this->_noindex = 0;
        }

        return (int)$this->_noindex;
    }

    public function getNositemap() {
        if (!isset($this->_nositemap)) {
            $this->_nositemap = 0;
        }

        return (int)$this->_nositemap;
    }

    public function getNofollow() {
        if (!isset($this->_nofollow)) {
            $this->_nofollow = 0;
        }

        return (int)$this->_nofollow;
    }

    public function getOg_type() {
        if (!isset($this->_og_type)) {
            global $post;
            if (isset($post->post_type)) {
                $this->_og_type = $this->getPostType($post->post_type);
            }
        }

        return $this->_og_type;
    }


    public function getPostType($type) {
        $types = array(
            'home' => 'website',
            'profile' => 'profile',
            'post' => 'article',
            'page' => 'article',
            'book' => 'book',
            'music' => 'music',
            'product' => 'product',
            'video' => 'video');

        if (in_array($type, array_keys($types))) {
            return $types[$type];
        }

        return $types['home'];
    }

    public function getClearedTitle() {
        if (isset($this->_title)) {
            $this->_title = $this->clearTitle($this->_title);
        }

        return $this->_title;
    }

    public function getClearedDescription() {
        if (isset($this->_description)) {
            $this->_description = $this->clearDescription($this->_description);
        }

        return $this->_description;
    }

    /**
     * Clear and format the title for all languages
     * @param $title
     * @return string
     */
    public function clearTitle($title) {
        return SQ_Classes_Tools::clearTitle($title);
    }

    /**
     * Clear and format the descrition for all languages
     * @param $description
     * @return mixed|string
     */
    public function clearDescription($description) {
        return SQ_Classes_Tools::clearDescription($description);
    }
}
