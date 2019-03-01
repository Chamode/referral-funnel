
window.onload = function () {
	new Vue({
		el: '#app',
		async mounted() {
			await this.fetchData();

			console.log('done');
		},
		data: () => ({

			pagination: {
				sortBy: 'name'
			},
			selected: [],
			search: '',
			isMobile: false,
			headers: [{
				text: 'Name',
				align: 'left',
				value: 'display_name'
			},
			{
				text: 'Email',
				value: 'user_email'
			},
			{
				text: 'Referral Link',
				value: 'reflink'
			},
			{
				text: 'Current Content',
				value: 'rf_postTitle'
			},
			{
				text: 'Campaign Email ID',
				value: 'rf_current_email_id'
			},
			{
				text: 'Total Invites',
				value: 'refcount'
			},
			{
				text: 'Current Progress',
				value: 'currprogress'
			},
			{ text: 'Block', value: 'name', sortable: false }
			],
			desserts: [],
			user_info: []

		}),

		methods: {
			onResize() {
				if (window.innerWidth < 769)
					this.isMobile = true;
				else
					this.isMobile = false;
			},
			toggleAll() {
				if (this.selected.length) this.selected = []
				else this.selected = this.desserts.slice()
			},
			changeSort(column) {

				console.log(column);
				if (this.pagination.sortBy === column) {
					this.pagination.descending = !this.pagination.descending
				} else {
					this.pagination.sortBy = column
					this.pagination.descending = false
				}
			},
			deleteItem(item) {
				const index = this.desserts.indexOf(item)
				confirm('Are you sure you want to block this user?') && this.desserts.splice(index, 1)
			},
			fetchData() {
				return new Promise((resolve, reject) => {
					jQuery.ajax({
						url: 'http://localhost/wp-plugin/wp-json/referral-funnel/v1/list'
					}).done(data => {
						console.log(data)
						data.forEach(data => {
							let tempObject = {}
							tempObject.display_name = data.data.display_name
							tempObject.user_email = data.data.user_email
							tempObject.refcount = data.refcount
							tempObject.currprogress = data.currprogress

							for (var i = 0; i < data.meta.reflink.length; i++) {
								tempObject.reflink = data.meta.reflink[i]
								tempObject.rf_postTitle = data.meta.rf_postTitle[i]
								tempObject.rf_current_email_id = data.meta.rf_current_email_id[i]
								this.user_info.push(tempObject)
							}




						});

						// this.user_info = data
						// this.user_info = this.user_info
						resolve();
					}).fail(error => {
						console.log(error)
						reject();

					})
				});

			}
		}
	})

}
	// console.log(user_info)
