/** NUMBER ITEMS in cart DOT */
const curr_cart = JSON.parse(localStorage.getItem("cart"))
if (curr_cart && curr_cart.length)
    $("#cart-notification-dot").text(curr_cart.length)

$(".btn-add-cart").click(event => {
    event.preventDefault();
    let curr_cart = JSON.parse(localStorage.getItem("cart"))
    if (!curr_cart) curr_cart = []
    curr_cart.push({
        "id": event.target.dataset.id,
        "title": event.target.dataset.title,
        "description": event.target.dataset.description,
        "price": event.target.dataset.price,
        "img_url": event.target.dataset.img,
        "team_id": event.target.dataset.team_id,
        "team_name": event.target.dataset.team_name
    })
    console.log(curr_cart)
    localStorage.setItem("cart", JSON.stringify(curr_cart))

    $("#cart-notification-dot").text(curr_cart.length)
})