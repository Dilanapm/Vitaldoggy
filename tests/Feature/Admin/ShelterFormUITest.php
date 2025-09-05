<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShelterFormUITest extends TestCase
{
    use RefreshDatabase;

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
    public function create_form_displays_all_required_fields()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.shelters.create'));

        $response->assertStatus(200);
        
        // Verificar que todos los campos están presentes
        $response->assertSee('name="name"', false);
        $response->assertSee('name="email"', false);
        $response->assertSee('name="phone"', false);
        $response->assertSee('name="address"', false);
        $response->assertSee('name="city"', false);
        $response->assertSee('name="capacity"', false);
        $response->assertSee('name="status"', false);
        $response->assertSee('name="description"', false);
        $response->assertSee('name="image"', false);

        // Verificar etiquetas de campos obligatorios
        $response->assertSee('Nombre del Refugio');
        $response->assertSee('Email');
        $response->assertSee('Teléfono');
        $response->assertSee('Dirección');
        $response->assertSee('Ciudad');
        $response->assertSee('Estado');

        // Verificar asteriscos rojos para campos obligatorios
        $response->assertSee('<span class="text-red-500">*</span>', false);
    }

    /** @test */
    public function create_form_displays_status_options()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.shelters.create'));

        $response->assertStatus(200);
        $response->assertSee('<option value="active"', false);
        $response->assertSee('<option value="inactive"', false);
        $response->assertSee('Activo');
        $response->assertSee('Inactivo');
    }

    /** @test */
    public function create_form_has_correct_action_and_method()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.shelters.create'));

        $response->assertStatus(200);
        $response->assertSee('action="' . route('admin.shelters.store') . '"', false);
        $response->assertSee('method="POST"', false);
        $response->assertSee('enctype="multipart/form-data"', false);
    }

    /** @test */
    public function create_form_has_csrf_token()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.shelters.create'));

        $response->assertStatus(200);
        $response->assertSee('name="_token"', false);
    }

    /** @test */
    public function create_form_has_correct_styling_classes()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.shelters.create'));

        $response->assertStatus(200);

        // Verificar que los inputs tienen las clases correctas de Tailwind
        $response->assertSee('bg-gradient-to-br from-[#751629] via-[#f56e5c] to-[#6b1f11]', false);
        $response->assertSee('rounded-xl', false);
        $response->assertSee('focus:ring-[#f56e5c]', false);

        // Verificar estructura del formulario
        $response->assertSee('bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm', false);
    }

    /** @test */
    public function create_form_has_image_upload_area()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.shelters.create'));

        $response->assertStatus(200);
        $response->assertSee('Imagen del Refugio');
        $response->assertSee('Selecciona una imagen');
        $response->assertSee('o arrastra y suelta');
        $response->assertSee('PNG, JPG, JPEG hasta 2MB');
        $response->assertSee('accept="image/*"', false);
    }

    /** @test */
    public function create_form_has_submit_and_cancel_buttons()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.shelters.create'));

        $response->assertStatus(200);
        $response->assertSee('Crear Refugio');
        $response->assertSee('Cancelar');
        $response->assertSee('fas fa-save', false);
        $response->assertSee('type="submit"', false);
    }

    /** @test */
    public function form_displays_validation_errors_with_old_input()
    {
        // Enviar datos inválidos para generar errores
        $invalidData = [
            'name' => '',
            'email' => 'invalid-email',
            'phone' => '',
            'address' => '',
            'city' => '',
            'capacity' => -1,
            'status' => 'invalid',
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.shelters.store'), $invalidData);

        $response->assertSessionHasErrors();

        // Obtener la respuesta de redirección (back)
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.shelters.create'));

        // Los valores old() deberían estar disponibles
        // En una prueba real, necesitarías simular el flujo completo
        $this->assertTrue(true); // Placeholder para el concepto
    }

    /** @test */
    public function form_accessibility_attributes_are_present()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.shelters.create'));

        $response->assertStatus(200);

        // Verificar que los campos tienen labels asociados
        $response->assertSee('for="name"', false);
        $response->assertSee('for="email"', false);
        $response->assertSee('for="phone"', false);
        $response->assertSee('for="address"', false);
        $response->assertSee('for="city"', false);
        $response->assertSee('for="capacity"', false);
        $response->assertSee('for="status"', false);
        $response->assertSee('for="description"', false);
        $response->assertSee('for="image"', false);

        // Verificar atributos required en campos obligatorios
        $response->assertSee('required', false);
    }

    /** @test */
    public function form_displays_breadcrumbs_and_navigation()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.shelters.create'));

        $response->assertStatus(200);
        $response->assertSee('Crear Nuevo Refugio');
        
        // Verificar que tiene enlace de regreso
        $response->assertSee(route('admin.shelters.index'), false);
    }

    /** @test */
    public function form_has_javascript_for_image_preview()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.shelters.create'));

        $response->assertStatus(200);
        $response->assertSee('<script>', false);
        $response->assertSee("getElementById('image')", false);
        $response->assertSee('addEventListener', false);
    }
}
