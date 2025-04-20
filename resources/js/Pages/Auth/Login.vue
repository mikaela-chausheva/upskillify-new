<script setup>
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';




const form = useForm({
    email: '',
    password: '',
});

const submit = () => {
    form.post(route('login.store'), {
        onFinish: () => form.reset('password'),
        onSuccess: () => {
            // After login is successful, redirect to the dashboard page
            window.location.href = route('home');  // Replace 'dashboard' with your desired route
        },
        onError: (errors) => {
            // Handle login errors if needed
            console.error('Login failed:', errors);
        },
    });
};
</script>

<template>
    <div class="login-form">
        <h2>Login</h2>
        <form @submit.prevent="submit" class="login-form">
            <div>
          <label for="email">Email</label>
          <input v-model="form.email" type="email" id="email" required />
        </div>

        <div>
          <label for="password">Password</label>
          <input v-model="form.password" type="password" id="password" required />
        </div>

        <button type="submit" :disabled="form.processing">Login</button>

        </form>
    </div>
</template>

 <style scoped>
.login-container {
    max-width: 400px;
    margin: 2rem auto;
    padding: 2rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
}

.login-form input {
    display: block;
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.login-form button {
    margin-top: 15px;
    padding: 10px;
    width: 100%;
    background-color: #1d4ed8;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.login-form button:hover {
    background-color: #2563eb;
}

.error {
    color: red;
    margin-top: 5px;
    font-size: 0.9rem;
}
</style>
