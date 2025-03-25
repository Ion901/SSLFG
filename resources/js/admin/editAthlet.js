    document.addEventListener('DOMContentLoaded', function() {
        const competition = document.getElementById('athlet_competition');
        const athletsDropdown = document.getElementById('athlet_name');

        // Store the currently selected athlete's value
        const selectedOption = athletsDropdown.options[athletsDropdown.selectedIndex];
        const initialAthlet = selectedOption.value;
        const initialAthletID = selectedOption.dataset.athletId;
        console.log('Initial Athlete ID:', initialAthletID);

    // Fetch new athletes only after a short delay (or directly)
    fetchAthlets(competition.value, initialAthlet, initialAthletID);

    competition.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const competitionName = selectedOption.value;
        fetchAthlets(competitionName, initialAthlet, initialAthletID);
    });
});

function fetchAthlets(competitionName, initialAthlet = null,id) {
    const athletsDropdown = document.getElementById('athlet_name');
    const hiddenInput = document.getElementById('id_athlet_fetched');

    if (!competitionName) return;

    fetch(`/athlets-available?competition=${encodeURIComponent(competitionName)}`)
        .then(response => response.json())
        .then(data => {
            athletsDropdown.innerHTML = ''; // Clear all options

            // Keep the currently selected athlete if passed
            if (initialAthlet) {
                const selectedOption = document.createElement('option');
                selectedOption.value = initialAthlet;
                selectedOption.setAttribute('data-athlet-id', id)
                selectedOption.textContent = initialAthlet;
                selectedOption.selected = true;

                athletsDropdown.appendChild(selectedOption);
            }

            // Populate other available athletes
            if (data.length > 0) {
                data.forEach(athlet => {
                    if (athlet.fullName === initialAthlet) return;
            
                    const option = document.createElement('option');
                    option.value = athlet.fullName;
                    option.textContent = athlet.fullName;
                    option.setAttribute('data-athlet-id', athlet.id);
                    athletsDropdown.appendChild(option);
                });
            } else {
                const option = document.createElement('option');
                option.textContent = "Nu mai sunt sportivi";
                option.disabled = true;
                athletsDropdown.appendChild(option);
            }
        })
        .catch(error => console.error("Error fetching athlets:", error));
}

