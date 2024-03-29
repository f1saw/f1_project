$(() => {
    // Temporary variables used to store image urls in form,
    // so you don't lose them when switching from "images from urls" and "images from local storage"
    let img1_temp = "";
    let img2_temp = "";
    // On "change" event of the choose file methodology toggle
    $("#choose-file-upload").on('change', event => {
        const image_local = $("#image-local-div");
        const image_url = $("#image-url-div");
        const img_url_1 = $("#img_url_1");
        const img_url_2 = $("#img_url_2");
        if (event.target.checked) {
            // Images upload from local storage
            image_local.removeClass("d-none");
            image_url.addClass("d-none");
            img1_temp = img_url_1.val()
            img2_temp = img_url_2.val()
            img_url_1.val("");
            img_url_2.val("")
        } else {
            // Images upload from urls
            img_url_1.val(img1_temp);
            img_url_2.val(img2_temp);
            image_local.addClass("d-none");
            image_url.removeClass("d-none");
            $("#images-local").val("");
        }
    })
})