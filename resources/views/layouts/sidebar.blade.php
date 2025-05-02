<!-- resources/views/layouts/sidebar.blade.php -->
<aside class="w-64 bg-gray-800 text-white min-h-screen p-4">
    <div class="text-lg font-bold mb-6">Panel Admin</div>
    <nav class="flex flex-col gap-2">
        <a href="{{ route('admin.dashboard') }}" class="hover:bg-gray-700 p-2 rounded">📊 Dashboard</a>
        <a href="{{ route('admin.usuarios.index') }}" class="hover:bg-gray-700 p-2 rounded">👥 Usuarios</a>
        <a href="{{ route('admin.usuarios.create') }}" class="hover:bg-gray-700 p-2 rounded">➕ Crear Usuario</a>
    </nav>
</aside>
