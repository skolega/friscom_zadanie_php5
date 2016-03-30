<?php

namespace Classes;


use mysqli;
/**
 * Database operations
 *
 * @author adam
 */
class Database extends \mysqli
{

    const DBHOST = 'localhost';
    const DBUSER = 'root';
    const DBPASS = '';
    const DBNAME = "friscom_homework";

    public function createDatabase()
    {

        $conn = new mysqli(Database::DBHOST, Database::DBUSER, Database::DBPASS);
        if ($conn->connect_error) {
            die("Błąd połączenia z bazą danych: " . $conn->connect_error);
        }

        $sql = "CREATE DATABASE IF NOT EXISTS friscom_homework";

        if ($conn->query($sql) !== TRUE) {
            echo "Błąd podczas tworzenia bazy danych: " . $conn->error;
        }

        $conn->close();
    }

    public function createTable()
    {
        $conn = new mysqli(Database::DBHOST, Database::DBUSER, Database::DBPASS, Database::DBNAME);

        if ($conn->connect_error) {
            die("Błąd połączenia z bazą danych: " . $conn->connect_error);
        }

        $sql = "CREATE TABLE IF NOT EXISTS words_counts 
                ( 
                    id INT NOT NULL AUTO_INCREMENT, 
                    word VARCHAR(30) NOT NULL, 
                    count INT NOT NULL, 
                    PRIMARY KEY (id) 
                ) ENGINE=InnoDB;";

        if ($conn->query($sql) !== TRUE) {
            echo "Błąd podczas tworzenia bazy danych: " . $conn->error;
        }

        $conn->close();
    }

    public function getWords()
    {
        $conn = new mysqli(Database::DBHOST, Database::DBUSER, Database::DBPASS, Database::DBNAME);

        $sql = "SELECT word, count FROM words_counts";

        $result = $conn->query($sql);

        $words = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $words[$row['word']] = $row['count'];
            }
        }

        $conn->close();

        return $words;
    }

    function writeWordsInDatabase($words)
    {
        $conn = new mysqli(Database::DBHOST, Database::DBUSER, Database::DBPASS, Database::DBNAME);

        if ($conn->connect_error) {
            die("Błąd połączenia z bazą danych: " . $conn->connect_error);
        }

        foreach ($words as $key => $var) {
            $values[] = '("' . $key . '",' . $var . ')';
        }
        $values = implode(",", $values);

        $sql = "INSERT INTO words_counts (word, count) VALUES " . $values;

        $ifWords = count($this->getWords());

        if ($ifWords < 1) {
            if ($conn->query($sql) !== TRUE) {
                echo "Błąd: " . $sql . "<br>" . $conn->error;
            }
        }
        $conn->close();
    }

}
