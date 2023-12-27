/** NUMBER ITEMS in cart DOT */
const items_cart = cart => {
    let cnt = 0;
    cart.forEach(item => {
        cnt += item.quantity;
    })
    return cnt;
}

const curr_cart = JSON.parse(localStorage.getItem("cart"))
const text = (curr_cart && curr_cart.length)? items_cart(curr_cart):""
$("#cart-notification-dot").text(text)

$(() => {
    window.addEventListener('storage', function() {
        const curr_cart = JSON.parse(localStorage.getItem("cart"))
        const text = (curr_cart && curr_cart.length)? items_cart(curr_cart):""
        $("#cart-notification-dot").text(text)
    })
})

$(".btn-add-cart").click(event => {
    event.preventDefault();
    let curr_cart = JSON.parse(localStorage.getItem("cart"))
    if (!curr_cart) curr_cart = []

    // TODO: caso sulla pagina store
    const size = $("#s-size").val();
    if (size !== "ns") {
        $("#select-info span:first-child").text("check").addClass("text-success").removeClass("text-danger");
        $("#select-info span:nth-child(2)").text("Added successfully!").addClass("text-success").removeClass("text-danger");
        $("#select-info").removeClass("d-none");
        const index = curr_cart.findIndex(item => {
            return item.id === event.target.dataset.id && item.size === size;
        })

        if (index !== -1) {
            curr_cart[index].quantity++;
        } else {
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

        console.log(curr_cart)
        localStorage.setItem("cart", JSON.stringify(curr_cart))

        $("#cart-notification-dot").text(items_cart(curr_cart));
    } else {
        $("#select-info span:first-child").text("warning").addClass("text-danger").removeClass("text-success");
        $("#select-info span:nth-child(2)").text("Please select a correct size!").addClass("text-danger").removeClass("text-success");
        $("#select-info").removeClass("d-none");
    }
})