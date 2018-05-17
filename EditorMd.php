<?php
namespace kordar\editormd;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\InputWidget;

class EditorMd extends InputWidget
{
    /**
     * @var string
     */
    public $assetClassName = '\kordar\editormd\EditorMdAsset';

    /**
     * @var array
     */
    public $emoji = [];

    /**
     * @var string
     */
    public $id = 'kordar-editormd';

    /**
     * @var array
     */
    public $editorOptions = [];

    public function run()
    {
        $this->registerClientScript();
        echo Html::tag('div', $this->renderTextAreaHtml(), ['id' => $this->id, 'class' => 'editormd']);
    }

    protected function renderTextAreaHtml()
    {
        if ($this->hasModel()) {
            return Html::activeTextarea($this->model, $this->attribute, ['class'=>'hide']);
        }
        return Html::textarea($this->name, $this->value, ['class'=>'hide']);
    }

    protected function renderEmojiScript()
    {
        if (empty($this->emoji)) {
            $this->emoji['path'] = (EmojiAsset::register($this->getView()))->baseUrl . '/';
            $this->emoji['ext'] = '.png';
        }
        return ArrayToJsObjectHelper::conversionToJsObject($this->emoji);
    }

    protected function renderEditorScript($baseUrl, $options)
    {
        $default = [
                     "width" => "100%",
                    "height" => 500,
             "syncScrolling" => "single",
                      "path" => $baseUrl . '/lib/',
                     "emoji" => true,
               "imageUpload" => true,
              "imageFormats" => ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
            "imageUploadURL" => "",
        "saveHTMLToTextarea" => true,
              "toolbarIcons" => [
                    "undo", "redo", "|",
                    "bold", "del", "italic", "quote", "ucwords", "uppercase", "lowercase", "|",
                    "h1", "h2", "h3", "h4", "h5", "h6", "|",
                    "list-ul", "list-ol", "hr", "|",
                    "link", "reference-link", "image", "code", "preformatted-text", "code-block", "table", "datetime", "emoji", "html-entities", "pagebreak", "|",
                    "goto-line", "watch", "preview", "fullscreen", "clear", "search"
              ]
        ];

        $options = array_merge($default, $options);

        return  ArrayToJsObjectHelper::conversionToJsObject($options);
    }

    public function registerClientScript()
    {
        $view = $this->getView();

        // emoji
        $view->registerJs("editormd.emoji={$this->renderEmojiScript()};");

        // editor md
        $editorAsset = call_user_func([$this->assetClassName, 'register'], $view);
        $view->registerJs('editor=editormd("' . $this->id . '", ' . $this->renderEditorScript($editorAsset->baseUrl, $this->editorOptions) . ');');

        //
        $view->registerJs("\$('#{$this->id}').css('z-index', 9)");
    }
}