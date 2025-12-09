<template>
  <aside class="w-64 bg-white shadow-lg min-h-screen">
    <nav class="p-4">
      <ul class="space-y-2">
        <li>
          <NuxtLink 
            to="/admin/dashboard" 
            class="block px-4 py-2 rounded hover:bg-gray-100"
            active-class="bg-primary-100 text-primary-600"
          >
            Dashboard
          </NuxtLink>
        </li>
        <li>
          <NuxtLink 
            to="/admin/artistas" 
            class="block px-4 py-2 rounded hover:bg-gray-100"
            active-class="bg-primary-100 text-primary-600"
          >
            Artistas
          </NuxtLink>
        </li>
        <li>
          <NuxtLink 
            to="/admin/clientes" 
            class="block px-4 py-2 rounded hover:bg-gray-100"
            active-class="bg-primary-100 text-primary-600"
          >
            Clientes
          </NuxtLink>
        </li>
        <li>
          <NuxtLink 
            to="/admin/pagos" 
            class="block px-4 py-2 rounded hover:bg-gray-100"
            active-class="bg-primary-100 text-primary-600"
          >
            Pagos
          </NuxtLink>
        </li>
        <li>
          <NuxtLink 
            to="/admin/publicidad" 
            class="block px-4 py-2 rounded hover:bg-gray-100"
            active-class="bg-primary-100 text-primary-600"
          >
            Publicidad
          </NuxtLink>
        </li>
        <li>
          <NuxtLink 
            to="/admin/ranking" 
            class="block px-4 py-2 rounded hover:bg-gray-100"
            active-class="bg-primary-100 text-primary-600"
          >
            Ranking
          </NuxtLink>
        </li>
      </ul>
    </nav>
  </aside>
</template>

<script setup>
</script>

