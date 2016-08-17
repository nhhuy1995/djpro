<?php
/**
 * @author: hungln
 * @desc: Use to import frontend's component like TinyMCE,...
 */
namespace DjCms\Service;

use \Phalcon\Mvc\User\Component;

class FrontEndComponent extends Component {
    const TINY_MCE_EDITOR = 'addTinyMce';
    const JCROP_IMAGE = 'addJcrop';

    private function addTinyMce() {
        $this->addActionJsFile('plugin/tinymce/jquery.tinymce.min.js');
    }

    private function addJcrop() {
        $this->addActionJsFile('js/jquery.Jcrop.js');
        $this->addActionCssFile('css/jquery.Jcrop.css');
    }

    public function addActionJsFile($listFile) {
        $listFile = is_string($listFile) ? array($listFile) : $listFile;
        if(is_array($listFile) && count($listFile)) {
            foreach($listFile as $files) {
                $this->assets
                    ->collection('actionJs')
                    ->addJs($files);
            }
        }
    }

    public function addActionCssFile($listFile) {
        $listFile = is_string($listFile) ? array($listFile) : $listFile;
        if(is_array($listFile) && count($listFile)) {
            foreach($listFile as $files) {
                $this->assets
                    ->collection('actionCss')
                    ->addCss($files);
            }
        }
    }
}