



$(document).ready(function () {

    const id = $("#id").val();

    fetch(`../model/datagrid_traza.php?id=${id}`)
        .then(res => res.json())
        .then(json => {
            const tbody = document.getElementById("tbodyTraza");
            tbody.innerHTML = "";

            if (json.data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" class="text-center">No hay registros de traza</td></tr>';
                return;
            }

            json.data.forEach(item => {
                const fila = document.createElement("tr");
                fila.innerHTML = `
                    <td>${item.ESTADO}</td>
                    <td>${item.FECHA}</td>
                    <td>${item.OBSERVACION}</td>
                    <td>${item.USUARIO}</td>
                `;
                tbody.appendChild(fila);
            });
        })
        .catch(err => {
            console.error("Error al cargar la traza:", err);
        });

});