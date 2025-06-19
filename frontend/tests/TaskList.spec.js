import { mount } from '@vue/test-utils'
import TaskList from '../src/components/TaskList.vue'

describe('TaskList', () => {
  it('wyświetla zadania', () => {
    const tasks = [
      { id: 1, title: 'Test', description: 'Opis', status: 'pending' }
    ]
    const wrapper = mount(TaskList, { props: { tasks } })
    expect(wrapper.text()).toContain('Test')
    expect(wrapper.text()).toContain('Opis')
  })

  it('wyświetla komunikat gdy brak zadań', () => {
    const wrapper = mount(TaskList, { props: { tasks: [] } })
    expect(wrapper.text()).toContain('Brak zadań')
  })
}) 