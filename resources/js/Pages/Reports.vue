

<!-- This example requires Tailwind CSS v3.0+ -->
<template>
    <AppLayout>
      <div class="container mx-auto mt-12">
                    <div class="grid grid-cols-1 gap-6 mb-6 lg:grid-cols-3">
                        <div class="w-full px-4 py-5 bg-white rounded-lg shadow">
                            <div class="text-sm font-medium text-gray-500 truncate">
                                Total users
                            </div>
                            <div class="mt-1 text-3xl font-semibold text-gray-900">
                                12,00
                            </div>
                        </div>
                        <div class="w-full px-4 py-5 bg-white rounded-lg shadow">
                            <div class="text-sm font-medium text-gray-500 truncate">
                                Total Profit
                            </div>
                            <div class="mt-1 text-3xl font-semibold text-gray-900">
                                $ 450k
                            </div>
                        </div>
                        <div class="w-full px-4 py-5 bg-white rounded-lg shadow">
                            <div class="text-sm font-medium text-gray-500 truncate">
                                Total Orders
                            </div>
                            <div class="mt-1 text-3xl font-semibold text-gray-900">
                                20k
                            </div>
                        </div>
                    </div>
                    
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
