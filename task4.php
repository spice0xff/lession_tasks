<?php

abstract class Publication {
    abstract public function getSource();
    abstract public function getContent();
    abstract public function getAll();
}

class News extends Publication {
    private $title = null;
    private $text = null;
    private $link = null;

    public function __construct($title, $text, $link) {
        $this->title = $title;
        $this->text = $text;
        $this->link = $link;
    }

    public function getSource() {
        return "<br><a href='$this->link'>$this->link</a>";
    }
    public function getContent() {
        return "<h1>$this->title</h1>$this->text";
    }
    public function getAll() {
    }
}

class Announces extends Publication {
    private $title = null;
    private $text = null;
    private $author = null;

    public function __construct($title, $text, $author) {
        $this->title = $title;
        $this->text = $text;
        $this->author = $author;
    }

    public function getSource() {
        return "<br>$this->author";
    }
    public function getContent() {
        return "<h1>$this->title</h1>$this->text";
    }
    public function getAll() {
    }
}

class MysqlConnection {
    private $pdo = null;

    public function __construct() {
        $this->pdo = new PDO("mysql:host=localhost;dbname=my_db", 'spice', 'Spice123');
        $this->pdo->query("set names utf8");
    }

    public function all($table_name, $column_name) {
        $sql = "
            SELECT title, text, $column_name
            FROM $table_name;
        ";
        $query_result = $this->pdo->query($sql);

        $result = $query_result->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function create($table_name, $column_name, $title, $text, $source) {
        $sql = "
            INSERT INTO `my_db`.`$table_name` (
              `title`,
              `text`,
              `$column_name`
            )
            VALUES
              (
                '$title',
                '$text',
                '$source'
              );
        ";
        $this->pdo->query($sql);
    }
}

class NewsDB {
    public function all() {
        $mysql_connection = new MysqlConnection();
        $query_result = $mysql_connection->all("news", "link");
        $all_news = [];
        foreach ($query_result as $value) {
            $news = new News($value["title"], $value["text"], $value["link"]);
            array_push($all_news, $news);
        }
        return $all_news;
    }

    public function create($title, $text, $source) {
        $mysql_connection = new MysqlConnection();
        $mysql_connection->create("news", "link", $title, $text, $source);
        $news = new News($title, $text, $source);
        return $news;
    }
}

class AnnouncesDB {
    public function all() {
        $mysql_connection = new MysqlConnection();
        $query_result = $mysql_connection->all("announces", "author");
        $all_announces = [];
        foreach ($query_result as $value) {
            $announces = new Announces($value["title"], $value["text"], $value["author"]);
            array_push($all_announces, $announces);
        }
        return $all_announces;
    }

    public function create($title, $text, $source) {
        $mysql_connection = new MysqlConnection();
        $mysql_connection->create("announces", "author", $title, $text, $source);
        $announces = new Announces($title, $text, $source);
        return $announces;
    }
}

function create_tables() {
    $pdo = new PDO("mysql:host=localhost;dbname=my_db", 'spice', 'Spice123');
    $pdo->query("set names utf8");

    $sql = "
        DROP TABLE `news`;
        DROP TABLE `announces`;
    
        CREATE TABLE `news` (
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `title` VARCHAR(64) NOT NULL,
          `text` TEXT NOT NULL,
          `link` VARCHAR(64) NOT NULL,
          `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`)
        ) ENGINE=INNODB DEFAULT CHARSET=utf8mb4;
        
        CREATE TABLE `announces` (
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `title` VARCHAR(64) NOT NULL,
          `text` TEXT NOT NULL,
          `author` VARCHAR(64) NOT NULL,
          `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`)
        ) ENGINE=INNODB DEFAULT CHARSET=utf8mb4;
    ";

    $pdo->query($sql);
}

function fill_tables() {
    $news_db = new NewsDB();
    $news_db->create("Заголовок новости1", "Содержимое новости1", "https://ya.ru");
    $news_db->create("Заголовок новости2", "Содержимое новости2", "https://google.ru");

    $announces_db = new AnnouncesDB();
    $announces_db->create("Заголовок объявления1", "Содержимое объявления1", "Лёня");
    $announces_db->create("Заголовок объявления2", "Содержимое объявления2", "Лёва");
}

function main() {
    create_tables();
    fill_tables();

    $news_db = new NewsDB();
    $announces_db = new AnnouncesDB();
    $all_publication_list = array_merge(
        $news_db->all(),
        $announces_db->all()
    );

    foreach ($all_publication_list as $publication) {
        echo $publication->getContent();
        echo $publication->getSource();
    }
}

main();
