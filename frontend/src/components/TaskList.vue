<template>
  <div class="bg-white rounded shadow p-4 mt-6 animate-fade-in">
    <table class="min-w-full text-sm">
      <thead>
        <tr class="bg-gray-100">
          <th class="p-2 text-left">Tytuł</th>
          <th class="p-2 text-left">Opis</th>
          <th class="p-2 text-center">Status</th>
          <th class="p-2 text-center">Akcje</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="task in tasks" :key="task.id" :class="{ 'opacity-50': task.status === 'completed' }" class="transition-all">
          <td class="p-2">{{ task.title }}</td>
          <td class="p-2">{{ task.description }}</td>
          <td class="p-2 text-center">
            <span :class="task.status === 'completed' ? 'text-green-600 font-bold' : 'text-gray-500'">
              {{ task.status === 'completed' ? 'Ukończone' : 'Do zrobienia' }}
            </span>
          </td>
          <td class="p-2 text-center space-x-2">
            <button @click="$emit('toggleStatus', task)" :title="task.status === 'completed' ? 'Oznacz jako do zrobienia' : 'Oznacz jako ukończone'"
              class="px-2 py-1 rounded bg-blue-100 hover:bg-blue-200 text-blue-700 transition">
              <span v-if="task.status === 'completed'">↩️</span>
              <span v-else>✔️</span>
            </button>
            <button @click="$emit('edit', task)" title="Edytuj" class="px-2 py-1 rounded bg-yellow-100 hover:bg-yellow-200 text-yellow-700 transition">✏️</button>
            <button @click="$emit('delete', task)" title="Usuń" class="px-2 py-1 rounded bg-red-100 hover:bg-red-200 text-red-700 transition">🗑️</button>
          </td>
        </tr>
        <tr v-if="!tasks.length">
          <td colspan="4" class="text-center text-gray-400 py-4">Brak zadań</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
defineProps({
  tasks: Array
})
</script>

<style scoped>
@keyframes fade-in {
  from { opacity: 0; }
  to { opacity: 1; }
}
.animate-fade-in {
  animation: fade-in 0.5s;
}
</style> 