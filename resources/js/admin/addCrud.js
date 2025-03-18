let addBtn = document.querySelector("#add");
let table = document.querySelector("#table>tbody");
let i = 1;

// Setup for initial row
const initialRow = table.querySelectorAll("tr")[1];


if (initialRow) {
    setupRowEvents(initialRow);
}

// Add new row
addBtn.addEventListener("click", function () {
    let newRow = document.createElement("tr");
    newRow.innerHTML = `
        <td>
            <input type="hidden" name="inputs[${i}][id_athlet]" class="id_athlet_fetched">
            <select class="select-picker w-full p-2 border border-gray-300 rounded" name="athlet_fullName">
                <option value="" disabled selected>Numele premiantului</option>
                ${athlets.map(athlet => `<option value="${athlet.fullName}" data-athlet-id="${athlet.id}">${athlet.fullName}</option>`).join('')}
            </select>
        </td>
        <td><input type="number" name="inputs[${i}][weight]" placeholder="Greutatea sportivului" class="form-control"></td>
        <td><input type="number" name="inputs[${i}][place]" placeholder="Loc ocupat" class="form-control"></td>
        <td>
            <input type="hidden" name="inputs[${i}][id_competition]" class="id_competition_fetched">
            <select id="competition_name" class="w-full p-2 border border-gray-300 rounded">
                <option value="" disabled selected>Numele competitiei</option>
                ${competitions.map(comp => `<option value='${comp.name}' data-competition-id="${comp.id}">${comp.name}</option>`).join('')}
            </select>
        </td>
        <td>
            <button type="button" class="btn btn-danger remove-table-row">Sterge</button>
        </td>
    `;

    table.appendChild(newRow);
    i++;

    // Activate all logic for new row
    setupRowEvents(newRow);

    // Reinitialize select2
    $(newRow).find(".select-picker").select2();

    // Delete row
    newRow.querySelector(".remove-table-row").addEventListener("click", function () {
        newRow.remove();
    });
});

// Setup events per row
function setupRowEvents(row) {

    const competitionSelect = row.querySelector("#competition_name");
    const athleteSelect = row.querySelector(".select-picker");
    const hiddenAthletId = row.querySelector(".id_athlet_fetched");
    const hiddenCompetitionId = row.querySelector(".id_competition_fetched");

    console.info(competitionSelect);

    if (!competitionSelect || !athleteSelect) return;

    competitionSelect.addEventListener("change", function () {
        let selectedOption = this.options[this.selectedIndex];
        let competitionName = selectedOption.value;
        console.log(competitionName);

        let competitionId = this.selectedOptions[0]?.dataset.competitionId || "";
        console.log(competitionId);

        hiddenCompetitionId.value = competitionId;

        fetch(`/athlets-available?competition=${competitionName}`)
            .then((res) => res.json())
            .then((data) => {
                athleteSelect.innerHTML = `<option value="" disabled selected>Select an athlete</option>`;
                if (data.length > 0) {
                    data.forEach((athlet) => {
                        const opt = document.createElement("option");
                        opt.value = athlet.fullName;
                        opt.textContent = athlet.fullName;
                        opt.setAttribute("data-athlet-id", athlet.id);
                        athleteSelect.appendChild(opt);
                    });
                } else {
                    const opt = document.createElement("option");
                    opt.textContent = "Nu mai sunt sportivi";
                    opt.disabled = true;
                    athleteSelect.appendChild(opt);
                }

                // Refresh select2 for athleteSelect
                $(athleteSelect).select2();
            });
    });

    $(athleteSelect).on('change', function () {
        const selected = this.options[this.selectedIndex];
        hiddenAthletId.value = selected?.dataset.athletId || "";
    });
}
