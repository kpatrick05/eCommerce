<!--
This example requires some changes to your config:

```
// tailwind.config.js
module.exports = {
  // ...
  theme: {
    extend: {
      gridTemplateRows: {
        '[auto,auto,1fr]': 'auto auto 1fr',
      },
    },
  },
  plugins: [
    // ...
    require('@tailwindcss/aspect-ratio'),
  ],
}
```
-->
<template>
  <AppLayout>
    <font-awesome-icon icon="fa-solid fa-cart-shopping" />
    <div class="bg-white">
      <div class="pt-6">
        <!-- Image gallery -->
        <div class="mx-auto w-2/4">
          <div class="aspect-w-3 aspect-h-4 hidden overflow-hidden rounded-lg lg:block">
            <img :src="product.image" 
              class="h-full w-full object-cover object-center" />
          </div>
        </div>
        <!-- Product info -->
        <div
          class="mx-auto max-w-2xl px-4 pt-10 pb-16 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pt-16 lg:pb-24">
          <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ product.title }}</h1>
          </div>

          <!-- Options -->
          <div class="mt-4 lg:row-span-3 lg:mt-0">
            <h2 class="sr-only">Product information</h2>
            <p class="text-3xl tracking-tight text-gray-900">{{ product.price }} $</p>

              <Link @click="success" :href="`/cart/add/${product.id}`" method="post" as="button" type="submit"
                class="mt-10 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 py-3 px-8 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Add
                to cart</Link>

          </div>

          <div class="py-10 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pt-6 lg:pb-16 lg:pr-8">
            <!-- Description and details -->
            <div>
              <h3 class="sr-only">Description</h3>

              <div class="space-y-6">
                <p class="text-base text-gray-900">{{ product.description }}</p>
              </div>
            </div>

            <div class="mt-10">
              <h3 class="text-sm font-medium text-gray-900">Highlights</h3>
            </div>

            <div class="mt-10">
              <h2 class="text-sm font-medium text-gray-900">Details</h2>

              <div class="mt-4 space-y-6">
                <p class="text-sm text-gray-600">{{ product.details }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, toRefs, onMounted } from 'vue'
import { StarIcon } from '@heroicons/vue/24/solid'
import { RadioGroup, RadioGroupLabel, RadioGroupOption } from '@headlessui/vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3'
import swal from 'sweetalert';

const props =defineProps({
  product : Object
})

const { product } = props;
console.log(product.title);



function success() {
  swal("Good Job!","The item was successfully added to your cart", "success");
}
</script>