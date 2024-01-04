const validateEmail = (email) => {
    return String(email)
        .toLowerCase()
        .match(
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        );
};

$("#email").on('input', event => {
    const email = event.target.value;
    if (email !== "" && !validateEmail(email)) {
        $("#select-info span:first-child").text("warning").addClass("text-danger");
        $("#select-info span:nth-child(2)").html("E-mail <strong class='text-danger'>NOT</strong> valid").addClass("text-danger");
        $("#select-info").removeClass("d-none");
    } else {
        $("#select-info span:first-child").text("").removeClass("text-danger");
        $("#select-info span:nth-child(2)").text("").removeClass("text-danger");
        $("#select-info").addClass("d-none");
    }
})