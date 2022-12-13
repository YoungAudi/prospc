window.TTValidate = function(elForm, elRules = {}, elTransformFormData = null, elSuccessFunc = null) {
    let form = elForm;
    let submitButton = elForm.querySelector("button[type='submit']");
    let validator;
    let rules = elRules;
    let transformData = (formData) => formData;
    let successFunc = () => {};
    if (elTransformFormData != null)
        transformData = elTransformFormData;
    if (elSuccessFunc != null)
        successFunc = elSuccessFunc;
    let handleForm = function(e) {
        submitButton.addEventListener('click', function (e) {
            let rs = document.querySelectorAll('.fv-plugins-message-container');
            for (var i = 0; i < rs.length; i++) {
                rs[i].remove();
            }

            validator = FormValidation.formValidation(
    			form,
    			{
                    fields: rules,
    				plugins: {
    					trigger: new FormValidation.plugins.Trigger(),
    					bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            // eleInvalidClass: '',  // comment to enable invalid state icons
                            eleValidClass: '' // comment to enable valid state icons
                        })
    				}
    			}
    		);		
            e.preventDefault();
            validator.validate().then(function (status) {
                if (status == 'Valid') {
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;
                    let url = form.action;
                    let sendData = new FormData(form);
                    sendData = transformData(sendData);
                    axios.post(url, sendData)
                    .then((result) => {
                        let successMessage = result.data.message;
                        if (!successMessage) {
                            successMessage = 'No hay un mensaje del servidor';
                        }
                        successFunc();
                        Swal.fire({
                            title: "Consulta exitosa",
                            text: successMessage,
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Entendido",
                            allowOutsideClick: false,
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        }).then(function (result) {
                            if (result.isConfirmed) { 
                                let redirectUrl = form.getAttribute('tt-redirect-url');
                                if (redirectUrl) {
                                    location.href = redirectUrl;
                                }
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
                            title: "Error",
                            text: errorText,
                            icon: "error",
                            allowOutsideClick: false,
                            buttonsStyling: false,
                            confirmButtonText: "Entendido",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    })
                    .finally(() => {
                        submitButton.removeAttribute('data-kt-indicator');
                        submitButton.disabled = false;
                    });
                } else {
                    Swal.fire({
                        title: "Compruebe los datos",
                        text: "Se detectarón algunos errores en el formulario, por favor compruebe los datos.",
                        icon: "error",
                        allowOutsideClick: false,
                        buttonsStyling: false,
                        confirmButtonText: "Entendido",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
		});
    }
    handleForm();
};