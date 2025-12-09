<template>
  <aside class="w-64 bg-white shadow-lg min-h-screen">
    <nav class="p-4">
      <ul class="space-y-2">
        <li>
          <NuxtLink 
            to="/artista/dashboard" 
            class="block px-4 py-2 rounded hover:bg-gray-100"
            active-class="bg-primary-100 text-primary-600"
          >
            Dashboard
          </NuxtLink>
        </li>
        <li>
          <NuxtLink 
            to="/artista/perfil" 
            class="block px-4 py-2 rounded hover:bg-gray-100"
            active-class="bg-primary-100 text-primary-600"
          >
            Mi Perfil
          </NuxtLink>
        </li>
        <li>
          <NuxtLink 
            to="/artista/galeria" 
            class="block px-4 py-2 rounded hover:bg-gray-100"
            active-class="bg-primary-100 text-primary-600"
          >
            Galería
          </NuxtLink>
        </li>
        <li>
          <NuxtLink 
            to="/artista/membresia" 
            class="block px-4 py-2 rounded hover:bg-gray-100"
            active-class="bg-primary-100 text-primary-600"
          >
            Membresía
          </NuxtLink>
        </li>
        <li>
          <NuxtLink 
            to="/artista/mensajes" 
            class="block px-4 py-2 rounded hover:bg-gray-100"
            active-class="bg-primary-100 text-primary-600"
          >
            Mensajes
          </NuxtLink>
        </li>
        <li>
          <NuxtLink 
            to="/artista/estadisticas" 
            class="block px-4 py-2 rounded hover:bg-gray-100"
            active-class="bg-primary-100 text-primary-600"
          >
            Estadísticas
          </NuxtLink>
        </li>
      </ul>
    </nav>
  </aside>
</template>

<script setup>
</script>

