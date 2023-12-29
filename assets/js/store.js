/** Render products management in pages in store.php */
const LOWER_BOUND = 0;
const UPPER_BOUND = 3;
const ITEMS_PER_PAGE = UPPER_BOUND - LOWER_BOUND + 1;
const render_products = (lower, upper) => {
    const products = $(".product").toArray();
    const prev_btn = $("#prev-page");
    const next_btn = $("#next-page");
    prev_btn.removeClass("my-disabled").attr("disabled", false);
    next_btn.removeClass("my-disabled").attr("disabled", false);

    if (lower === 0) prev_btn.addClass("my-disabled").attr("disabled", true);
    if (upper >= products.length) next_btn.addClass("my-disabled").attr("disabled", true);

    products.forEach((item, index) => {
        if (index >= lower && index <= upper) {
            $(item).removeClass("d-none");
        } else {
            $(item).addClass("d-none");
        }
    })
}

$("#prev-page").on('click', () => {
    const curr_page_btn = $("#curr-page");
    const curr_page = curr_page_btn.text();
    if (curr_page > 1) {
        render_products(ITEMS_PER_PAGE * (curr_page*1 - 2), ITEMS_PER_PAGE * (curr_page*1 - 1) - 1);
        curr_page_btn.text(curr_page*1 - 1);
    }
})

$("#next-page").on('click', () => {
    const curr_page_btn = $("#curr-page");
    const curr_page = curr_page_btn.text();
    if (curr_page < $(".product").toArray().length / ITEMS_PER_PAGE) {
        render_products(ITEMS_PER_PAGE * curr_page, ITEMS_PER_PAGE * (curr_page*1 + 1) - 1);
        curr_page_btn.text(curr_page*1 + 1);
    }
})

$(() => {
    render_products(LOWER_BOUND, UPPER_BOUND);
});


/** IMG URLs management in create/edit product */
$(".img_url").on('input', $.debounce(250, event => {
    const curr_url = $(event.target).val()
    const curr_img = event.target.id.split("_").slice(-1)[0];
    if (curr_url !== "") {
        $("#img-preview").removeClass("d-none")
        $(`#img-url-${curr_img}`).removeClass("d-none").attr("src", curr_url)
    } else {
        $(`#img-url-${curr_img}`).addClass("d-none").attr("src", "")
        const other_img = (curr_img === "1")? "2":"1";
        if ($(`#img-url-${other_img}`).attr("src") === "") {
            $("#img-preview").addClass("d-none")
        }
    }
}))

const urls = [$("#img_url_1"), $("#img_url_2")]
urls.forEach((url, index) => {
    if (url.val() !== "") {
        $("#img-preview").removeClass("d-none")
        $(`#img-url-${index + 1}`).removeClass("d-none").attr("src", url.val())
    }
})