(function($) {
    //Check if user is referred 
    let body = document.querySelector('body')
    pageURL = $(location).attr("href");
    body.querySelectorAll('.tve-leads-conversion-object form').forEach(node => {
        //Create the link
        node.addEventListener('submit', e => {
            e.preventDefault();
            let dataArary = $(e.target).serializeArray();
            
            $.post('http://localhost/innerawe2/wp-json/referral-funnel/v1/user-authentication', { data: JSON.stringify(dataArary), pageURL: pageURL}).done(data => {
                createShareBoxHtml(data);
            });

        });
    });

    let createShareBoxHtml = (linkToShare) => {
        let html = 
        `
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
})(jQuery);