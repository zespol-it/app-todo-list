<script setup>
import Dashboard from './views/Dashboard.vue'
</script>

<template>
  <div class="min-h-screen bg-gray-100">
    <header class="bg-white shadow">
      <div class="max-w-4xl mx-auto py-6 px-4">
        <h1 class="text-3xl font-bold text-gray-900">Lista zadań</h1>
      </div>
    </header>
    <main class="py-6">
      <Dashboard />
    </main>
  </div>
</template>

<style scoped>
.logo {
  height: 6em;
  padding: 1.5em;
  will-change: filter;
  transition: filter 300ms;
}
.logo:hover {
  filter: drop-shadow(0 0 2em #646cffaa);
}
.logo.vue:hover {
  filter: drop-shadow(0 0 2em #42b883aa);
}
</style>
