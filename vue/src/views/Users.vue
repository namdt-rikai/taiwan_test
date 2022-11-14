<template>
	<div class="ml-2 mr-2 w-96 search-btn">
		<label for="default-search"
			class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-300">Search...</label>
		<div class="relative">
			<div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
				<svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
					stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
						d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
				</svg>
			</div>
			<input type="search" id="user-search" @change="filteredList($event.target.value)"
				class="block p-4 pl-10 sm:w-32 md:w-40 lg:w-96 text-md text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
				placeholder="Search...">
		</div>
	</div>

	<!-- test modal -->
	<div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3">
		<div v-for="user in listUser" :key="user.id"
			class="w-full max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
			<div class="card-info flex flex-col items-center py-10" @click="getUser(user.login)">
				<img class="mb-3 w-24 h-24 rounded-full shadow-lg" :src="user.avatar_url" :alt="user.login" />
				<h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ user.login }}</h5>
				<span class="text-sm text-gray-500 dark:text-gray-400">{{ user.type }}</span>
				<div class="flex mt-4 space-x-3 md:mt-6">
					<span
						class="inline-flex items-center py-2 px-4 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{
								user.site_admin
						}}</span>
				</div>
			</div>
		</div>
	</div>

	<div id="userModal" v-if="showModal == true" class="fixed animated fadeIn">
		<div
			class="overflow-y-auto overflow-x-hidden fixed top-30 right-50 left-50 z-50 inset-0 h-modal h-full flex justify-center bg-gray-600 bg-opacity-75">
			<div class="modal-dialog relative w-auto pointer-events-none">
				<div
					class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
					<div
						class="modal-header flex flex-col flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
						<img class="mb-3 w-60 h-60 rounded-full shadow-lg" :src="currentUser.avatar_url"
							:alt="currentUser.login" />
						<h5 class="text-xl font-medium leading-normal text-gray-800">{{ currentUser.name }}</h5>
						<div
							class="flex flex-shrink-0 flex-wrap items-center justify-center p-2 border-t border-gray-200 rounded-b-md">
							<a :href="currentUser.html_url" target="_blank"><button type="button"
									class="px-6 py-2.5 bg-purple-600 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out"
									data-bs-dismiss="modal">Follow</button></a>
						</div>
					</div>
					<p class="modal-body relative font-normal text-gray-700 dark:text-gray-400">

					<div class="flex mb-3">
						<div class="overflow-hidden w-10 h-10 bg-gray-100 rounded-full dark:bg-gray-600 mr-3 flex">
							<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
								xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 200 200"
								enable-background="new 0 0 200 200" xml:space="preserve">
								<path fill="#282828" d="M100.232,149.198c-2.8,0-5.4-1.8-7.2-5.2c-22.2-41-22.4-41.4-22.4-41.6c-3.2-5.1-4.9-11.3-4.9-17.6
										c0-19.1,15.5-34.6,34.6-34.6s34.6,15.5,34.6,34.6c0,6.5-1.8,12.8-5.2,18.2c0,0-1.2,2.4-22.2,41
										C105.632,147.398,103.132,149.198,100.232,149.198z M100.332,54.198c-16.9,0-30.6,13.7-30.6,30.6c0,5.6,1.5,11.1,4.5,15.9
										c0.6,1.3,16.4,30.4,22.4,41.5c2.1,3.9,5.2,3.9,7.4,0c7.5-13.8,21.7-40.1,22.2-41c3.1-5,4.7-10.6,4.7-16.3
										C130.832,67.898,117.132,54.198,100.332,54.198z" />
								<path fill="#282828" d="M100.332,105.598c-10.6,0-19.1-8.6-19.1-19.1s8.5-19.2,19.1-19.2c10.6,0,19.1,8.6,19.1,19.1
										S110.832,105.598,100.332,105.598z M100.332,71.298c-8.3,0-15.1,6.8-15.1,15.1c0,8.3,6.8,15.1,15.1,15.1c8.3,0,15.1-6.8,15.1-15.1
										C115.432,78.098,108.632,71.298,100.332,71.298z" />
							</svg>
						</div>
						<span class="self-center">
							{{ currentUser.location ? currentUser.location : "Unknown Location" }}
						</span>
					</div>
					<div class="flex">
						<div class="grid overflow-hidden w-10 h-10 bg-gray-100 rounded-full dark:bg-gray-600 mr-3 flex justify-items-center items-center">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
								stroke="currentColor" class="w-6 h-6">
								<path stroke-linecap="round" stroke-linejoin="round"
									d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
							</svg>

						</div>
						<span class="self-center">
							{{ currentUser.followers ? currentUser.followers : "Unknown Location" }}
						</span>
					</div>
					</p>
					<div
						class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-center p-4 border-t border-gray-200 rounded-b-md">
						<button type="button" @click="closeModal()"
							class="px-6 py-2.5 bg-purple-600 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out"
							data-bs-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>


</template>

<script>

import VueClickAway from "vue3-click-away";

export default {
	data() {
		return {
			listUser: {},
			currentUser: {},
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
		async getUser(username) {
			let res = await this.$store.dispatch('user/getDetailUser', username)
			this.currentUser = res.data
			this.showModal = !this.showModal;
		},
		closeModal() {
			this.showModal = false;
		},
		onClickAway(event) {
			console.log(1)
			this.showModal = !this.showModal;
			console.log(this.showModal)
		}
	},
	directives: {
		ClickAway: VueClickAway,
	}
}


</script>

<style lang="scss" scoped>

</style>