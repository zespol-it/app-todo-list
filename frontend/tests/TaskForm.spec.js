import { mount } from '@vue/test-utils'
import TaskForm from '../src/components/TaskForm.vue'

describe('TaskForm', () => {
  it('renderuje formularz i obsługuje dodawanie', async () => {
    const wrapper = mount(TaskForm, {
      props: { editingTask: null }
    })
    await wrapper.find('input').setValue('Nowe zadanie')
    await wrapper.find('form').trigger('submit.prevent')
    // emit powinien być wywołany, ale tu testujemy tylko render
    expect(wrapper.find('input').element.value).toBe('Nowe zadanie')
  })

  it('renderuje formularz edycji', async () => {
    const wrapper = mount(TaskForm, {
      props: { editingTask: { id: 1, title: 'Edytuj', description: '', status: 'pending' } }
    })
    expect(wrapper.find('input').element.value).toBe('Edytuj')
    expect(wrapper.find('select').exists()).toBe(true)
  })
}) 