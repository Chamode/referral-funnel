
(function ($) {

    let initVue = (id) => {
        new Vue({
            el: '#' + id,
            data:
            {
                joinedDate: null,
                countdown: null,
                savedTimer: null,
                currentDate: moment(),
                maxHours: null
            },
            mounted() {
                this.getUserJoinedDate();
            },
            methods: {
                getUserJoinedDate() {
                    //MAKE SURE TO DELETE 'joinedDate and maxHours' below, AND CHANGE CODE BELOW TO USE FROM DATA OBJECT

                    $.get('/innerawe2/wp-json/referral-funnel/v1/countdown').done((response) => {
                        this.joinedDate = response[0][0]
                        this.maxHours = response[1]

                        if (this.joinedDate) {

                            let maxDate = moment(this.joinedDate, 'YYYY-MM-DD HH:mm:ss');
                            maxDate.add(this.maxHours, 'h');

                            //To check if the timer has already exceeded the time limit
                            if (!this.currentDate.isBefore(maxDate)) {
                                document.querySelectorAll(".jwtechlab-hide-banner").forEach(el => {
                                    el.style.display = 'none'
                                })
                                return;
                            }

                            this.savedTimerMil = maxDate.diff(this.currentDate);

                            this.formatCountdown();


                            let recursiveLoop = () => {
                                setTimeout(() => {
                                    this.savedTimerMil = this.savedTimerMil - 1000;
                                    this.formatCountdown();
                                    recursiveLoop();
                                }, 1000);
                            }

                            recursiveLoop();
                        }
                    })
                },
                formatCountdown() {
                    let formattedCountdown = moment.duration(this.savedTimerMil);
                    this.countdown = `${formattedCountdown.days()}<span style="color:black">days</span> ${formattedCountdown.hours()}<span style="color:black">hrs</span> ${formattedCountdown.minutes()}<span style="color:black">mins </span>${formattedCountdown.seconds()}<span style="color:black">s</span>`;
                }
            }
        });
    }

    document.querySelectorAll('.jwtechlab-timer').forEach(el => {
        initVue(el.id);
    })
    //timerIDArray*


})(jQuery);