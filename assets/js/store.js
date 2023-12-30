/** Render products management in pages in store.php */
const LOWER_BOUND = 0;
const UPPER_BOUND = 10;
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
    $(".lds-ring-container").addClass("d-none")
});