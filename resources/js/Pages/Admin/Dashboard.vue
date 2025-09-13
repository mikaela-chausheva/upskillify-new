<template>
  <Navbar />
  <div class="max-w-7xl mx-auto px-6 py-10">
    <!-- Title -->
    <h1 class="text-3xl font-bold mb-8">Admin Dashboard</h1>

    <!-- Main Statistics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 mb-10">
      <!-- Users by Roles -->
      <div class="bg-white rounded-2xl shadow-lg p-6 col-span-2">
        <h2 class="text-xl font-semibold mb-4">Users by Roles</h2>
        <div class="flex justify-center">
          <PieChart :chart-data="userChartData" class="max-w-md w-full" />
        </div>
      </div>

      <!-- Total Courses -->
      <div
        class="bg-white rounded-2xl shadow-lg p-6 flex flex-col justify-center items-center space-y-6"
      >
        <div class="text-center">
          <h2 class="text-xl font-semibold mb-2">Total Courses</h2>
          <p class="text-5xl text-blue-600 font-bold">{{ coursesCount }}</p>
        </div>
        <Link
          href="/courses"
          class="bg-blue-500 text-white px-5 py-2 rounded-lg hover:bg-blue-600 transition"
        >
          View Courses
        </Link>
      </div>
    </div>

    <!-- Management Section -->
    <div class="bg-white rounded-2xl shadow-lg p-8">
      <h2 class="text-xl font-semibold mb-2">Management</h2>
      <p class="mb-6 text-gray-600">
        Access to administrator functionalities.
      </p>
      <Link
        href="/admin/users"
        class="inline-block bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 transition"
      >
        View All Users
      </Link>
    </div>
  </div>
  <Footer />
</template>

<script setup>
import Navbar from "@/Components/Navbar.vue";
import Footer from "@/Components/Footer.vue";
import { Link } from "@inertiajs/vue3";
import PieChart from "@/Components/PieChart.vue";

const props = defineProps({
  userStats: Object,
  coursesCount: Number,
});

const userChartData = {
  labels: ["Admin", "Teacher", "Student"],
  datasets: [
    {
      label: "Number of Users",
      data: [
        props.userStats.admin || 0,
        props.userStats.teacher || 0,
        props.userStats.student || 0,
      ],
      backgroundColor: ["#f87171", "#60a5fa", "#34d399"],
    },
  ],
};
</script>
