<?php
require_once '/var/www/vendor/autoload.php';
require_once 'api.php';

use CpChart\Data;
use CpChart\Image;
use CpChart\Chart\Pie;
use Ajaxray\PHPWatermark\Watermark;

// Круговая диаграмма
function get_pie_chart() {
    // Получаем записи из базы данных
    $entries = read_entries_with_service_name();
    // Подсчет записей с комментариями и без
    $withComment = 0;
    $withoutComment = 0;

    foreach ($entries as $entry) {
        if (!is_null($entry['comment'])) {
            $withComment++;
        } else {
            $withoutComment++;
        }
    }

    $dataPie = new Data();
    $dataPie->addPoints([$withComment, $withoutComment], "Comments");
    $dataPie->setSerieDescription("Comments", "With/Without Comments");
    $dataPie->addPoints(["with comment (" . $withComment . ")", "without comment (" . $withoutComment . ")"], "Labels");
    $dataPie->setAbscissa("Labels");

    $imagePie = new Image(600, 400, $dataPie);

    // Создаем объект для круговой диаграммы
    $pieChart = new Pie($imagePie, $dataPie);
    $pieChart->draw2DPie(300, 200, ["DrawLabels" => true]);

    // Сохраняем изображение
    $imagePie->Render("storage/graph1.png");
}


// Столбчатая диаграмма по полю amount
function get_amount_distribution() {
    // Получаем записи из базы данных
    $entries = read_entries_with_service_name();

    $dataBarAmount = new Data();
    $temp = array_column($entries, 'amount');
    $amounts = [];
    foreach($temp as $item) {
        if (!isset($amounts[$item])) {
            $amounts[$item] = 0;
        }
        $amounts[$item]++;
    }
    ksort($amounts);

    $dataBarAmount->addPoints($amounts, "Amounts");
    $dataBarAmount->setSerieDescription("Amounts", "Amount");
    $dataBarAmount->addPoints(array_keys($amounts), "Labels");
    $dataBarAmount->setAbscissa("Labels");

    $imageBarAmount = new Image(600, 400, $dataBarAmount);
    $imageBarAmount->setGraphArea(30, 30, 580, 380);
    $imageBarAmount->drawScale();
    $imageBarAmount->drawBarChart();
    $imageBarAmount->Render("storage/graph2.png");
}

// Столбчатая диаграмма по стоимости заказа для каждого клиента

function get_cost_per_client() {
    // Получаем записи из базы данных
    $entries = read_entries_with_service_name();

    $dataBarCost = new Data();
    $costs = [];
    foreach ($entries as $entry) {
        $cost = $entry['amount'] * $entry['cost'];
        $costs[$entry['customer_name']] = isset($costs[$entry['customer_name']]) ? $costs[$entry['customer_name']] + $cost : $cost;
    }

    $dataBarCost->addPoints(array_values($costs), "Costs");
    $dataBarCost->setSerieDescription("Costs", "Total Cost by Customer");
    $dataBarCost->addPoints(array_keys($costs), "Labels");
    $dataBarCost->setAbscissa("Labels");

    $imageBarCost = new Image(1050, 800, $dataBarCost);
    $imageBarCost->setGraphArea(50, 30, 1030, 580);
    $imageBarCost->drawScale(["LabelRotation"=>90]);
    $imageBarCost->drawBarChart();
    $imageBarCost->Render("storage/graph3.png");
}

function overlay_watermarks() {
    $WATERMARK_DENSITY = 250; // расстояние между водяными знаками

    for ($i = 1; $i <= 3; $i++) {
        $image_path = "storage/graph" . $i . ".png";
        $img = imagecreatefrompng($image_path);
        $img_size = getimagesize($image_path);
        $watermark = imagecreatefrompng("storage/logo_transparent.png");

        $res_width = $img_size[0];
        $res_height = $img_size[1];

        $watermark_width = imagesx($watermark);
        $watermark_height = imagesy($watermark);

        $res_img = imagecreatetruecolor($res_width,$res_height);
        imagecopyresampled($res_img,$img,0,0,0,0,
            $res_width,$res_height,$img_size[0],$img_size[1]);

        for ($j = 0; $j < ($res_width / $WATERMARK_DENSITY); $j++) {
            for ($k = 0; $k < ($res_height / $WATERMARK_DENSITY); $k++) {
                $watermark_pos_x = $watermark_width / 2 + $j * $WATERMARK_DENSITY;
                $watermark_pos_y = $watermark_height / 2 + $k * $WATERMARK_DENSITY;

                imagecopy($res_img,$watermark,$watermark_pos_x,$watermark_pos_y,
        0,0,$watermark_width,$watermark_height);
            }
        }

        imagepng($res_img, $image_path);
    }
}
?>