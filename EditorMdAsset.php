<?php
namespace kordar\editormd;

use yii\web\AssetBundle;

class EditorMdAsset extends AssetBundle
{
    public $sourcePath = '@bower/editor.md';

    public $css = [
        'css/editormd.css',
    ];

    public $js = [
        'editormd.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];

}