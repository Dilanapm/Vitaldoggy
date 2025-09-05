# 🐳 Guía de Resolución: Imágenes no se muestran en Laravel + Docker

## 📋 Problema Común
**Síntoma:** Las imágenes no se muestran en el navegador, aparece error 403 o 404 al acceder a rutas como `/storage/imagen.jpg`

---

## 🔍 Diagnóstico Rápido

### ✅ **Checklist de Verificación:**
```bash
# 1. ¿Están los contenedores ejecutándose?
docker ps

# 2. ¿Existe el enlace simbólico?
ls -la public/storage

# 3. ¿Existen los archivos físicos?
ls -la storage/app/public/

# 4. ¿Funciona el acceso directo?
curl -I http://localhost/storage/imagen.jpg
```

---

## 🚨 Causas Principales y Soluciones

### **1. Enlace Simbólico Incorrecto (Más Común)**

#### ❌ **Problema:**
El enlace simbólico se creó **fuera del contenedor** con `php artisan storage:link`

#### 🔍 **Síntomas:**
```bash
$ ls -la public/storage
# ❌ MAL: Apunta a ruta del host
lrwxrwxrwx -> /home/user/proyecto/storage/app/public

# ✅ BIEN: Apunta a ruta del contenedor  
lrwxrwxrwx -> /var/www/html/storage/app/public
```

#### ✅ **Solución:**
```bash
# 1. Eliminar enlace incorrecto
rm public/storage

# 2. Recrear con Sail (IMPORTANTE)
./vendor/bin/sail artisan storage:link

# 3. Verificar que apunte correctamente
ls -la public/storage
```

---

### **2. Permisos de Archivos**

#### ❌ **Problema:**
Los archivos tienen permisos incorrectos o propietario incorrecto

#### 🔍 **Síntomas:**
- Error 403 Forbidden
- Archivos visibles pero no accesibles vía web

#### ✅ **Solución:**
```bash
# Verificar permisos actuales
./vendor/bin/sail exec laravel.test ls -la storage/app/public/

# Corregir permisos si es necesario
./vendor/bin/sail exec laravel.test chown -R sail:sail storage/app/public/
./vendor/bin/sail exec laravel.test chmod -R 755 storage/app/public/
```

---

### **3. Configuración de Rutas Inconsistente**

#### ❌ **Problema:**
Las rutas en la base de datos no coinciden con la estructura real de archivos

#### 🔍 **Síntomas:**
```php
// En DB: "imagen.jpg"
// Pero se busca en: "/storage/shelters/imagen.jpg"
// Resultado: 404 Not Found
```

#### ✅ **Solución:**
```php
// Modelo con manejo de rutas flexible
public function getImageUrlAttribute()
{
    if ($this->image_path) {
        // Si ya incluye la carpeta, usar tal como está
        if (strpos($this->image_path, 'shelters/') === 0) {
            return asset('storage/' . $this->image_path);
        }
        // Si no, asumir que está en la carpeta correcta
        return asset('storage/shelters/' . $this->image_path);
    }
    return null;
}
```

#### 🛠️ **Comando de Estandarización:**
```bash
./vendor/bin/sail artisan fix:shelter-image-paths --dry-run  # Simular
./vendor/bin/sail artisan fix:shelter-image-paths            # Ejecutar
```

---

### **4. Contenedores no Ejecutándose**

#### ❌ **Problema:**
Los servicios de Docker están detenidos

#### 🔍 **Síntomas:**
```bash
$ docker ps
# Sin contenedores o contenedores con status "Exited"
```

#### ✅ **Solución:**
```bash
# Iniciar todos los servicios
./vendor/bin/sail up -d

# Verificar estado
docker ps

# Ver logs si hay problemas
./vendor/bin/sail logs
```

---

### **5. Configuración de Servidor Web**

#### ❌ **Problema:**
El servidor web (Nginx/Apache) no está configurado para servir archivos estáticos

#### 🔍 **Síntomas:**
- Los archivos existen pero retornan 404
- Configuración de `.htaccess` incorrecta

#### ✅ **Solución:**
```bash
# Verificar configuración del contenedor
./vendor/bin/sail exec laravel.test cat /etc/nginx/sites-available/default

# O para Apache:
./vendor/bin/sail exec laravel.test cat /etc/apache2/sites-available/000-default.conf
```

---

## 🚀 Comandos de Emergencia

