window.onload = go();

function go(){
    verCliente();
    sumarTotal();
}

function verCliente() {
    let select = document.getElementById('selectCliente');
    let label = document.getElementById('labelCliente');

    let ds = select.options[select.selectedIndex].dataset;
    label.innerHTML = `DNI: ${ds.dni}, Tel.: ${ds.tel} <br /> E-Mail: ${ds.email}`;
}

function calcularSubtotal(el) {
    let precio = el.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.children[0];
    let subt = precio.parentElement.nextElementSibling.children[0];
    
    subt.value = precio.innerHTML * el.value;

    sumarTotal();
}

function sumarTotal() {
    let subt = document.querySelectorAll(".subtotal_");
    let inputTotal = document.getElementsByName("total")[0];
    let total = 0;

    subt.forEach(el => total += parseFloat(el.value));

    inputTotal.value = total;
}