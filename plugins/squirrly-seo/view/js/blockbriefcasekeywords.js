(function ($) {

    $.fn.sq_Briefcase = function () {
        var $this = this;

        $this.listenAdd = function () {
            $this.find('#sq_save_keyword').on('click', function () {
                var $button = $(this);
                var $keyword = $this.find('#sq_keyword').val();
                $button.addClass('sq_minloading');
                $.post(
                    sqQuery.ajaxurl,
                    {
                        action: 'sq_briefcase_addkeyword',
                        keyword: $keyword,
                        nonce: sqQuery.nonce
                    }
                ).done(function (response) {
                    if (typeof response.saved !== 'undefined') {
                        location.reload();
                        $button.removeClass('sq_minloading');
                    } else {
                        $.sq_showMessage(response.error).addClass('sq_error');
                    }
                }).fail(function () {
                    $button.removeClass('sq_minloading');
                }, 'json');
            });
        };

        $this.listenResearch = function () {
            $this.find('.sq_doresearch').on('click', function () {
                var $button = $(this);
                var $keyword = $(this).data('keyword');
                $button.addClass('sq_minloading');

                $.post(
                    sqQuery.ajaxurl,
                    {
                        action: 'sq_briefcase_doresearch',
                        keyword: $keyword,
                        nonce: sqQuery.nonce
                    }
                ).done(function (response) {
                    if (typeof response.error !== 'undefined') {
                        if (response.error === 'limit_exceeded') {
                            $.sq_showMessage(response.error).addClass('sq_error');
                        } else {
                            $.sq_showMessage(response.error, 10000).addClass('sq_error');
                        }
                        $button.removeClass('sq_minloading');
                    } else {
                        location.reload();
                    }

                }).fail(function () {
                    $button.removeClass('sq_minloading');
                }, 'json');
            });
        };

        $this.listenCount = function () {
            $this.find('.sq_open_subrow').on('click', function () {
                var $button = $(this);
                var $id = $(this).data('id');
                var $keyword = $(this).data('keyword');
                $this.find('.fa_showmore').removeClass('fa-sort-asc');

                if( $('#sq_subrow_' + $id).is(':visible')){
                    $('#sq_subrow_' + $id).hide();
                    return;
                }

                $button.addClass('sq_minloading');

                $.post(
                    sqQuery.ajaxurl,
                    {
                        action: 'sq_briefcase_article',
                        keyword: $keyword,
                        nonce: sqQuery.nonce
                    }
                ).done(function (response) {
                    if (typeof response.error !== 'undefined') {
                        if (response.error === 'limit_exceeded') {
                            $.sq_showMessage(response.error).addClass('sq_error');
                        } else {
                            $.sq_showMessage(response.error, 10000).addClass('sq_error');
                        }
                    } else if (typeof response.articles !== 'undefined') {
                        $('.sq_subrow').hide();
                        $('#sq_subrow_' + $id).find('td').html(response.articles);
                        $('#sq_subrow_' + $id).show();

                        $this.listenRecheck();
                    }
                    $('#sq_row_' + $id).find('.fa_showmore').addClass('fa-sort-asc');

                    $button.removeClass('sq_minloading');
                }).fail(function () {
                    $button.removeClass('sq_minloading');
                }, 'json');
            });
        };

        $this.find('.sq_research_selectit').on('click', function () {
            $(this).addClass('sq_minloading');
            var $keyword = $(this).data('keyword');
            $.sq_setCookie('sq_keyword', $keyword);

            location.href = $(this).data('post');
        });


        $this.listenDelete = function () {
            $this.find('.sq_delete_keyword').on('click', function () {
                if (confirm('Are you sure ?')) {
                    var $button = $(this);
                    var $id = $(this).data('id');
                    $button.addClass('sq_minloading');
                    $.post(
                        sqQuery.ajaxurl,
                        {
                            action: 'sq_briefcase_deletekeyword',
                            id: $id,
                            nonce: sqQuery.nonce
                        }
                    ).done(function (response) {
                        if (typeof response.deleted !== 'undefined') {
                            $this.find('#sq_row_' + $id).remove();
                            $this.find('#sq_subrow_' + $id).remove();
                        } else {
                            $.sq_showMessage(response.error).addClass('sq_error');
                        }
                        $button.removeClass('sq_minloading');
                    }).fail(function () {
                        $button.removeClass('sq_minloading');
                    }, 'json');
                }
            });
        };

        $this.listenRecheck = function () {
            $this.find('.sq_rank_refresh').on('click', function () {
                var $button = $(this);
                var $id = $(this).data('id');
                var $keyword = $(this).data('keyword');
                $this.find('#sq_rank_value' + $id).addClass('sq_minloading');
                $button.addClass('sq_minloading');
                $.post(
                    sqQuery.ajaxurl,
                    {
                        action: 'sq_serp_refresh_post',
                        id: $id,
                        keyword: $keyword,
                        nonce: sqQuery.nonce
                    }
                ).done(function (response) {
                    if (typeof response.rank !== 'undefined') {
                        $('#sq_rank_value' + $id).html(response.rank);
                        if (typeof response.datetime !== 'undefined') {
                            $('#sq_rank_value' + $id).attr('title',response.datetime);
                        }
                    } else {
                        $.sq_showMessage(response.error).addClass('sq_error');
                    }
                    $this.find('#sq_rank_value' + $id).removeClass('sq_minloading');
                    $button.removeClass('sq_minloading');
                }).fail(function () {
                    $this.find('#sq_rank_value' + $id).removeClass('sq_minloading');
                    $button.removeClass('sq_minloading');
                }, 'json');
            });
        };


        $this.listenAdd();
        $this.listenCount();
        $this.listenResearch();
        $this.listenDelete();


        return $this;
    };


    if ($('#sq_settings').length > 0) {
        $('#sq_settings').sq_Briefcase();
    } else {
        $(document).ready(function () {
            $('#sq_settings').sq_Briefcase();
        });
    }

})(jQuery);

