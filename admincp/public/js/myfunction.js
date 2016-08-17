/*
 * Layout
 */


(function () {
    //Get saved layout type from LocalStorage
    var layoutStatus = localStorage.getItem('ma-layout-status');
    if (layoutStatus == 1) {
        $('body').addClass('sw-toggled');
        $('#tw-switch').prop('checked', true);
    }

    $('body').on('change', '#toggle-width input:checkbox', function () {
        if ($(this).is(':checked')) {
            setTimeout(function () {
                $('body').addClass('toggled sw-toggled');
                localStorage.setItem('ma-layout-status', 1);
            }, 250);
        }
        else {
            setTimeout(function () {
                $('body').removeClass('toggled sw-toggled');
                localStorage.setItem('ma-layout-status', 0);
                $('.main-menu > li').removeClass('animated');
            }, 250);
        }
    });
})();


/*
 * Detact Mobile Browser
 */
if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
    $('html').addClass('ismobile');
}

$(document).ready(function () {
    /*
     * Top Search
     */
    (function () {
        $('body').on('click', '#top-search > a', function (e) {
            e.preventDefault();

            $('#header').addClass('search-toggled');
        });

        $('body').on('click', '#top-search-close', function (e) {
            e.preventDefault();

            $('#header').removeClass('search-toggled');
        });
    })();

    /*
     * Sidebar
     */
    (function () {
        //Toggle
        $('body').on('click', '#menu-trigger, #chat-trigger', function (e) {
            e.preventDefault();
            var x = $(this).data('trigger');

            $(x).toggleClass('toggled');
            $(this).toggleClass('open');
            $('body').toggleClass('modal-open');

            //Close opened sub-menus
            $('.sub-menu.toggled').not('.active').each(function () {
                $(this).removeClass('toggled');
                $(this).find('ul').hide();
            });


            $('.profile-menu .main-menu').hide();

            if (x == '#sidebar') {

                $elem = '#sidebar';
                $elem2 = '#menu-trigger';

                $('#chat-trigger').removeClass('open');

                if (!$('#chat').hasClass('toggled')) {
                    $('#header').toggleClass('sidebar-toggled');
                }
                else {
                    $('#chat').removeClass('toggled');
                }
            }


            //When clicking outside
            if ($('#header').hasClass('sidebar-toggled')) {
                $(document).on('click', function (e) {
                    if (($(e.target).closest($elem).length === 0) && ($(e.target).closest($elem2).length === 0)) {
                        setTimeout(function () {
                            $('body').removeClass('modal-open');
                            $($elem).removeClass('toggled');
                            $('#header').removeClass('sidebar-toggled');
                            $($elem2).removeClass('open');
                        });
                    }
                });
            }
        })

        //Submenu
        $('body').on('click', '.sub-menu > a', function (e) {
            e.preventDefault();
            $(this).next().slideToggle(200);
            $(this).parent().toggleClass('toggled');
        });
    })();

    /*
     * Clear Notification
     */
    $('body').on('click', '[data-clear="notification"]', function (e) {
        e.preventDefault();

        var x = $(this).closest('.listview');
        var y = x.find('.lv-item');
        var z = y.size();

        $(this).parent().fadeOut();

        x.find('.list-group').prepend('<i class="grid-loading hide-it"></i>');
        x.find('.grid-loading').fadeIn(1500);


        var w = 0;
        y.each(function () {
            var z = $(this);
            setTimeout(function () {
                z.addClass('animated fadeOutRightBig').delay(1000).queue(function () {
                    z.remove();
                });
            }, w += 150);
        })

        //Popup empty message
        setTimeout(function () {
            $('#notifications').addClass('empty');
        }, (z * 150) + 200);
    });

    /*
     * Dropdown Menu
     */
    if ($('.dropdown')[0]) {
        //Propagate
        $('body').on('click', '.dropdown.open .dropdown-menu', function (e) {
            e.stopPropagation();
        });

        $('.dropdown').on('shown.bs.dropdown', function (e) {
            if ($(this).attr('data-animation')) {
                $animArray = [];
                $animation = $(this).data('animation');
                $animArray = $animation.split(',');
                $animationIn = 'animated ' + $animArray[0];
                $animationOut = 'animated ' + $animArray[1];
                $animationDuration = ''
                if (!$animArray[2]) {
                    $animationDuration = 500; //if duration is not defined, default is set to 500ms
                }
                else {
                    $animationDuration = $animArray[2];
                }

                $(this).find('.dropdown-menu').removeClass($animationOut)
                $(this).find('.dropdown-menu').addClass($animationIn);
            }
        });

        $('.dropdown').on('hide.bs.dropdown', function (e) {
            if ($(this).attr('data-animation')) {
                e.preventDefault();
                $this = $(this);
                $dropdownMenu = $this.find('.dropdown-menu');

                $dropdownMenu.addClass($animationOut);
                setTimeout(function () {
                    $this.removeClass('open')

                }, $animationDuration);
            }
        });
    }


    /*
     * Auto Hight Textarea
     */
    if ($('.auto-size')[0]) {
        autosize($('.auto-size'));
    }

    /*
     * Custom Scrollbars
     */
    function scrollbar(className, color, cursorWidth) {
        $(className).niceScroll({
            cursorcolor: color,
            cursorborder: 0,
            cursorborderradius: 0,
            cursorwidth: cursorWidth,
            bouncescroll: true,
            mousescrollstep: 100
        });
    }

    //Scrollbar for HTML(not mobile) but not for login page
    if (!$('html').hasClass('ismobile')) {
        if (!$('.login-content')[0]) {
            //scrollbar('html', 'rgba(0,0,0,0.3)', '5px');
        }

        //Scrollbar Tables
        if ($('.table-responsive')[0]) {
            scrollbar('.table-responsive', 'rgba(0,0,0,0.5)', '5px');
        }

        //Scrill bar for Chosen
        if ($('.chosen-results')[0]) {
            scrollbar('.chosen-results', 'rgba(0,0,0,0.5)', '5px');
        }

        //Scroll bar for tabs
        if ($('.tab-nav')[0]) {
            scrollbar('.tab-nav', 'rgba(0,0,0,0)', '1px');
        }

        //Scroll bar for dropdowm-menu
        if ($('.dropdown-menu .c-overflow')[0]) {
            scrollbar('.dropdown-menu .c-overflow', 'rgba(0,0,0,0.5)', '0px');
        }

        //Scrollbar for rest
        if ($('.c-overflow')[0]) {
            //scrollbar('.c-overflow', 'rgba(0,0,0,0.5)', '5px');
        }
    }


    /*
     * Profile Menu
     */
    $('body').on('click', '.profile-menu > a', function (e) {
        e.preventDefault();
        $(this).parent().toggleClass('toggled');
        $(this).next().slideToggle(200);
    });

    /*
     * Text Feild
     */

    //Add blue animated border and remove with condition when focus and blur
    if ($('.fg-line')[0]) {
        $('body').on('focus', '.form-control', function () {
            $(this).closest('.fg-line').addClass('fg-toggled');
        })

        $('body').on('blur', '.form-control', function () {
            var p = $(this).closest('.form-group');
            var i = p.find('.form-control').val();

            if (p.hasClass('fg-float')) {
                if (i.length == 0) {
                    $(this).closest('.fg-line').removeClass('fg-toggled');
                }
            }
            else {
                $(this).closest('.fg-line').removeClass('fg-toggled');
            }
        });
    }

    //Add blue border for pre-valued fg-flot text feilds
    if ($('.fg-float')[0]) {
        $('.fg-float .form-control').each(function () {
            var i = $(this).val();

            if (i !== null && !i.length == 0) {
                $(this).closest('.fg-line').addClass('fg-toggled');
            }

        });
    }

    /*
     * Tag Select
     */
    //if ($('.tag-select')[0]) {
    //    $('.tag-select').chosen({
    //        width: '100%',
    //        allow_single_deselect: true
    //    });
    //}

    /*
     * Input Slider
     */
    //Basic
    //if ($('.input-slider')[0]) {
    //    $('.input-slider').each(function () {
    //        var isStart = $(this).data('is-start');
    //
    //        $(this).noUiSlider({
    //            start: isStart,
    //            range: {
    //                'min': 0,
    //                'max': 100,
    //            }
    //        });
    //    });
    //}

    //Range slider
    if ($('.input-slider-range')[0]) {
        $('.input-slider-range').noUiSlider({
            start: [30, 60],
            range: {
                'min': 0,
                'max': 100
            },
            connect: true
        });
    }

    //Range slider with value
    if ($('.input-slider-values')[0]) {
        $('.input-slider-values').noUiSlider({
            start: [45, 80],
            connect: true,
            direction: 'rtl',
            behaviour: 'tap-drag',
            range: {
                'min': 0,
                'max': 100
            }
        });

        $('.input-slider-values').Link('lower').to($('#value-lower'));
        $('.input-slider-values').Link('upper').to($('#value-upper'), 'html');
    }

    /*
     * Input Mask
     */
    if ($('input-mask')[0]) {
        $('.input-mask').mask();
    }

    /*
     * Color Picker
     */
    if ($('.color-picker')[0]) {
        $('.color-picker').each(function () {
            $('.color-picker').each(function () {
                var colorOutput = $(this).closest('.cp-container').find('.cp-value');
                $(this).farbtastic(colorOutput);
            });
        });
    }


    /*
     * Date Time Picker
     */

    //Date Time Picker
    if ($('.date-time-picker')[0]) {
        $('.date-time-picker').datetimepicker();
    }

    //Time
    if ($('.time-picker')[0]) {
        $('.time-picker').datetimepicker({
            format: 'LT'
        });
    }

    //Date
    if ($('.date-picker')[0]) {
        $('.date-picker').datetimepicker({
            format: 'DD/MM/YYYY'
        });
    }

    /*
     * Form Wizard
     */

    if ($('.form-wizard-basic')[0]) {
        $('.form-wizard-basic').bootstrapWizard({
            tabClass: 'fw-nav',
            'nextSelector': '.next',
            'previousSelector': '.previous'
        });
    }

    /*
     * Bootstrap Growl - Notifications popups
     */
    function notify(message, type) {
        $.growl({
            message: message
        }, {
            type: type,
            allow_dismiss: false,
            label: 'Cancel',
            className: 'btn-xs btn-inverse',
            placement: {
                from: 'top',
                align: 'right'
            },
            delay: 2500,
            animate: {
                enter: 'animated bounceIn',
                exit: 'animated bounceOut'
            },
            offset: {
                x: 20,
                y: 85
            }
        });
    };

    /*
     * Waves Animation
     */
    (function () {
        Waves.attach('.btn:not(.btn-icon)');
        Waves.attach('.btn-icon', ['waves-circle', 'waves-float']);
        Waves.init();
    })();

    /*
     * Lightbox
     */
    if ($('.lightbox')[0]) {
        $('.lightbox').lightGallery({
            enableTouch: true
        });
    }

    /*
     * Link prevent
     */
    $('body').on('click', '.a-prevent', function (e) {
        e.preventDefault();
    });

    /*
     * Collaspe Fix
     */
    if ($('.collapse')[0]) {

        //Add active class for opened items
        $('.collapse').on('show.bs.collapse', function (e) {
            $(this).closest('.panel').find('.panel-heading').addClass('active');
        });

        $('.collapse').on('hide.bs.collapse', function (e) {
            $(this).closest('.panel').find('.panel-heading').removeClass('active');
        });

        //Add active class for pre opened items
        $('.collapse.in').each(function () {
            $(this).closest('.panel').find('.panel-heading').addClass('active');
        });
    }

    /*
     * Tooltips
     */
    if ($('[data-toggle="tooltip"]')[0]) {
        $('[data-toggle="tooltip"]').tooltip();
    }

    /*
     * Popover
     */
    if ($('[data-toggle="popover"]')[0]) {
        $('[data-toggle="popover"]').popover();
    }

    /*
     * Message
     */

    //Actions
    if ($('.on-select')[0]) {
        var checkboxes = '.lv-avatar-content input:checkbox';
        var actions = $('.on-select').closest('.lv-actions');

        $('body').on('click', checkboxes, function () {
            if ($(checkboxes + ':checked')[0]) {
                actions.addClass('toggled');
            }
            else {
                actions.removeClass('toggled');
            }
        });
    }

    if ($('#ms-menu-trigger')[0]) {
        $('body').on('click', '#ms-menu-trigger', function (e) {
            e.preventDefault();
            $(this).toggleClass('open');
            $('.ms-menu').toggleClass('toggled');
        });
    }

    /*
     * Login
     */
    if ($('.login-content')[0]) {
        //Add class to HTML. This is used to center align the logn box
        $('html').addClass('login-content');

        $('body').on('click', '.login-navigation > li', function () {
            var z = $(this).data('block');
            var t = $(this).closest('.lc-block');

            t.removeClass('toggled');

            setTimeout(function () {
                $(z).addClass('toggled');
            });

        })
    }

    /*
     * Fullscreen Browsing
     */
    if ($('[data-action="fullscreen"]')[0]) {
        var fs = $("[data-action='fullscreen']");
        fs.on('click', function (e) {
            e.preventDefault();

            //Launch
            function launchIntoFullscreen(element) {

                if (element.requestFullscreen) {
                    element.requestFullscreen();
                } else if (element.mozRequestFullScreen) {
                    element.mozRequestFullScreen();
                } else if (element.webkitRequestFullscreen) {
                    element.webkitRequestFullscreen();
                } else if (element.msRequestFullscreen) {
                    element.msRequestFullscreen();
                }
            }

            //Exit
            function exitFullscreen() {

                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                }
            }

            launchIntoFullscreen(document.documentElement);
            fs.closest('.dropdown').removeClass('open');
        });
    }

    /*
     * Clear Local Storage
     */
    if ($('[data-action="clear-localstorage"]')[0]) {
        var cls = $('[data-action="clear-localstorage"]');

        cls.on('click', function (e) {
            e.preventDefault();

            swal({
                title: "Are you sure?",
                text: "All your saved localStorage values will be removed",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function () {
                localStorage.clear();
                swal("Done!", "localStorage is cleared", "success");
            });
        });
    }

    /*
     * Profile Edit Toggle
     */
    if ($('[data-pmb-action]')[0]) {
        $('body').on('click', '[data-pmb-action]', function (e) {
            e.preventDefault();
            var d = $(this).data('pmb-action');

            if (d === "edit") {
                $(this).closest('.pmb-block').toggleClass('toggled');
            }

            if (d === "reset") {
                $(this).closest('.pmb-block').removeClass('toggled');
            }


        });
    }

    /*
     * IE 9 Placeholder
     */
    if ($('html').hasClass('ie9')) {
        $('input, textarea').placeholder({
            customClass: 'ie9-placeholder'
        });
    }

});
//Delete
$('.btndelete').click(function () {
    return confirm('Bạn có chắc chắn xóa?');
})
//Delete form
$('.btndeleteform').click(function () {
    var r = confirm("Bạn chắc chắn chứ ?");
    if (r == true) {
        $('#mainform').submit();
    }
});
//checked all
$(function () {
    $('#checkallcat').click(function () {
        if ($(this).is(':checked')) $('.catitem:not(:disabled)').prop('checked', true);
        else $('.catitem:not(:disabled)').prop('checked', false);
    });
});

