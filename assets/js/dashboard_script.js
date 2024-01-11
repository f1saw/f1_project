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
        })
    });
function goToProfile(){
    window.location.href = "../../views/private/users/show_profile.php"
}
function goToOrders(){
    window.location.href = "/f1_project/views/private/orders/all.php"
}

 function goToTable(){
     window.location.href = "/f1_project/views/private/users/all.php"
 }

 function goToStoreManagement() {
    window.location.href = "/f1_project/views/private/store/all.php"
 }