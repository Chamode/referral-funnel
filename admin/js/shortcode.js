<html>
    <form id="my_form" method="POST">
  Email: <input type="text" id="email" name="email"><br>
  
</form><button type="submit" id='submit' value="Submit">
 <script>


    jQuery(document).ready(function($) {
var pageURL = $(location). attr("href");

      $('#submit').click(function() {
          var email=jQuery('#email').val();
          console.log(email)
          $.ajax({
             type: "POST",
             url: "http://localhost/wp-plugin/wp-json/referral-funnel/v1/addlist",
             data: {pageURL: pageURL,
                 email:email},
             success: function(msg) {
               console.log(msg)
               $.ajax({
                           type: 'POST',
        dataType: 'json',
		url: 'http://localhost/wp-plugin/wp-json/referral-funnel/v1/getmeta',
		data: {pageURL: pageURL,
		    email:email
		},
		success: function(data){
		     console.log('getmeta success')
                console.log(data)
                 $('#link').text(data)
        },
        error: function(data){
            console.log('getmeta error')
                console.log(JSON.stringify(data))
        }
               })
              
             },
                     error: function(data){
            console.log('ttt')
                console.log(JSON.stringify(data))
        }
          });

      });

    });

 </script>
</html>