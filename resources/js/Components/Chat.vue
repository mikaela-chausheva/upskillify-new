<template>
    <div class="fixed bottom-6 right-6 w-80 bg-white border rounded-xl shadow-lg z-50">
      <div class="bg-blue-600 text-white p-3 rounded-t-xl font-semibold flex justify-between items-center">
        <span>📢 Course Chat</span>
        <button @click="isOpen = !isOpen" class="text-white text-lg leading-none">×</button>
      </div>

      <div v-if="isOpen" class="p-3 h-80 flex flex-col">
        <div class="flex-1 overflow-y-auto space-y-2 mb-2">
          <div
            v-for="msg in messages"
            :key="msg.id"
            :class="[
              'text-sm flex',
              msg.user_id === props.userId ? 'justify-end' : 'justify-start'
            ]"
          >
            <div
              :class="[
                'max-w-[70%] px-3 py-2 rounded-lg',
                msg.user_id === props.userId
                  ? 'bg-blue-100 text-right text-blue-800'
                  : 'bg-gray-200 text-left text-gray-800'
              ]"
            >
              <strong v-if="msg.user_id !== props.userId">
                {{ msg.user.first_name }} {{ msg.user.last_name }}:
              </strong>
              <div>{{ msg.message }}</div>
            </div>
          </div>
        </div>

        <div class="flex items-center gap-2">
          <input
            v-model="newMessage"
            @keyup.enter="sendMessage"
            class="flex-1 border rounded px-2 py-1 text-sm"
            placeholder="Type a message..."
          />
          <button
            @click="sendMessage"
            class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700"
          >
            Send
          </button>
        </div>
      </div>
    </div>
  </template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const props = defineProps({
  courseId: Number,
  userId: Number,
  userName: String,
})

const messages = ref([])
const newMessage = ref('')
const isOpen = ref(true)

const fetchMessages = async () => {
  const { data } = await axios.get(`/courses/${props.courseId}/messages`)
  messages.value = data
}

const sendMessage = async () => {
  if (!newMessage.value.trim()) return

  // Изпращане към бекенда
  await axios.post(`/courses/${props.courseId}/messages`, {
    message: newMessage.value,
  })

  messages.value.push({
    id: Date.now(),
    message: newMessage.value,
    user: {
      first_name: props.userName.split(' ')[0],
      last_name: props.userName.split(' ')[1] ?? '',
    },
  })

  newMessage.value = ''
}

const listenForMessages = () => {
  if (typeof window.Echo === 'undefined') {
    console.warn('⚠️ Echo is not available. Make sure bootstrap.js is loaded and Reverb is running.')
    return
  }

  window.Echo.private(`course.${props.courseId}`)
    .listen('MessageSent', (e) => {
        messages.value.push({
        id: e.message.id,
        message: e.message.message,
        user: {
            first_name: e.user.first_name,
            last_name: e.user.last_name,
            }
        })
    })
}

onMounted(() => {
  fetchMessages()
  listenForMessages()
})
</script>

