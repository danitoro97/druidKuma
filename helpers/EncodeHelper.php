<?php

namespace app\helpers;

use yii\helpers\Html;

class EncodeHelper extends Html
{
    public static function encode($content, $doubleEncode = true)
    {
        return str_replace(['<script>', '</script>'], ['&lt;script&gt;', '&lt;&#47;script&gt;'], $content);
    }
}
