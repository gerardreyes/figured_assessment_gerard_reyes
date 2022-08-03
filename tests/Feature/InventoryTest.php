<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Inventory;

class InventoryTest extends TestCase
{
    /**
     * Visit the inventories home page.
     * Expected response is 200.
     *
     * @return void
     */
    public function test_visit_inventories_home_page()
    {
        $response = $this->get('/inventories');
        $response->assertStatus(200);
    }

    /**
     * Get all Available Units.
     * Expected result is no unit with zero balance is taken.
     *
     * @return void
     */
    public function test_get_only_available_units()
    {
        $availableUnits = Inventory::available()->get();
        foreach ($availableUnits as $unit) {
            $this->assertNotEquals(0, $unit->balance);
        }
    }

    /**
     * Get all Quantity On Hand.
     * Expected result is Total Quantity On Hand and Total Price.
     *
     * @return void
     */
    public function test_get_quantity_on_hand()
    {
        $expectedPrice = $expectedTotal = 0;
        $availableUnits = Inventory::available()->get();

        $model = new Inventory();
        $quantityOnHand = $model->getQuantityOnHand($availableUnits); // Get the total quantity and price based on available units.

        foreach ($availableUnits as $unit) {
            $expectedPrice += $unit->balance * $unit->unit_price;
            $expectedTotal += $unit->balance;
        }

        $this->assertEquals($expectedPrice, $quantityOnHand['price']);
        $this->assertEquals($expectedTotal, $quantityOnHand['total']);
    }
}
