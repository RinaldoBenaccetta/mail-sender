// XMLHttpRequest version with minAjax library
// function sendMail() {
//     document.getElementById("mail-status").innerHTML = "processing...";
//     minAjax({
//         url:"mail-sender/index.php",//request URL
//         type:"POST",//Request type GET/POST
//         //Send Data in form of GET/POST
//         data:getValues(),
//         //CALLBACK FUNCTION with RESPONSE as argument
//         success: function(data){
//             document.getElementById("mail-status").innerHTML = data;
//             //alert(data);
//         }
//
//     });
// }

function sendMail() {
    document.getElementById("mail-status").innerHTML = "processing...";

    var input = getValues()

    var data = new FormData()

    request(data, input)
}

function request(data, input) {
    data.append('senderName', input['senderName'])
    data.append('senderFirstName', input['senderFirstName'])
    data.append('senderPhone', input['senderPhone'])
    data.append('senderMail', input['senderMail'])
    data.append('message', input['message'])
    data.append('senderPhone', input['senderPhone'])
    data.append('mailError', input['mailError'])
    data.append('client', input['client'])

    fetch('mail-sender/index.php', {

        method: 'POST',

        body: data

        //body: JSON.stringify(getValues()) // don't work

        //body: getValues() // don't work

    }).then(res => {
        if(res.ok) {
            res.text()
                .then(text => {
                document.getElementById("mail-status").textContent = text;
            });
        } else {
            throw Error(`Request rejected with status ${res.status}`);
        }
    })
        .catch((error) => console.log(error))
}


function getValues() {
    return {
        client: 'js',
        senderName: document
            .getElementById("senderName").value,
        senderFirstName: document
            .getElementById("senderFirstName").value,
        senderPhone: document
            .getElementById("senderPhone").value,
        senderMail: document
            .getElementById("senderMail").value,
        message: document
            .getElementById("message").value,
        mailOk: document
            .getElementById("mailOk").value,
        mailError: document
            .getElementById("mailError").value,
    };
}