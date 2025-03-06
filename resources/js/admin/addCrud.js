let addBtn = document.querySelector("#add");
let table = document.querySelector("#table>tbody");
let i = 1;

addBtn.addEventListener("click", function () {
    let newRow = document.createElement("tr");
    newRow.innerHTML = `
            <td>
                <input type="text" name="inputs[${i}][fullName]" placeholder="Introdu numele complet al sportivului" class="form-control" />
            </td>
            <td>
                <input type="number" class="yearpicker form-control" name="inputs[${i}][age]" placeholder="Anul nasterii"  >
            </td>
            <td>
                 <input type="number" name="inputs[${i}][weight]" placeholder="Greutateta sportivului" class="form-control">
            </td>
            <td>
                <input type="number" name="inputs[${i}][place]" placeholder="Loc ocupat" class="form-control">
            </td>
            <td>
                    <input type="hidden" name="inputs[${i}][id_competition]" id="id_competition_fetched">
                    <select id="competition_name" name="competition_name"
                        class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled selected>Numele competitiei</option>
                            ${competitions.map(comp => `<option value="${comp.name}" data-competition-id="${comp.id}">${comp.name}</option>`).join('')}
                    </select>
                </td>
            <td>
                <button type="button" class="btn btn-danger remove-table-row">Sterge</button>
            </td>
    `;

    table.appendChild(newRow);
    i++;

    //add competition id from evry new row added via js
    let selectElement = newRow.querySelector("#competition_name");
    let hiddenInput = newRow.querySelector("#id_competition_fetched");

        selectElement.addEventListener("change", function () {
            let selectedOption = this.options[this.selectedIndex];
            hiddenInput.value = selectedOption.getAttribute("data-competition-id");
        });

    // Reinitialize yearpicker for the new row
    $(newRow).find(".yearpicker").yearpicker();

    // Remove row functionality
    newRow.querySelector(".remove-table-row").addEventListener("click", function () {
        newRow.remove();
    });
});

//add copmetition id from the initial document(the first detail tabel row)
let competitionInput = document.querySelector('#id_competition_fetched');
document.getElementById("competition_name").addEventListener("change", function () {
    let selectedOption = this.options[this.selectedIndex];
    competitionInput.value = selectedOption.dataset.competitionId;
});
