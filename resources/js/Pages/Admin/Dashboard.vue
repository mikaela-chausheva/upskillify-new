<template>
    <div class="p-8">
      <h1 class="text-3xl font-bold mb-6">Административен панел</h1>

      <div class="space-y-4">
        <div class="bg-white rounded shadow p-6">
          <h2 class="text-xl font-semibold mb-2">Управление</h2>
          <p class="mb-4 text-gray-600">Достъп до администраторски функционалности.</p>
          <Link
            href="/admin/users"
            class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
          >
            Виж всички потребители
          </Link>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { Link } from '@inertiajs/vue3';
  </script>
