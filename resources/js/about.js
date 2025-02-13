const createOdometer = (el, value) => {
    const odometer = new Odometer({
      el: el,
      value: 0,
    });

    let hasRun = false;

    const options = {
      threshold: [0, 0.9],
    };

    const callback = (entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          if (!hasRun) {
            odometer.update(value);
            hasRun = true;
          }
        }
      });
    };

    const observer = new IntersectionObserver(callback, options);
    observer.observe(el);
  };

  const subscribersOdometer = document.querySelector(".activs-athlets");
  createOdometer(subscribersOdometer, 40);

  const videosOdometer = document.querySelector(".emerit-coach");
  createOdometer(videosOdometer, 10);

  const projectsOdometer = document.querySelector(".activity-years");
  createOdometer(projectsOdometer, 48);



  document.addEventListener("DOMContentLoaded", function () {
    const searchYear = document.querySelector('#year-search')
    const searchText = document.querySelector("#text-search");
    const table = document.querySelector("#dataTable");
    const tbody = table.querySelector("tbody");
    const rows = Array.from(tbody.querySelectorAll("tr"));
    const paginationContainer = document.querySelector(".pagination");

    let currentPage = 1;
    const rowsPerPage = 5;
    let filteredRows = [...rows]; // Store full data for filtering

    function displayRows(rowsToDisplay) {
        tbody.innerHTML = "";
        rowsToDisplay.forEach(row => tbody.appendChild(row));
    }

    function paginateTable(page, data) {
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        displayRows(data.slice(start, end));

        paginationContainer.innerHTML = "";
        const totalPages = Math.ceil(data.length / rowsPerPage);

        for (let i = 1; i <= totalPages; i++) {
            const button = document.createElement("button");
            button.textContent = i;
            button.className = page === i ? "active1" : "";
            button.addEventListener("click", () => {
                currentPage = i;
                paginateTable(currentPage, data);
            });
            paginationContainer.appendChild(button);
        }
    }

    searchText.addEventListener("input", function () {
        const searchValue = searchText.value.toLowerCase().trim();
        filteredRows = rows.filter(row => row.innerText.toLowerCase().includes(searchValue));
        currentPage = 1;
        paginateTable(currentPage, filteredRows);
    });

    searchYear.addEventListener("input", function () {
        const year = searchYear.value;
        if(year == 0){
            filteredRows = rows;
        }else{
            filteredRows = rows.filter(row => row.innerText.toLowerCase().includes( year));
        }

        currentPage = 1;
        paginateTable(currentPage, filteredRows);
    });

    paginateTable(currentPage, filteredRows);
});
