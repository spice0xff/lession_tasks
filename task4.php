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

    const NEWS = 0;
    const ANNOUNCES = 1;

    public function __construct() {
        $this->pdo = new PDO("mysql:host=localhost;dbname=my_db", 'spice', 'Spice123');
        $this->pdo->query("set names utf8");
    }

    public function all($publication_type) {
        switch ($publication_type) {
            case self::NEWS:
                $table_name = "news";
                $column_name = "link";
                break;
            case self::ANNOUNCES:
                $table_name = "announces";
                $column_name = "author";
                break;
            default:
                return [];
        }

        $sql = "
            SELECT title, text, $column_name
            FROM $table_name;
        ";

        $query_result = $this->pdo->query($sql);
        $result = $query_result->fetchAll(PDO::FETCH_ASSOC);
        $publication_list = [];
        foreach ($result as $elem) {
            $title = $elem["title"];
            $text = $elem["text"];
            $source = $elem[$column_name];
            switch ($publication_type) {
                case self::NEWS:
                    $publication = new News($title, $text, $source);
                    break;
                case self::ANNOUNCES:
                    $publication = new Announces($title, $text, $source);
                    break;
                default:
                    return [];
            }
            array_push($publication_list, $publication);
        }
        return $publication_list;
    }

    public function create($publication_type, $title, $text, $source) {
        switch ($publication_type) {
            case self::NEWS:
                $table_name = "news";
                $column_name = "link";
                break;
            case self::ANNOUNCES:
                $table_name = "announces";
                $column_name = "author";
                break;
            default:
                return [];
        }

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

        switch ($publication_type) {
            case self::NEWS:
                $news = new News($title, $text, $source);
                return $news;
            case self::ANNOUNCES:
                $announces = new Announces($title, $text, $source);
                return $announces;
            default:
                return [];
        }
    }
}

class NewsDB {
    public function all() {
        $mysql_connection = new MysqlConnection();
        $result = $mysql_connection->all(MysqlConnection::NEWS);
        return $result;
    }

    public function create($title, $text, $source) {
        $mysql_connection = new MysqlConnection();
        $result = $mysql_connection->create(MysqlConnection::NEWS, $title, $text, $source);
        return $result;
    }
}

class AnnouncesDB {
    public function all() {
        $mysql_connection = new MysqlConnection();
        $result = $mysql_connection->all(MysqlConnection::ANNOUNCES);
        return $result;
    }

    public function create($title, $text, $source) {
        $mysql_connection = new MysqlConnection();
        $result = $mysql_connection->create(MysqlConnection::ANNOUNCES, $title, $text, $source);
        return $result;
    }
}

function create_tables() {
    $pdo = new PDO("mysql:host=localhost;dbname=my_db", 'spice', 'Spice123');
    $pdo->query("set names utf8");

    $sql = "
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

function drop_tables() {
    $pdo = new PDO("mysql:host=localhost;dbname=my_db", 'spice', 'Spice123');
    $pdo->query("set names utf8");

    $sql = "
        DROP TABLE `news`;
        DROP TABLE `announces`;
    ";

    $pdo->query($sql);
}

function main() {
    drop_tables();
    create_tables();

    $news_db = new NewsDB();
    $news_db->create("Заголовок новости1", "Содержимое новости1", "https://ya.ru");
    $news_db->create("Заголовок новости2", "Содержимое новости2", "https://google.ru");

    $announces_db = new AnnouncesDB();
    $announces_db->create("Заголовок объявления1", "Содержимое объявления1", "Лёня");
    $announces_db->create("Заголовок объявления2", "Содержимое объявления2", "Лёва");

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
