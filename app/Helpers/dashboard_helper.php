<?php

if (!function_exists('time_ago')) {
    function time_ago($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
        
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
        
        $string = [
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        ];
        
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
        
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
    if (!function_exists('character_limiter')) {
    /**
     * Membatasi jumlah karakter seperti di CI3 (Compatibility)
     *
     * @param string $str     Teks input
     * @param int $limit      Jumlah maksimal karakter
     * @param string $end_char Akhiran (contoh: ...)
     * @return string
     */
    function character_limiter(string $str, int $limit = 100, string $end_char = '...'): string
    {
        if (strlen($str) <= $limit) {
            return $str;
        }

        return rtrim(mb_substr($str, 0, $limit, 'UTF-8')) . $end_char;
    }
}
}