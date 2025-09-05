<?php

namespace Tests\Feature;

use App\Models\Shelter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ShelterFormQuickTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_shelter()
    {
        Storage::fake('public');
        
        $admin = User::factory()->create([
            'roles' => json_encode(['admin']),
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.shelters.store'), [
                'name' => 'Test Shelter',
                'email' => 'test@shelter.com',
                'phone' => '123-456-7890',
                'address' => 'Test Address',
                'city' => 'Test City',
                'capacity' => 50,
                'status' => 'active',
                'description' => 'Test description',
            ]);

        $this->assertDatabaseHas('shelters', [
            'name' => 'Test Shelter',
            'email' => 'test@shelter.com',
        ]);

        $response->assertRedirect();
    }

    public function test_form_validation_works()
    {
        $admin = User::factory()->create([
            'roles' => json_encode(['admin']),
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.shelters.store'), []);

        $response->assertSessionHasErrors([
            'name', 'email', 'phone', 'address', 'city', 'status'
        ]);
    }
}
