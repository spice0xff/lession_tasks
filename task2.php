<?php

function task1() {
    $index = 0;
    while (true) {
        $pow = $index++**2;
        if ($pow >= 10000) {
            break;
        }
        echo "$pow\n";
    }
}

function task2($string) {
    echo strrev($string)."\n";
}

function task3($raw_array) {
    foreach ($raw_array as $elem) {
        if (gettype($elem) == "string") {
            echo "Achtung! Achtung!\n";
            return;
        }
    }
    $sum = $raw_array[3] + $raw_array[6] + $raw_array[8];
    echo "$sum\n";
}

function task4() {
    $mondays_august_2019 = [
        "2019/08/05",
        "2019/08/12",
        "2019/08/19",
        "2019/08/26",
    ];
    foreach ($mondays_august_2019 as $monday) {
        echo "$monday\n";
    }
}

function task5($array_raw, $string_raw) {
    if (!$array_raw or !$string_raw) {
        return false;
    }

    $array_res = [];
    foreach ($array_raw as $elem) {
        array_push($array_res,(string)$elem.$string_raw);
    }
    return $array_res;
}

function task6($year, $month) {
    // Формирование даты из входных данных. Если при формировании возникла ошибка, вывод соответствующего сообщения.
    // Из задания не понятно, что значит "несуществующий год". Если год задан числом, то он определенно существует в том
    // смысле, что для него можно провести необходимые расчеты.
    $unix_time = @mktime(0, 0, 0, $month, 1, $year);
    if (!$unix_time) {
        echo "date parse error\n";
        return;
    }

    $start_month = getdate($unix_time)["mon"];
    while (true) {
        if (getdate($unix_time)["wday"] == 2) {
            print_r(date("Y-m-d\n", $unix_time));
        }
        $unix_time += 60*60*24;
        $current_month = getdate($unix_time)["mon"];
        if ($current_month != $start_month) {
            break;
        }
    }
}

function task7() {
    $number = 0;
    while (true) {
        $number += 1;
        # Пусть перебор всех комбинаций 3 и 7 возьмет на себя природа бинарных чисел.
        $bin_number = substr(str_replace("1", "7", str_replace("0", "3", decbin($number))), 1);

        if (strpos($bin_number, "3") === false or strpos($bin_number, "7") === false) {
            continue;
        }

        if ((int)$bin_number % 3 or (int)$bin_number % 7) {
            continue;
        }

        $num_sum = 0;
        for ($index=0; $index<strlen($bin_number); $index++) {
            $num_sum += (int)$bin_number[$index];
        }
        if ($num_sum % 3 or $num_sum % 7) {
            continue;
        }

        echo "$bin_number\n";
        break;
    }
}

function main() {
    task1();
    task2("ASS");
    task3([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
    task3([0, 1, "2", 3, 4, 5, 6, 7, 8, 9]);
    task4();
    print_r(task5([1, 2, 3], "ASS"));
    print_r(task5([1, 2, 3], ""));
    task6("2019", 10);
    task6("20192019201920192019", 10);
    task7();
}

main();
