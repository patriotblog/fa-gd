<?php

namespace FaGD;
/**
 * The GNU License (GNU v 3.0)
 *
 * Coyright Under GNU 2.0 License.
 * Copyright 2017 This Library forked from https://github.com/mahmoud-eskandari/PersianRender
 * @package    Fa-GD
 * @author     MohammadAli Taebi <taebi.ali@gmail.com>
 * @copyright  20017 MohammadAli Taebi
 * @link       https://github.com/patriotblog/fa-gd
 * @see        Fa-GD
 * @version    0.1
 */

class PPersianRender
{
    /**
     * Charachter List
     * @var array
     */
    private static $N_LIST = [
        'آ' => ['ﺂ', 'ﺂ', ''],
        'ا' => ['ﺎ', '', ''],
        'ب' => ['ﺐ', 'ﺒ', 'ﺑ'],
        'پ' => ['ﭗ', 'ﭙ', 'ﭘ'],
        'ت' => ['ﺖ', 'ﺘ', 'ﺗ'],
        'ث' => ['ﺚ', 'ﺜ', 'ﺛ'],
        'ج' => ['ﺞ', 'ﺠ', 'ﺟ'],
        'چ' => ['ﭻ', 'ﭽ', 'ﭼ'],
        'ح' => ['ﺢ', 'ﺤ', 'ﺣ'],
        'خ' => ['ﺦ', 'ﺨ', 'ﺧ'],
        'د' => ['ﺪ', 'ﺪ', ''],
        'ذ' => ['ﺬ', 'ﺬ', ''],
        'ر' => ['ﺮ', 'ﺮ', ''],
        'ز' => ['ﺰ', 'ﺰ', ''],
        'ژ' => ['ﮋ', 'ﮋ', ''],
        'س' => ['ﺲ', 'ﺴ', 'ﺳ'],
        'ش' => ['ﺶ', 'ﺸ', 'ﺷ'],
        'ص' => ['ﺺ', 'ﺼ', 'ﺻ'],
        'ض' => ['ﺾ', 'ﻀ', 'ﺿ'],
        'ط' => ['ﻂ', 'ﻄ', 'ﻃ'],
        'ظ' => ['ﻆ', 'ﻈ', 'ﻇ'],
        'ع' => ['ﻊ', 'ﻌ', 'ﻋ'],
        'غ' => ['ﻎ', 'ﻐ', 'ﻏ'],
        'ف' => ['ﻒ', 'ﻔ', 'ﻓ'],
        'ق' => ['ﻖ', 'ﻘ', 'ﻗ'],
        'ک' => ['ﻚ', 'ﻜ', 'ﻛ'],
        'گ' => ['ﮓ', 'ﮕ', 'ﮔ'],
        'ل' => ['ﻞ', 'ﻠ', 'ﻟ'],
        'م' => ['ﻢ', 'ﻤ', 'ﻣ'],
        'ن' => ['ﻦ', 'ﻨ', 'ﻧ'],
        'و' => ['ﻮ', 'ﻮ', ''],
        'ه' => ['ﻪ', 'ﻬ', 'ﻫ'],
        'ی' => ['ﯽ', 'ﯿ', 'ﯾ'],
        'ك' => ['ﻚ', 'ﻜ', 'ﻛ'],
        'ي' => ['ﻲ', 'ﻴ', 'ﻳ'],
        'أ' => ['ﺄ', 'ﺄ', 'ﺃ'],
        'ؤ' => ['ﺆ', 'ﺆ', ''],
        'إ' => ['ﺈ', 'ﺈ', 'ﺇ'],
        'ئ' => ['ﺊ', 'ﺌ', 'ﺋ'],
        'ة' => ['ﺔ', 'ﺘ', 'ﺗ'],
    ];

    /**
     * Render Persian Letter
     * @param $str
     * @param bool $reverse
     * @return string
     */
    public static function render($str, $reverse = false)
    {
        //
        $str = str_replace(['ي', "\0"], ['ی', ''], $str);
        $str = self::numeric_replace($str);
        $str = self::mb_str_split(trim($str));
        $out = [];

        $i = 0;
        while(isset($str[$i])) {
            $l = $i - 1;
            if(isset($str[$l])) {
                $l = $str[$l];
            } else {
                $l = false;
            }
            $r = $i + 1;
            if(isset($str[$r])) {
                $r = $str[$r];
            } else {
                $r = false;
            }
            $out[] = self::howChar($l, $str[$i], $r);
            $i++;
        }

        if($reverse) {
            $out = array_reverse($out);
            $text = implode('', $out);
            return self::en_letter_handler($text);
        }else{
            return implode('', $out);
        }
    }

    /**
     * Replace Numeric Letters
     * @param $val
     * @param bool $persian_to_latin
     * @return mixed
     */
    public static function numeric_replace($val, $persian_to_latin = false)
    {
        $f = array('۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '۰');
        $t = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');

        if($persian_to_latin) {
            return str_replace($f, $t, $val);
        }

        return str_replace($t, $f, $val);
    }

    /**
     * Find Charachter Mode (Middle OR END OR FIRST)
     * @param $l
     * @param $char
     * @param $r
     * @return bool|string
     */
    private static function howChar($l, $char, $r)
    {
        if(!isset(self::$N_LIST[$char])) {
            return $char;
        }
        $Result = 0;
        if(
            !empty($r) && array_key_exists($r, self::$N_LIST)
            && !empty(self::$N_LIST[$char][2])
            && !empty(self::$N_LIST[$r][0])
        ) {
            $Result += 4;
        }
        if(
            !empty($l)
            && array_key_exists($l, self::$N_LIST)
            && !empty(self::$N_LIST[$char][0])
            && !empty(self::$N_LIST[$l][2])
        ) {
            $Result += 2;
        }
        if($Result === 6) {
            return self::$N_LIST[$char][1];
        }
        if($Result === 4) {
            return self::$N_LIST[$char][2];
        }
        if($Result === 2) {
            return self::$N_LIST[$char][0];
        }
        return $char;
    }

    private static function en_letter_handler($text){
        $en_letters = 'abcdefghijklmnopqrstuvwxyz';
        $en_letters .= 'ABCDEFGHIJKLMNOPQRESTUVWXYZ';

        $tmp = '';
        $words = [];
        for($i=0; $i<mb_strlen($text); $i++){
            $item = mb_substr($text, $i, 1);
            if(strpos($en_letters, $item)>-1){
                $tmp .= $item;
                continue;
            }elseif($item == ' ' && !empty($tmp)) {
                $words[] = $tmp;
                $tmp = '';
            }
        }

        foreach ($words as $word) {
            $reverse = self::reverse($word);
            $text = str_replace($word, $reverse, $text);
        }

        return $text;
    }

    private static function reverse($text){
        $reverse = '';
        for($i=mb_strlen($text); $i>=0; $i--){
            $reverse .= mb_substr($text, $i, 1);
        }
        return $reverse;
    }

    /**
     * Split String in utf-8
     * @param $string
     * @param int $string_length
     * @return array
     */
	public static function mb_str_split($string, $string_length = 1)
    {
        if(mb_strlen($string) > $string_length || !$string_length) {
            do {
                $parts[] = mb_substr($string, 0, $string_length);
                $string = mb_substr($string, $string_length);
            } while(!empty($string));
        } else {
            $parts = array($string);
        }
        return $parts;
    }

}