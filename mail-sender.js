// function sendMail(){
// // Create our XMLHttpRequest object
//     var hr = new XMLHttpRequest();
// // Create some variables we need to send to our PHP file
//     var url = "processForm.php";
//     var fn = document.getElementById("fname").value;
//     var ln = document.getElementById("lname").value;
//     var vars = "firstname="+fn+"&lastname="+ln;
//     hr.open("POST", url, true);
//     hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
// // Access the onreadystatechange event for the XMLHttpRequest object
//     hr.onreadystatechange = function() {
//         if(hr.readyState == 4 && hr.status == 200) {
//             var return_data = hr.responseText;
//             document.getElementById("status").innerHTML = return_data;
//         }
//     }
// // Send the data to PHP now... and wait for response to update the status div
//     hr.send(vars); // Actually execute the request
//     document.getElementById("status").innerHTML = "processing...";
// }

function sendMail(){
// Create our XMLHttpRequest object
    var hr = new XMLHttpRequest();
// Create some variables we need to send to our PHP file
    let postValues = getValues();
    console.log(postValues);

    var url = "mail-sender/index.php";
    hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
// Access the onreadystatechange event for the XMLHttpRequest object
    hr.onreadystatechange = function() {
        if(hr.readyState === 4 && hr.status === 200) {
            document.getElementById("status").innerHTML = hr.responseText;
        }
    };
// Send the data to PHP now... and wait for response to update the status div
    hr.send(postValues); // Actually execute the request
    document.getElementById("mail-status").innerHTML = "processing...";
}

function getValues() {
    return {
        'senderName': document
            .getElementById("senderName").value,
        'senderFirstName': document
            .getElementById("senderFirstName").value,
        'senderPhone': document
            .getElementById("senderPhone").value,
        'senderMail': document
            .getElementById("senderMail").value,
        'mailOk': document
            .getElementById("mailOk").value,
        'mailError': document
            .getElementById("mailError").value,
    };
}