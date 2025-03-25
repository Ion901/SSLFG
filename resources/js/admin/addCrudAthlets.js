let addBtn = document.querySelector("#add");
let table = document.querySelector("#table>tbody");
let i = 1;

// Add new row
addBtn.addEventListener("click", function () {
    let newRow = document.createElement("tr");
    newRow.innerHTML = `
                <td>
                    <input type="text" id="athlet_fullName" name="inputs[${i}][athlet_fullName]"
                        class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                        placeholder="Nume, Prenume">

                </td>
                <td>
                    <input type="number" id="athlet_birthdate" name="inputs[${i}][athlet_birthdate]"
                        class="yearpicker w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                        placeholder="Anul nasterii" >
                </td>
                 <td>
                    <button type="button" class="btn btn-danger remove-table-row">Sterge</button>
                </td>

    `;

    table.appendChild(newRow);
    i++;

    // Activate all logic for new row

    // Reinitialize select2
    $(newRow).find(".yearpicker").yearpicker();

    // Delete row
    newRow.querySelector(".remove-table-row").addEventListener("click", function () {
        newRow.remove();
    });
});
