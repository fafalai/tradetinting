function hideJobdetailsColumn() {
    $("#ul_dropdownlist a").on('click', function (event) {
        var $target = $(event.currentTarget),
            val = $target.attr('data-value'),
            $input = $target.find('input');
        if (val === "0") {
            $("#ul_dropdownlist input").prop("checked", true);
            $target.attr("data-value", "-1");
            $("#Table_jobdetails tr td").css("display", "none");
            $("#Table_jobdetails th").css("display", "none");
        } else if (val === "-1") {
            $("#ul_dropdownlist input").prop("checked", false);
            $target.attr("data-value", "0");
            $("#Table_jobdetails tr td").css("display", "");
            $("#Table_jobdetails th").css("display", "");
        } else {
            if ($input.prop("checked")) {
                setTimeout(function () {
                    $input.prop('checked', false);
                    $("#Table_jobdetails tr td:nth-child(" + val + ")").css("display", "");
                    $("#Table_jobdetails th:nth-child(" + val + ")").css("display", "");
                }, 0);
            } else {
                setTimeout(function () {
                    $input.prop('checked', true);
                    $("#Table_jobdetails tr td:nth-child(" + val + ")").css("display", "none");
                    $("#Table_jobdetails th:nth-child(" + val + ")").css("display", "none");
                }, 0);
            }
        }
        //        $(event.target).blur();
        //        console.log(options);
        return false;
    });
}

$(document).ready(function () {
    hideJobdetailsColumn();
});