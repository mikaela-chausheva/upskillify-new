<template>
    <Navbar />
    <div class="p-8">
      <h1 class="text-3xl font-bold mb-6">Административен панел</h1>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Статистика за ролите -->
        <div class="bg-white rounded shadow p-6">
          <h2 class="text-xl font-semibold mb-4">Потребители по роли</h2>
          <PieChart :chart-data="userChartData" />
        </div>

        <!-- Брой курсове -->
        <div class="bg-white rounded shadow p-6 flex items-center justify-between">
          <div>
            <h2 class="text-xl font-semibold mb-2">Общо курсове</h2>
            <p class="text-4xl text-blue-600 font-bold">{{ coursesCount }}</p>
          </div>
          <Link
            href="/courses"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition"
          >
            Виж курсове
          </Link>
        </div>
      </div>

      <!-- Достъп до управление -->
      <div class="bg-white rounded shadow p-6">
        <h2 class="text-xl font-semibold mb-2">Управление</h2>
        <p class="mb-4 text-gray-600">Достъп до администраторски функционалности.</p>
        <Link
          href="/admin/users"
          class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition"
        >
          Виж всички потребители
        </Link>
      </div>
    </div>
    <Footer />
  </template>

<script setup>
  import Navbar from '@/Components/Navbar.vue';
  import Footer from '@/Components/Footer.vue'
import { Link } from '@inertiajs/vue3';
import PieChart from '@/Components/PieChart.vue';

const props = defineProps({
  userStats: Object,
  coursesCount: Number,
});

const userChartData = {
  labels: ['Admin', 'Teacher', 'Student'],
  datasets: [{
    label: 'Брой потребители',
    data: [
      props.userStats.admin || 0,
      props.userStats.teacher || 0,
      props.userStats.student || 0
    ],
    backgroundColor: ['#f87171', '#60a5fa', '#34d399']
  }]
};
</script>
