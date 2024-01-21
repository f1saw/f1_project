 $(".flex-slide").each(function () {
    $(this).hover(function () {
        $(this).find('.flex-title').css({
            transform: 'rotate(0deg)',
            top: '10%'
        });
        $(this).find('.flex-about').css({
            opacity: '1'
        });
    }, function () {
        $(this).find('.flex-title').css({
            transform: 'rotate(90deg)',
            top: '15%'
        });
        $(this).find('.flex-about').css({
            opacity: '0'
        });
        $(this).find('.flex-title-product').css({
            top: '19%'
        })
 });

let id = ['goProfile', 'goOrders', 'goTable', 'GoStoreMan'];
for (let i=0; i<id.length; ++i){
    goToPage(id[i]);
}

function goToPage(id){
    $(`#${id}`).on("click", () => {
        switch (id){
            case('goProfile') : window.location.href = "../../show_profile.php"; break;
            case('goOrders') : window.location.href = "/f1_project/views/private/orders/all.php"; break
            case('goTable') : window.location.href = "/f1_project/views/private/users/all.php"; break;
            case('GoStoreMan') : window.location.href = "/f1_project/views/private/store/all.php"; break;
        }
    })
}


