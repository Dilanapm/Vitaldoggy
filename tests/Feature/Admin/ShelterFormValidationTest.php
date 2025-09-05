<?php

namespace Tests\Feature\Admin;

use App\Models\Shelter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ShelterFormValidationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->adminUser = User::factory()->create([
            'roles' => json_encode(['admin']),
            'email_verified_at' => now(),
        ]);
    }

    /** @test */
    public function form_validation_displays_correct_error_messages_in_spanish()
    {
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.shelters.store'), []);

        $response->assertSessionHasErrors([
            'name',
            'email',
            'phone',
            'address',
            'city',
            'status'
        ]);

        $errors = session('errors')->getBag('default');
        
        $this->assertStringContainsString('El nombre del refugio es obligatorio', $errors->first('name'));
        $this->assertStringContainsString('El email es obligatorio', $errors->first('email'));
        $this->assertStringContainsString('El teléfono es obligatorio', $errors->first('phone'));
        $this->assertStringContainsString('La dirección es obligatoria', $errors->first('address'));
        $this->assertStringContainsString('La ciudad es obligatoria', $errors->first('city'));
        $this->assertStringContainsString('El estado es obligatorio', $errors->first('status'));
    }

    /** @test */
    public function form_validates_email_format()
    {
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.shelters.store'), [
                'name' => 'Test Shelter',
                'email' => 'invalid-email-format',
                'phone' => '123-456-7890',
                'address' => 'Test Address',
                'city' => 'Test City',
                'status' => 'active'
            ]);

        $response->assertSessionHasErrors(['email']);
        $errors = session('errors')->getBag('default');
        $this->assertStringContainsString('Debe proporcionar un email válido', $errors->first('email'));
    }

    /** @test */
    public function form_validates_unique_email()
    {
        Shelter::factory()->create(['email' => 'existing@test.com']);

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.shelters.store'), [
                'name' => 'Test Shelter',
                'email' => 'existing@test.com',
                'phone' => '123-456-7890',
                'address' => 'Test Address',
                'city' => 'Test City',
                'status' => 'active'
            ]);

        $response->assertSessionHasErrors(['email']);
        $errors = session('errors')->getBag('default');
        $this->assertStringContainsString('Ya existe un refugio con este email', $errors->first('email'));
    }

    /** @test */
    public function form_validates_capacity_minimum()
    {
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.shelters.store'), [
                'name' => 'Test Shelter',
                'email' => 'test@shelter.com',
                'phone' => '123-456-7890',
                'address' => 'Test Address',
                'city' => 'Test City',
                'capacity' => 0,
                'status' => 'active'
            ]);

        $response->assertSessionHasErrors(['capacity']);
        $errors = session('errors')->getBag('default');
        $this->assertStringContainsString('La capacidad debe ser al menos 1', $errors->first('capacity'));
    }

    /** @test */
    public function form_validates_capacity_maximum()
    {
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.shelters.store'), [
                'name' => 'Test Shelter',
                'email' => 'test@shelter.com',
                'phone' => '123-456-7890',
                'address' => 'Test Address',
                'city' => 'Test City',
                'capacity' => 1001,
                'status' => 'active'
            ]);

        $response->assertSessionHasErrors(['capacity']);
        $errors = session('errors')->getBag('default');
        $this->assertStringContainsString('La capacidad no puede exceder 1000', $errors->first('capacity'));
    }

    /** @test */
    public function form_validates_status_enum()
    {
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.shelters.store'), [
                'name' => 'Test Shelter',
                'email' => 'test@shelter.com',
                'phone' => '123-456-7890',
                'address' => 'Test Address',
                'city' => 'Test City',
                'status' => 'invalid_status'
            ]);

        $response->assertSessionHasErrors(['status']);
        $errors = session('errors')->getBag('default');
        $this->assertStringContainsString('El estado debe ser activo o inactivo', $errors->first('status'));
    }

    /** @test */
    public function form_validates_image_file_type()
    {
        Storage::fake('public');

        $invalidFile = UploadedFile::fake()->create('document.txt', 100, 'text/plain');

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.shelters.store'), [
                'name' => 'Test Shelter',
                'email' => 'test@shelter.com',
                'phone' => '123-456-7890',
                'address' => 'Test Address',
                'city' => 'Test City',
                'status' => 'active',
                'image' => $invalidFile
            ]);

        $response->assertSessionHasErrors(['image']);
        $errors = session('errors')->getBag('default');
        $this->assertStringContainsString('La imagen debe ser de tipo: jpeg, jpg, png', $errors->first('image'));
    }

    /** @test */
    public function form_validates_image_file_size()
    {
        Storage::fake('public');

        // Crear imagen de 3MB (mayor al límite de 2MB)
        $largeImage = UploadedFile::fake()->image('large.jpg')->size(3072);

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.shelters.store'), [
                'name' => 'Test Shelter',
                'email' => 'test@shelter.com',
                'phone' => '123-456-7890',
                'address' => 'Test Address',
                'city' => 'Test City',
                'status' => 'active',
                'image' => $largeImage
            ]);

        $response->assertSessionHasErrors(['image']);
        $errors = session('errors')->getBag('default');
        $this->assertStringContainsString('La imagen no puede ser mayor a 2MB', $errors->first('image'));
    }

    /** @test */
    public function form_validates_string_max_lengths()
    {
        $longString = str_repeat('a', 256);

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.shelters.store'), [
                'name' => $longString,
                'email' => 'test@shelter.com',
                'phone' => str_repeat('1', 21),
                'address' => $longString,
                'city' => str_repeat('c', 101),
                'description' => str_repeat('d', 1001),
                'status' => 'active'
            ]);

        $response->assertSessionHasErrors([
            'name',
            'phone',
            'address',
            'city',
            'description'
        ]);

        $errors = session('errors')->getBag('default');
        $this->assertStringContainsString('El nombre no puede tener más de 255 caracteres', $errors->first('name'));
        $this->assertStringContainsString('El teléfono no puede tener más de 20 caracteres', $errors->first('phone'));
        $this->assertStringContainsString('La dirección no puede tener más de 255 caracteres', $errors->first('address'));
        $this->assertStringContainsString('La ciudad no puede tener más de 100 caracteres', $errors->first('city'));
        $this->assertStringContainsString('La descripción no puede tener más de 1000 caracteres', $errors->first('description'));
    }

    /** @test */
    public function update_form_allows_same_email_for_current_shelter()
    {
        $shelter = Shelter::factory()->create(['email' => 'original@test.com']);

        $response = $this->actingAs($this->adminUser)
            ->put(route('admin.shelters.update', $shelter), [
                'name' => 'Updated Shelter',
                'email' => 'original@test.com', // Same email should be allowed
                'phone' => '123-456-7890',
                'address' => 'Updated Address',
                'city' => 'Updated City',
                'status' => 'active'
            ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function update_form_validates_unique_email_for_other_shelters()
    {
        $shelter1 = Shelter::factory()->create(['email' => 'shelter1@test.com']);
        $shelter2 = Shelter::factory()->create(['email' => 'shelter2@test.com']);

        $response = $this->actingAs($this->adminUser)
            ->put(route('admin.shelters.update', $shelter2), [
                'name' => 'Updated Shelter',
                'email' => 'shelter1@test.com', // Email from another shelter
                'phone' => '123-456-7890',
                'address' => 'Updated Address',
                'city' => 'Updated City',
                'status' => 'active'
            ]);

        $response->assertSessionHasErrors(['email']);
        $errors = session('errors')->getBag('default');
        $this->assertStringContainsString('Ya existe un refugio con este email', $errors->first('email'));
    }
}
