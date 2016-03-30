<?php

namespace Classes;

use Classes\Database;

/**
 * String operations
 *
 * @author adam
 */
class StringOperations
{
    const TEXTURL = 'http://www.wkrakowie.pl/tekstownik.txt';

    public function getTextFromUrl()
    {
        $text = file_get_contents(StringOperations::TEXTURL);
        $lowercaseText = strtolower($text);

        return $lowercaseText;
    }

    public function countSpecificWords()
    {
        $t = [' ', "';\\n \\' \\''\" '; exit 0; ')", 'ąąąą', ' " ', "\'", '=', '+', '-', '*', '/', '\\', ',', '.', ';', ':', '[', ']', '{', '}', '(', ')', '<', '>', '&', '%', '$', '@', '#', '^', '!', '?', '~'];
        $text = str_replace($t, " ", $this->getTextFromUrl());
        $words = array_count_values(str_word_count($text, 1));

        return $words;
    }

}
