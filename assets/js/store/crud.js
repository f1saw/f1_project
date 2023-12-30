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