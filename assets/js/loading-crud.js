/** LOADING effect */
$(() => {
    $(".lds-ring-container").addClass("d-none");
})

$("#form-loading").on('submit', () => {
    $(".lds-ring-container").removeClass("d-none")
})

$("#delete-loading").on('click', () => {
    $(".lds-ring-container").removeClass("d-none");
})