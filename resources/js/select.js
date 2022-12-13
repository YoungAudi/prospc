window.TTSelect = function(elSelectChange, elSelectUpdate, elRoute, elId, elVar, elStartValue = null) {
    let route = elRoute;
    let theId = elId;
    let firstLoad = true;
    let startValue = elStartValue;
    let theVar = elVar;
    let selectChange = elSelectChange;
    let selectUpdate = elSelectUpdate;
    
    let handleSelect = function(e) {
        if (startValue != null && startValue != '') doActualization(selectChange);

        selectChange.addEventListener('change', function (e) {
            doActualization(e.currentTarget);
        });
    }

    let  doActualization = function(elementSelect) {
        let id = elementSelect.value;
        if (id != undefined && id != '') {
            selectUpdate.innerHTML = "<option value=''>Cargando...</option>";
            let url = route.replace('content', id);
            axios.get(url)
            .then((result) => {
                let text = `<option value=''>Selecciona una opción</option>`;
                let data = result.data.data;
                for (let val of data) {
                    if (firstLoad && startValue == val[theId]) {
                        firstLoad = false;
                        text += `<option selected value='${val[theId]}'>${val[theVar]}</option>`;
                    } else {
                        text += `<option value='${val[theId]}'>${val[theVar]}</option>`;
                    }
                }
                firstLoad = false;
                selectUpdate.innerHTML = text;
            });
        } else {
            selectUpdate.innerHTML = "<option value=''>Aún no se cargan valores</option>";
        }
    };

    handleSelect();
};