const validateEmail = email => {
    return email.length <= 255 && String(email)
        .toLowerCase()
        .match(
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        );
};

const validatePassword = password => {
    let isValid = password.length <= 255;
    const confirm = $("#confirm").val();
    if (confirm !== undefined) {
        isValid = isValid && password === confirm;
    }
    return isValid;
}

const validators_user = {
    "email": {
        id: "email",
        validator: validateEmail,
        err_msg: "E-mail <strong class='text-danger'>NOT</strong> valid"
    },
    "password": {
        id: "pass",
        validator: validatePassword,
        err_msg: "Password is <strong class='text-danger'>NOT</strong> correct"
    }
}

for (const [key, value] of Object.entries(validators_user)) {
    // console.log(key, value);
    $(`#${value.id}`).on('input', event => {
        if (!value.validator(event.target.value)) {
            $(`#select-info-${value.id} span:first-child`).text("warning").addClass("text-danger");
            $(`#select-info-${value.id} span:nth-child(2)`).html(`${value.err_msg}`).addClass("text-danger");
            $(`#select-info-${value.id}`).removeClass("d-none");
        } else {
            $(`#select-info-${value.id} span:first-child`).text("").removeClass("text-danger");
            $(`#select-info-${value.id} span:nth-child(2)`).text("").removeClass("text-danger");
            $(`#select-info-${value.id}`).addClass("d-none");
        }
    })
}