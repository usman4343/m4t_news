<?php

/**
 * The class handles the theme part in WP
 */
class SQ_Classes_DisplayController {

    private static $cache;

    public function init() {
        /* Load the global CSS file */
        self::loadMedia('global');
    }

    /**
     * Check if ajax
     * @return bool
     */
    private static function _isAjax() {
        $url = (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : false);
        if ($url && (strpos($url, str_replace(get_bloginfo('url'), '', admin_url('admin-ajax.php', 'relative'))) !== false)) {
            return true;
        }

        return false;
    }

    /**
     * echo the css link from theme css directory
     *
     * @param string $uri The name of the css file or the entire uri path of the css file
     * @param string $params : trigger, media
     *
     * @return string
     */
    public static function loadMedia($uri = '', $params = array('trigger' => true, 'media' => 'all')) {
        if (self::_isAjax()) {
            return;
        }

        $css_uri = '';
        $js_uri = '';

        if (!isset($params['media'])) {
            $params['media'] = 'all';
        }

        if (isset(self::$cache[$uri]))
            return;
        self::$cache[$uri] = true;

        /* if is a custom css file */
        if (strpos($uri, '//') === false) {
            if (strpos($uri, '.') !== false) {
                $name = strtolower(_SQ_NAMESPACE_ . substr($uri, 0, strpos($uri, '.')));
            } else {
                $name = strtolower(_SQ_NAMESPACE_ . $uri);
            }
            if (strpos($uri,'.css') !== false && file_exists(_SQ_THEME_DIR_ . 'css/' . strtolower($uri))) {
                $css_uri = _SQ_THEME_URL_ . 'css/' . strtolower($uri);
            }
            if (strpos($uri,'.js') !== false && file_exists(_SQ_THEME_DIR_ . 'js/' . strtolower($uri))) {
                $js_uri = _SQ_THEME_URL_ . 'js/' . strtolower($uri);
            }

            if (file_exists(_SQ_THEME_DIR_ . 'css/' . strtolower($uri) . '.css')) {
                $css_uri = _SQ_THEME_URL_ . 'css/' . strtolower($uri) . '.css';
            }
            if (file_exists(_SQ_THEME_DIR_ . 'js/' . strtolower($uri) . '.js')) {
                $js_uri = _SQ_THEME_URL_ . 'js/' . strtolower($uri) . '.js';
            }
        } else {
            $name = strtolower(basename($uri));
            if (strpos($uri, '.css') !== FALSE)
                $css_uri = $uri;
            elseif (strpos($uri, '.js') !== FALSE) {
                $js_uri = $uri;
            }
        }


        if ($css_uri <> '') {
            if (!wp_style_is($name)) {
                wp_enqueue_style($name, $css_uri, null, SQ_VERSION_ID, $params['media']);
            }

            if (isset($params['trigger']) && $params['trigger'] === true) {
                wp_print_styles(array($name));
            }
        }

        if ($js_uri <> '') {
            if (!wp_script_is($name)) {
                wp_enqueue_script($name, $js_uri, array('jquery'), SQ_VERSION_ID);
            }
            if (isset($params['trigger']) && $params['trigger'] === true) {
                wp_print_scripts(array($name));
            }
        }
    }


    /**
     * return the block content from theme directory
     *
     * @param $block
     * @param $view
     * @return bool|string
     */
    public function getView($block, $view) {
        if (file_exists(_SQ_THEME_DIR_ . $block . '.php')) {
            ob_start();
            include(_SQ_THEME_DIR_ . $block . '.php');
            return ob_get_clean();
        }

        return false;
    }
}
