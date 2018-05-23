function redirect(address) {
    location.href = address;
}

function changeMenuColor() {
    var path = window.location.pathname;
    var link = $("#DIV_topMenu a");

    switch (path.substr(1, path.length - 5)) {
        case "jobs":
            link.eq(1).addClass("current_page_item");
            break;
        case "jobdetails":
            link.eq(1).addClass("current_page_item");
            break;
        case "index":
            link.eq(0).addClass("current_page_item");
            break;
        case "clients":
            link.eq(2).addClass("current_page_item");
            break;
        case "resource":
            link.eq(3).addClass("current_page_item");
            break;
        case "contact":
            link.eq(4).addClass("current_page_item");
            break;
        default:
            link.eq(5).addClass("current_page_item");
            break;
    }
}

$(document).ready(function () {
    changeMenuColor();
});
