const MAX_TITLE_LENGTH = 150;
const MAX_DESCRIPTION_LENGTH = 500;
const MAX_IMGS_LENGTH = 700;
const MAX_COLOR_LENGTH = 20;
const MAX_SIZE_LENGTH = 20;

/**
 * Error detected in input fields,
 * so showing a proper message (err_msg) and disabling submit button is performed.
 * @param id
 * @param err_msg
 */
const err_input_info = (id, err_msg) => {
    // assignment needed in order to select the proper div where to display errors with images length
    id = (/^img_url_/.test(id))? validators_products["images"].err_id : id;

    $(`#input-info-${id} span:first-child`).text("warning").addClass("text-danger");
    $(`#input-info-${id} span:nth-child(2)`).html(`${err_msg}`).addClass("text-danger");
    $(`#input-info-${id}`).removeClass("d-none");
    $("#btn-submit").attr("disabled", true)
}

const clear_input_info = id => {
    // assignment needed in order to select the proper div where to display errors with images length
    id = (/^img_url_/.test(id))? validators_products["images"].err_id : id;

    $(`#input-info-${id} span:first-child`).text("").removeClass("text-danger");
    $(`#input-info-${id} span:nth-child(2)`).text("").removeClass("text-danger");
    $(`#input-info-${id}`).addClass("d-none");
}

const validateMaxFiles = (id, value, params) => {
    return $("#images-local")[0].files.length <= params;
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

/**
 * Object designed to store validating information
 * key: string
 * ids: array containing the list of ids to perform the validator function on
 * validator: function used to validate input given
 * params: array containing validator function parameters
 * err_msg: string where to specify message if an error is detected
 */
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
    },
    "images_local": {
        ids: ["images-local"],
        validator: validateMaxFiles,
        params: 2,
        err_msg: "You can upload a maximum of <strong class='text-danger'>TWO</strong> images",
        err_id: "images-local"
    }
}

/**
 * Enable (or Disable) btn-submit if essential inputs are valid (or NOT)
 * @param validators
 */
const check_all = validators => {
    let isValid = true;
    for (const [key, value] of Object.entries(validators)) {
        value.ids.forEach((id, index) => {
            isValid = isValid && value.validator(id, $(`#${id}`).val(), value.params);
        })
    }
    if (isValid) {
        $("#btn-submit").attr("disabled", false)
    }
}

/**
 * Add "input" event listener on each input field
 */
for (const [key, value] of Object.entries(validators_products)) {
    // console.log(key, value);
    value.ids.forEach((id, index) => {
        $(`#${id}`).on('input', event => {
            if (!value.validator(id, event.target.value, value.params)) {
                err_input_info(id, value.err_msg)
            } else {
                clear_input_info(value.ids)
                check_all(validators_products)
            }
        })
    })
}