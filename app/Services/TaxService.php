<?php

namespace App\Services;

use App\Models\Pegawai;
use App\Models\TaxConfiguration;

class TaxService
{
    /**
     * Calculate PPh 21 based on Gross Salary and Pegawai's PTKP Status (TER Method).
     *
     * @param Pegawai $pegawai
     * @param float $grossSalary
     * @return float
     */
    public function calculatePPh21(Pegawai $pegawai, float $grossSalary): float
    {
        // 1. Get PTKP Category (A, B, or C) from Pegawai model accessor
        $category = $pegawai->ptkp_category; // 'A', 'B', 'C'

        // 2. Find applicable TER bracket
        // query where category matches AND gross is between min and max
        $config = TaxConfiguration::where('category', $category)
            ->where('min_gross', '<=', $grossSalary)
            ->where(function ($query) use ($grossSalary) {
                // Handle infinity (last bracket often has max_gross as null or huge)
                $query->where('max_gross', '>=', $grossSalary)
                      ->orWhereNull('max_gross');
            })
            ->first();

        if (!$config) {
            // Fallback strategy: if salary is higher than highest stored bracket, use the highest rate?
            // Or log error. for now, let's look for the highest bracket in that category.
             $highest = TaxConfiguration::where('category', $category)->orderByDesc('min_gross')->first();
             if ($highest && $grossSalary >= $highest->min_gross) {
                 $config = $highest;
             } else {
                 return 0; // Should not happen if brackets start at 0
             }
        }

        // 3. Calculate Tax
        return $grossSalary * $config->rate;
    }
}
