function checkTo10(checkEvent){
	var prods = 0;
	var checkProds = document.querySelectorAll(".checkprod");

	if(checkEvent.checked){
		checkProds.forEach(el => {
			if(el.checked) prods++;
		});

		if(prods > 10){
			alert(`Máximo ${prods-1} elementos seleccionables`);
			checkEvent.checked = false;
		}
	}
}