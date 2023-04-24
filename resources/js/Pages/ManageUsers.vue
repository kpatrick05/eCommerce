
<script setup>
import { ref, watch} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';


const props = defineProps({
	users: Object,
})

let search= ref('');


const form = useForm({
	search : ''
})

const submit  = () => {
  form.post(route("users.search", form.search));
};


</script>


<template>
	<AppLayout>


		<!-- component -->
		<div class="bg-white p-8 rounded-md w-full">
			<div class=" flex items-center justify-between pb-6">
				<div>
					<h2 class="text-gray-600 font-semibold">All users</h2>

				</div>
				<div >

					<form @keyup="submit">
							<label for="default-search"
								class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
							<div class="relative">
								<div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
									<svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
									stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
									</svg>
								</div>
								<input  v-model="form.search" type="text"
									class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
									placeholder="Search Mockups, Logos..." required>
								<!-- <button @click="submitForm"
									class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button> -->
							</div>
						</form>


						<!-- <input class="bg-gray-50 outline-none ml-1 block " type="text" name="" id="" placeholder="search..."> -->
					<!-- <div class="lg:ml-40 ml-10 space-x-8">
						<button class="bg-indigo-600 px-4 py-2 rounded-md text-white font-semibold tracking-wide cursor-pointer">New Report</button>
						<button class="bg-indigo-600 px-4 py-2 rounded-md text-white font-semibold tracking-wide cursor-pointer">Create</button>
					</div> -->
				</div>
			</div>
			<div>
				<div class="mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
					<div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
						<table class="min-w-full leading-normal">
							<thead>
								<tr>
									<th
										class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
										Name
									</th>
									<th
										class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
										Role
									</th>
									<th
										class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
										Created at
									</th>
									<th
										class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
										Email
									</th>
									<th
										class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
										Status
									</th>
									<th
										class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">

									</th>

								</tr>
							</thead>
							<tbody>
								<tr v-for="user in props.users">
									<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
										<div class="flex items-center">
											<div class="mx-1 h-8 w-8 rounded-full object-cover">
												<img class="mx-1 h-8 w-8 rounded-full object-cover"
													:src="user.profile_photo_url" alt="" />
											</div>
											<div class="ml-3">
												<p class="text-gray-900 whitespace-no-wrap">
													{{ user.name }}
												</p>
											</div>
										</div>
									</td>
									<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
										<p class="text-gray-900 whitespace-no-wrap" v-if="user.is_admin == 1">Admin</p>
										<p class="text-gray-900 whitespace-no-wrap" v-else>User</p>
									</td>
									<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
										<p class="text-gray-900 whitespace-no-wrap">
											{{ user.created_at }}
										</p>
									</td>
									<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
										<p class="text-gray-900 whitespace-no-wrap">
											{{ user.email }}
										</p>
									</td>
									<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
										<span
											class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
											<span aria-hidden
											class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
										<span class="relative">Active</span>
									</span>
								</td>
								<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
									<Link method="get" :href="'/user/' + user.id"
										class="bg-indigo-600 mx-2 px-4 py-2 rounded-md text-white font-semibold tracking-wide cursor-pointer">
									Edit</Link>
									<button
										class="bg-red-600 mx-2 px-4 py-2 rounded-md text-white font-semibold tracking-wide cursor-pointer">Delete</button>
								</td>
							</tr>

						</tbody>
					</table>
					<!-- <div
							class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between          ">
							<span class="text-xs xs:text-sm text-gray-900">
	                            Showing 1 to 4 of 50 Entries
	                        </span>
							<div class="inline-flex mt-2 xs:mt-0">
								<button
	                                class="text-sm text-indigo-50 transition duration-150 hover:bg-indigo-500 bg-indigo-600 font-semibold py-2 px-4 rounded-l">
	                                Prev
	                            </button>
								&nbsp; &nbsp;
								<button
	                                class="text-sm text-indigo-50 transition duration-150 hover:bg-indigo-500 bg-indigo-600 font-semibold py-2 px-4 rounded-r">
	                                Next
	                            </button>
							</div>
						</div> -->
					</div>
				</div>
		</div>
	</div>

</AppLayout></template>


  
