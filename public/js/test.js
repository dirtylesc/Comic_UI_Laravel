fetch("http://localhost:8080/comics", {
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
    body: JSON.stringify({
        a: 1,
        b: 2
    }),
})
    .then(res => {
        return res.json();
    })
    .then(data => {
        console.log('====================================');
        console.log(data);
        console.log('====================================');
    })

// $.ajax({
//     url: "http://localhost:8080/comics",
//     type: 'POST',
//     dataType: 'json',
//     data: JSON.stringify({
//         a: 1,
//         b: 2
//     }),
//     processData: false,
//     contentType: false,
//     success: function(response) {
//         console.log('====================================');
//         console.log(response);
//         console.log('====================================');
//         if (response.success) {
//         }
//     },
//     error: function(data) {
//         // const erorrs = Object.values(data.responseJSON.errors);
//         // notifyError(erorrs);
//     }
// });