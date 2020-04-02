/**
 * Here is an example of integration of mail sender within Javascript.
 * There is two example methods : by classic XMLHttpRequest and by fetch method.
 */


/**
 * The URL of the php file that process mail request.
 *
 * @type {string}
 */
const URL = "mail-sender/index.php"

/**
 * The method used.
 * Must be POST and no change.
 * @type {string}
 */
const METHOD = "POST"

/**
 * Get the values from the form.
 *
 * @returns {{senderPhone: *, mailError: *, senderName: *, senderFirstName: *, client: string, mailOk: *, message: *, senderMail: *}}
 */
function getValues() {
    return {
        client: 'js',
        redirect: 'true',
        // template can be sets here :
        // template: 'test-template',
        // subject can be sets here :
        // subject: 'hello!',
        // custom values used in custom template can be set :
        // myValue: 'me',
        // objects to :
        // myObject: {
        //  firstValue: 'value'
        //  secondValue: 42
        // }
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

/**
 * Send the mail with classic XMLHttpRequest.
 * Here with the minAjax library.
 * https://flouthoc.github.io/minAjax.js/
 *
 */
function sendMailWithMinAjax() {
    processing();
    minAjax({
        url: URL,//request URL
        type: METHOD,//Request type GET/POST
        //Send Data in form of GET/POST
        data: getValues(),
        //CALLBACK FUNCTION with RESPONSE as argument
        success: function (response) {
            console.log(response)
            handleResponse(response)
        }

    });
}

/**
 * Send the mail with fetch method.
 */
function sendMailWithFetch() {
    processing();

    let input = getValues()

    let data = new FormData()

    fetchRequest(data, input)
}

/**
 * Send the request to the server with fetch.
 *
 * @param data
 * @param input
 */
function fetchRequest(data, input) {
    data.append('senderName', input['senderName'])
    data.append('senderFirstName', input['senderFirstName'])
    data.append('senderPhone', input['senderPhone'])
    data.append('senderMail', input['senderMail'])
    data.append('message', input['message'])
    data.append('senderPhone', input['senderPhone'])
    data.append('mailError', input['mailError'])
    data.append('client', input['client'])

    fetch(URL, {

        method: METHOD,

        body: data

    }).then(res => {
        if (res.ok) {
            res.text()
                .then(response => {
                    // if there is a response from the server, handle the
                    // response.
                    handleResponse(response)
                });
        } else {
            throw Error(`Request rejected with status ${res.status}`)
        }
    })
        .catch((error) => console.log(error))
}

/**
 * Decide what to do with the response of the server.
 *
 * @param response
 */
function handleResponse(response) {
    if (response === "ok") {
        handleOk()
    } else if (response.includes('error')) {
        handleError(response)
    } else {
        handleVoid()
    }
}

/**
 * what to do while processing.
 *
 */
function processing() {
    document.getElementById("mail-status").innerHTML = "processing..."
}

/**
 * what to do if server return ok.
 *
 */
function handleOk() {
    document.getElementById("mail-status").textContent = 'E-mail sended!'
}

/**
 * What to do if server return an error.
 *
 * @param response
 */
function handleError(response) {
    document.getElementById("mail-status").textContent = `There is a code ${getCode(response)} error!`
}

/**
 * What to do if server does not return neither ok nor error.
 *
 */
function handleVoid() {
    document.getElementById("mail-status").textContent = "Something went wrong"
}

/**
 * Get the code of the error.
 *
 * @param response
 * @returns {*|string}
 */
function getCode(response) {
    console.log(response)
    return response.split(':')[1]
}