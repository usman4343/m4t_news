<?php

/**
 * Set the patterns
 */
class SQ_Core_BlockPatterns extends SQ_Classes_BlockController {

    function hookGetContent() {
        parent::preloadSettings();
        SQ_Classes_ObjController::getClass('SQ_Classes_Error')->hookNotices();
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('patterns');
    }

    /**
     * Called when Post action is triggered
     *
     * @return void
     */
    public function action() {
        parent::action();
        switch (SQ_Classes_Tools::getValue('action')) {

            case 'sq_savepatters':
                if (!current_user_can('manage_options')) {
                    return;
                }

                $patterns = SQ_Classes_Tools::getValue('sq_patterns', array());
                if (!empty($patterns)) {
                    SQ_Classes_Tools::saveOptions("patterns", $patterns);
                }

                //If a new post type is added
                $newposttype = SQ_Classes_Tools::getValue('sq_select_post_types', '');
                if ($newposttype <> '') {
                    $patterns[$newposttype] = $patterns['custom'];
                    if (!empty($patterns)) {
                        SQ_Classes_Tools::saveOptions("patterns", $patterns);
                    }
                }

                //empty the cache on settings changed
                SQ_Classes_Tools::emptyCache();
                break;
        }
    }


}
