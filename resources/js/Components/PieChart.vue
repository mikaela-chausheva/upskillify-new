<template>
    <Pie :data="chartData" />
  </template>

  <script setup>
  import { Pie } from 'vue-chartjs'
  import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement } from 'chart.js'

  ChartJS.register(Title, Tooltip, Legend, ArcElement)

  defineProps({
    chartData: Object
  })
  </script>
