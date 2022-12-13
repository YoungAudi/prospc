window.propuestas = function(){
	// let form;

	let getData = (e) => {
		return 
	}

	return {
		init: function() {
			// form = document.getElementById('form');
			return getData();
		}
	}
}();

window.datos = {
			adjuntos: [],
			needs: [],
			addNeed() {
				this.needs.push({tipo:'', nombre:''});
			},
			removeNeed(index) {
				this.needs.splice(index,1);
			},
			reset() {
				this.adjuntos = [];
				this.needs = [];
			}
		};