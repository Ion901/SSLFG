
let category = document.getElementById("category");

function handleCategoryChange() {
    if (category.value === "SPORT") {
        fetchAPI(category);
    }
}

if (category.value === "SPORT") {
    fetchAPI(category);
} else {
    category.addEventListener("change", handleCategoryChange);
}


function fetchAPI(category1){
    let category = category1.value;

    let competitionDropdown = document.getElementById("competition_name");
    let competitionLocationDropdown = document.getElementById("competition_location");

    // Clear previous options
    competitionDropdown.innerHTML = '<option value="">Select Competition</option>';
    competitionLocationDropdown.value = '';

    if (category === "SPORT") {

        fetch(`/competitions-available?category=${category}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    data.forEach(competition => {

                        let option = document.createElement("option");
                        option.value = competition.name;
                        option.textContent = competition.name;
                        option.dataset.location = competition.location;
                        option.dataset.date = competition.date;
                        option.dataset.competition_id = competition.id
                        competitionDropdown.appendChild(option);

                    });
                } else {
                    let option = document.createElement("option");
                    option.textContent = "No available competitions";
                    option.disabled = true;
                    competitionDropdown.appendChild(option);
                }
            })
            .catch(error => console.error("Error fetching competitions:", error));

            document.getElementById("competition_name").addEventListener("change", function () {
                let selectedOption = this.options[this.selectedIndex];

                let selectedLocation = selectedOption.dataset.location;

                const date = selectedOption.dataset.date;
                const formattedDate = new Date(date).toISOString().split('T')[0];
                let selectedDate = formattedDate;

                let locationDropdown = document.getElementById("competition_location");
                let locationInput = document.getElementById("competition_location_input");

                let dateInput = document.getElementById("competition_date");

                let competitionInput = document.querySelector('#id_competition_fetched');


                // Update location selection
                Array.from(locationDropdown.children).forEach(option => {
                    if (option.value === selectedLocation) {
                        option.selected = true; // Mark as selected
                        locationInput.value = option.value; // Update the input field

                        competitionInput.value = selectedOption.dataset.competition_id;
                    }
                });

                // Update date field
                if (selectedDate) {
                    dateInput.value = selectedDate; // Fill in the competition date
                } else {
                    dateInput.value = ""; // Reset if no date is found
                }
            });
    }
}



