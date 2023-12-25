/** CART page RENDER */
// $(document).ready()
$().ready(() => {
    render_cart();
    $(".lds-ring-container").addClass("d-none");
    $("#cart-list").removeClass("d-none");
    $("#second-body").removeClass("d-none");
})

/** Remove item from cart (LocalStorage) */
const remove_on_click = () => {
    $(".remove").click(event => {
        event.preventDefault();
        // Find ID to remove through the index of the "remove button" (e.g. "remove-7" refers to the item with ID 7)
        const id_to_remove = event.target.id.split("-")[1]
        // Find product by ID the product to remove from current cart
        // splice(start, deleteCount)
        curr_cart.splice(curr_cart.findIndex(i => {
            return i.id === id_to_remove
        }), 1);

        // Set new current cart in LocalStorage and render changes
        localStorage.setItem("cart", JSON.stringify(curr_cart))
        $("#cart-notification-dot").text(curr_cart.length)
        render_cart();
        console.log(JSON.parse(localStorage.getItem("cart")))
    })
}

const render_cart = () => {
    // Delete all child nodes
    $("#cart-list").empty();
    let total_price = 0
    if (curr_cart && curr_cart.length) {
        curr_cart.forEach(item => {
            total_price += (item.price * 1);
            $("#cart-list").prepend(
                $(`<div id='element-${item.id}' class='row d-flex justify-content-center gap-4 item'>` +
                        html_img(item.id, item.img_url) +
                        html_description(item.id, item.title, item.team_name, item.price) +
                        html_price(item.price) +
                        "<hr class='d-md-none rounded my-thick-grey'>" +
                    "</div>")
            )
        })
        // Add event listener on "click" to each .remove button
        remove_on_click();
        $("#total-price").text(str2int_dec(total_price) + " €");
        const curr_cart_length = curr_cart.length;
        $("#count-items").text(curr_cart_length + ` product${curr_cart_length > 1? "s":""}`)

    } else {
        $("#cart-empty-alert").removeClass("d-none");
    }
}

const html_img = (id, img_url) => {
    return `<div class="col-12 col-md-4 col-lg-3 text-center text-md-end">
                <a href="/f1_project/views/public/store/product.php?id=${id}" target="_blank" class="text-decoration-none">
                    <img height="200px" class="product-img" src="${img_url}" alt="">
                </a>
            </div>`
}

const html_description = (id, desc, team, price) => {
    return `<div class="col-12 col-md-4 text-center text-md-start">
                <a href="/f1_project/views/public/store/product.php?id=${id}" target="_blank" class="link-product w-100 text-decoration-none text-light d-flex flex-column justify-content-between align-items-start">
                    <span class="mx-auto mx-md-0 w-100">
                        ${desc}
                        <hr class="rounded my-thin-grey">
                        ${team}
                    </span>
                    <br>
                    <div class="w-100 d-flex justify-content-around justify-content-md-end align-items-center">
                        <button id="remove-${id}" class="remove bg-transparent border-0 p-0 text-info d-flex gap-2 mt-3">
                            <span class="material-symbols-outlined">delete</span>
                            Remove
                        </button>
                        <strong class="mt-3 d-md-none">${str2int_dec(price)} €</strong>        
                    </div>
                </a>
            </div>`
}

const html_price = price => {
    return `<div class="d-none d-md-block col-12 col-md-2 text-start ms-auto">
                    <strong>${str2int_dec(price)} €</strong>
                </div>`
}

const str2int_dec = str => {
    const int = Math.floor(str / 100);
    // Decimal part obtained with module operator
    // If it is less than 10, I need to add "0" character in order to obtain "05", and not "5" to indicate 5 cents ("5" should represent 50 cents)
    // otherwise, the value returned by the module operator is already good
    // e.g. price = 7505
    //          int = "75"
    //          dec = "05"
    // output wanted = "75.05"
    const dec = (str%100 < 10)? ("0" + str % 100) : str % 100
    return `${int}.${dec}`;
}
