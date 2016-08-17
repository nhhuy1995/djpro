(function() {
    if (typeof djSelectionData === "undefined") {
        djSelectionData = function() {
            var _option = {
                timeout: 400,
                thread: null,
                inputElem: null,
                inputParam: "",
                suggestWrapper: null,
                listWrapper: null,
                urlAjax: "",
                urlBrandnewAjax: "",
                css: {
                    suggestElem: 'dj_select_suggest_elem',
                    brandNewElem: 'dj_select_brand_new'
                },
                renderSuggestElem: function(elem) {
                    return '<li class="' + this.css.suggestElem + '" data-name="'
                                + elem.name + '" data-id="' + elem._id + '">'
                                + elem.name
                            + '</li>';
                },
                renderSuggestBrandnew: function(value) {
                    return '<li class="' + this.css.brandNewElem + ' "> Tạo mới ( ' + value + ' ) </li>';
                },
                allowAddBrandNew: false
            };

            this.getOpt = function() {
                return _option;
            }
        };

        djSelectionData.prototype = {
            init : function(option) {
                var opt = this.getOpt();
                $.extend(opt, option);
                this._addHtmlListener();
            },

            getSuggestRemoteData: function() {
                var opt = this.getOpt();
                clearTimeout(opt.thread);
                var thisWrap = this;
                opt.thread = setTimeout(function () {
                    var q = $(opt.inputElem).val();
                    var suggestObj = $(opt.suggestWrapper);
                    suggestObj.html('');
                    if (q.length) {
                        $.get(opt.urlAjax, {q: q}, function (re) {
                            var data = re.data;
                            if (data && data.length > 0) {
                                data.forEach(thisWrap._createElemSuggest);
                                suggestObj.parent().show();
                            } else {
                                if (opt.allowAddBrandNew) {
                                    suggestObj.append(opt.renderSuggestBrandnew);
                                } else
                                    suggestObj.parent().hide();
                            }
                        });
                    } else {
                        suggestObj.html('');
                        suggestObj.parent().hide();
                    }
                }, opt.timeout);
            },
            _createElemSuggest: function(elem) {
                var opt = this.getOpt();
                $(opt.suggestWrapper).append(opt.renderSuggestElem(elem));
            },
             _addElemToList: function(obj) {
                var objJquery = $(obj);
                var opt = this.getOpt();
                var tagId = objJquery.attr('data-id');
                var tagName = objJquery.attr('data-name');
                this._appendElemToList(tagId, tagName);
            },
            _addBrandNewElem: function(newTagName) {
                var opt = this.getOpt();

                if (opt.urlBrandnewAjax.length) {
                    $.post(opt.urlBrandnewAjax, {name: newTagName}, function (re) {
                        var data = re.data;
                        if (data.status == 1) {
                            this._appendElemToList(data.tagId, data.tagName);
                        } else {
                            var message = (data.message) ? data.message: 'Đã có lỗi xảy ra';
                            alert(message);
                        }
                    });
                }
            },
            _appendElemToList: function (tagId, tagName) {
                var opt = this.getOpt();
                var html = '<li class="p-5">'
                        + '<label class="checkbox checkbox-inline">'
                        + '<input class="inputid_home" name="' + this.getOpt().inputParam + '[]" value="' + tagId + '" type="hidden">'
                        + '<input checked type="checkbox" class="checkEnableTag"><i class="input-helper"></i>'
                        + '<span>' + tagName + '</span>'
                        + '</label>'
                '</li>';
                $(opt.listWrapper).append(html);
                $(opt.suggestWrapper).parent().hide();
            },
            _addHtmlListener: function() {
                var opt = this.getOpt();
                var suggestWrapper = $(opt.suggestWrapper);
                var self = this;
                $(opt.inputElem).keyup(function() {
                    self.getSuggestRemoteData();
                });

                suggestWrapper.on('click', 'li.' + opt.css.suggestElem, function(obj) {
                    self._addElemToList(obj);
                });
                suggestWrapper.on('click', 'li.' + opt.css.brandNewElem, function(obj) {
                    self._addBrandNewElem(obj);
                });
            },
            test: function () {
                console.log(this._createElemSuggest({
                    _id: "1",
                    name: '23233'
                }));
            }
        }; 
    }

})();
