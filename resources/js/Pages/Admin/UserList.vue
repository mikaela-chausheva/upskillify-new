<template>
  <div class="min-h-screen flex flex-col bg-gray-50">
    <Navbar />

    <div class="max-w-7xl mx-auto px-6 py-10 w-full">
      <!-- Title -->
      <h1 class="text-3xl font-bold mb-6">Users</h1>

      <!-- Success message -->
      <div v-if="$page.props.flash?.success" class="mb-6 text-green-600 font-medium">
        {{ $page.props.flash.success }}
      </div>

      <!-- Users Table -->
      <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <table class="w-full text-left border-collapse">
          <thead class="bg-gray-100 text-gray-700 text-sm uppercase tracking-wide">
            <tr>
              <th class="p-4 border-b">Name</th>
              <th class="p-4 border-b">Email</th>
              <th class="p-4 border-b">Role</th>
              <th class="p-4 border-b text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="user in users"
              :key="user.id"
              class="border-t hover:bg-gray-50 transition"
            >
              <!-- Name -->
              <td class="p-4 text-gray-800 font-medium">
                {{ user.first_name }} {{ user.last_name }}
              </td>

              <!-- Email -->
              <td class="p-4 text-gray-600">
                {{ user.email }}
              </td>

              <!-- Role -->
              <td class="p-4 capitalize text-gray-700">
                {{ user.role }}
              </td>

              <!-- Actions -->
              <td class="p-4 text-center">
                <select
                  :value="user.role"
                  @change="$event => updateRole(user.id, $event.target.value)"
                  class="border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none"
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
    </div>

    <Footer class="mt-auto" />
  </div>
</template>

<script setup>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
  users: {
    type: Array,
    required: true,
  },
});

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
