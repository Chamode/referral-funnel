
(function () {
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
                    this.joinedDate = '2019-03-09 02:03:01';
                    this.maxHours = 72;

                    setTimeout(() => {
                        if (this.joinedDate) {

                            let maxDate = moment(this.joinedDate, 'YYYY-MM-DD HH:mm:ss');
                            maxDate.add(this.maxHours, 'h');

                            //To check if the timer has already exceeded the time limit
                            if(!this.currentDate.isBefore(maxDate)) {
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

                    }, 1000);
                    $.get('http://localhost/wp-plugin/wp-json/referral-funnel/v1/countdown/').done((data) => {
                       data.joinedDate
                    })
                },
                formatCountdown() {
                    let formattedCountdown = moment.duration(this.savedTimerMil);
                    this.countdown = `${formattedCountdown.days()}days ${formattedCountdown.hours()}hrs ${formattedCountdown.minutes()}mins ${formattedCountdown.seconds()}s`;
                }
            }
        });
    }

    document.querySelectorAll('.jwtechlab-timer').forEach(el => {
        initVue(el.id);
    })
    //timerIDArray*


})();