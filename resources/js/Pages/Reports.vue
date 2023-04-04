

<!-- This example requires Tailwind CSS v3.0+ -->
<template>
    <AppLayout>
        <div class="container m-auto w-[400px] text-white bg-emerald-500 mt-5 py-2 px-3 rounded">
            Hey admin
        </div>
        <div>
            <apexchart type="line" height="350" :options="data.chartOptions" :series="data.series"></apexchart>
   
        </div>

    </AppLayout>
</template>
  
<script setup>
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue';
const data = {
          
          series: [{
              name: "Desktops",
              data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
          }],
          chartOptions: {
            chart: {
              height: 350,
              type: 'line',
              zoom: {
                enabled: false
              }
            },
            dataLabels: {
              enabled: false
            },
            stroke: {
              curve: 'straight'
            },
            title: {
              text: 'Product Trends by Month',
              align: 'left'
            },
            grid: {
              row: {
                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
              },
            },
            xaxis: {
              categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
            }
          },
          
          
        }


</script>
