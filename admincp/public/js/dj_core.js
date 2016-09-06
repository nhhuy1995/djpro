$(document).ready(function () {
    djCropImage = function () {

        return {
            elemToBind: null,
            previewElem: null,
            inputElem: null,
            jcrop: null,
            aspectRatio: {
                width: 2300,
                height: 800
            },
            cropType: null,
            croping: false,
            showCoords: function (c) {
                $('#x').val(c.x);
                $('#y').val(c.y);
                // $('#x2').val(c.x2);
                // $('#y2').val(c.y2);
                $('#w').val(c.w);
                $('#h').val(c.h);
            },
            bindElem: function () {
                $(this.elemToBind).attr('href', "#")
                    .attr('data-toggle', 'modal')
                    .attr('data-target', '#modal_crop_image')
                    .attr('data-preview', this.previewElem)
                    .attr('data-input', this.inputElem)
                    .attr('data-bind-elem', this.elemToBind)
                    .attr('data-crop-type', this.cropType)
                    .attr('data-aspect-ratio', JSON.stringify(this.aspectRatio));
            },
            init_jcrop: function (aspectRatio) {
                $('.imagePreviewLarge').removeAttr('style');
                this.jcrop = $.Jcrop('#cropbox', {
                    onChange: this.showCoords,
                    onSelect: this.showCoords,
                    setSelect: [0, 0, aspectRatio.width, aspectRatio.height],
                    aspectRatio: aspectRatio.width / aspectRatio.height
                });
            },
            createModal: function () {
                var htmlModal = '<div id="modal_crop_image" class="modal fade" role="dialog">'
                    + '<div class="modal-dialog" style="width: 100% !important;">'
                    + '<div class="modal-content">'
                    + '<form id="crom_image_form" action="/imagecrop/index" method="post">'
                    + '<div class="modal-header">'
                    + '<button type="button" class="close" data-dismiss="modal">&times;</button>'
                    + '<h4 class="modal-title">Modal Header</h4>'
                    + '</div>'
                    + '<div class="modal-body">'
                    + '<center>'
                    + '<img src="" id="cropbox"/>'
                    + '</center>'
                    + '<br/>'
                    + 'Width:'
                    + '<input id="w" name="w" type="text" class="input-sm form-control"/>'
                    + 'Height:'
                    + '<input id="h" name="h" type="text" class="input-sm form-control"/>'
                    + '</div>'
                    + '<div class="modal-footer">'
                    + '<input type="hidden" id="crop_img" name="crop_img"/>'
                    + '<input type="hidden" id="x" name="x"/>'
                    + '<input type="hidden" id="y" name="y"/>'
                    + '<input type="hidden" id="dj_crop_type" name="type" value="news"/>'
                    + '<input type="hidden" id="dj_aspect_ratio" name="aspect_ratio" value=""/>'
                    + '<button type="submit" class="btn btn-primary">Crop Image</button>'
                    + '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
                    + '</div>'
                    + '</form>'
                    + '<span id="djcrop_bindElem"><span>'
                    + '</div>'
                    + '</div>'
                    + '</div>';
                $('body').append(htmlModal);
            },
            showModal: function () {
                var self = this;
                return (function () {
                    $('#modal_crop_image').on('show.bs.modal', function (e) {
                        var relateElem = $(e.relatedTarget);
                        var previewElem = $(relateElem.attr('data-preview'));
                        var img = previewElem.find('img').attr('src');
                        $("#crom_image_form").next('#djcrop_bindElem')
                            .attr('data-bind-elem', relateElem.attr('data-bind-elem'));
                        $('#cropbox').attr('src', img);
                        $('#crop_img').val(img);

                        if (self.jcrop != null)
                            self.jcrop.destroy();

                        setTimeout(function () {
                            var aspectRatio = relateElem.attr('data-aspect-ratio');
                            $("#dj_crop_type").val(relateElem.attr('data-crop-type'));
                            $("#dj_aspect_ratio").val(aspectRatio);
                            self.init_jcrop(JSON.parse(aspectRatio));
                        }, 500);

                    })
                })();
            },
            submit: function () {
                var self = this;
                $("#crom_image_form").submit(function (event) {
                    event.preventDefault();
                    var bindElem = $(this).next('#djcrop_bindElem').attr('data-bind-elem');
                    var bindElemObj = $(bindElem);
                    if (self.croping) {
                        console.log('croping image...');
                        return;
                    }

                    self.croping = true;
                    $.post($(this).attr('action'), $(this).serialize(), function (data) {

                        // allow crop again
                        self.croping = false;

                        // get new cropped image
                        if (data.image != undefined) {
                            var previewElem = $(bindElemObj.attr('data-preview'));
                            previewElem.attr('style', '');
                            setTimeout(function () {
                                previewElem.find('img').prop('src', data.image);
                            }, 500);
                            $('#cropbox').attr('src', data.image);
                            $('#crop_img').val(data.image);

                            // remove all file input and bind new data
                            $(bindElemObj.attr('data-input')).val(data.image);
                            $('#modal_crop_image').modal('hide'); // dismiss modal

                            $('input [type=file]').each(function () {
                                $(this).val('');
                            });

                        } else {
                            alert('Có lỗi xảy ra khi crop ảnh');
                        }
                    });
                });
            },
            registerFunction: function (config) {
                this.elemToBind = config.bindElem;
                this.previewElem = config.previewElem;
                this.inputElem = config.inputElem;
                this.aspectRatio = config.aspectRatio;
                this.cropType = config.cropType;
                this.bindElem();

                if (!djCropImage.register) {
                    this.createModal();
                    this.showModal();
                    this.submit();
                    djCropImage.register = true;
                }
            }
        };
    };
    djCropImage.register = false;

    // if (typeof djPictureUpload == 'undefined') {
    //     djPictureUpload = function () {
    //         var _option = {
    //             selectElem: "",
    //             urlAjax: "",
    //             thumbnail: "/img/240x240.png",
    //             currentSrc: "",
    //             label: "Ảnh đại diện",
    //             method: 'post'
    //         }

    //         this.getOpt = function () {
    //             return _option;
    //         }
    //     };

    //      djPictureUpload.prototype = {
    //         init: function (option) {
    //             var opt = this.getOpt();
    //             $.extend(opt, option);
    //             this._bindHtmlForm();
    //         },

    //         _bindHtmlForm: function() {
    //             var opt = this.getOpt();
    //             var currentContent = $(opt.selectElem)[0].outerHTML;
    //             var currentImageUrl = (opt.currentSrc !== '') ? opt.currentSrc : opt.thumbnail;
    //             var formContent = '<div class="form-group fg-float">'
    //                 + '<div class="fg-line"><div class="">' + opt.label + '</div></div>'
    //                 + '<div class="fg-line">'
    //                     + '<div class="fileinput fileinput-new" data-provides="fileinput">'
    //                         + '<div class="fileinput-preview thumbnail" data-trigger="fileinput">'
    //                             + '<img src="' + currentImageUrl +'">'
    //                         + '</div>'
    //                         + '<div class="image">'
    //                             + '<span class="btn btn-info btn-file waves-effect">'
    //                                 + '<span class="fileinput-new">Select</span>'
    //                                 + '<span class="fileinput-exists">Change</span>'
    //                                 + '<input type="file" name="file">'
    //                             + '</span>'
    //                             + '<a href="#" class="btn btn-danger waves-effect" data-dismiss="fileinput" style="float: right;">Remove</a>'
    //                         + '</div>'
    //                         + currentContent
    //                         + '</div>'
    //                 + '</div>'
    //             + '</div>';
    //             $(opt.selectElem).replaceWith(formContent);
    //         }
    //     }
    // }

    $('.fileinput').on('change.bs.fileinput', function (event, previewId) {
        $(this).find('.edit_crop').click();
    });

    (function () {
        if (typeof djSelectionData == 'undefined') {
            djSelectionData = function () {
                var _option = {
                    selectElem: "",
                    urlAjax: "",
                    placeholder: "",
                    method: 'post',
                    formatRepoSelection: function (repo) {
                        return repo.name || repo.text;
                    },
                    formatRepo: function (repo) {
                        return repo.name;
                    }

                }

                this.getOpt = function () {
                    return _option;
                }
            };

            djSelectionData.prototype = {
                init: function (option) {
                    var opt = this.getOpt();
                    $.extend(opt, option);
                    this._addHtmlListener();
                },

                _addHtmlListener: function () {
                    var opt = this.getOpt();
                    var objectJq = $(opt.selectElem);

                    objectJq.select2({
                        multiple: true,
                        tags: true,
                        placeholder: opt.placeholder,
                        ajax: {
                            url: opt.urlAjax,
                            dataType: 'json',
                            method: opt.method,
                            delay: 250,
                            data: function (params) {
                                return {
                                    q: params.term, // search term
                                    page: params.page
                                };
                            },
                            processResults: function (data, params) {
                                params.page = params.page || 1;

                                return {
                                    results: data.items,
                                    pagination: {
                                        more: (params.page * 20) < data.total_count
                                    }
                                };
                            }
                        },
                        escapeMarkup: function (markup) {
                            return markup;
                        },
                        minimumInputLength: 3,
                        templateResult: opt.formatRepo,
                        templateSelection: opt.formatRepoSelection
                    });
                }
            }
        }
    })();

    (function() {
        if (typeof djOnkeyUpEvent == 'undefined') {
            djOnkeyUpEvent = function () {
                var option = {
                    elem: '',
                    data: {},
                    url: '/incoming/checkelemexists',
                    delay: 400,
                    method: 'get',
                    callback: function() {}
                };

                this.getOpt = function() {
                    return option;
                }
            };

            djOnkeyUpEvent.prototype = {
                init: function (option) {
                    var opt = this.getOpt();
                    $.extend(opt, option);
                    this._addHtmlListener();
                },
                _addHtmlListener : function() {
                    var thread;
                    var opt = this.getOpt();
                    $(opt.elem).on('keyup', function() {
                        clearTimeout(thread);
                        var data = {};
                        if (typeof opt.data == 'function')
                            data = opt.data();
                        else
                            data = opt.data();
                        thread = setTimeout(function() {
                            $.ajax({
                                url: opt.url,
                                method: opt.method,
                                data: data,
                                success: opt.callback
                            });
                        }, opt.delay);
                    });
                }
            }
        }
    })();

    (function() {
        djCheckElemExists = function() {
            djOnkeyUpEvent.apply(this);
        };
        djCheckElemExists.prototype = Object.create(djOnkeyUpEvent.prototype);
        djCheckElemExists.prototype.constructor = djCheckElemExists;

        djCheckElemExists.prototype.init = function(option) {
            djOnkeyUpEvent.prototype.init.call(this, option);

            var check_exists_elem = '<span style="float:right;" class="check_exists_result"></span>'
            $(option.elem).parents('.form-group')
                .append(check_exists_elem);
            var check_elem_jq = $(option.elem).parents('.form-group')
                .find('.check_exists_result');
            var _opt = this.getOpt();
            _opt.callback = function(data, err, object) {
                if (data.status == _opt.notExistsStatus)
                    check_elem_jq.text('New').css({color: 'blue'});
                else
                    check_elem_jq.text('Exists').css({color: 'red'});
            }
        }
    })();
});