const MAX_LENGTH = 255;

const err_input_info = (id, err_msg) => {
    $(`#input-info-${id} span:first-child`).text("warning").addClass("text-danger");
    $(`#input-info-${id} span:nth-child(2)`).html(`${err_msg}`).addClass("text-danger");
    $(`#input-info-${id}`).removeClass("d-none");
}

const clear_input_info = ids => {
    // foreach used to clear input communication with ids: [pass, pass-confirm]
    ids.forEach(id => {
        $(`#input-info-${id} span:first-child`).text("").removeClass("text-danger");
        $(`#input-info-${id} span:nth-child(2)`).text("").removeClass("text-danger");
        $(`#input-info-${id}`).addClass("d-none");
    })

}

const validateEmail = (id, email) => {
    return email.length <= MAX_LENGTH && String(email)
        .toLowerCase()
        .match(
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        );
};

const validatePassword = (id, password) => {
    const isValid = password.length <= MAX_LENGTH;

    if (id === "pass") {
        const confirm = $("#pass-confirm").val();
        console.log("pass, now check confirm")
        if (confirm !== undefined) {
            console.log(confirm)
            return isValid && password === confirm;
        }
        return isValid;
    } else {
        const original_password = $("#pass").val();
        console.log("conf pass, now check original")
        if (original_password !== undefined) {
            return isValid && original_password === password;
        }
        return isValid;
    }
}

const validators_user = {
    "email": {
        ids: ["email"],
        validator: validateEmail,
        err_msg: ["E-mail <strong class='text-danger'>NOT</strong> valid"]
    },
    "password": {
        ids: ["pass", "pass-confirm"],
        validator: validatePassword,
        err_msg: ["Password is <strong class='text-danger'>NOT</strong> correct",
            "Retyped password does <strong class='text-danger'>NOT</strong> match with the original one"]
    }
}

for (const [key, value] of Object.entries(validators_user)) {
    // console.log(key, value);
    value.ids.forEach((id, index) => {
        $(`#${id}`).on('input', event => {
            if (!value.validator(id, event.target.value)) {
                err_input_info(id, value.err_msg[index])
            } else {
                clear_input_info(value.ids)
            }
        })
    })
}