
// JQUERY UNTUK MILIH PENGAJAR DENG SELECT
//     < script src = "https://code.jquery.com/jquery-1.12.4.min.js" ></script >
//         <script type="text/javascript">
//             $(document).ready(function(){
//                 $("select.country").change(function () {
//                     var selectedCountry = $(this).children("option:selected").val();
//                     $(".pengajar").val(selectedCountry);
//                     alert("You have selected the country - " + selectedCountry);
//                 });
//             });
//     </script> 

// for filter
function setAflerIdForFilter() {
    $(function () {
        var value = $('#aflerFilter').val()
        var id_pengajar = $('#listaflers option').filter(function () {
            return this.value == value;
        }).data('id_pengajar');
        $(".filterpengajar").val(id_pengajar);
    })
}

// for filter
function setAfleeIdForFilter() {
    $(function () {
        var value = $('#afleeFilter').val()
        var id_siswa = $('#listaflees option').filter(function () {
            return this.value == value;
        }).data('id_siswa');
        $(".filtersiswa").val(id_siswa);
    })
}

// for create schedule
function setAflerId() {
    $(function () {
        var value = $('#afler').val()
        console.debug(value)
        var id_pengajar = $('#aflers option').filter(function () {
            return this.value == value;
        }).data('id_pengajar');
        $(".pengajar").val(id_pengajar);
    })
}

// for create schedule
function setAfleeId() {
    $(function () {
        var value = $('#aflee').val()
        var id_siswa = $('#aflees option').filter(function () {
            return this.value == value;
        }).data('id_siswa');
        $(".siswa").val(id_siswa);
    })
}

// for create schedule
function setGradeId() {
    $(function () {
        var value = $('#grade').val()
        var id_grade = $('#grades option').filter(function () {
            return this.value == value;
        }).data('id_grade');
        $(".grade").val(id_grade);
    })
}

// for create schedule
function setLocationId() {
    $(function () {
        var value = $('#location').val()
        var id_location = $('#locations option').filter(function () {
            return this.value == value;
        }).data('id_location');
        $(".location").val(id_location);
    })
}

// for filter by afler
function changePaymentValueFalseAfler() {
    $(function () {
        $("#payment_status_afler").val(false);
        $("#submit-filter-afler").click();
    })
}

// for change value payment_status afler
function changePaymentValueAfler() {
    $(function () {
        var r = confirm("Apakah Anda yakin jadwal tersebut SUDAH DIBAYAR AFL?");
        if (r == true) {
            $("#payment_status_afler").val("payed_by_AFL");
            $("#submit-filter-afler").click();
        } else {
            $("#payment_status_afler").val(false);
        }
    })
}

// for filter by aflee
function changePaymentValueFalseAflee() {
    $(function () {
        $("#payment_status_aflee").val(false);
        $("#submit-filter-aflee").click();
    })
}

// for change value payment_status aflee
function changePaymentValueAflee() {
    $(function () {
        var r = confirm("Apakah Anda yakin siswa telah men-TRANSFER TAGIHAN ini?");
        if (r == true) {
            $("#payment_status_aflee").val("transfered_by_Aflee");
            $("#submit-filter-aflee").click();
        } else {
            $("#payment_status_aflee").val(false);
        }
    })
}