<template>
    <AppLayout>

        <div class="container mx-auto mt-10 rounded-lg  ">
            <div class="flex  my-10">
                <div class="w-3/4 bg-white p-10">
                    <div class="flex justify-between border-b pb-8">
                        <h1 class="font-semibold text-2xl">Shopping Cart</h1>
                        <h2 class="font-semibold text-2xl">{{ count }} Items</h2>
                    </div>
                    <div class="flex mt-10 mb-5">
                        <h3 class="font-semibold text-gray-600 text-xs uppercase w-2/5">Product Details</h3>
                        <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 ">
                            Quantity</h3>
                        <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 ">
                            Price</h3>
                        <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 ">
                            Total</h3>
                    </div>
                    <div v-for="product in products" :key="product.id"
                        class="flex items-center hover:bg-gray-100 -mx-8 px-6 py-5">
                        <div class="flex w-2/5"> <!-- product -->
                            <div class="w-20">
                                <img class="h-24" :src="product.image" alt="">
                            </div>
                            <div class="flex flex-col justify-between ml-4 flex-grow">
                                <span class="font-bold text-sm">{{ product.title }}</span>
                                <span class="text-red-500 text-xs">{{ product.title }}</span>
                                <Link :href="`/cart/remove/${product.id}`" method="post" as="button"
                                    class="font-semibold hover:text-red-500 text-gray-500 w-10  text-xs">Remove</Link>
                            </div>
                        </div>

                        <div class="flex justify-center w-1/5">
                            <Link :href="`/cart/removequant/${product.id}`" method="post" as="button">
                            <svg class="fill-current text-gray-600 w-3" viewBox="0 0 448 512">
                                <path
                                    d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z" />
                            </svg>
                            </Link>

                            <div v-for="item in cartItems">
                                <p v-if="product.id == item.product_id" class="p-3">{{ item.quantity }}</p>
                            </div>
                            <Link :href="`/cart/addquant/${product.id}`" method="post" as="button">
                            <svg class="fill-current text-gray-600 w-3" viewBox="0 0 448 512">
                                <path
                                    d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z" />
                            </svg>
                            </Link>
                        </div>
                        <span class="text-center w-1/5 font-semibold text-sm">{{ product.price }}</span>
                      
                            <div class="text-center w-1/5 font-semibold text-sm">
                                <span v-for="item in cartItems">
                                    <p v-if="product.id == item.product_id" class="p-3">{{ product.price * item.quantity }}</p>
                                </span>
                            </div>
                        

                    </div>
                    <hr>




                    <Link href="/products" as="button" class="flex font-semibold text-indigo-600 text-sm mt-10">

                    <svg class="fill-current mr-2 text-indigo-600 w-4" viewBox="0 0 448 512">
                        <path
                            d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z" />
                    </svg>
                    Continue Shopping
                    </Link>
                </div>

                <div id="summary" class="w-1/4 px-8 py-10 bg-gray-100 rounded-md shadow-sm">
                    <h1 class="font-semibold text-2xl border-b pb-8">Order Summary</h1>
                    <div class="flex justify-between mt-10 mb-5">
                        <span class="font-semibold text-sm uppercase">Items {{ count }}</span>
                        <span class="font-semibold text-sm">{{ total }}$</span>
                    </div>
                    <div>
                        <label class="font-medium inline-block mb-3 text-sm uppercase ">Shipping</label>
                        <select class="block p-2 text-gray-600 w-full text-sm border-1 border-gray-300 rounded-md">
                            <option>Standard shipping - $10.00</option>
                        </select>
                    </div>
                    <div class="py-10">
                        <label for="promo" class="font-semibold inline-block mb-3 text-sm uppercase">Promo
                            Code</label>
                        <input type="text" id="promo" placeholder="Enter your code"
                            class="border-1 border-gray-300 rounded-md p-2 text-sm w-full">
                    </div>
                    <button
                        class="bg-red-500 hover:bg-red-600 px-5 py-2 text-sm text-white uppercase rounded-md">Apply</button>
                    <div class="border-t mt-8">
                        <div class="flex font-semibold justify-between py-6 text-sm uppercase">
                            <span>Total cost</span>
                            <span>${{ costWithShipping }}</span>
                        </div>
                        <Link :href="`/cart/checkout`" method="post" as="button"
                            class="bg-indigo-500 font-semibold hover:bg-indigo-600 py-3 text-sm text-white uppercase w-full rounded-md">Checkout</Link>
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ref, watch } from 'vue';


const props = defineProps({
    cartItems: Object,
    products: Object,
    total: Number,
    count: Number,
    totalProduct : Number

})
let costWithShipping = 0;

watch(() => {
    costWithShipping = ref(props.total + 10)
});

</script>