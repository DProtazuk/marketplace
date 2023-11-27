<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";

class MyFunction
{
    public function checking_array_post($array)
    {
        $status = 0;

        foreach ($array as $item) {
            if (empty($_POST[$item]) || trim($_POST[$item]) === '') {
                $status = 1;
                break;
            }
        }

        if ($status === 1)
            return false;
        else return true;
    }

    public function random_unique_id()
    {
        return uniqid("unique_" . time());
    }

    public function random_link()
    {
        return uniqid(time());
    }



    public function random()
    {
        return time() * rand(15, 100) - date("d");
    }

    public function getExtension($str)
    {
        $i = explode('.', $str);
        return strtolower(end($i));
    }

    public function create_rating($num)
    {
        $rating = $num;

        // Округление оценки до ближайшего 0,5
        $rounded_rating = round($rating * 2) / 2;

        // Количество полных звезд
        $full_stars = floor($rounded_rating);

        // Определяем, нужна ли нам полузвезда
        $half_star = ($rounded_rating - $full_stars) >= 0.5;

        // HTML-код для отображения звезд
        $star_html = '';
        for ($i = 0; $i < $full_stars; $i++) {
            $star_html .= '<img width="10" height="10" src="/res/img/rating/full-star.png">';
        }
        if ($half_star) {
            $star_html .= '<img width="10" height="10" src="/res/img/rating/half-star.png">';
        }
        for ($i = 0; $i < 5 - $full_stars - ($half_star ? 1 : 0); $i++) {
            $star_html .= '<img width="10" height="10" src="/res/img/rating/empty-star.png">';
        }

        // Отображаем HTML-код звезд
        return $star_html;
    }

    public function create_ratingShop($num)
    {
        $rating = $num;

        // Округление оценки до ближайшего 0,5
        $rounded_rating = round($rating * 2) / 2;

        // Количество полных звезд
        $full_stars = floor($rounded_rating);

        // Определяем, нужна ли нам полузвезда
        $half_star = ($rounded_rating - $full_stars) >= 0.5;

        // HTML-код для отображения звезд
        $star_html = '';
        for ($i = 0; $i < $full_stars; $i++) {
            $star_html .= '<img width="15" height="15" src="/res/img/rating/full-star.png">';
        }
        if ($half_star) {
            $star_html .= '<img width="15" height="15" src="/res/img/rating/half-star.png">';
        }
        for ($i = 0; $i < 5 - $full_stars - ($half_star ? 1 : 0); $i++) {
            $star_html .= '<img width="15" height="15" src="/res/img/rating/empty-star.png">';
        }

        // Отображаем HTML-код звезд
        return $star_html;
    }

    public function transliterate($string) {
        $translit = array(
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch',
            'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
            'И' => 'I', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R',
            'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C', 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Shch',
            'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
            ' ' => '_'
        );

        $transliterated = strtr($string, $translit);
        return $transliterated;
    }
}