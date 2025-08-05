<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\SparePart;
use App\Models\Supplier;
use App\Models\User;
use App\Models\UsageRecord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
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

    public function test_manager_can_view_dashboard(): void
    {
        // Create test data
        SparePart::factory()->count(5)->create();
        SparePart::factory()->lowStock()->count(2)->create();
        Supplier::factory()->count(3)->create();
        UsageRecord::factory()->pending()->count(3)->create();

        $response = $this->actingAs($this->manager)->get('dashboard');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('dashboard')
                ->has('stats')
                ->has('recentUsage')
                ->has('lowStockItems')
                ->has('user')
        );
    }

    public function test_staff_can_view_dashboard(): void
    {
        // Create test data
        SparePart::factory()->count(5)->create();
        UsageRecord::factory()->create(['user_id' => $this->staff->id]);

        $response = $this->actingAs($this->staff)->get('dashboard');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('dashboard')
                ->has('stats')
                ->has('user')
        );
    }

    public function test_dashboard_shows_correct_stats(): void
    {
        $response = $this->actingAs($this->manager)->get('dashboard');

        $response->assertInertia(fn ($page) => 
            $page->has('stats')
                ->has('stats.total_spare_parts')
                ->has('stats.low_stock_items')
                ->has('stats.total_suppliers')
                ->has('stats.pending_requests')
        );
    }

    public function test_dashboard_shows_low_stock_alerts(): void
    {
        // Clean database first
        SparePart::query()->delete();
        
        $lowStockPart = SparePart::factory()->create([
            'name' => 'Critical Part',
            'quantity' => 2,
            'minimum_stock' => 5,
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->manager)->get('dashboard');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->has('lowStockItems', 1)
                ->where('lowStockItems.0.name', 'Critical Part')
        );
    }

    public function test_dashboard_shows_recent_usage_for_staff(): void
    {
        $sparePart = SparePart::factory()->create();
        $usage = UsageRecord::factory()->create([
            'user_id' => $this->staff->id,
            'spare_part_id' => $sparePart->id,
            'purpose' => 'Maintenance work',
        ]);

        $response = $this->actingAs($this->staff)->get('dashboard');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->has('recentUsage', 1)
                ->where('recentUsage.0.purpose', 'Maintenance work')
        );
    }
}