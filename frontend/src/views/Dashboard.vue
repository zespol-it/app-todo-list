<template>
  <div class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-5xl w-full mx-auto">
      <h1 class="text-3xl font-bold mb-6 text-center">To-Do Dashboard</h1>
      <TaskForm
        :editingTask="editingTask"
        @created="onTaskCreated"
        @updated="onTaskUpdated"
        @cancelEdit="editingTask = null"
      />
      <div v-if="alert.message" :class="alertClass" class="my-4 px-4 py-2 rounded shadow text-center animate-fade-in">
        {{ alert.message }}
      </div>
      <TaskList
        :tasks="tasks"
        @edit="editTask"
        @delete="deleteTask"
        @toggleStatus="toggleStatus"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import TaskList from '../components/TaskList.vue'
import TaskForm from '../components/TaskForm.vue'

const tasks = ref([])
const editingTask = ref(null)
const alert = ref({ message: '', type: 'success' })

const fetchTasks = async () => {
  try {
    const res = await fetch('http://localhost:8000/api/tasks')
    tasks.value = await res.json()
  } catch (e) {
    showAlert('Błąd pobierania zadań', 'error')
  }
}

const showAlert = (message, type = 'success') => {
  alert.value = { message, type }
  setTimeout(() => (alert.value.message = ''), 3000)
}

const onTaskCreated = (task) => {
  tasks.value.unshift(task)
  showAlert('Dodano zadanie!')
}

const onTaskUpdated = (task) => {
  const idx = tasks.value.findIndex(t => t.id === task.id)
  if (idx !== -1) tasks.value[idx] = task
  editingTask.value = null
  showAlert('Zaktualizowano zadanie!')
}

const editTask = (task) => {
  editingTask.value = { ...task }
}

const deleteTask = async (task) => {
  if (!confirm('Na pewno usunąć zadanie?')) return
  try {
    await fetch(`http://localhost:8000/api/tasks/${task.id}`, { method: 'DELETE' })
    tasks.value = tasks.value.filter(t => t.id !== task.id)
    showAlert('Usunięto zadanie!')
  } catch (e) {
    showAlert('Błąd usuwania zadania', 'error')
  }
}

const toggleStatus = async (task) => {
  try {
    const res = await fetch(`http://localhost:8000/api/tasks/${task.id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ status: task.status === 'completed' ? 'pending' : 'completed' })
    })
    const updated = await res.json()
    const idx = tasks.value.findIndex(t => t.id === task.id)
    if (idx !== -1) tasks.value[idx] = updated
    showAlert('Zmieniono status zadania!')
  } catch (e) {
    showAlert('Błąd zmiany statusu', 'error')
  }
}

onMounted(fetchTasks)

const alertClass = computed(() =>
  alert.value.type === 'error'
    ? 'bg-red-200 text-red-800 border border-red-400'
    : 'bg-green-200 text-green-800 border border-green-400'
)
</script>

<style>
@keyframes fade-in {
  from { opacity: 0; }
  to { opacity: 1; }
}
.animate-fade-in {
  animation: fade-in 0.5s;
}
</style> 