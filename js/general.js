function redirect(address) {
    location.href = address;
}

function changeMenuColor() {
    var path = window.location.pathname;
    var link = $("#DIV_topMenu a");
    var pageName = path.split("/");
    switch (pageName[pageName.length - 1]) {
        case "":
            link.eq(0).addClass("current_page_item");
            break;
        case "jobs.php":
            link.eq(1).addClass("current_page_item");
            break;
        case "jobdetails.php":
            link.eq(1).addClass("current_page_item");
            break;
        case "index.php":
            link.eq(0).addClass("current_page_item");
            break;
        case "clients.php":
            link.eq(2).addClass("current_page_item");
            break;
        case "resource.php":
            link.eq(3).addClass("current_page_item");
            break;
        case "contact.php":
            link.eq(4).addClass("current_page_item");
            break;
        default:
            link.eq(5).addClass("current_page_item");
            break;
    }
}

var currencySympol = {
    '0': '',
    'AED': '&#1583;.&#1573;', // ?
    'AFN': '&#65;&#102;',
    'ALL': '&#76;&#101;&#107;',
    'AMD': '',
    'ANG': '&#402;',
    'AOA': '&#75;&#122;', // ?
    'ARS': '&#36;',
    'AUD': '&#36;',
    'AWG': '&#402;',
    'AZN': '&#1084;&#1072;&#1085;',
    'BAM': '&#75;&#77;',
    'BBD': '&#36;',
    'BDT': '&#2547;', // ?
    'BGN': '&#1083;&#1074;',
    'BHD': '.&#1583;.&#1576;', // ?
    'BIF': '&#70;&#66;&#117;', // ?
    'BMD': '&#36;',
    'BND': '&#36;',
    'BOB': '&#36;&#98;',
    'BRL': '&#82;&#36;',
    'BSD': '&#36;',
    'BTN': '&#78;&#117;&#46;', // ?
    'BWP': '&#80;',
    'BYR': '&#112;&#46;',
    'BZD': '&#66;&#90;&#36;',
    'CAD': '&#36;',
    'CDF': '&#70;&#67;',
    //    'CHF': '&#67;&#72;&#70;',
    'CHF': '&#70;&#114;',
    'CLF': '', // ?
    'CLP': '&#36;',
    'CNY': '&#165;',
    'COP': '&#36;',
    'CRC': '&#8353;',
    'CUP': '&#8396;',
    'CVE': '&#36;', // ?
    'CZK': '&#75;&#269;',
    'DJF': '&#70;&#100;&#106;', // ?
    'DKK': '&#107;&#114;',
    'DOP': '&#82;&#68;&#36;',
    'DZD': '&#1583;&#1580;', // ?
    'EGP': '&#163;',
    'ETB': '&#66;&#114;',
    'EUR': '&#8364;',
    'FJD': '&#36;',
    'FKP': '&#163;',
    'GBP': '&#163;',
    'GEL': '&#4314;', // ?
    'GHS': '&#162;',
    'GIP': '&#163;',
    'GMD': '&#68;', // ?
    'GNF': '&#70;&#71;', // ?
    'GTQ': '&#81;',
    'GYD': '&#36;',
    'HKD': '&#36;',
    'HNL': '&#76;',
    'HRK': '&#107;&#110;',
    'HTG': '&#71;', // ?
    'HUF': '&#70;&#116;',
    'IDR': '&#82;&#112;',
    'ILS': '&#8362;',
    'INR': '&#8377;',
    'IQD': '&#1593;.&#1583;', // ?
    'IRR': '&#65020;',
    'ISK': '&#107;&#114;',
    'JEP': '&#163;',
    'JMD': '&#74;&#36;',
    'JOD': '&#74;&#68;', // ?
    'JPY': '&#165;',
    'KES': '&#75;&#83;&#104;', // ?
    'KGS': '&#1083;&#1074;',
    'KHR': '&#6107;',
    'KMF': '&#67;&#70;', // ?
    'KPW': '&#8361;',
    'KRW': '&#8361;',
    'KWD': '&#1583;.&#1603;', // ?
    'KYD': '&#36;',
    'KZT': '&#1083;&#1074;',
    'LAK': '&#8365;',
    'LBP': '&#163;',
    'LKR': '&#8360;',
    'LRD': '&#36;',
    'LSL': '&#76;', // ?
    'LTL': '&#76;&#116;',
    'LVL': '&#76;&#115;',
    'LYD': '&#1604;.&#1583;', // ?
    'MAD': '&#1583;.&#1605;.', //?
    'MDL': '&#76;',
    'MGA': '&#65;&#114;', // ?
    'MKD': '&#1076;&#1077;&#1085;',
    'MMK': '&#75;',
    'MNT': '&#8366;',
    'MOP': '&#77;&#79;&#80;&#36;', // ?
    'MRO': '&#85;&#77;', // ?
    'MUR': '&#8360;', // ?
    'MVR': '.&#1923;', // ?
    'MWK': '&#77;&#75;',
    'MXN': '&#36;',
    'MYR': '&#82;&#77;',
    'MZN': '&#77;&#84;',
    'NAD': '&#36;',
    'NGN': '&#8358;',
    'NIO': '&#67;&#36;',
    'NOK': '&#107;&#114;',
    'NPR': '&#8360;',
    'NZD': '&#36;',
    'OMR': '&#65020;',
    'PAB': '&#66;&#47;&#46;',
    'PEN': '&#83;&#47;&#46;',
    'PGK': '&#75;', // ?
    'PHP': '&#8369;',
    'PKR': '&#8360;',
    'PLN': '&#122;&#322;',
    'PYG': '&#71;&#115;',
    'QAR': '&#65020;',
    'RON': '&#108;&#101;&#105;',
    'RSD': '&#1044;&#1080;&#1085;&#46;',
    'RUB': '&#8381;',
    'RWF': '&#1585;.&#1587;',
    'SAR': '&#65020;',
    'SBD': '&#36;',
    'SCR': '&#8360;',
    'SDG': '&#163;', // ?
    'SEK': '&#107;&#114;',
    'SGD': '&#36;',
    'SHP': '&#163;',
    'SLL': '&#76;&#101;', // ?
    'SOS': '&#83;',
    'SRD': '&#36;',
    'STD': '&#68;&#98;', // ?
    'SVC': '&#36;',
    'SYP': '&#163;',
    'SZL': '&#76;', // ?
    'THB': '&#3647;',
    'TJS': '&#84;&#74;&#83;', // ? TJS (guess)
    'TMT': '&#109;',
    'TND': '&#1583;.&#1578;',
    'TOP': '&#84;&#36;',
    'TRY': '&#8356;', // New Turkey Lira (old symbol used)
    'TTD': '&#36;',
    'TWD': '&#78;&#84;&#36;',
    'TZS': '',
    'UAH': '&#8372;',
    'UGX': '&#85;&#83;&#104;',
    'USD': '&#36;',
    'UYU': '&#36;&#85;',
    'UZS': '&#1083;&#1074;',
    'VEF': '&#66;&#115;',
    'VND': '&#8363;',
    'VUV': '&#86;&#84;',
    'WST': '&#87;&#83;&#36;',
    'XAF': '&#70;&#67;&#70;&#65;',
    'XCD': '&#36;',
    'XDR': '',
    'XOF': '',
    'XPF': '&#70;',
    'YER': '&#65020;',
    'ZAR': '&#82;',
    'ZMK': '&#90;&#75;', // ?
    'ZWL': '&#90;&#36;',
};

