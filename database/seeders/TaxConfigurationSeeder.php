<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaxConfiguration;

class TaxConfigurationSeeder extends Seeder
{
    public function run()
    {
        // TER A (TK/0, TK/1, K/0)
        $terA = [
            [0, 5400000, 0.00],
            [5400000, 5650000, 0.0025],
            [5650000, 5950000, 0.0050],
            [5950000, 6300000, 0.0075],
            [6300000, 6750000, 0.0100],
            [6750000, 7500000, 0.0150],
            [7500000, 8150000, 0.0200],
            [8150000, 9650000, 0.0300],
            [9650000, 11050000, 0.0400],
            [11050000, 12600000, 0.0500],
            [12600000, 15850000, 0.0600],
            [15850000, 19650000, 0.0700],
            [19650000, 24600000, 0.0800],
        ];

        foreach ($terA as $bracket) {
            TaxConfiguration::create([
                'category' => 'A',
                'min_gross' => $bracket[0],
                'max_gross' => $bracket[1],
                'rate' => $bracket[2],
            ]);
        }

        // TER B (TK/2, TK/3, K/1, K/2)
        $terB = [
            [0, 6200000, 0.00],
            [6200000, 6500000, 0.0025],
            [6500000, 6850000, 0.0050],
            [6850000, 7300000, 0.0075],
            [7300000, 7800000, 0.0100],
            [7800000, 8650000, 0.0150],
            [8650000, 9350000, 0.0200],
            [9350000, 10950000, 0.0300],
            [10950000, 12600000, 0.0400],
            [12600000, 14100000, 0.0500],
            [14100000, 17500000, 0.0600],
        ];

        foreach ($terB as $bracket) {
             TaxConfiguration::create([
                'category' => 'B',
                'min_gross' => $bracket[0],
                'max_gross' => $bracket[1],
                'rate' => $bracket[2],
            ]);
        }

         // TER C (K/3)
        $terC = [
            [0, 6600000, 0.00],
            [6600000, 6950000, 0.0025],
            [6950000, 7350000, 0.0050],
            [7350000, 7800000, 0.0075],
            [7800000, 8300000, 0.0100],
            [8300000, 9250000, 0.0150],
            [9250000, 10750000, 0.0200],
            [10750000, 12750000, 0.0300],
        ];

        foreach ($terC as $bracket) {
             TaxConfiguration::create([
                'category' => 'C',
                'min_gross' => $bracket[0],
                'max_gross' => $bracket[1],
                'rate' => $bracket[2],
            ]);
        }
    }
}
