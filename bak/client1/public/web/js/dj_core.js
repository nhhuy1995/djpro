    (function () {
        if (typeof djSelectionData == 'undefined') {
            djSelectionData = function () {
                var _option = {
                    selectElem: "",
                    urlAjax: "",
                    placeholder: "",
                    method: 'post',
                    width: '100%',
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
                        tokenSeparators: [','],
                        width: opt.width,
                        language: {
                            inputTooShort: function (value) {
                                return "Vui lòng gõ thêm " + (value.minimum - value.input.length) + " ký tự"; 
                            }
                        },
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