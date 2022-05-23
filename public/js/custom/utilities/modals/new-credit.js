"use strict";
var KTModalNewCard = function() {
    var t, e, n, r, o, i;
    return {
        init: function() {
            (i = document.querySelector("#kt_modal_new_card")) && (o = new bootstrap.Modal(i),
                r = document.querySelector("#kt_modal_new_card_form"), t = document.getElementById("kt_modal_new_card_submit"),
                e = document.getElementById("kt_modal_new_card_cancel"), $(r.querySelector('[name="card_expiry_month"]')).on("change", (function() {
                n.revalidateField("card_expiry_month")
            })), $(r.querySelector('[name="card_expiry_year"]')).on("change", (function() {
                n.revalidateField("card_expiry_year")
            })), n = FormValidation.formValidation(r, {
                fields: {
                    bank_info: {
                        validators: {
                            notEmpty: {
                                message: "Banka Bilgisini giriniz giriniz"
                            }
                        }
                    },
                    cerdit_name: {
                        validators: {
                            notEmpty: {
                                message: "Kredi Sahibi ismi giriniz"
                            }
                        }
                    },
                    credit_installement: {
                        validators: {
                            notEmpty: {
                                message: "Kart taksitini seçiniz"
                            },
                            creditCard: {
                                message: "Card number is not valid"
                            }
                        }
                    },
                    cekilen_tutar: {
                        validators: {
                            notEmpty: {
                                message: "Çekilen tutarı giriniz"
                            }
                        }
                    },
                    son_odeme_tarihi: {
                        validators: {
                            notEmpty: {
                                message: "Son ödeme tarihini giriniz"
                            }
                        }
                    }
                    ,
                    ilk_cekildigi_tarih: {
                        validators: {
                            notEmpty: {
                                message: "İlk çekilen tarihi giriniz."
                            }
                        }
                    },
                    kurl: {
                        validators: {
                            notEmpty: {
                                message: "Kredi Görselini giriniz."
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger,
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            }), t.addEventListener("click", (function(e) {
                e.preventDefault(), n && n.validate().then((function(e) {
                    console.log("validated!"), "Valid" == e ? (t.setAttribute("data-kt-indicator", "on"), t.disabled = !0,
                        setTimeout((function() {
                            var form_data = $('#kt_modal_new_card_form').serialize();
                            $.ajax({'type': 'POST', 'url': '/credit/save', 'data': form_data })
                                .done(()=>{
                                    t.removeAttribute("data-kt-indicator"), t.disabled = !1, Swal.fire({
                                        text: "Form has been successfully submitted!",
                                        icon: "success",
                                        buttonsStyling: !1,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then((function(t) {
                                        t.isConfirmed && o.hide()
                                        $('#kt_modal_new_card_form').trigger("reset");
                                        location.reload();
                                    }))
                                });
                    }), 2e3)) : Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    })
                }))
            })), e.addEventListener("click", (function(t) {
                t.preventDefault(), Swal.fire({
                    text: "Are you sure you would like to cancel?",
                    icon: "warning",
                    showCancelButton: !0,
                    buttonsStyling: !1,
                    confirmButtonText: "Yes, cancel it!",
                    cancelButtonText: "No, return",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-active-light"
                    }
                }).then((function(t) {
                    t.value ? (r.reset(), o.hide()) : "cancel" === t.dismiss && Swal.fire({
                        text: "Your form has not been cancelled!.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    })
                }))
            })))
        }
    }
}();
KTUtil.onDOMContentLoaded((function() {
    KTModalNewCard.init()
}));
