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
                renderSuggestElem: function(elem) {
                    return '<li data-name="'
                                + elem.name + '" data-id="' + elem._id + '">'
                                + elem.name
                            + '</li>';
                },
                renderBrandnewElem: function(val) {
                    return '<li> Tạo mới ( ' + val + ' )</li>';
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
                $(opt.inputElem).on('keyup', this.getSuggestRemoteData);
                $(opt.suggestWrapper).on('change', 'li', this._addElemToList);
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
                                    // this._addBrandNewElem(q);
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
            _addBrandNewElem: function(newTagName) {
                var opt = this.getOpt();

                if (opt.urlBrandnewAjax.length) {
                    $.post(opt.urlBrandnewAjax, {name: newTagName}, function (re) {
                        var data = re.data;
                        if (data.status == 1) {
                            
                        } else {
                            var message = (data.message) ? data.message: 'Đã có lỗi xảy ra';
                            alert(message);
                        }
                    });
                }
            }
        }; 
    }

})();