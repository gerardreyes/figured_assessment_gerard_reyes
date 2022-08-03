<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Populate the inventories table using the csv provided as its source data.
        $csvFile = fopen(storage_path("Fertiliser_Inventory_Movements.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile)) !== FALSE) {
            if (!$firstline) {
                DB::table('inventories')->insert([
                    'transaction_date' => Carbon::createFromFormat('d/m/Y', $data[0])->format('Y-m-d'),
                    'type' => $data[1],
                    'quantity' => $data[2],
                    'balance' => $data[2],
                    'unit_price' => !empty($data[3]) ? $data[3] : 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
