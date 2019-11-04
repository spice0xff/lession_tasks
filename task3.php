<?php

function task1() {
    $pdo = new PDO("mysql:host=localhost;dbname=my_db", 'spice', 'Spice123');
    $pdo->query("set names utf8");

    $cyrillic_alphabet = "абвгдеёжзийклмнопрстуфхцчшщъыьэюя";
    for ($index_user = 0; $index_user < 1000; $index_user++) {
        $name = "";
        for ($index_name = 0; $index_name < rand(5, 15); $index_name++) {
            $symbol_index = rand(0, mb_strlen($cyrillic_alphabet) - 1);
            $symbol = mb_substr($cyrillic_alphabet, $symbol_index, 1);
            $name .= $symbol;
        }
        $name = mb_convert_case($name, MB_CASE_TITLE, "UTF-8");

        $age = rand(10, 100);

        $sql = "INSERT INTO users (name, age) VALUES ('$name', $age)";
//        echo "$sql<br>";
        $pdo->query($sql);
    }
}

function task2() {
    $pdo = new PDO("mysql:host=localhost;dbname=my_db", 'spice', 'Spice123');
    $pdo->query("set names utf8");

    $sql = "SELECT * FROM users u WHERE u.`age`>50;";
    $query_result = $pdo->query($sql);
    $result = $query_result->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function task3() {
    $pdo = new PDO("mysql:host=localhost;dbname=my_db", 'spice', 'Spice123');
    $pdo->query("set names utf8");

    $sql = "SELECT * FROM users u WHERE u.`name` LIKE 'ав' OR u.`name` LIKE 'аб';";
    $query_result = $pdo->query($sql);
    $result = $query_result->fetchAll(PDO::FETCH_ASSOC);

    $json_result = json_encode($result);

    echo $json_result;
}

function task4() {
    $pdo = new PDO("mysql:host=localhost;dbname=my_db", 'spice', 'Spice123');
    $pdo->query("set names utf8");

    $sql = "SELECT name FROM users u WHERE age > 70;";
    $query_result = $pdo->query($sql);
    $result = $query_result->fetchAll(PDO::FETCH_ASSOC);
    $name_list = [];
    foreach ($result as $elem) {
        $name = $elem["name"];
        array_push($name_list, $name);
    }

    $sql = "UPDATE users SET NAME='ass' WHERE age > 70;";
    $pdo->query($sql);

    return $name_list;
}

function task5() {
    $pdo = new PDO("mysql:host=localhost;dbname=my_db", 'spice', 'Spice123');
    $pdo->query("set names utf8");

    $sql = "SELECT DISTINCT u.`name` FROM users u;";
    $query_result = $pdo->query($sql);
    $result = $query_result->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $elem) {
        echo $elem["name"]."<br>";
    }
}

function main() {
    task1();
    task2();
    task3();
    task4();
    task5();
}

main();