### **Solución Rápida Completa:**
```bash
# 1. Reiniciar servicios
./vendor/bin/sail down
./vendor/bin/sail up -d

# 2. Recrear enlace simbólico
rm public/storage
./vendor/bin/sail artisan storage:link

# 3. Verificar permisos
./vendor/bin/sail exec laravel.test chmod -R 755 storage/app/public/

# 4. Probar acceso
curl -I http://localhost/storage/shelters/imagen.jpg
```

---

## 📊 Herramientas de Diagnóstico

### **Comando de Verificación Completa:**
```php
<?php
// En tinker: ./vendor/bin/sail artisan tinker

// Verificar rutas y archivos
$shelters = \App\Models\Shelter::whereNotNull('image_path')->get();
foreach ($shelters as $shelter) {
    echo "ID: {$shelter->id}\n";
    echo "Nombre: {$shelter->name}\n";
    echo "Ruta DB: {$shelter->image_path}\n";
    echo "URL generada: {$shelter->image_url}\n";
    echo "Archivo existe: " . (\Storage::disk('public')->exists($shelter->image_path) ? 'SÍ' : 'NO') . "\n";
    echo "---\n";
}
```

### **Script de Validación:**
```bash
#!/bin/bash
echo "🔍 Diagnóstico de Imágenes Laravel + Docker"
echo "============================================"

echo "1. Estado de contenedores:"
docker ps --format "table {{.Names}}\t{{.Status}}"

echo -e "\n2. Enlace simbólico:"
ls -la public/storage

echo -e "\n3. Archivos en storage:"
./vendor/bin/sail exec laravel.test ls -la storage/app/public/shelters/ | head -5

echo -e "\n4. Prueba de acceso web:"
curl -s -I http://localhost/storage/shelters/albergue1.jpg | head -1
```

---

## ⚡ Buenas Prácticas

### **1. Siempre usar Sail para comandos de Laravel:**
```bash
# ✅ CORRECTO
./vendor/bin/sail artisan storage:link
./vendor/bin/sail artisan migrate

# ❌ INCORRECTO (cuando usas Docker)
php artisan storage:link
php artisan migrate
```

### **2. Estructura de carpetas consistente:**
```
storage/app/public/
├── shelters/
│   ├── imagen1.jpg
│   └── imagen2.png
├── pets/
│   ├── pet1.jpg
│   └── pet2.png
└── users/
    └── avatar1.jpg
```

### **3. Validación en Form Requests:**
```php
// En StoreShelterRequest.php
'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
```

### **4. Manejo consistente de uploads:**
```php
// En Controller
if ($request->hasFile('image')) {
    $imagePath = $request->file('image')->store('shelters', 'public');
    $data['image_path'] = $imagePath; // Guardará: "shelters/hash.jpg"
}
```

---

## 🎯 Checklist de Prevención

### **Al configurar un nuevo proyecto:**
- [ ] Ejecutar `./vendor/bin/sail artisan storage:link`
- [ ] Verificar que `public/storage` apunte a `/var/www/html/storage/app/public`
- [ ] Probar subida de archivos en modo desarrollo
- [ ] Configurar límites de tamaño en PHP y Nginx
- [ ] Establecer estructura de carpetas consistente

### **Al hacer deploy:**
- [ ] Recrear enlaces simbólicos en producción
- [ ] Verificar permisos de `storage/`
- [ ] Configurar servidor web para servir archivos estáticos
- [ ] Probar acceso a imágenes después del deploy

---

## 🚨 Errores Comunes a Evitar

1. **❌** Crear enlaces simbólicos con `php artisan` cuando usas Docker
2. **❌** Asumir que las rutas del host funcionan en el contenedor
3. **❌** No verificar permisos después de cambios
4. **❌** Mezclar diferentes formatos de rutas en la DB
5. **❌** No probar el acceso directo a archivos
6. **❌** Olvidar recrear enlaces después de cambios en contenedores

---

## 📚 Referencias Rápidas

### **URLs de prueba:**
```
http://localhost/storage/shelters/imagen.jpg  # Acceso directo
http://localhost/admin/shelters              # Lista con imágenes
```

### **Comandos útiles:**
```bash
# Logs en tiempo real
./vendor/bin/sail logs -f

# Entrar al contenedor
./vendor/bin/sail exec laravel.test bash

# Estado de servicios
./vendor/bin/sail ps
```

¡Con esta guía deberías poder resolver cualquier problema de imágenes en Laravel + Docker! 🎉