var suggesstion = {
    team: function (idinput, idvalue) {
        var mp = [];
        $('#' + idinput).typeahead({
            source: function (query, process) {
                return $.get('/incoming/getTeam', {q: query}, function (data) {
                    var objects = [];
                    $.each(data.data, function (i, o) {
                        mp[o.name] = o._id;
                        objects.push(o.name);
                    });
                    process(objects);
                });
            },
            updater: function (item) {
                $('#' + idvalue).val(mp[item]);
                return item;
            }
        });
    },
    match: function (idinput, idvalue) {
        // add typehead
        var mp = [];
        $('#' + idinput).typeahead({
            source: function (query, process) {
                var league = $('.form-control[name=league]').val();
                $.get('/incoming/getLiveScoreMatch', {q: query, league: league}, function (data) {
                    if (data.data == undefined || data.data.length == 0) return;
                    var $objects = [];
                    $.each(data.data, function (i, o) {
                        var group;
                        group = {
                            id: o._id,
                            //name: o.team1.name + " vs " + o.team2.name + "( "+ o.datestart+ " )",
                            name: o.team1.name + " vs " + o.team2.name,
                            toString: function () {
                                return this.name;
                            },
                            substr: function (start, length) {
                                return this.toString().substr(start, length);
                            },
                            toLowerCase: function () {
                                return this.name.toLowerCase();
                            },
                            indexOf: function (string) {
                                return String.prototype.indexOf.apply(this.name, arguments);
                            },
                            replace: function (string) {
                                var value = this.name;
                                return String.prototype.replace.apply(value, arguments);
                            }
                        };
                        $objects.push(group);

                    });
                    process($objects);
                });
            },
            updater: function (item) {
                //var item = JSON.parse(item);
                $('#' + idvalue).val(item.id);
                return item;
            },
            render: function (items) {
                var that = this;

                items = $(items).map(function (i, item) {
                    i = $(that.options.item).data('value', item);
                    i.find('a').html(that.highlighter(item));
                    $(i[0]).attr('data-id', item.id);
                    return i[0];
                });

                if (this.autoSelect) {
                    items.first().addClass('active');
                }
                this.$menu.html(items);
                return this;
            }
        });
    }
}

$(document).ready(function () {
    $('.form_editor').tinymce({
        script_url: '/plugin/tinymce/tinymce.min.js',
        width: "100%",
        height: 400,
        theme_advanced_fonts: "Arial=arial;",
        //theme_advanced_font_sizes: "12px, 14px, 18px, 24px, 36px",
        fontsize_formats: "8pt 9pt 10pt 11pt 12pt 26pt 36pt",
        toolbar: "insertfile undo redo | styleselect | fontselect | fontsizeselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages | forecolor backcolor",
        theme: "modern",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern imagetools responsivefilemanager"
        ],
        external_filemanager_path: "/plugin/filemanager/",

        filemanager_title: "Responsive Filemanager",
        external_plugins: {"filemanager": "/plugin/filemanager/plugin.min.js"},
    });
});


$(document).ready(function () {
    $('.score_editor').editable({
        success: function (response, newValue) {
            $.post('/incoming/updateScore', {
                id: $(this).data('id'),
                data: newValue,
                team: $(this).data('team')
            }, function (re) {

            });
        }
    });
});

function saveOption(el) {

    $.post('/settings/saveOption', {name: el.name, value: $(el).val()}, function (data) {

    });
}