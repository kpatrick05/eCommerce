

<!-- This example requires Tailwind CSS v3.0+ -->
<template>
    <AppLayout>


    

        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Product Create
        </h2>


        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="mb-6">
                                <label for="Title"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Title</label>
                                <input type="text" v-model="form.title" name="title"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="" />
                                <div v-if="form.errors.title" class="text-sm text-red-600">
                                    {{ form.errors.title }}
                                </div>
                            </div>
                            <div class="mb-6">
                                <label for="slug"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Slug</label>
                                <input type="text" v-model="form.slug" name="title"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="" />
                                <div v-if="form.errors.slug" class="text-sm text-red-600">
                                    {{ form.errors.slug }}
                                </div>
                            </div>
                            <div class="mb-6">
                                <label for="price"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Price</label>
                                <input type="number" v-model="form.price" name="content" id=""
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">

                                <div v-if="form.errors.content" class="text-sm text-red-600">
                                    {{ form.errors.content }}
                                </div>
                            </div>
                            <div class="mb-6">
                                <label for="descripition"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Description</label>
                                <input type="text" v-model="form.description" name="content" id=""
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">

                                <div v-if="form.errors.content" class="text-sm text-red-600">
                                    {{ form.errors.content }}
                                </div>
                            </div>
                            <div class="mb-6">
                                <label for="image"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Image</label>
                              <input ref="image" type="file" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <div v-if="form.errors.content" class="text-sm text-red-600">
                                    {{ form.errors.image }}
                                </div>
                            </div>
                            <button type="submit"
                                class="text-white bg-blue-700  focus:outline-none  font-medium rounded-lg text-sm px-5 py-2.5 "
                                :disabled="form.processing" :class="{ 'opacity-25': form.processing }">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



    </AppLayout>
</template>
  
<script setup>
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from "@inertiajs/vue3";

// const props = defineProps({
//     product: Object
// })

const imagePreview = ref(null);
const image = ref(null);

const form = useForm({
    id:null ,
    title: null,
    slug: null,
    price: null,
    description: null,
    image: null

});


// // console.log(form.title);


const submit = () => {
    if (image.value) {
        form.image = image.value.files[0];
    }
    form.post(route("product.store"));
};

</script>
