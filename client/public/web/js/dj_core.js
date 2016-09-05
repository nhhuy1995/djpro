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

$(document).ready(function () {
    $("#jquery_jplayer").bind($.jPlayer.event.volumechange, function(event) {
        var volume  = event.jPlayer.options.volume;
        var muted = event.jPlayer.options.muted;
        if (muted)
            Cookies.set('jPlayer-audio-muted', 'yes', { expires: 7 });
        else
            Cookies.set('jPlayer-audio-muted', 'no', { expires: 7 });
        Cookies.set('jPlayer-audio-volume', volume, { expires: 7 });
    });

    $(".jp-repeat").click(function() {
        Cookies.set('jPlayer-audio-repeat', true, { expires: 7 });
    });

    $(".jp-repeat-off").click(function() {
        Cookies.set('jPlayer-audio-repeat', '', { expires: 7 });
    });
})

function jPlayerSetDefault() {
    var muted = Cookies.get('jPlayer-audio-muted');
    if (typeof muted == 'string' && muted == 'yes')
        $("#jquery_jplayer").jPlayer("mute", true);

    var volume = parseFloat(Cookies.get('jPlayer-audio-volume'));
    if (volume > 0)
        $("#jquery_jplayer").jPlayer("volume", volume);

    var quality =  Cookies.get('jPlayer-audio-quality');
    if (typeof quality == 'string') {
        var player = $("#jquery_jplayer");
        var qualityElem = $('.media_quality_select[data-media-type="' + quality + '"]');
        var audioRrl = qualityElem.attr("data-media-src");
        if (audioRrl != undefined) {
            $('.media_quality_select').removeAttr('style');
            qualityElem.attr('style','color: #B302CB');

            if (quality == '32')
                $("#jquery_jplayer").jPlayer("setMedia", {
                    m4a: audioRrl
                });
            else
                $("#jquery_jplayer").jPlayer("setMedia", {
                    mp3: audioRrl
                });
        }
    }
}

function jPlayerPlaylistSetDefault(playlistPlayer) {
    var muted = Cookies.get('jPlayer-audio-muted');
    if (typeof muted == 'string' && muted == 'yes')
        $("#jquery_jplayer").jPlayer("mute", true);

    var volume = parseFloat(Cookies.get('jPlayer-audio-volume'));
    if (volume > 0)
        $("#jquery_jplayer").jPlayer("volume", volume);

    var isShuffle = Cookies.get('jPlayer-playlist-shuffle');
    if (isShuffle == 'true')
        playlistPlayer.shuffle(true);
    else
        playlistPlayer.shuffle(false);

}

function addParameterToUrl(url, parameterName, parameterValue, atStart/*Add param before others*/){
    replaceDuplicates = true;
    if(url.indexOf('#') > 0){
        var cl = url.indexOf('#');
        urlhash = url.substring(url.indexOf('#'),url.length);
    } else {
        urlhash = '';
        cl = url.length;
    }
    sourceUrl = url.substring(0,cl);

    var urlParts = sourceUrl.split("?");
    var newQueryString = "";

    if (urlParts.length > 1)
    {
        var parameters = urlParts[1].split("&");
        for (var i=0; (i < parameters.length); i++)
        {
            var parameterParts = parameters[i].split("=");
            if (!(replaceDuplicates && parameterParts[0] == parameterName))
            {
                if (newQueryString == "")
                    newQueryString = "?";
                else
                    newQueryString += "&";
                newQueryString += parameterParts[0] + "=" + (parameterParts[1]?parameterParts[1]:'');
            }
        }
    }
    if (newQueryString == "")
        newQueryString = "?";

    if(atStart){
        newQueryString = '?'+ parameterName + "=" + parameterValue + (newQueryString.length>1?'&'+newQueryString.substring(1):'');
    } else {
        if (newQueryString !== "" && newQueryString != '?')
            newQueryString += "&";
        newQueryString += parameterName + "=" + (parameterValue?parameterValue:'');
    }
    return urlParts[0] + newQueryString + urlhash;
};