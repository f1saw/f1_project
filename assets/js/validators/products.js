const MAX_TITLE_LENGTH = 150;
const MAX_DESCRIPTION_LENGTH = 500;
const MAX_IMGS_LENGTH = 700;
const MAX_COLOR_LENGTH = 20;
const MAX_SIZE_LENGTH = 20;

const err_input_info = (id, err_msg) => {
    // assignment needed in order to select the proper div where to display errors with images length
    id = (/^img_url_/.test(id))? validators_products["images"].err_id : id;

    $(`#input-info-${id} span:first-child`).text("warning").addClass("text-danger");
    $(`#input-info-${id} span:nth-child(2)`).html(`${err_msg}`).addClass("text-danger");
    $(`#input-info-${id}`).removeClass("d-none");
}

const clear_input_info = id => {
    // assignment needed in order to select the proper div where to display errors with images length
    id = (/^img_url_/.test(id))? validators_products["images"].err_id : id;

    $(`#input-info-${id} span:first-child`).text("").removeClass("text-danger");
    $(`#input-info-${id} span:nth-child(2)`).text("").removeClass("text-danger");
    $(`#input-info-${id}`).addClass("d-none");
}


const validateMaxLength = (id, value, params) => {
    // test required to handle image urls length
    if (/^img_url_/.test(id)) {
        const other = id === validators_products["images"].ids[0]? 1:0;
        value += $(`#${validators_products["images"].ids[other]}`).val();
    }
    // in params[0] there is the MAX_LENGTH as function parameter
    return value.length <= params[0];
}

const validatePrice = (id, value) => {
    return /^[0-9]+([,.][0-9]{1,2})?$/.test(value)
}

const validateTeam = (id, value) => {
    return /^[0-9]+$/.test(value)
}

const validators_products = {
    "title": {
        ids: ["title"],
        validator: validateMaxLength,
        params: [MAX_TITLE_LENGTH],
        err_msg: "Title is too <strong class='text-danger'>LONG</strong>"
    },
    "description": {
        ids: ["desc"],
        validator: validateMaxLength,
        params: [MAX_DESCRIPTION_LENGTH],
        err_msg: "Description is too <strong class='text-danger'>LONG</strong>"
    },
    "price": {
        ids: ["price"],
        validator: validatePrice,
        err_msg: "Price is <strong class='text-danger'>NOT</strong> valid"
    },
    "team": {
        ids: ["team_id"],
        validator: validateTeam,
        err_msg: "Team ID is <strong class='text-danger'>NOT</strong> valid"
    },
    "size": {
        ids: ["size"],
        validator: validateMaxLength,
        params: [MAX_SIZE_LENGTH],
        err_msg: "Size input is too <strong class='text-danger'>LONG</strong>"
    },
    "color": {
        ids: ["color"],
        validator: validateMaxLength,
        params: [MAX_COLOR_LENGTH],
        err_msg: "Color input is too <strong class='text-danger'>LONG</strong>"
    },
    "images": {
        ids: ["img_url_1", "img_url_2"],
        validator: validateMaxLength,
        params: [MAX_IMGS_LENGTH],
        err_msg: "Image URLs are too <strong class='text-danger'>LONG</strong>",
        err_id: "images"
    }
}

for (const [key, value] of Object.entries(validators_products)) {
    // console.log(key, value);
    value.ids.forEach((id, index) => {
        $(`#${id}`).on('input', event => {
            if (!value.validator(id, event.target.value, value.params)) {
                err_input_info(id, value.err_msg)
            } else {
                clear_input_info(value.ids)
            }
        })
    })
}