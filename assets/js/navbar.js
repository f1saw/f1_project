/** NUMBER ITEMS in cart DOT */
const items_cart = cart => {
    let cnt = 0;
    cart.forEach(item => {
        cnt += item.quantity;
    })
    return cnt;
}

const cart_notification_dot = $("#cart-notification-dot");
const user_id = $("#user-id").text()
const curr_cart = JSON.parse(localStorage.getItem(`cart-${user_id}`))
const text = (curr_cart && curr_cart.length)? items_cart(curr_cart):""
cart_notification_dot.text(text)

$(() => {
    window.addEventListener('storage', function() {
        const curr_cart = JSON.parse(localStorage.getItem(`cart-${user_id}`))
        const text = (curr_cart && curr_cart.length)? items_cart(curr_cart):""
        if (text !== "0") {
            cart_notification_dot.text(text)
        }
    })
})

const onConfirm = (event, size_param = null) => {
    let curr_cart = JSON.parse(localStorage.getItem(`cart-${user_id}`))
    if (!curr_cart) curr_cart = []

    const size = size_param?? $("#s-size").val();
    if (size !== "") {
        let pushed = 0;
        const index = curr_cart.findIndex(item => {
            return item.id === event.target.dataset.id && item.size === size;
        })

        if (index !== -1) {
            curr_cart[index].quantity++;
        } else {
            // Prevent from pushing undefined items in the cart
            if (event.target.dataset.title !== undefined) {
                pushed = 1;
                curr_cart.push({
                    "id": event.target.dataset.id,
                    "title": event.target.dataset.title,
                    "description": event.target.dataset.description,
                    "size": size,
                    "price": event.target.dataset.price,
                    "img_url": event.target.dataset.img,
                    "team_id": event.target.dataset.team_id,
                    "team_name": event.target.dataset.team_name,
                    "quantity": 1
                })
            }
        }

        console.log(curr_cart)
        localStorage.setItem(`cart-${user_id}`, JSON.stringify(curr_cart))

        cart_notification_dot.text(items_cart(curr_cart));

        if (size_param === null) {
            if (pushed) {
                // The previous page was the product page (the size has not been passed as a function parameter)
                $("#select-info span:first-child").text("check").addClass("text-success").removeClass("text-danger");
                $("#select-info span:nth-child(2)").text("Added successfully!").addClass("text-success").removeClass("text-danger");
                $("#select-info").removeClass("d-none");
                $(".btn-add-cart :last-child").text("Added!");

                setTimeout(() => {
                    $(".btn-add-cart :last-child").text("Add to cart!");
                }, 2000)
            }
        } else {
            if (pushed) {
                // The previous page was the store page (the size has been passed as a function parameter)
                $(`#span-add-it-${event.target.dataset.id} button`).addClass("btn-success").removeClass("btn-danger");
                $(`#span-add-it-${event.target.dataset.id} button :last-child`).text("Added");

                setTimeout(() => {
                    $(`#span-add-it-${event.target.dataset.id} button`).addClass("btn-danger").removeClass("btn-success");
                    $(`#span-add-it-${event.target.dataset.id} button :last-child`).text("Add it!");
                }, 2000)
            }
        }
    } else {
        if (size_param === null) {
            // The previous page was the product page (the size has not been passed as a function parameter)
            $("#select-info span:first-child").text("warning").addClass("text-danger").removeClass("text-success");
            $("#select-info span:nth-child(2)").text("Please select a correct size!").addClass("text-danger").removeClass("text-success");
            $("#select-info").removeClass("d-none");
        } else {
            // The previous page was the store page (the size has been passed as a function parameter)
            $(`#span-add-it-${event.target.dataset.id} button :last-child`).html("Select <strong>SIZE</strong>!");

            setTimeout(() => {
                $(`#span-add-it-${event.target.dataset.id} button :last-child`).text("Add it!");
            }, 2500)
        }
    }
}

/** Click event to handle the adding of a product to the cart.
 * If every input data is correct, the product will be pushed into the cart
 * */
$(".btn-add-cart").click(async event => {
    // Prevent form submitting
    event.preventDefault();

    // If the button which has been clicked has "btn-modal" class,
    //  it means that it has generated a modal where the user has to select the size of the product.
    // Otherwise, the size has already been selected in the product page.
    if ($(event.target).hasClass("btn-modal")) {

        const id_item = event.target.dataset.id;
        // Promise constant in order to wait the user to click "confirm" or "close" on the modal
        const promise = new Promise((resolve, reject) => {
            $(`#confirm-modal-${id_item}`).on('click', resolve);
            $(`#close-modal-${id_item}`).on('click', reject);
        })

        // Waiting user action
        await promise
            .then(() => onConfirm(event, $(`#s-size-${id_item}`).val())) // Get the selected size from the modal and pass it in the parameters list
            .catch(() => {})
    } else {
        // The size was already selected through the product page,
        //  so it is not necessary to pass it in the parameters list
        onConfirm(event);
    }
})