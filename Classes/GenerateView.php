<?php

namespace Classes;

use Classes\Database;
use Classes\StringOperations;
include 'Classes/Database.php';
include 'Classes/StringOperations.php';

/**
 * @author adam
 */
class GenerateView
{

    public function renderTable($words)
    {
        $tableRows = null;
        
        foreach ($words as $word => $count) {
            $tableRows = $tableRows . '<tr>'
                    . '<td>' . $word . '</td>'
                    . '<td>' . $count . '</td>'
                    . '</tr>';
            
        }
        $result = '<table class="table table-bordered">'
                . '<thead>'
                . '<tr>'
                . '<th>Słowo</th>'
                . '<th>Ile razy w tekście</th>'
                . '</tr>'
                . '</thead>'
                . '<tbody>'
                . $tableRows
                . '</tbody>'
                . '</table>';

        return $result;
    }

    public function renderView()
    {
        $string = new StringOperations();
        $db = new Database();

        $string->getTextFromUrl();
        $string->countSpecificWords();
        $db->createDatabase();
        $db->createTable();
        $wordsCounted = $string->countSpecificWords();
        $db->writeWordsInDatabase($wordsCounted);
        $words = $db->getWords();
        arsort($words);
        $table = $this->renderTable($words);
        
        return $table;
    }

}
