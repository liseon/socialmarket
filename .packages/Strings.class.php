<?php
/**
 * Класс работы со строками (просто сборник функций)
 *
 * User: Игорь
 * Date: 26.12.2014
 * Time: 0:01
 */

class Strings
{
    public static function normalize($text) {
        $pattern = '/[^\w\.а-я]/iu';

        //str_replace([' ', ',', '.', '!', '?', '&', '_', '~'], '', mb_strtolower($text, 'UTF-8'));
        $text = mb_strtolower($text, 'UTF-8');
        $text = str_replace('ё', 'е', $text);

        return preg_replace($pattern, '', mb_strtolower($text, 'UTF-8'));
    }
}