let id = ['teams', 'circuits', 'drivers', 'statistics'];
for (let i=0; i<id.length; ++i){
    next_page(id[i]);
}


function next_page(id){
    $(`#${id}`).on("click", () => {
        switch (id){
            case('teams') : window.location.href = "/f1_project/views/public/teams.php"; break;
            case('circuits') : window.location.href = "/f1_project/views/public/circuits.php"; break
            case('drivers') : window.location.href = "/f1_project/views/public/drivers.php"; break;
            case('statistics') : window.location.href = "/f1_project/views/public/statistics.php"; break;
        }
    })
}