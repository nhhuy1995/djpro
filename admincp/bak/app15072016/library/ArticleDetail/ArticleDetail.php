<?php
namespace DjCms\Library\ArticleDetail;

class ArticleDetail
{

    public static function getMediaUrl($link, $baseUrl)
    {
        $urlInfo = parse_url($link);
        if (preg_match('/.*zippyshare.com.*/', $urlInfo['host']))
            $trackGetter = new ZippyShare($link, $baseUrl);
        else {
            switch ($urlInfo['host']) {
                case 'soundcloud.com':
                    $trackGetter = new SoundCloud($link, $baseUrl);
                    break;
                case 'www.tunescoop.com':
                    $trackGetter = new TuneScoop($link, $baseUrl);
                    break;
                default:
                    return $link;
            }
        }
        return $trackGetter->getDirectUri();
    }

}