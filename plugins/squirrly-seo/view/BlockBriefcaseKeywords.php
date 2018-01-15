<div id="sq_settings">
    <div class="col-md-12 no-t-m m-b-lg no-p">
        <div class="panel panel-transparent">
            <div class="panel-heading">
                <span class="sq_briefcase_icon"></span>
                <div id="sq_posts_title">
                    <?php if (SQ_Classes_Tools::getIsset('skeyword')) { ?>
                        <div class="sq_serp_settings_button m-t-sm" style="float: right;  margin-right: 10px;">
                            <button type="button" class="btn btn-info p-v-xs" onclick="location.href = '?page=sq_briefcase';" style="cursor: pointer"><?php echo __('Show All') ?></button>
                        </div>
                    <?php } ?>

                    <?php _e('Briefcase Keywords (Beta)', _SQ_PLUGIN_NAME_); ?>
                </div>
            </div>
            <div class="panel-body">

                <div class="col-md-12">
                    <form method="post" style="float: right">
                        <input type="search" id="post-search-input" autofocus name="skeyword" value="<?php echo htmlspecialchars(SQ_Classes_Tools::getValue('skeyword')) ?>"/>
                        <input type="submit" class="button" value="<?php echo __('Search Keyword', _SQ_PLUGIN_NAME_) ?>"/>
                    </form>
                    
                    <button class="btn btn-success" onclick="jQuery('.sq_add_keyword').toggle();"><?php _e('Add new keyword', _SQ_PLUGIN_NAME_); ?></button>
                    <?php if (!SQ_Classes_Tools::getOption('sq_google_serp_active')) { ?>
                        <?php if (isset($view->keywords) && !empty($view->keywords)) { ?>
                            <a href="<?php echo SQ_Classes_Tools::getBusinessLink() ?>" class="btn btn-warning"><?php _e('See the Google Ranks for these Keywords', _SQ_PLUGIN_NAME_); ?></a>
                        <?php } ?>
                    <?php } else { ?>
                        <a href="?page=sq_posts" class="btn btn-default"><?php _e('Go to  Analytics', _SQ_PLUGIN_NAME_); ?></a>
                    <?php } ?>


                </div>

                <div class="col-md-12 m-b-lg">
                    <div class="sq_add_keyword panel panel-gray" style="display: none">
                        <div class="panel-body">
                            <div class="col-md-12 m-t-md m-b-lg">
                                <div class="form-group">
                                    <label for="sq_keyword"><?php _e('Keyword', _SQ_PLUGIN_NAME_); ?></label>
                                    <input type="text" class="form-control" id="sq_keyword" placeholder="<?php echo __('Enter a Keyword (2-4 words)', _SQ_PLUGIN_NAME_) ?>">
                                </div>
                                <button type="button" id="sq_save_keyword" class="btn btn-success"><?php _e('Add Keyword', _SQ_PLUGIN_NAME_); ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="tablenav top">
                        <?php echo $view->listTable->pagination('top') ?>
                    </div>
                    <div class="panel panel-white">

                        <div class="panel-body">
                            <?php if (isset($view->keywords) && !empty($view->keywords)) { ?>

                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 40%;"><?php echo __('Keyword', _SQ_PLUGIN_NAME_) ?></th>
                                        <th style="width: 5%;" align="right"><?php echo __('Used', _SQ_PLUGIN_NAME_) ?></th>
                                        <th style="width: 37%;"><?php echo __('Data', _SQ_PLUGIN_NAME_) ?></th>
                                        <th style="width: 8%;"></th>
                                        <th style="width: 2%;"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php


                                    foreach ($view->keywords as $key => $row) {

                                        $research = '';
                                        if ($row->research <> '') {
                                            $research = json_decode($row->research);
                                        }
                                        ?>
                                        <tr id="sq_row_<?php echo $row->id ?>">
                                            <td scope="row"><?php echo($view->index + $key + 1) ?></td>
                                            <td><?php echo $row->keyword ?></td>

                                            <td class="sq_open_subrow" align="right" style="cursor: pointer" data-id="<?php echo $row->id ?>" data-keyword="<?php echo htmlspecialchars($row->keyword) ?>"><?php echo($row->count > 0 ? $row->count . ' <i class="fa fa-sort-desc fa_showmore" style="color: rgb(88, 158, 228)"></i>' : '0') ?> </td>
                                            <td>
                                                <ul class="sq_row_stats"><?php
                                                    if ($research <> '') {
                                                        if ($research->sc) {
                                                            ?>
                                                            <li>
                                                                <i class="fa fa-users" style="color: <?php echo $research->sc->color ?>" title="<?php echo __('Competition', _SQ_PLUGIN_NAME_) ?>"></i>
                                                                <span style="color: <?php echo $research->sc->color ?>" title="<?php echo __('Competition', _SQ_PLUGIN_NAME_) ?>"><?php echo($research->sc->text <> '' ? $research->sc->text : __('-', _SQ_PLUGIN_NAME_)) ?></span>
                                                            </li>
                                                            <?php
                                                        }
                                                        if ($research->sv) {
                                                            ?>
                                                            <li>
                                                                <i class="fa fa-search" style="color: <?php echo $research->sv->color ?>" title="<?php echo __('SEO Search Volume', _SQ_PLUGIN_NAME_) ?>"></i>
                                                                <span style="color: <?php echo $research->sv->color ?>" title="<?php echo __('SEO Search Volume', _SQ_PLUGIN_NAME_) ?>"><?php echo($research->sv->text <> '' ? $research->sv->text : __('-', _SQ_PLUGIN_NAME_)) ?></span>
                                                            </li>
                                                            <?php
                                                        }
                                                        if ($research->tw) {
                                                            ?>
                                                            <li>
                                                                <i class="fa fa-comments-o" style="color: <?php echo $research->tw->color ?>" title="<?php echo __('Recent discussions', _SQ_PLUGIN_NAME_) ?>"></i>
                                                                <span style="color: <?php echo $research->tw->color ?>" title="<?php echo __('Recent discussions', _SQ_PLUGIN_NAME_) ?>"><?php echo($research->tw->text <> '' ? $research->tw->text : __('-', _SQ_PLUGIN_NAME_)) ?></span>
                                                            </li>
                                                            <?php
                                                        }
                                                        if ($research->td) {
                                                            ?>
                                                            <li>
                                                                <i class="fa fa-bar-chart" style="color: <?php echo $research->td->color ?>" title="<?php echo __('Trending', _SQ_PLUGIN_NAME_) ?>"></i>
                                                                <span style="color: <?php echo $research->td->color ?>" title="<?php echo __('Trending', _SQ_PLUGIN_NAME_) ?>"><?php echo($research->td->text <> '' ? $research->td->text : __('-', _SQ_PLUGIN_NAME_)) ?></span>
                                                            </li>
                                                            <?php
                                                        }

                                                        ?>
                                                        <li>(<?php echo($row->country ? $row->country : 'us') ?>)</li><?php
                                                    } else { ?>
                                                        <li>
                                                            <button class="btn btn-success sq_doresearch" data-keyword="<?php echo htmlspecialchars($row->keyword) ?>"><?php echo __('Do a research', _SQ_PLUGIN_NAME_); ?></button>
                                                        </li>
                                                        <?php
                                                    }

                                                    //echo $row->research
                                                    ?></ul>
                                            </td>
                                            <td>
                                                <button class="btn btn-info sq_research_selectit" data-post="<?php echo admin_url('post-new.php') ?>" data-keyword="<?php echo htmlspecialchars($row->keyword) ?>"><?php echo __('Use Keyword', _SQ_PLUGIN_NAME_) ?></button>
                                            </td>
                                            <td style="position: relative">
                                                <button type="button" class="btn btn-default sq_delete_keyword" style="position: absolute; left: -10px;" data-id="<?php echo $row->id ?>" title="<?php _e('Delete', _SQ_PLUGIN_NAME_); ?>">x</button>
                                            </td>
                                        </tr>
                                        <tr id="sq_subrow_<?php echo $row->id ?>" class="sq_subrow" style="display: none">
                                            <td colspan="6" style="padding: 0 !important;"></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    </tbody>
                                </table>

                            <?php } else { ?>
                                <div class="panel-body">
                                    <h3 class="text-center"><?php echo $view->error; ?></h3>

                                    <div class="col-md-9 m-b-lg"></div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="tablenav bottom">
                        <?php echo $view->listTable->pagination('bottom') ?>
                    </div>

                </div>

            </div>
        </div>

    </div>

</div>