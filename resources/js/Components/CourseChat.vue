<template>
    <div class="chat-container">
      <div class="messages">
        <div v-for="msg in messages" :key="msg.id" class="message">
          <strong>{{ msg.user.name }}:</strong> {{ msg.message }}
        </div>
      </div>

      <div class="input-area">
        <input v-model="newMessage" @keyup.enter="sendMessage" placeholder="Type your message..." />
        <button @click="sendMessage">Send</button>
      </div>
    </div>
  </template>

  <script>
  export default {
    props: {
      courseId: Number,
      userId: Number,
      userName: String,
    },
    data() {
      return {
        messages: [],
        newMessage: '',
      };
    },
    mounted() {
      this.fetchMessages();
      this.listenForMessages();
    },
    methods: {
      fetchMessages() {
        axios.get(`/api/courses/${this.courseId}/messages`)
          .then(response => {
            this.messages = response.data;
          });
      },
      sendMessage() {
        if (this.newMessage.trim() === '') return;

        axios.post(`/api/courses/${this.courseId}/messages`, {
          message: this.newMessage,
        });

        this.newMessage = '';
      },
      listenForMessages() {
        window.Echo.private(`course.${this.courseId}`)
          .listen('MessageSent', (e) => {
            this.messages.push({
              id: e.message.id,
              message: e.message.message,
              user: { name: e.user.name },
            });
          });
      },
    },
  };
  </script>

  <style scoped>
  .chat-container {
    border: 1px solid #ccc;
    padding: 1rem;
    max-width: 600px;
  }
  .messages {
    max-height: 300px;
    overflow-y: auto;
    margin-bottom: 1rem;
  }
  .input-area {
    display: flex;
    gap: 0.5rem;
  }
  </style>
