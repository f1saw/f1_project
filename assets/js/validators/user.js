const MAX_LENGTH = 255;

const err_input_info = (id, err_msg) => {
    $(`#input-info-${id} span:first-child`).text("warning").addClass("text-danger");
    $(`#input-info-${id} span:nth-child(2)`).html(`${err_msg}`).addClass("text-danger");
    $(`#input-info-${id}`).removeClass("d-none");
    $(".btn-submit,#btn-submit").attr("disabled", true)
}

const clear_input_info = ids => {
    // foreach used to clear input communication with ids: [pass, pass-confirm]
    ids.forEach(id => {
        $(`#input-info-${id} span:first-child`).text("").removeClass("text-danger");
        $(`#input-info-${id} span:nth-child(2)`).text("").removeClass("text-danger");
        $(`#input-info-${id}`).addClass("d-none");
    })

}

const validateMaxLength = (id, value) => {
    // if value is undefined, it means it is not shown on the page.
    // it does not count as valid/not valid.
    return (value === undefined)? true : value.length <= MAX_LENGTH;
}

const validateEmail = (id, email) => {
    if (email === '') return true;
    return validateMaxLength(id, email) && String(email)
        .toLowerCase()
        .match(
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        );
};

const validatePassword = (id, password) => {
    // if password is undefined, it means it is not shown on the page.
    // it does not count as valid/not valid.
    if (password === undefined) return true;

    const isValid = password.length <= MAX_LENGTH;

    if (id === "pass") {
        const confirm = $("#pass-confirm").val();
        if (confirm !== undefined) {
            console.log("C " + confirm)
            return isValid && password === confirm;
        }
        return isValid;
    } else {
        const original_password = $("#pass").val();
        if (original_password !== undefined) {
            return isValid && original_password === password;
        }
        return isValid;
    }
}

const validators_user = {
    "firstname": {
        ids: ["fname"],
        validator: validateMaxLength,
        err_msg: ["First name is too <strong class='text-danger'>LONG</strong>"]
    },
    "lastname": {
        ids: ["lname"],
        validator: validateMaxLength,
        err_msg: ["Last name is too <strong class='text-danger'>LONG</strong>"]
    },
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
    },
    "img_url": {
        ids: ["img_url"],
        validator: validateMaxLength,
        err_msg: ["Image url is too <strong class='text-danger'>LONG</strong>"]
    },
}

const check_all = validators => {
    let isValid = true;
    for (const [key, value] of Object.entries(validators)) {
        value.ids.forEach((id, index) => {
            isValid = isValid && value.validator(id, $(`#${id}`).val());
        })
    }
    if (isValid) {
        $(".btn-submit,#btn-submit").attr("disabled", false)
    }
}

for (const value of Object.values(validators_user)) {
    // console.log(key, value);
    value.ids.forEach((id, index) => {
        console.log()
        const dom_element = $(`#${id}`)
        if (dom_element.val() !== undefined) {
            dom_element.on('input', event => {
                if (!value.validator(id, event.target.value)) {
                    err_input_info(id, value.err_msg[index])
                } else {
                    clear_input_info(value.ids)
                    check_all(validators_user)
                }
            })
        }
    })
}