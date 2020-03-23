window.onresize = function() {
    var mydiv = document.querySelector("#mydiv");
    mydiv.style.minHeight = window.screen.height + "px";
};

window.onload = function() {
    var mydiv = document.querySelector("#mydiv");
    mydiv.style.minHeight = window.screen.height + "px";
};

function openNav() {
    document.getElementById("mySidenav").style.width =
        document.getElementById("innerSidenav").clientWidth + "px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

function deleteCustomer(id) {
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: "/delete-customer",
        type: "POST",
        data: { id },
        success: function(response) {
            if (response == "Success") {
                $("#customer_" + id).remove();
            }
        }
    });
}

function deleteVehicle(id) {
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: "/delete-vehicle",
        type: "POST",
        data: { id },
        success: function(response) {
            if (response == "Success") {
                $("#vehicle_" + id).remove();
            }
        }
    });
}

$("#profile_form").submit(function() {
    if (1) {
        //
    }
    return false;
});

$(".calendar-day").click(function() {
    $(".calendar-day").removeClass("calendar-day-selected");
    $("#datetimepicker1").removeClass("dateInput-selected");
    $(this).addClass("calendar-day-selected");
    $("#form-data-date").val($(this).text());
});

$(".ride-button").click(function() {
    $(".ride-button").removeClass("ride-selected");
    $(this).addClass("ride-selected");
    $("#form-data-ride").val($(this).val());
});

function GetCustomerIndexFormId(id) {
    for (var i = 0; i < CustomerData.length; i++) {
        if (CustomerData[i].id == id) return i;
    }
    return 0;
}

$(".src-address").click(function() {
    $(".src-address").removeClass("src-address-selected");
    $(this).addClass("src-address-selected");
    var text = $(this).val();
    var customerId = GetCustomerIndexFormId(
        $("#form-data-customer-name").val()
    );
    if (text == "Home" && customerId != "") {
        $("#src-address").val(CustomerData[customerId].home_address);
        $("#form-data-src-address").val(CustomerData[customerId].home_address);
    } else if (text == "Office" && customerId != "") {
        $("#src-address").val(CustomerData[customerId].office_address);
        $("#form-data-src-address").val(
            CustomerData[customerId].office_address
        );
    } else if (text == "DFW") {
        $("#src-address").val("DFW International Airport (DFW)");
        $("#form-data-src-address").val("DFW International Airport (DFW)");
    } else if (text == "DAL") {
        $("#src-address").val("Dallas Love Field Airport (DAL)");
        $("#form-data-src-address").val("Dallas Love Field Airport (DAL)");
    }
    $("#form-data-src-address-t").val($(this).val());
});

$(".dst-address").click(function() {
    $(".dst-address").removeClass("dst-address-selected");
    $(this).addClass("dst-address-selected");
    var text = $(this).val();
    var customerId = GetCustomerIndexFormId(
        $("#form-data-customer-name").val()
    );
    if (text == "Home" && customerId != "") {
        $("#dst-address").val(CustomerData[customerId].home_address);
        $("#form-data-dst-address").val(CustomerData[customerId].home_address);
    } else if (text == "Office" && customerId != "") {
        $("#dst-address").val(CustomerData[customerId].office_address);
        $("#form-data-dst-address").val(
            CustomerData[customerId].office_address
        );
    } else if (text == "DFW") {
        $("#dst-address").val("DFW International Airport (DFW)");
        $("#form-data-dst-address").val("DFW International Airport (DFW)");
    } else if (text == "DAL") {
        $("#dst-address").val("Dallas Love Field Airport (DAL)");
        $("#form-data-dst-address").val("Dallas Love Field Airport (DAL)");
    }
    $("#form-data-dst-address-t").val($(this).val());
});

$(".vehicle-cell").click(function() {
    $(".vehicle-cell").removeClass("vehicle-selected");
    $(this).addClass("vehicle-selected");
    $("#form-data-vehicle").val($(this).attr("idinfo"));
});

$(".time-cell").click(function() {
    $(".time-cell").removeClass("time-cell-selected");
    $(this).addClass("time-cell-selected");
    $("#form-data-hour").val($(this).text());
});

$(".timetype-cell").click(function() {
    $(".timetype-cell").removeClass("timetype-selected");
    $(this).addClass("timetype-selected");
    $("#form-data-time-t").val($(this).text());
});

$(".minute-cell").click(function() {
    $(".minute-cell").removeClass("minute-selected");
    $(this).addClass("minute-selected");
    $("#form-data-minute").val($(this).text());
});

function DurationPlus() {
    var val = $("#duration").val();
    val++;
    if (val > 999) val = 999;
    $("#duration").val(val);
    $("#form-data-duration").val(val);
}

function DurationMinus() {
    var val = $("#duration").val();
    val--;
    if (val < 0) val = 0;
    $("#duration").val(val);
    $("#form-data-duration").val(val);
}

function PassengerMinus() {
    var val = $("#passenger").val();
    val--;
    if (val < 1) val = 1;
    $("#passenger").val(val);
    $("#form-data-passenger-count").val(val);
}

function PassengerPlus() {
    var val = $("#passenger").val();
    val++;
    if (val > 999) val = 999;
    $("#passenger").val(val);
    $("#form-data-passenger-count").val(val);
}

function DateChanged() {
    $(".calendar-day").removeClass("calendar-day-selected");
    $("#datetimepicker1").addClass("dateInput-selected");
    $("#form-data-date").val($("#other_date").val());
}

function SourceAddressChanged(obj) {
    $("#form-data-src-address").val($(obj).val());
}

function DestAddressChanged(obj) {
    $("#form-data-dst-address").val($(obj).val());
}

function DurationChanged(obj) {
    $("#form-data-duration").val($(obj).val());
}

function PassengerChanged(obj) {
    $("#form-data-passenger-count").val($(obj).val());
}

function PassengerNameChanged(obj) {
    $("#form-data-passenger-name").val($(obj).val());
}

function PassengerPhoneChanged(obj) {
    $("#form-data-passenger-phone").val($(obj).val());
}

function backToBooking() {
    window.location.href = "/home";
}

function CustomerSelected(id, name, home, office) {
    $("#customer").val(name);
    $("#form-data-customer-name").val(id);
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
}

$("#bookingForm").submit(function() {
    var ele = $("#bookingForm :input[required]");
    for (var i = 0; i < ele.length; i++) {
        if (ele[i].value == "") {
            $("#VariationAlert").css("display", "block");
            setTimeout(function() {
                $("#VariationAlert").fadeOut("slow", function() {});
            }, 2000);
            return false;
        }
    }
    return true;
});