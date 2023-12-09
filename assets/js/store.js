const curr_cart = JSON.parse(localStorage.getItem("cart"))
if (curr_cart)
    $("#cart-notification-dot").text(curr_cart.length)

$(".btn-add-cart").click(event => {
    event.preventDefault();
    let curr_cart = JSON.parse(localStorage.getItem("cart"))
    if (!curr_cart) curr_cart = []
    curr_cart.push({
        "id": event.target.dataset.id,
        "title": event.target.dataset.title,
        "price": event.target.dataset.price,
        "img_url": event.target.dataset.img
    })
    console.log(curr_cart)
    localStorage.setItem("cart", JSON.stringify(curr_cart))

    $("#cart-notification-dot").text(curr_cart.length)
})

$("#img_url").on('input', $.debounce(250, () => {
    const curr_url = $("#img_url").val()
    if (curr_url !== "") {
        $("#img-preview").removeClass("d-none")
        $("#img-act").removeClass("d-none").attr("src", curr_url)
    } else {
        $("#img-preview").addClass("d-none")
        $("#img-act").addClass("d-none")
    }
}))
