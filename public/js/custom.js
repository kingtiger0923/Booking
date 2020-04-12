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
    //ConfirmDialog_DeleteCustomer("Are you sure?", "Customer Delete", id);
    if (confirm("Are you sure to delete the Customer?")) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/delete-customer",
            type: "POST",
            data: { id },
            success: function(response) {
                if (response == "Success") {
                    $("#customer_" + id).remove();
                }
            },
        });
    }
}

function deleteVehicle(id) {
    if (confirm("Are you sure to delete the Vehicle?")) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/delete-vehicle",
            type: "POST",
            data: { id },
            success: function(response) {
                if (response == "Success") {
                    $("#vehicle_" + id).remove();
                }
            },
        });
    }
}

$(".calendar-day").click(function() {
    $(".calendar-day").removeClass("calendar-day-selected");
    $("#datetimepicker1").removeClass("dateInput-selected");
    $(this).addClass("calendar-day-selected");
    $("#form-data-date").val($(this).text());
});

$("#Setting_save").on("click", function() {
    var smtphost = $("#smtp_host").val();
    var email_addr = $("#email_addr").val();
    var smtp_user = $("#smtp_user").val();
    var smtp_pass = $("#smtp_pass").val();

    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: "/save_setting",
        type: "POST",
        data: { smtphost, email_addr, smtp_user, smtp_pass },
        success: function(response) {
            $("#setting-alert").fadeIn("slow");
            setTimeout(function() {
                $("#setting-alert").fadeOut("slow");
            }, 2000);
        },
    });
});

$(".ride-button").click(function() {
    $(".ride-button").removeClass("ride-selected");
    $(this).addClass("ride-selected");
    if ($(this).val() == "Hourly") {
        $(".duration_box").fadeIn("slow");
    } else {
        $(".duration_box").fadeOut("slow");
    }
    $("#form-data-ride").val($(this).val());
});

function GetCustomerIndexFormId(id) {
    for (var i = 0; i < CustomerData.length; i++) {
        if (CustomerData[i].id == id) return i;
    }
    return -1;
}

$(".src-address").click(function() {
    $(".src-address").removeClass("src-address-selected");
    $(this).addClass("src-address-selected");
    var text = $(this).val();
    var customerId = GetCustomerIndexFormId(
        $("#form-data-customer-name").val()
    );
    if (text == "Home" && customerId != -1) {
        $("#src-address").val(CustomerData[customerId].home_address);
        $("#form-data-src-address").val(CustomerData[customerId].home_address);
    } else if (text == "Office" && customerId != -1) {
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

    if (text == "Home" && customerId != -1) {
        $("#dst-address").val(CustomerData[customerId].home_address);
        $("#form-data-dst-address").val(CustomerData[customerId].home_address);
    } else if (text == "Office" && customerId != -1) {
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
    $("#form-data-dst-address-t").val(text);
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

$("input[name='price_t']").on("change", function() {
    //alert($(this).val());
    if ($(this).val() == "Manu") {
        $("#ManualPrice_Input").show();
    } else {
        $("#ManualPrice_Input").hide();
    }
});

function SourceAddressChanged(obj) {
    setTimeout(function() {
        $("#form-data-src-address").val($(obj).val());
    }, 500);
}

function DestAddressChanged(obj) {
    setTimeout(function() {
        $("#form-data-dst-address").val($(obj).val());
    }, 500);
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
    var txt = $(obj).val();
    var formated;
    if (txt.length == 10) formated = formatPhoneNumber(txt);
    else formated = txt;
    $(obj).val(formated);
    $("#form-data-passenger-phone").val(formated);
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

function SearchForVehicles(obj) {
    var filter = $(obj).val();
    filter = filter.toUpperCase();

    var filter, i, txtValue, list;
    list = document.getElementsByClassName("vehicle_block");
    for (i = 0; i < list.length; i++) {
        txtValue = list[i].getAttribute("vehicle_info");
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            list[i].style.display = "block";
        } else {
            list[i].style.display = "none";
        }
    }
}

$("#profile_form").submit(function() {
    var Pass1, Pass2;
    Pass1 = document.getElementById("change_password").value;
    Pass2 = document.getElementById("confirm_password").value;
    console.log(Pass1, Pass2, Pass1 == Pass2);
    if (Pass1 == Pass2) return true;
    return false;
});

function PhoneNumberInput(obj) {
    var txt = $(obj).val();
    var formated;
    if (txt.length == 10) formated = formatPhoneNumber(txt);
    else formated = txt;
    $(obj).val(formated);
}

function formatPhoneNumber(phoneNumberString) {
    var cleaned = ("" + phoneNumberString).replace(/\D/g, "");
    var match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
    if (match) {
        return "+1(" + match[1] + ") " + match[2] + "-" + match[3];
    }
    return null;
}

function SearchForCustomers(obj) {
    var filter = $(obj).val();
    filter = filter.toUpperCase();
    console.log("=filter=" + filter);

    var filter, i, txtValue, list;
    list = document.getElementsByClassName("customer_block");
    for (i = 0; i < list.length; i++) {
        txtValue = list[i].getAttribute("cus_name");
        console.log(txtValue);
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            list[i].style.display = "block";
        } else {
            list[i].style.display = "none";
        }
    }
}

function CustomerNameChanged(obj) {
    for (var i = 0; i < CustomerData.length; i++) {
        var name = CustomerData[i].firstname + " " + CustomerData[i].lastname;
        if (obj.value == name) {
            $("#form-data-customer-name").val(CustomerData[i].id);
        }
    }
}

function autocompleteCustomer(inp, arr) {
    /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
    var currentFocus;
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", OnAutoCompleteInput);
    inp.addEventListener("focus", OnAutoCompleteInput);

    function OnAutoCompleteInput(e) {
        var a,
            b,
            i,
            val = this.value;
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        // if (!val) {
        //     return false;
        // }
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
        for (i = 0; i < arr.length; i++) {
            /*check if the item starts with the same letters as the text field value:*/
            if (
                arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()
            ) {
                /*create a DIV element for each matching element:*/
                b = document.createElement("DIV");
                /*make the matching letters bold:*/
                b.innerHTML =
                    "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                b.innerHTML += arr[i].substr(val.length);
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function(e) {
                    /*insert the value for the autocomplete text field:*/
                    inp.value = this.getElementsByTagName("input")[0].value;
                    /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
                    closeAllLists();
                    /* ------------------------------ */
                    CustomerNameChanged(inp);
                });
                a.appendChild(b);
            }
        }
    }
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 38) {
            //up
            /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if (currentFocus > -1) {
                /*and simulate a click on the "active" item:*/
                if (x) x[currentFocus].click();
            }
        }
    });

    function addActive(x) {
        /*a function to classify an item as "active":*/
        if (!x) return false;
        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = x.length - 1;
        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");
    }

    function removeActive(x) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    }

    function closeAllLists(elmnt) {
        /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }
    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function(e) {
        closeAllLists(e.target);
    });
}

$(document).ready(function() {
    var timezone = moment.tz.guess();
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: "/setTimezone",
        type: "POST",
        data: { timezone },
        success: function(response) {},
    });
    setTimeout(function() {
        if (
            typeof CustomerNameArr === "undefined" ||
            CustomerNameArr === null
        ) {} else {
            autocompleteCustomer(
                document.getElementById("customer"),
                CustomerNameArr
            );
        }
    }, 1000);
});