<template>
  <form @submit.prevent="onSubmit" class="bg-white rounded shadow p-4 mb-6 animate-fade-in">
    <div class="mb-4">
      <label class="block mb-1 font-medium">Tytuł <span class="text-red-500">*</span></label>
      <input v-model="form.title" type="text" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" required maxlength="255" />
    </div>
    <div class="mb-4">
      <label class="block mb-1 font-medium">Opis</label>
      <textarea v-model="form.description" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" rows="2"></textarea>
    </div>
    <div class="flex items-center space-x-2 mb-4" v-if="editingTask">
      <label class="font-medium">Status:</label>
      <select v-model="form.status" class="border rounded px-2 py-1">
        <option value="pending">Do zrobienia</option>
        <option value="completed">Ukończone</option>
      </select>
    </div>
    <div class="flex space-x-2">
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
        {{ editingTask ? 'Zapisz zmiany' : 'Dodaj zadanie' }}
      </button>
      <button v-if="editingTask" type="button" @click="$emit('cancelEdit')" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400 transition">Anuluj</button>
    </div>
  </form>
</template>

<script setup>
import { ref, watch, toRefs } from 'vue'
const emit = defineEmits(['created', 'updated', 'cancelEdit'])
const props = defineProps({
  editingTask: Object
})

const form = ref({
  title: '',
  description: '',
  status: 'pending'
})

watch(() => props.editingTask, (task) => {
  if (task) {
    form.value = { ...task }
  } else {
    form.value = { title: '', description: '', status: 'pending' }
  }
}, { immediate: true })

const onSubmit = async () => {
  if (!form.value.title.trim()) return
  try {
    if (props.editingTask) {
      const res = await fetch(`http://localhost:8000/api/tasks/${form.value.id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(form.value)
      })
      const updated = await res.json()
      emit('updated', updated)
    } else {
      const res = await fetch('http://localhost:8000/api/tasks', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(form.value)
      })
      const created = await res.json()
      emit('created', created)
      form.value = { title: '', description: '', status: 'pending' }
    }
  } catch (e) {
    // obsługa błędów przez dashboard
  }
}
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