//
//var cod = new Array();
//var sym = new Array();
//cod[0] = 'ALL';
//sym[0] = '&#76;&#101;&#107;';
//cod[1] = 'USD';
//sym[1] = '&#36;';
//cod[2] = 'AFN';
//sym[2] = '&#1547;';
//cod[3] = 'ARS ';
//sym[3] = '&#36;';
//cod[4] = 'AWG';
//sym[4] = '&#402;';
//cod[5] = 'AUD';
//sym[5] = '&#36;';
//cod[6] = 'AZN';
//sym[6] = '&#1084;&#1072;&#1085;';
//cod[7] = 'BSD;';
//sym[7] = '&#36;';
//cod[8] = 'BBD';
//sym[8] = '&#36;';
//cod[9] = 'BYR';
//sym[9] = '&#112;&#46;';
//cod[10] = 'BEF';
//sym[10] = '&#8355;';
//cod[11] = 'BZD';
//sym[11] = '&#66;&#90;&#36;';
//cod[12] = 'BMD';
//sym[12] = '&#36;';
//cod[13] = 'BOB';
//sym[13] = '&#36;&#98;';
//cod[14] = 'BAM';
//sym[14] = '&#75;&#77;';
//cod[15] = 'BWP ';
//sym[15] = '&#80;';
//cod[16] = 'BGN';
//sym[16] = '&#1083;&#1074;';
//cod[17] = 'BRL';
//sym[17] = '&#82;&#36;';
//cod[18] = 'BRC';
//sym[18] = '&#8354;';
//cod[19] = 'GBP';
//sym[19] = '&#163;';
//cod[20] = 'BND';
//sym[20] = '&#36;';
//cod[21] = 'KHR';
//sym[21] = '&#6107;';
//cod[22] = 'CAD ';
//sym[22] = '&#36;';
//cod[23] = 'KYD';
//sym[23] = '&#36;';
//cod[24] = 'CLP';
//sym[24] = '&#36;';
//cod[25] = 'CNY';
//sym[25] = '&#20803;';
//cod[26] = 'COP ';
//sym[26] = '&#36;';
//cod[27] = 'CRC ';
//sym[27] = '&#8353;';
//cod[28] = 'HRK';
//sym[28] = '&#107;&#110;';
//cod[29] = 'CUP';
//sym[29] = '&#8369;';
//cod[30] = 'CYP';
//sym[30] = '&#163;';
//cod[31] = 'CZK ';
//sym[31] = '&#75;&#269;';
//cod[32] = 'DKK ';
//sym[32] = '&#107;&#114;';
//cod[33] = 'DOP';
//sym[33] = '&#82;&#68;&#36;';
//cod[34] = 'XCD ';
//sym[34] = '&#36;';
//cod[35] = 'EGP';
//sym[35] = '&#163;';
//cod[36] = 'SVC ';
//sym[36] = '&#36;';
//cod[37] = 'GBP ';
//sym[37] = '&#163;';
//cod[38] = 'EEK';
//sym[38] = '&#107;&#114;';
//cod[39] = 'EUR';
//sym[39] = '&#8364;';
//cod[40] = 'XEU ';
//sym[40] = '&#8352;';
//cod[41] = 'FKP';
//sym[41] = '&#163;';
//cod[42] = 'FJD';
//sym[42] = '&#36;';
//cod[43] = 'FRF';
//sym[43] = '&#8355;';
//cod[44] = 'GHC';
//sym[44] = '&#162;';
//cod[45] = 'GIP ';
//sym[45] = '&#163;';
//cod[46] = 'GRD ';
//sym[46] = '&#8367;';
//cod[47] = 'GTQ';
//sym[47] = '&#81;';
//cod[48] = 'GGP';
//sym[48] = '&#163;';
//cod[49] = 'GYD';
//sym[49] = '&#36;';
//cod[50] = 'NLG ';
//sym[50] = '&#402;';
//cod[51] = 'HNL';
//sym[51] = '&#76;';
//cod[52] = 'HKD';
//sym[52] = '&#72;&#75;&#36;';
//cod[53] = 'HKD ';
//sym[53] = '&#22291;';
//cod[54] = 'HKD ';
//sym[54] = '&#22291;';
//cod[55] = 'HKD ';
//sym[55] = '&#20803;';
//cod[56] = 'HUF';
//sym[56] = '&#70;&#116;';
//cod[57] = 'ISK';
//sym[57] = '&#107;&#114;';
//cod[58] = 'INR ';
//sym[58] = '₹';
//cod[59] = 'IDR ';
//sym[59] = '&#82;&#112;';
//cod[60] = 'IRR';
//sym[60] = '&#65020;';
//cod[61] = 'IEP ';
//sym[61] = '&#163;';
//cod[62] = 'IMP';
//sym[62] = '&#163;';
//cod[63] = 'ILS';
//sym[63] = '&#8362;';
//cod[64] = 'ITL';
//sym[64] = '&#8356;';
//cod[65] = 'JMD';
//sym[65] = '&#74;&#36;';
//cod[66] = 'JPY ';
//sym[66] = '&#165;';
//cod[67] = 'JEP ';
//sym[67] = '&#163;';
//cod[68] = 'KZT ';
//sym[68] = '&#1083;&#1074;';
//cod[69] = 'KPW ';
//sym[69] = '&#8361;';
//cod[70] = 'KRW ';
//sym[70] = '&#8361;';
//cod[71] = 'KGS ';
//sym[71] = '&#1083;&#1074;';
//cod[72] = 'LAK ';
//sym[72] = '&#8365;';
//cod[73] = 'LVL ';
//sym[73] = '&#76;&#115;';
//cod[74] = 'LBP ';
//sym[74] = '&#163;';
//cod[75] = 'LRD ';
//sym[75] = '&#36;';
//cod[76] = 'CHF ';
//sym[76] = '&#67;&#72;&#70;';
//cod[77] = 'LTL ';
//sym[77] = '&#76;&#116;';
//cod[78] = 'LUF ';
//sym[78] = '&#8355;';
//cod[79] = 'MKD ';
//sym[79] = '&#1076;&#1077;&#1085;';
//cod[80] = 'MYR ';
//sym[80] = '&#82;&#77;';
//cod[81] = 'MTL ';
//sym[81] = '&#76;&#109;';
//cod[82] = 'MUR ';
//sym[82] = '&#8360;';
//cod[83] = 'MXN ';
//sym[83] = '&#36;';
//cod[84] = 'MNT ';
//sym[84] = '&#8366;';
//cod[85] = 'MZN ';
//sym[85] = '&#77;&#84;';
//cod[86] = 'NAD ';
//sym[86] = '&#36;';
//cod[87] = 'NPR ';
//sym[87] = '&#8360;';
//cod[88] = 'ANG ';
//sym[88] = '&#402;';
//cod[89] = 'NLG ';
//sym[89] = '&#402;';
//cod[90] = 'NZD ';
//sym[90] = '&#36;';
//cod[91] = 'NIO ';
//sym[91] = '&#67;&#36;';
//cod[92] = 'NGN ';
//sym[92] = '&#8358;';
//cod[93] = 'KPW ';
//sym[93] = '&#8361;';
//cod[94] = 'NOK ';
//sym[94] = '&#107;&#114;';
//cod[95] = 'OMR ';
//sym[95] = '&#65020;';
//cod[96] = 'PKR ';
//sym[96] = '&#8360;';
//cod[97] = 'PAB ';
//sym[97] = '&#66;&#47;&#46;';
//cod[98] = 'PYG ';
//sym[98] = '&#71;&#115;';
//cod[99] = 'PEN ';
//sym[99] = '&#83;&#47;&#46;';
//cod[100] = 'PHP ';
//sym[100] = '&#80;&#104;&#112;';
//cod[101] = 'PLN ';
//sym[101] = '&#122;&#322;';
//cod[102] = 'QAR ';
//sym[102] = '&#65020;';
//cod[103] = 'RON ';
//sym[103] = '&#108;&#101;&#105;';
//cod[104] = 'RUB ';
//sym[104] = '&#1088;&#1091;&#1073;';
//cod[105] = 'SHP ';
//sym[105] = '&#163;';
//cod[106] = 'SAR ';
//sym[106] = '&#65020;';
//cod[107] = 'RSD ';
//sym[107] = '&#1044;&#1080;&#1085;&#46;';
//cod[108] = 'SCR ';
//sym[108] = '&#8360;';
//cod[109] = 'SGD ';
//sym[109] = '&#36;';
//cod[110] = 'SKK ';
//sym[110] = '&#83;&#73;&#84;';
//cod[111] = 'EUR ';
//sym[111] = '&#8364;';
//cod[112] = 'SBD ';
//sym[112] = '&#36;';
//cod[113] = 'SOS ';
//sym[113] = '&#83;';
//cod[114] = 'ZAR ';
//sym[114] = '&#82;';
//cod[115] = 'KRW ';
//sym[115] = '&#8361;';
//cod[116] = 'ESP ';
//sym[116] = '&#8359;';
//cod[117] = 'LKR ';
//sym[117] = '&#8360;';
//cod[118] = 'SEK ';
//sym[118] = '&#107;&#114;';
//cod[119] = 'CHF ';
//sym[119] = '&#67;&#72;&#70;';
//cod[120] = 'SRD ';
//sym[120] = '&#36;';
//cod[121] = 'SYP ';
//sym[121] = '&#163;';
//cod[122] = 'TWD ';
//sym[122] = '&#78;&#84;&#36;';
//cod[123] = 'THB';
//sym[123] = '&#3647;';
//cod[124] = 'TTD';
//sym[124] = '&#84;&#84;&#36;';
//cod[125] = 'TRY';
//sym[125] = '&#89;&#84;&#76;';
//cod[126] = 'TRL';
//sym[126] = '&#8356;';
//cod[127] = 'TVD ';
//sym[127] = '&#36;';
//cod[128] = 'UAH ';
//sym[128] = '&#8372;';
//cod[129] = 'GBP ';
//sym[129] = '&#163;';
//cod[130] = 'USD ';
//sym[130] = '&#36;';
//cod[131] = 'UYU ';
//sym[131] = '&#36;&#85;';
//cod[132] = 'UZS ';
//sym[132] = '&#1083;&#1074;';
//cod[133] = 'VAL ';
//sym[133] = '&#8356;';
//cod[134] = 'VEB ';
//sym[134] = '&#66;&#115;';
//cod[135] = 'VND ';
//sym[135] = '&#8363;';
//cod[136] = 'YER ';
//sym[136] = '&#65020;';
//cod[137] = 'ZWD ';
//sym[137] = '&#90;&#3;';


