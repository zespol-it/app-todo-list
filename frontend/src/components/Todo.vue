<template>
  <div class="max-w-4xl mx-auto p-4">
    <!-- Alert dla błędów -->
    <div v-if="error" class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded relative" role="alert">
      <strong class="font-bold">Błąd! </strong>
      <span class="block sm:inline">{{ error }}</span>
      <button @click="error = ''" class="absolute top-0 right-0 px-4 py-3">
        <svg class="h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
          <title>Zamknij</title>
          <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
        </svg>
      </button>
    </div>

    <div class="mb-4">
      <input 
        v-model="newTask" 
        @keyup.enter="addTask"
        type="text" 
        placeholder="Dodaj nowe zadanie..." 
        class="w-full p-2 border rounded focus:outline-none focus:border-blue-500"
      >
    </div>
    
    <TransitionGroup 
      name="list" 
      tag="div" 
      class="space-y-2"
    >
      <div v-for="task in tasks" 
           :key="task.id" 
           class="flex items-center justify-between p-3 bg-white rounded shadow"
      >
        <div class="flex items-center gap-3">
          <button 
            @click="toggleTaskStatus(task.id)"
            :class="[
              'p-2 rounded-full transition-colors duration-200',
              task.status === 'completed' 
                ? 'bg-green-500 text-white' 
                : 'bg-gray-200 hover:bg-gray-300'
            ]"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
          </button>
          <span :class="{ 'line-through text-gray-500': task.status === 'completed' }">
            {{ task.title }}
          </span>
        </div>
        <div class="flex gap-2">
          <button 
            @click="deleteTask(task.id)"
            class="p-2 text-red-500 hover:bg-red-100 rounded transition-colors duration-200"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
          </button>
        </div>
      </div>
    </TransitionGroup>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const tasks = ref([])
const newTask = ref('')
const error = ref('')

// Pobieranie zadań
const fetchTasks = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/tasks')
    tasks.value = response.data
    error.value = ''
  } catch (err) {
    error.value = 'Nie udało się pobrać zadań. Spróbuj ponownie później.'
    console.error('Błąd podczas pobierania zadań:', err)
  }
}

// Dodawanie nowego zadania
const addTask = async () => {
  if (!newTask.value.trim()) return

  try {
    const response = await axios.post('http://localhost:8000/api/tasks', {
      title: newTask.value,
      status: 'pending'
    })
    tasks.value.push(response.data)
    newTask.value = ''
    error.value = ''
  } catch (err) {
    error.value = 'Nie udało się dodać zadania. Spróbuj ponownie później.'
    console.error('Błąd podczas dodawania zadania:', err)
  }
}

// Przełączanie statusu zadania
const toggleTaskStatus = async (taskId) => {
  try {
    const task = tasks.value.find(t => t.id === taskId)
    const newStatus = task.status === 'completed' ? 'pending' : 'completed'
    
    await axios.put(`http://localhost:8000/api/tasks/${taskId}`, {
      status: newStatus
    })
    
    task.status = newStatus
    error.value = ''
  } catch (err) {
    error.value = 'Nie udało się zaktualizować statusu zadania. Spróbuj ponownie później.'
    console.error('Błąd podczas aktualizacji statusu:', err)
  }
}

// Usuwanie zadania
const deleteTask = async (taskId) => {
  try {
    await axios.delete(`http://localhost:8000/api/tasks/${taskId}`)
    tasks.value = tasks.value.filter(task => task.id !== taskId)
    error.value = ''
  } catch (err) {
    error.value = 'Nie udało się usunąć zadania. Spróbuj ponownie później.'
    console.error('Błąd podczas usuwania zadania:', err)
  }
}

// Pobierz zadania przy montowaniu komponentu
onMounted(fetchTasks)
</script>

<style>
.list-enter-active,
.list-leave-active {
  transition: all 0.5s ease;
}
.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateX(30px);
}
</style> 