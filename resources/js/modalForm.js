window.TTModalForm = function() {
    let triggers;
    let modal;
    let form;
    let idAttribute;
    let submitButton;
    let route;
    let loadData;
    let title;
    let endHere;

    let handleModalForm = function(e) {
        // let data = {};
        for (var i = 0; i < triggers.length; i++) {
            triggers[i].addEventListener('click', async (evt) => {
                evt.preventDefault();
                let results = {};
                let elId = evt.currentTarget.getAttribute(idAttribute);
                if (loadData) {
                    await axios.get(loadData.replace('content', elId)).then((result) => {
                        results = result.data.data;
                    });
                }
                let inputs = form.querySelectorAll(".fca");
                for (var i = 0; i < inputs.length; i++) {
                    let theName = inputs[i].getAttribute('name');
                    if (theName in results) {
                        inputs[i].value = results[theName];
                    } else {
                        inputs[i].value = '';
                    }
                }
                form.querySelector('input[name="_method"]').value = "PUT";
                formTitle.innerHTML = title;
                form.action = route.replace('content', elId);
                if (!endHere) {
                    necesidades = results.needs;
                    loadNeeds();
                }
                    modal.show();
                // data = results;
            });
        }
        // return data;
    }
    return {
        init: function(elRoute, elModal, elModalContainer, elTriggers, elLoadData = null, elTitle = 'Editar', elIdAttribute = 'tt-id', elEndHere = true) {
            // falta poner función para cargar datos del form en caso de que se requiera cargar algún dato, tipo una ruta de carga
            triggers = document.querySelectorAll(elTriggers);
            route = elRoute;
            endHere = elEndHere;
            if (!endHere) {
                necesidades=[];
            }
            title = elTitle;
            loadData = elLoadData;
            modal = elModal;
            idAttribute = elIdAttribute;
            form = elModalContainer.querySelector('form');
            formTitle = form.querySelector('.modal-title');
            submitButton = form.querySelector("button[type='submit']");
            return handleModalForm();
        }
    };
}();