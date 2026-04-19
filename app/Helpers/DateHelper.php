<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function parse($data): array
    {
        $date = Carbon::parse($data);

        return [
            'anno' => $date->year,
            'mese' => $date->month,
            'giorno' => $date->day,
            'ora' => $date->format('H:i'),
        ];
    }

    public static function format($data): string
    {
        return Carbon::parse($data)->format('d-m-Y H:i');
    }

    public static function formatItalianDate($data): string
    {
        return Carbon::parse($data)->format('d/m/Y');
    }

    public static function monthName(int $mese): string
    {
        return match ($mese) {
            1 => 'Gennaio',
            2 => 'Febbraio',
            3 => 'Marzo',
            4 => 'Aprile',
            5 => 'Maggio',
            6 => 'Giugno',
            7 => 'Luglio',
            8 => 'Agosto',
            9 => 'Settembre',
            10 => 'Ottobre',
            11 => 'Novembre',
            12 => 'Dicembre',
            default => '',
        };
    }
}
