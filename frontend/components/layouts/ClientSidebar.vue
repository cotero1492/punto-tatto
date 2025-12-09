<template>
  <aside class="w-64 bg-white shadow-lg min-h-screen">
    <nav class="p-4">
      <ul class="space-y-2">
        <li>
          <NuxtLink 
            to="/cliente/dashboard" 
            class="block px-4 py-2 rounded hover:bg-gray-100"
            active-class="bg-primary-100 text-primary-600"
          >
            Dashboard
          </NuxtLink>
        </li>
        <li>
          <NuxtLink 
            to="/artists" 
            class="block px-4 py-2 rounded hover:bg-gray-100"
            active-class="bg-primary-100 text-primary-600"
          >
            Buscar Artistas
          </NuxtLink>
        </li>
        <li>
          <NuxtLink 
            to="/cliente/favoritos" 
            class="block px-4 py-2 rounded hover:bg-gray-100"
            active-class="bg-primary-100 text-primary-600"
          >
            Favoritos
          </NuxtLink>
        </li>
        <li>
          <NuxtLink 
            to="/cliente/mensajes" 
            class="block px-4 py-2 rounded hover:bg-gray-100"
            active-class="bg-primary-100 text-primary-600"
          >
            Mensajes
          </NuxtLink>
        </li>
      </ul>
    </nav>
  </aside>
</template>

<script setup>
</script>

