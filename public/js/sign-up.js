(function ($) {
    //Check if user is referred 
    let body = document.querySelector('body')
    pageURL = $(location).attr("href");

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

    var pid = getUrlParameter('pid');
    var uid = getUrlParameter('uid');

    let initReferredUser = () => {
        body.querySelectorAll('.tve-leads-conversion-object form').forEach(node => {
            node.addEventListener('submit', e => {
                $.post("http://localhost/innerawe2/wp-json/referral-funnel/v1/addlist", {
                    pid: pid,
                    uid: uid
                }).done(data => {
                    console.log(data)
                }).fail(error => {
                    console.log(error.responseText)
                    alert('Something has went wrong, please refresh the page.');
                })

            });
        })
    }

    let initExistingUser = () => {
        $.post('http://localhost/innerawe2/wp-json/referral-funnel/v1/init-page', { _wpnonce: ref_funnel.nonce, pageURL: pageURL }).done(data => {
            
            if (pid && uid && data.userData.ID === 0) 
                initReferredUser();
            else if (!pid && !uid && data.userData.ID === 0)
                initForm();
            else
               createShareBoxHtml(data.shareLink, data.referrals);
               
        }).fail(error => {
            console.log(error.responseText)
            alert('Something has went wrong, please refresh the page.');
        })
    }

    let initForm = () => {
        body.querySelectorAll('.tve-leads-conversion-object form').forEach(node => {
            //Create the link
            node.addEventListener('submit', e => {
                e.preventDefault();
                let dataArary = $(e.target).serializeArray();

                $.post('http://localhost/innerawe2/wp-json/referral-funnel/v1/user-authentication', { data: JSON.stringify(dataArary), pageURL: pageURL }).done(data => {
                    createShareBoxHtml(data);
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
        `;

        body.querySelectorAll('.tve-leads-conversion-object').forEach(node => {
            let $node = $(node)
            $node.empty();
            $node.append($(html));

        })
    }

    initExistingUser();
})(jQuery);