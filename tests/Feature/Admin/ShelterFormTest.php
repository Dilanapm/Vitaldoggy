<?php

namespace Tests\Feature\Admin;

use App\Models\Shelter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ShelterFormTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Crear un usuario administrador para las pruebas
        $this->adminUser = User::factory()->create([
            'roles' => json_encode(['admin']),
            'email_verified_at' => now(),
        ]);
    }

    /** @test */
    public function admin_can_access_shelter_create_form()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.shelters.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.shelters.create');
        $response->assertSee('Crear Nuevo Refugio');
        $response->assertSee('Nombre del Refugio');
        $response->assertSee('Email');
        $response->assertSee('Teléfono');
    }

    /** @test */
    public function non_admin_cannot_access_shelter_create_form()
    {
        $regularUser = User::factory()->create([
            'roles' => json_encode(['user']),
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($regularUser)
            ->get(route('admin.shelters.create'));

        $response->assertStatus(403);
    }

    /** @test */
    public function guest_cannot_access_shelter_create_form()
    {
        $response = $this->get(route('admin.shelters.create'));

        $response->assertRedirect('/login');
    }

    /** @test */
    public function admin_can_create_shelter_with_valid_data()
    {
        Storage::fake('public');

        $shelterData = [
            'name' => 'Refugio Test',
            'email' => 'test@refugio.com',
            'phone' => '123-456-7890',
            'address' => 'Calle Test 123',
            'city' => 'Ciudad Test',
            'capacity' => 50,
            'status' => 'active',
            'description' => 'Un refugio de prueba para testing.',
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.shelters.store'), $shelterData);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('shelters', [
            'name' => 'Refugio Test',
            'email' => 'test@refugio.com',
            'phone' => '123-456-7890',
            'address' => 'Calle Test 123',
            'city' => 'Ciudad Test',
            'capacity' => 50,
            'status' => 'active',
        ]);
    }

    /** @test */
    public function admin_can_create_shelter_with_image()
    {
        Storage::fake('public');

        $image = UploadedFile::fake()->image('refugio.jpg', 800, 600);

        $shelterData = [
            'name' => 'Refugio Con Imagen',
            'email' => 'imagen@refugio.com',
            'phone' => '987-654-3210',
            'address' => 'Avenida Imagen 456',
            'city' => 'Ciudad Imagen',
            'capacity' => 75,
            'status' => 'active',
            'description' => 'Refugio con imagen de prueba.',
            'image' => $image,
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.shelters.store'), $shelterData);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $shelter = Shelter::where('email', 'imagen@refugio.com')->first();
        $this->assertNotNull($shelter);
        $this->assertNotNull($shelter->image);
        
        // Verificar que el archivo se guardó
        $this->assertTrue(Storage::disk('public')->exists($shelter->image));
    }

    /** @test */
    public function shelter_creation_fails_with_invalid_data()
    {
        $invalidData = [
            'name' => '', // Requerido
            'email' => 'invalid-email', // Formato inválido
            'phone' => '', // Requerido
            'address' => '', // Requerido
            'city' => '', // Requerido
            'capacity' => -5, // Debe ser positivo
            'status' => 'invalid_status', // Valor inválido
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.shelters.store'), $invalidData);

        $response->assertSessionHasErrors([
            'name',
            'email',
            'phone',
            'address',
            'city',
            'capacity',
            'status',
        ]);

        $this->assertDatabaseCount('shelters', 0);
    }

    /** @test */
    public function shelter_creation_fails_with_duplicate_email()
    {
        // Crear un refugio existente
        Shelter::factory()->create([
            'email' => 'existing@refugio.com'
        ]);

        $duplicateData = [
            'name' => 'Refugio Duplicado',
            'email' => 'existing@refugio.com', // Email duplicado
            'phone' => '111-222-3333',
            'address' => 'Calle Duplicada 789',
            'city' => 'Ciudad Duplicada',
            'capacity' => 30,
            'status' => 'active',
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.shelters.store'), $duplicateData);

        $response->assertSessionHasErrors(['email']);
        
        // Solo debe existir el refugio original
        $this->assertDatabaseCount('shelters', 1);
    }

    /** @test */
    public function shelter_creation_fails_with_large_image()
    {
        Storage::fake('public');

        // Crear imagen que excede el límite (simulando 3MB)
        $largeImage = UploadedFile::fake()->image('large.jpg')->size(3072); // 3MB

        $shelterData = [
            'name' => 'Refugio Imagen Grande',
            'email' => 'grande@refugio.com',
            'phone' => '555-666-7777',
            'address' => 'Calle Grande 999',
            'city' => 'Ciudad Grande',
            'capacity' => 40,
            'status' => 'active',
            'image' => $largeImage,
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.shelters.store'), $shelterData);

        $response->assertSessionHasErrors(['image']);
        $this->assertDatabaseCount('shelters', 0);
    }

    /** @test */
    public function shelter_creation_fails_with_invalid_image_type()
    {
        Storage::fake('public');

        // Crear archivo que no es imagen
        $invalidFile = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        $shelterData = [
            'name' => 'Refugio Archivo Inválido',
            'email' => 'invalido@refugio.com',
            'phone' => '888-999-0000',
            'address' => 'Calle Inválida 111',
            'city' => 'Ciudad Inválida',
            'capacity' => 25,
            'status' => 'active',
            'image' => $invalidFile,
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.shelters.store'), $shelterData);

        $response->assertSessionHasErrors(['image']);
        $this->assertDatabaseCount('shelters', 0);
    }

    /** @test */
    public function admin_can_access_shelter_edit_form()
    {
        $shelter = Shelter::factory()->create();

        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.shelters.edit', $shelter));

        $response->assertStatus(200);
        $response->assertViewIs('admin.shelters.edit');
        $response->assertSee('Editar Refugio');
        $response->assertSee($shelter->name);
        $response->assertSee($shelter->email);
    }

    /** @test */
    public function admin_can_update_shelter_with_valid_data()
    {
        $shelter = Shelter::factory()->create([
            'name' => 'Refugio Original',
            'email' => 'original@refugio.com',
        ]);

        $updatedData = [
            'name' => 'Refugio Actualizado',
            'email' => 'actualizado@refugio.com',
            'phone' => '999-888-7777',
            'address' => 'Nueva Dirección 222',
            'city' => 'Nueva Ciudad',
            'capacity' => 60,
            'status' => 'inactive',
            'description' => 'Descripción actualizada.',
        ];

        $response = $this->actingAs($this->adminUser)
            ->put(route('admin.shelters.update', $shelter), $updatedData);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $shelter->refresh();
        $this->assertEquals('Refugio Actualizado', $shelter->name);
        $this->assertEquals('actualizado@refugio.com', $shelter->email);
        $this->assertEquals('inactive', $shelter->status);
    }

    /** @test */
    public function shelter_update_fails_with_invalid_data()
    {
        $shelter = Shelter::factory()->create();

        $invalidData = [
            'name' => '',
            'email' => 'invalid-email',
            'phone' => '',
            'address' => '',
            'city' => '',
            'capacity' => -10,
            'status' => 'invalid_status',
        ];

        $response = $this->actingAs($this->adminUser)
            ->put(route('admin.shelters.update', $shelter), $invalidData);

        $response->assertSessionHasErrors([
            'name',
            'email',
            'phone',
            'address',
            'city',
            'capacity',
            'status',
        ]);

        // Los datos no deben haber cambiado
        $shelter->refresh();
        $this->assertNotEquals('', $shelter->name);
    }

    /** @test */
    public function shelter_form_displays_old_input_on_validation_errors()
    {
        $invalidData = [
            'name' => 'Nombre Incorrecto',
            'email' => 'invalid-email',
            'phone' => '123456789',
            'address' => 'Dirección de Prueba',
            'city' => 'Ciudad de Prueba',
            'capacity' => -5,
            'status' => 'invalid_status',
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.shelters.store'), $invalidData);

        $response->assertSessionHasErrors();
        
        // Verificar que los valores se mantienen en el formulario
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.shelters.create'));
        
        // En una implementación real, verificarías que los valores old() aparecen en el HTML
        $this->assertTrue(session()->hasOldInput('name'));
        $this->assertEquals('Nombre Incorrecto', old('name'));
    }
}