function generalCurrencyOptions() {
    var select = $("#fldcurrency");

    //    for (var i = 0; i < cod.length; i++) {
    //        select.append($("<option>").attr("value", cod[i]).text(cod[i]));
    //    }
    select.append($('<option>').attr('value', 'USD').text('USD'));
    select.append($('<option>').attr('value', 'EUR').text('EUR'));
    select.append($('<option>').attr('value', 'JPY').text('JPY'));
    select.append($('<option>').attr('value', 'GBP').text('GBP'));
    select.append($('<option>').attr('value', 'AUD').text('AUD'));
    select.append($('<option>').attr('value', 'CAD').text('CAD'));
    select.append($('<option>').attr('value', 'CHF').text('CHF'));
    select.append($('<option>').attr('value', 'CNY').text('CNY'));
    select.append($('<option>').attr('value', 'NZD').text('NZD'));
    select.append($('<option>').attr('value', 'HKD').text('HKD'));
}

function showCurrencySymbol(val) {
    console.log(currencySympol[val.value]);
    var symbol = document.getElementById("span_symbol");
    symbol.innerHTML = currencySympol[val.value];
    //    $("#span_symbol").attr("innerHTML", currencySympol[val.value]);
}

var fldcurrency;

function reloadCurrency() {

    if (!empty(fldcurrency)) {
        console.log(fldcurrency);
        $("#fldcurrency").val(fldcurrency);
        var symbol = document.getElementById("span_symbol");
        symbol.innerHTML = currencySympol[fldcurrency];
    }
}

