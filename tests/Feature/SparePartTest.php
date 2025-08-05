<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\SparePart;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SparePartTest extends TestCase
{
    use RefreshDatabase;

    protected User $manager;
    protected User $staff;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles
        $managerRole = Role::factory()->create(['name' => 'manager']);
        $staffRole = Role::factory()->create(['name' => 'staff_engineering']);

        // Create users
        $this->manager = User::factory()->create(['role_id' => $managerRole->id]);
        $this->staff = User::factory()->create(['role_id' => $staffRole->id]);
    }

    public function test_manager_can_view_spare_parts_index(): void
    {
        SparePart::factory()->count(3)->create();

        $response = $this->actingAs($this->manager)->get('/spare-parts');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('spare-parts/index'));
    }

    public function test_staff_can_view_spare_parts_index(): void
    {
        SparePart::factory()->count(3)->create();

        $response = $this->actingAs($this->staff)->get('/spare-parts');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('spare-parts/index'));
    }

    public function test_manager_can_create_spare_part(): void
    {
        $supplier = Supplier::factory()->create();

        $response = $this->actingAs($this->manager)->post('/spare-parts', [
            'name' => 'Test Spare Part',
            'code' => 'TSP-001',
            'quantity' => 10,
            'storage_location' => 'A1-B2',
            'price' => 99.99,
            'minimum_stock' => 5,
            'supplier_id' => $supplier->id,
            'description' => 'Test description',
            'status' => 'active',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('spare_parts', [
            'name' => 'Test Spare Part',
            'code' => 'TSP-001',
        ]);
    }

    public function test_staff_cannot_create_spare_part(): void
    {
        $supplier = Supplier::factory()->create();

        $response = $this->actingAs($this->staff)->post('/spare-parts', [
            'name' => 'Test Spare Part',
            'code' => 'TSP-001',
            'quantity' => 10,
            'storage_location' => 'A1-B2',
            'price' => 99.99,
            'minimum_stock' => 5,
            'supplier_id' => $supplier->id,
            'description' => 'Test description',
            'status' => 'active',
        ]);

        $response->assertStatus(403);
    }

    public function test_spare_part_search_functionality(): void
    {
        SparePart::factory()->create(['name' => 'HVAC Filter']);
        SparePart::factory()->create(['name' => 'Water Pump']);

        $response = $this->actingAs($this->manager)->get('/spare-parts?search=HVAC');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('spare-parts/index')
                ->has('spareParts.data', 1)
        );
    }

    public function test_low_stock_filter(): void
    {
        SparePart::factory()->lowStock()->count(2)->create();
        SparePart::factory()->create(['quantity' => 50, 'minimum_stock' => 10]);

        $response = $this->actingAs($this->manager)->get('/spare-parts?low_stock=true');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('spare-parts/index')
                ->has('spareParts.data', 2)
        );
    }
}