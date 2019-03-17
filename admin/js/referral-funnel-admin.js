
window.onload = function () {
	new Vue({
		el: '#app',
		async mounted() {
			await this.fetchData();
		},
		data: () => ({

			pagination: {
				sortBy: 'name'
			},
			isDataFetched: false,
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
			user_info: []

		}),

		methods: {
			onResize() {
				if (window.innerWidth < 769)
					this.isMobile = true;
				else
					this.isMobile = false;
			},
			deleteItem(item) {

				var prompt = confirm('Are you sure you want to block or unblock this user?')

				if (prompt) {
					return new Promise((resolve, reject) => {
						jQuery.ajax({
							type: 'POST',
							url: '/wp-json/referral-funnel/v1/disable-user',
							data: {
								email: item.user_email,
								user_disabled: item.user_disabled,
								array_count: item.array_count,
								pid: item.pid
							}
						}).done(data => {
							this.user_info.forEach(uinfo => {
								if (item.user_email == uinfo.user_email) {
									uinfo.user_disabled = data
								}
							})
							resolve();
						}).fail(error => {
							console.error(error)
							reject();

						})
					});
				} else {

				}
			},
			fetchData() {
				return new Promise((resolve, reject) => {
					jQuery.ajax({
						url: '/wp-json/referral-funnel/v1/list'
					}).done(data => {
						data.forEach(data => {

							for (var i = 0; i < data.meta.reflink.length; i++) {
								let tempObject = {}

								tempObject.display_name = data.data.display_name
								tempObject.user_email = data.data.user_email
								tempObject.reflink = data.meta.reflink[i]

								var pid = tempObject.reflink.substring(
									tempObject.reflink.lastIndexOf("p") + 4,
									tempObject.reflink.lastIndexOf("&")
								);
								var refcounter = data.meta[pid][0];
								var requiredref = data.meta['rf_current_required'][i];
								data.meta.user_disabled[0] == [] ? data.meta.user_disabled[0] == ["green"] : null
								tempObject.refcount = refcounter
								tempObject.currprogress = refcounter + '/' + requiredref
								tempObject.rf_postTitle = data.meta.rf_postTitle[i]
								tempObject.rf_current_email_id = data.meta.rf_current_email_id[i]
								tempObject.user_disabled = data.meta.user_disabled[0]
								tempObject.array_count = i
								tempObject.pid = pid
								this.user_info.push(tempObject)
							}


						});
						resolve();
					}).fail(error => {
						console.error(error)
						reject();

					}).always(() => {
						this.isDataFetched = true;
					})
				});

			}
		}
	})

}