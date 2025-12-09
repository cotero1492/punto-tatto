<template>
  <footer class="bg-gray-800 text-white py-8 mt-16">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
          <h3 class="text-xl font-bold mb-4">PUNTO TATTO</h3>
          <p class="text-gray-400">La mejor plataforma para encontrar artistas de tatuaje.</p>
        </div>
        <div>
          <h4 class="font-semibold mb-4">Enlaces</h4>
          <ul class="space-y-2 text-gray-400">
            <li><NuxtLink to="/artists" class="hover:text-white">Artistas</NuxtLink></li>
            <li><NuxtLink to="/login" class="hover:text-white">Iniciar sesión</NuxtLink></li>
            <li><NuxtLink to="/register" class="hover:text-white">Registrarse</NuxtLink></li>
          </ul>
        </div>
        <div>
          <h4 class="font-semibold mb-4">Contacto</h4>
          <p class="text-gray-400">Email: contacto@puntotatto.com</p>
        </div>
      </div>
      <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
        <p>&copy; 2024 PUNTO TATTO. Todos los derechos reservados.</p>
      </div>
    </div>
  </footer>
</template>

<script setup>
</script>

