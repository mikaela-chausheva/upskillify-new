<template>
    <div class="min-h-screen flex flex-col">
        <Navbar/>
        <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Потребители</h1>

        <div v-if="$page.props.flash?.success" class="mb-4 text-green-600">
            {{ $page.props.flash.success }}
        </div>

        <table class="w-full text-left border border-gray-200">
            <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border-b">Име</th>
                <th class="p-2 border-b">Email</th>
                <th class="p-2 border-b">Роля</th>
                <th class="p-2 border-b">Действия</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users" :key="user.id" class="border-t hover:bg-gray-50">
                <td class="p-2">{{ user.first_name }} {{ user.last_name }}</td>
                <td class="p-2">{{ user.email }}</td>
                <td class="p-2 capitalize">{{ user.role }}</td>
                <td class="p-2">
                    <select
                    :value="user.role"
                    @change="$event => updateRole(user.id, $event.target.value)"
                    class="border rounded p-1 text-sm"
                    >
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                    <option value="admin">Admin</option>
                    </select>
                </td>
            </tr>
            </tbody>
        </table>
        </div>
        <Footer class="mt-auto" />
    </div>
  </template>

  <script setup>
    import Navbar from '@/Components/Navbar.vue'
  import Footer from '@/Components/Footer.vue'
  import { router } from '@inertiajs/vue3'

  const props = defineProps({
    users: {
      type: Array,
      required: true,
    },
  })

  function updateRole(userId, role) {
    if (!userId) {
    console.error('Missing user ID');
    return;
  }

  router.patch(`/admin/users/${userId}/role`, { role }, {
    preserveScroll: true,
    onError: (errors) => {
      console.error('Error updating role', errors);
    }
  });
  }
  </script>
