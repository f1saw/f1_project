$(() => {
    $(".lds-ring-container").addClass("d-none");
})

$("#profile-data").on('submit', () => {
    $(".lds-ring-container").removeClass("d-none");
})

function last_page(){
    document.getElementById("page1").style.removeProperty('display');
    document.getElementById("page2").style.display = "none";
}

function next_page(){
    document.getElementById("page1").style.display = "none";
    document.getElementById("page2").style.removeProperty('display');
}