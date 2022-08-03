<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'transaction_date',
        'type',
        'quantity',
        'balance',
        'unit_price',
    ];

    use HasFactory;


    // Get the total quantity and price based on available units.
    public function getQuantityOnHand($availableUnits)
    {
        $price = $total = 0;
        foreach ($availableUnits as $unit) {
            $total += $unit->balance; // Add current balance to the running total.
            $price += $unit->balance * $unit->unit_price; // Add the current price to the total price by multiplying balance to the unit price.
        }
        return ['total' => $total, 'price' => $price];
    }

    // Updates the balance of inventory based on the number of applications entered.
    public function updateQuantityOnHand($availableUnits, $application)
    {
        foreach ($availableUnits as $unit) {
            $newBalance = $unit->balance - $application; // Set the new balance by subtracting current balance to the number of applications.
            $application = $application - $unit->balance; // Set the new number of applications by subtracting application to the current balance.

            // In case the new amount is negative, change it to zero, else use current value.
            $newBalance = $newBalance <= 0 ? 0 : $newBalance;
            $application = $application <= 0 ? 0 : $application;

            Inventory::whereId($unit->id)->update(['balance' => $newBalance]); // Update the new balance in the inventories table.

            // If no more number of applications remaining, end the loop.
            if ($application <= 0) {
                break;
            }
        }
    }

    // Get all inventory that have balance using scope.
    public function scopeAvailable($query)
    {
        $query->where('balance', '>', 0);
    }
}
