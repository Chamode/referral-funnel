// // Referral Counter and amount left
// <script>
//   jQuery(document).ready(function($) {
// var getUrlParameter = function getUrlParameter(sParam) {
//     var sPageURL = window.location.search.substring(1),
//       sURLVariables = sPageURL.split('&'),
//       sParameterName,
//       i;

//     for (i = 0; i < sURLVariables.length; i++) {
//     sParameterName = sURLVariables[i].split('=');

//   if (sParameterName[0] === sParam) {
//             return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
// }
// }
// };
// var pid = getUrlParameter('pid');
// var uid = getUrlParameter('uid');

// var pageURL = $(location). attr("href");

//     if (pid !== undefined && uid !== undefined) {
//     console.log(pid)
//         jQuery.ajax({
//     type: 'POST',
//   dataType: 'json',
// url: 'http://localhost/wp-plugin/innerawesome/wp-json/referral-funnel/v1/init-referral-counter',
// 		data: {pid: pid,
//                uid:uid},
// 		success: function(data){
//     console.log(data)
//                 jQuery('#counter').text(data)
//   jQuery('#link').text(pageURL)
// },
//         error: function(data){
//     console.log('ttt')
//                 console.log(JSON.stringify(data))
// }
// })
// }
//     else {
//     console.log('no')
//   }
//   })
// </script>
//   <p id="counter"></p>


//   // Input form
//   <html>
//     <form id="my_form" method="POST">
//   Email: <input type="text" id="email" name="email"><br>
  
// </form><button type="submit" id='submit' value="Submit"></button>
//  <script>


//     jQuery(document).ready(function($) {
        
        
//         var getUrlParameter = function getUrlParameter(sParam) {
//     var sPageURL = window.location.search.substring(1),
//         sURLVariables = sPageURL.split('&'),
//         sParameterName,
//         i;

//     for (i = 0; i < sURLVariables.length; i++) {
//         sParameterName = sURLVariables[i].split('=');

//         if (sParameterName[0] === sParam) {
//             return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
//         }
//     }
// };
        
//     var pageURL = $(location). attr("href");

//    var pid = getUrlParameter('pid');
//     var uid = getUrlParameter('uid');
 
//     if (pid !== undefined && uid !== undefined) {
//       $('#submit').click(function() {
//           var email=jQuery('#email').val();
//           console.log(email)
//           $.ajax({
//              type: "POST",
//              url: "http://localhost/wp-plugin/innerawesome/wp-json/referral-funnel/v1/addlist",
//              data: {pageURL: pageURL,
//                  email:email,
//                  pid: pid,
//                  uid:uid
//              },
//              success: function(msg) {
//                   console.log('addlist success')
//                console.log(msg)
//                           $.ajax({
//                            type: 'POST',
//         dataType: 'json',
// 		url: 'http://localhost/wp-plugin/innerawesome/wp-json/referral-funnel/v1/getmeta',
// 		data: {pageURL: pageURL,
// 		    email:email
// 		},
// 		success: function(data){
// 		     console.log('getmeta success')
//                 console.log(data)
//                 window.location.href = data
//                  $('#link').text(data)
//         },
//         error: function(data){
//             console.log('getmeta error')
//                 console.log(JSON.stringify(data))
//         }
//                })
//              },
//              error: function(data){
//             console.log('sss')
//             console.log(JSON.stringify(data))
//         }
//           });


//       });

//     }else{
//              $('#submit').click(function() {
//           var email=jQuery('#email').val();
//           console.log(email)
//           $.ajax({
//              type: "POST",
//              url: "http://localhost/wp-plugin/innerawesome/wp-json/referral-funnel/v1/addlist",
//              data: {pageURL: pageURL,
//                  email:email
//              },
//              success: function(msg) {
//                   console.log('addlist success')
//                console.log(msg)
//                           $.ajax({
//                            type: 'POST',
//         dataType: 'json',
// 		url: 'http://localhost/wp-plugin/innerawesome/wp-json/referral-funnel/v1/getmeta',
// 		data: {pageURL: pageURL,
// 		    email:email
// 		},
// 		success: function(data){
// 		     console.log('getmeta success')
//                 console.log(data)
//                 window.location.href = data
//                  $('#link').text(data)
//         },
//         error: function(data){
//             console.log('getmeta error')
//                 console.log(JSON.stringify(data))
//         }
//                })
//              },
//              error: function(data){
//             console.log('addtolist error')
//             console.log(JSON.stringify(data))
//         }
//           });


//       });
//     }
//     });

//  </script>
// </html><p id="link"></p>