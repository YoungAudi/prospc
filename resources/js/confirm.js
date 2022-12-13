window.TTConfirm = function() {
    let confirmsForms;
    let successFunc = () => {};

    let handleConfirm = function(e) {
        for (var i = 0; i < confirmsForms.length; i++) {
            confirmsForms[i].addEventListener('submit', function(e) {
                e.preventDefault();
                let formConfirm = e.currentTarget;
                let submitButton = formConfirm.querySelector("button[type='submit']");
                submitButton.disabled = true;
                let confirmTitle = formConfirm.getAttribute('tt-title');
                if (!confirmTitle) confirmTitle = '¿Seguro que desea realizar la acción?';
                let confirmText = formConfirm.getAttribute('tt-text');
                if (!confirmText) confirmText = '¡La acción no es reversible!';
                Swal.fire({
                    title: confirmTitle,
                    text: confirmText,
                    icon: "warning",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "Aceptar",
                    cancelButtonText: 'Cancelar',
                    allowOutsideClick: false,
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-secondary",
                    }
                }).then(function (result) {
                    if (result.isConfirmed) { 
                        let actionUrl = formConfirm.action;
                        let sendData = new FormData(formConfirm);
                        axios.post(actionUrl, sendData)
                        .then((result) => {
                            let successMessage = result.data.message;
                            if (!successMessage) {
                                successMessage = 'No hay un mensaje del servidor';
                            }
                            submitButton.disabled = false;
                            successFunc();
                            Swal.fire({
                                title: "Consulta exitosa",
                                text: successMessage,
                                icon: "success",
                                toast: true,
                                buttonsStyling: false,
                                showConfirmButton: false,
                                position: 'top-right',
                                timerProgressBar: true,
                                timer: 2200,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            });
                        })
                        .catch((error) => {
                            let errorText = '';
                            if (error.response.data.errors != undefined) {
                                errorText = error.response.data.errors[Object.keys(error.response.data.errors)[0]];
                            } else {
                                errorText = error.response.data.message;
                            }
                            Swal.fire({
                                title: "Error "+error.response.status,
                                text: errorText,
                                icon: "error",
                                allowOutsideClick: false,
                                buttonsStyling: false,
                                confirmButtonText: "Entendido",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        });
                    }
                })
                .finally(() => {
                    submitButton.disabled = false;
                });
            });
        }
    }
    return {
        init: function(confirmSelector, elSuccessFunc = null) {
            confirmsForms = document.querySelectorAll(confirmSelector);
            if (elSuccessFunc != null)
                successFunc = elSuccessFunc;
            handleConfirm();
        }
    };
}();