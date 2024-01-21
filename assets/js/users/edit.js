$(() => {
    $(".lds-ring-container").addClass("d-none");
})

$("#profile-data").on('submit', () => {
    $(".lds-ring-container").removeClass("d-none");
})

$("#goToNextPage").on('click', () => {
    $("#page1").addClass("d-none");
    $("#page2").removeClass("d-none");
})

$("#goToLastPage").on('click', () => {
    $("#page2").addClass("d-none");
    $("#page1").removeClass("d-none");
})
