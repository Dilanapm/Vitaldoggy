<x-app-layout :pageTitle="'Gestión de Usuarios'" :metaDescription="'Administra todos los usuarios de VitalDoggy.'">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2
                    class="font-semibold text-2xl bg-gradient-to-r from-[#751629] via-[#f56e5c] to-[#6b1f11] bg-clip-text text-transparent">
                    Gestión de Usuarios
                </h2>
                <p class="text-gray-600 dark:text-gray-300 mt-2">
                    Administra todos los usuarios registrados en la plataforma.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Breadcrumb Navigation -->
        <x-admin-breadcrumb :items="[]" currentPage="Gestión de Usuarios" />
        <!-- Incluir SweetAlert globalmente -->
        <x-sweet-alert />

        <livewire:admin.user-management />
    </div>
</x-app-layout>