function empty(val) {
    if (val === undefined)
        return true;

    if (typeof (val) == 'function' || typeof (val) == 'number' || typeof (val) == 'boolean' || Object.prototype.toString.call(val) === '[object Date]')
        return false;

    if (val == null || val.length === 0) // null or 0 length array
        return true;

    if (typeof (val) == "object") {
        // empty object

        var r = true;

        for (var f in val)
            r = false;

        return r;
    }

    return false;
}

function hideJobdetailsColumn() {
//    var options = [];
    $("#ul_dropdownlist a").on('click', function (event) {
        var $target = $(event.currentTarget),
            val = $target.attr('data-value'),
            $input = $target.find('input');
//            idx;

        console.log($input.prop("checked"));
        if ($input.prop("checked")) {
//            options.splice(idx, 1);
            setTimeout(function () {
                $input.prop('checked', false);
                $("#Table_jobdetails tr td:nth-child("+val+")").css("display","");
                $("#Table_jobdetails th:nth-child("+val+")").css("display","");
            }, 0);
        } else {
//            options.push(val);
            setTimeout(function () {
                $input.prop('checked', true);
                $("#Table_jobdetails tr td:nth-child("+val+")").css("display","none");
                $("#Table_jobdetails th:nth-child("+val+")").css("display","none");
            }, 0);
        }

        $(event.target).blur();

//        console.log(options);
        return false;
    });
}
$(document).ready(function () {
    changeMenuColor();

    //    generalCurrency();

    generalCurrencyOptions();

    reloadCurrency();

    hideJobdetailsColumn();
});
