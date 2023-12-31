$(() => {
    $(".lds-ring-container").addClass("d-none");
})

$("#profile-data").on('submit', () => {
    $(".lds-ring-container").removeClass("d-none");
})