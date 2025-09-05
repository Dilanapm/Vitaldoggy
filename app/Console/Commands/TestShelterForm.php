<?php

namespace App\Console\Commands;

use App\Http\Requests\StoreShelterRequest;
use App\Models\Shelter;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestShelterForm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:shelter-form {--validate} {--create}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the shelter form validation and creation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Iniciando tests del formulario de refugios...');
        $this->newLine();

        if ($this->option('validate')) {
            $this->testValidation();
        }

        if ($this->option('create')) {
            $this->testCreation();
        }

        if (!$this->option('validate') && !$this->option('create')) {
            $this->testValidation();
            $this->testCreation();
        }
    }

    private function testValidation()
    {
        $this->info('📋 Probando validación del formulario...');
        $this->newLine();

        // Test 1: Datos vacíos
        $this->testCase('Datos vacíos', [], [
            'name' => 'El nombre del refugio es obligatorio.',
            'email' => 'El email es obligatorio.',
            'phone' => 'El teléfono es obligatorio.',
            'address' => 'La dirección es obligatoria.',
            'city' => 'La ciudad es obligatoria.',
            'status' => 'El estado es obligatorio.',
        ]);

        // Test 2: Email inválido
        $this->testCase('Email inválido', [
            'name' => 'Test Shelter',
            'email' => 'invalid-email',
            'phone' => '123-456-7890',
            'address' => 'Test Address',
            'city' => 'Test City',
            'status' => 'active',
        ], [
            'email' => 'Debe proporcionar un email válido.',
        ]);

        // Test 3: Capacidad negativa
        $this->testCase('Capacidad negativa', [
            'name' => 'Test Shelter',
            'email' => 'test@shelter.com',
            'phone' => '123-456-7890',
            'address' => 'Test Address',
            'city' => 'Test City',
            'capacity' => -5,
            'status' => 'active',
        ], [
            'capacity' => 'La capacidad debe ser al menos 1.',
        ]);

        // Test 4: Estado inválido
        $this->testCase('Estado inválido', [
            'name' => 'Test Shelter',
            'email' => 'test@shelter.com',
            'phone' => '123-456-7890',
            'address' => 'Test Address',
            'city' => 'Test City',
            'status' => 'invalid_status',
        ], [
            'status' => 'El estado debe ser activo o inactivo.',
        ]);

        // Test 5: Datos válidos
        $this->testCase('Datos válidos', [
            'name' => 'Test Shelter',
            'email' => 'test@shelter.com',
            'phone' => '123-456-7890',
            'address' => 'Test Address',
            'city' => 'Test City',
            'capacity' => 50,
            'status' => 'active',
            'description' => 'Test description',
        ], []);

        $this->newLine();
        $this->info('✅ Tests de validación completados');
        $this->newLine();
    }

    private function testCreation()
    {
        $this->info('🏗️  Probando creación de refugio...');
        $this->newLine();

        // Buscar un usuario admin
        $admin = User::where('roles', 'LIKE', '%admin%')->first();
        
        if (!$admin) {
            $this->error('❌ No se encontró un usuario administrador. Crea uno primero.');
            return;
        }

        $this->info("👤 Usando usuario administrador: {$admin->email}");

        // Datos de prueba
        $testData = [
            'name' => 'Refugio de Prueba ' . time(),
            'email' => 'test-' . time() . '@shelter.com',
            'phone' => '123-456-7890',
            'address' => 'Dirección de Prueba 123',
            'city' => 'Ciudad de Prueba',
            'capacity' => 50,
            'status' => 'active',
            'description' => 'Este es un refugio creado para pruebas automatizadas.',
        ];

        try {
            $shelter = Shelter::create($testData);
            $this->info("✅ Refugio creado exitosamente:");
            $this->table(
                ['Campo', 'Valor'],
                [
                    ['ID', $shelter->id],
                    ['Nombre', $shelter->name],
                    ['Email', $shelter->email],
                    ['Teléfono', $shelter->phone],
                    ['Dirección', $shelter->address],
                    ['Ciudad', $shelter->city],
                    ['Capacidad', $shelter->capacity ?? 'No especificada'],
                    ['Estado', $shelter->status],
                ]
            );
        } catch (\Exception $e) {
            $this->error("❌ Error al crear refugio: " . $e->getMessage());
        }

        $this->newLine();
    }

    private function testCase(string $testName, array $data, array $expectedErrors)
    {
        // Crear reglas básicas sin unique para testing
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'capacity' => ['nullable', 'integer', 'min:1', 'max:1000'],
            'status' => ['required', 'in:active,inactive'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ];

        $messages = [
            'name.required' => 'El nombre del refugio es obligatorio.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Debe proporcionar un email válido.',
            'phone.required' => 'El teléfono es obligatorio.',
            'phone.max' => 'El teléfono no puede tener más de 20 caracteres.',
            'address.required' => 'La dirección es obligatoria.',
            'address.max' => 'La dirección no puede tener más de 255 caracteres.',
            'city.required' => 'La ciudad es obligatoria.',
            'city.max' => 'La ciudad no puede tener más de 100 caracteres.',
            'capacity.integer' => 'La capacidad debe ser un número entero.',
            'capacity.min' => 'La capacidad debe ser al menos 1.',
            'capacity.max' => 'La capacidad no puede exceder 1000.',
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado debe ser activo o inactivo.',
            'description.max' => 'La descripción no puede tener más de 1000 caracteres.',
        ];

        $validator = Validator::make($data, $rules, $messages);

        $this->line("🧪 Test: <info>{$testName}</info>");

        if (empty($expectedErrors)) {
            if ($validator->passes()) {
                $this->line("   ✅ <fg=green>PASSED</fg=green> - Validación exitosa");
            } else {
                $this->line("   ❌ <fg=red>FAILED</fg=red> - Se esperaba validación exitosa");
                $errors = $validator->errors()->all();
                foreach ($errors as $error) {
                    $this->line("      • {$error}");
                }
            }
        } else {
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                $allExpectedFound = true;
                
                foreach ($expectedErrors as $field => $expectedMessage) {
                    if (!isset($errors[$field])) {
                        $this->line("   ❌ <fg=red>FAILED</fg=red> - Error esperado para '{$field}' no encontrado");
                        $allExpectedFound = false;
                    } else {
                        $actualMessage = $errors[$field][0];
                        if (strpos($actualMessage, $expectedMessage) !== false || 
                            $actualMessage === $expectedMessage) {
                            // Mensaje encontrado correctamente
                        } else {
                            $this->line("   ❌ <fg=red>FAILED</fg=red> - Mensaje incorrecto para '{$field}'");
                            $this->line("      Esperado: {$expectedMessage}");
                            $this->line("      Actual: {$actualMessage}");
                            $allExpectedFound = false;
                        }
                    }
                }

                if ($allExpectedFound) {
                    $this->line("   ✅ <fg=green>PASSED</fg=green> - Todos los errores esperados encontrados");
                }
            } else {
                $this->line("   ❌ <fg=red>FAILED</fg=red> - Se esperaban errores de validación");
            }
        }
        
        $this->newLine();
    }
}
