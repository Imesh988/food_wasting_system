<?php
namespace App\Helpers;

class Gs1Parser
{
    public static function parse(string $s): array
    {
        $result = ['gtin'=>null,'expiry'=>null,'batch'=>null,'raw'=>$s];
        $s = trim($s);

        if (preg_match('/\(?01\)?(\d{14})/', $s, $m)) $result['gtin'] = $m[1];
        if (preg_match('/\(?17\)?(\d{6})/', $s, $m)) {
            $yy = substr($m[1],0,2); $mm = substr($m[1],2,2); $dd = substr($m[1],4,2);
            $year = 2000 + intval($yy);
            if (checkdate(intval($mm), intval($dd), $year)) {
                $result['expiry'] = sprintf('%04d-%02d-%02d',$year,intval($mm),intval($dd));
            }
        }
        if (preg_match('/\(?10\)?([^\(\)]+)/', $s, $m)) $result['batch'] = trim($m[1]);

        return $result;
    }
}
