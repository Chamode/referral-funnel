(function ($) {
    //Check if user is referred 
    let body = document.querySelector('body')

    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
    };

    var pageURL = $(location).attr("href");

    var uid = getUrlParameter('uid');

    console.log({uid})

    let initReferredUser = () => {
        body.querySelectorAll('.tve-leads-conversion-object form').forEach(node => {
            console.log('initReferredUser')
            node.addEventListener('submit', e => {
                let dataArary = $(e.target).serializeArray();
                $.post("/innerawe2/wp-json/referral-funnel/v1/check-user", {
                    data: JSON.stringify(dataArary),
                    uid: uid
                }).done(data => {
                    if (data === true) {
                        alert('User has already been referred!');
                        // window.location.reload();
                        window.location.reload(true)
                    }
                    else {

                        $.post("/innerawe2/wp-json/referral-funnel/v1/addlist", {
                            data: JSON.stringify(dataArary),
                            pageURL: pageURL,
                            uid: uid
                        }).done(data => {
                            console.log({addUser: data});
                        }).fail(error => {
                            console.error(error.responseText)
                            alert('Something has went wrong, please refresh the page.');
                        })
                    }
                }).fail(error => {
                    console.error(error.responseText)

                })


            });
        })
    }

    let initExistingUser = () => {

        if (!uid) {
            uid = 0;
        }
        $.post('/innerawe2/wp-json/referral-funnel/v1/init-page', { _wpnonce: ref_funnel.nonce, pageURL: pageURL, uid:uid }).done(data => {
            console.log(data);
            if (data.init) {
                //Referred user
                if (uid && data.user.ID === 0)
                    initReferredUser();
                //Unreffered User
                else if (!uid && data.user.ID === 0)
                    initUnreferredUser();
                //User already signed up
                else
                    createShareBoxHtml(data.shareLink, data.referrals);
            }


        }).fail(error => {
            console.log(error)
            alert('Referral Funnel has not loaded properly. Please check if the plugin details or the page info are filled properly.');
        })
    }

    let initUnreferredUser = () => {
        console.log('Unreferred user init!')
        body.querySelectorAll('.tve-leads-conversion-object form').forEach(node => {
            //Create the link
            node.addEventListener('submit', e => {
                e.preventDefault();
                let dataArary = $(e.target).serializeArray();
                $.post('/innerawe2/wp-json/referral-funnel/v1/user-register', { data: JSON.stringify(dataArary), pageURL: pageURL }).done(data => {
                    console.log(data)
                    createShareBoxHtml(data.link, data.referrals);
                });

            });
        });
    }

    let createShareBoxHtml = (linkToShare, refferals) => {
        let html =
            `
        <div>You have ${refferals.currentProgress}/${refferals.goal} friends invited!</div>
        <div class="form-group">
            <label for="ref-funnel-linkToShare">Share this link with your friends!</label>
            <input type="text" class="form-control" id="ref-funnel-linkToShare" value="${linkToShare}" readonly>
        </div>
        <div id="jwtechlab-social-share">
        </div>
        `;

        body.querySelectorAll('.tve-leads-conversion-object').forEach(node => {
            let $node = $(node)
            $node.empty();
            $node.append($(html));

            if (FB) {
                let socialMediaHtml = `<div><div class="fb-share-button" data-href="${linkToShare}" data-layout="button_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div></div>
                <a target="_blank" href="https://wa.me/whatsappphonenumber/?text=${linkToShare}">WhatsApp</a>
                `
                $node.find('#jwtechlab-social-share').append($(socialMediaHtml))
            }

        })
    }

    initExistingUser();
})(jQuery);