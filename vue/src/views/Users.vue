<template>
	<div class="ml-2 mr-2 w-96 search-btn">
		<label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-300">Search</label>
		<div class="relative">
			<div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
				<svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
					viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
						d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
				</svg>
			</div>
			<input type="search" id="user-search" @change="filteredList($event.target.value)"
				class="block p-4 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
				placeholder="Search username">
		</div>
	</div>


	<!-- test modal -->
	<div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3">
		<div v-for="user in listUser" x-data="{ dropdownOpen: true }" :key="user.id" class="w-full max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
			<div class="flex justify-end">
				<button @click="dropdownOpen = !dropdownOpen" class="relative z-10 block rounded-md bg-white p-2 focus:outline-none">
					<svg class="w-6 h-6 transform group-hover:-rotate-180 transition duration-150 ease-in-out" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path></svg>
				</button>
				<!-- Dropdown menu -->
				<div x-show="dropdownOpen"  class="absolute bg-white border rounded-sm transform scale-0 group-hover:scale-100 absolute 
					transition duration-150 ease-in-out origin-top min-w-32">
					<ul class="py-1" aria-labelledby="dropdownButton">
						<li>
							<a href="#" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Edit</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="flex flex-col items-center pb-10">
				<img class="mb-3 w-24 h-24 rounded-full shadow-lg" :src="user.avatar_url" :alt="user.login"/>
				<h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ user.login }}</h5>
				<span class="text-sm text-gray-500 dark:text-gray-400">{{ user.type }}</span>
				<div class="flex mt-4 space-x-3 md:mt-6">
					<span class="inline-flex items-center py-2 px-4 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ user.site_admin }}</span>
				</div>
			</div>
		</div>
	</div>
	<!-- end test -->



	<!-- <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3">
		<div v-for="user in listUser" :key="user.id" @click="getUser(user.login)"
			class="card-info flex flex-col py-4 px-6 shadow-md bg-white hover:bg-gray-50 h-[320px]">
				<img :src="user.avatar_url" alt="" class="w-full h-48 object-cover">
				<h4 class="mt-4 text-lg font-bold">{{ user.login }}</h4>
				<div class="overflow-hidden flex-1">
					<span
						class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
						{{ user.site_admin }}
					</span>
				</div>
		</div>
	</div> -->
	<modal v-if="showModal">
		<div class="max-w-sm rounded overflow-hidden shadow-lg" @click="$emit('close')">
			<div class="card-info" @click.stop="closeModal()">
				<img class="w-full" src="https://storage.hungjp.tk/images/638022191835680507_eae2c1ae-bb55-4136-84a9-de4944a9c8d7.jpg" alt="Sunset in the mountains">
				<div class="px-6 py-4">
					<div class="font-bold text-xl mb-2">{{user}}</div>
					<p class="text-gray-700 text-base">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis eaque, exercitationem praesentium nihil.
					</p>
				</div>
				<div class="px-6 pt-4 pb-2">
					<span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#photography</span>
					<span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#travel</span>
					<span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#winter</span>
				</div>
			</div>
		</div>
	</modal>

</template>

<script>
import exampleModal from './modals/exampleModal.vue';
import '../api/users';
export default {
	data() {
		return {
			listUser: {},
			user: {},
			showModal: false
		}
	},
	async created() {
		await this.$store.dispatch('user/getListUser')
		this.filteredList()
	},

	methods: {
		filteredList(searchValue = '') {
			this.listUser = this.$store.state.user.list;
			if (searchValue !== '') {
				this.listUser = this.listUser.filter((user) =>
					user.login.toLowerCase().includes(searchValue.toLowerCase())
				);
			}
		},
		getUser(username) {
    		this.$store.dispatch('getDetailUser', username)
			console.log(username)
			this.showModal = true;
		},
		closeModal() {
			console.log("close")
			this.showModal = false;
		}
	},
	components:{
    	"example-modal":exampleModal
  	}
}


</script>

<style lang="scss" scoped>

</style>