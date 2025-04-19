 <script setup>
  import { useForm } from '@inertiajs/vue3'

  const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    password: '',
    password_confirmation: '',
  })

  function submitForm() {
    // console.log('Submitting form', form)
    // form.post('/register')
    form.post('/register', {
      onStart() {
        // Optionally you can add loading states or disable the submit button
        console.log('Submitting form...');
      },
      onFinish() {
        // Handle the state after the request is done
        console.log('Form submission finished.');
      },
      onError(errors) {
        // This is where you can handle form errors if validation fails
        console.log('Form errors:', errors);
      },
      onSuccess() {
        // After success, you can redirect to another page
        console.log('Registration successful!');
        // Redirect to login page after successful registration (optional)
        // You could use: this.$inertia.visit('/login') for Inertia routing
        window.location.href = "/login"; // Redirect to login after registration
      }
    })
  }
  </script>

<template>
    <div class="register-form">
      <h1>Register</h1>
      <form @submit.prevent="submitForm">
        <div>
          <label for="first_name">First Name</label>
          <input v-model="form.first_name" type="text" id="first_name" required />
        </div>

        <div>
          <label for="last_name">Last Name</label>
          <input v-model="form.last_name" type="text" id="last_name" required />
        </div>

        <div>
          <label for="email">Email</label>
          <input v-model="form.email" type="email" id="email" required />
        </div>

        <div>
          <label for="password">Password</label>
          <input v-model="form.password" type="password" id="password" required />
        </div>

        <div>
          <label for="password_confirmation">Confirm Password</label>
          <input v-model="form.password_confirmation" type="password" id="password_confirmation" required />
        </div>

        <button type="submit" :disabled="form.processing">Register</button>
      </form>
    </div>
  </template>

  <style scoped>
.register-form {
  max-width: 400px;
  margin: auto;
}
</style>
