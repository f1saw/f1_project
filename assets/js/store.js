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
