document.addEventListener("DOMContentLoaded", function(){
    const calendarGrid = document.getElementById("calendarGrid");
    const monthYear = document.getElementById("monthYear");
    const selectedDateElement = document.getElementById("selectedDate");
    const prevMonth = document.getElementById("prevMonth");
    const nextMonth = document.getElementById("nextMonth");

    let currentDate = new Date(2025, 7, 1);

    function renderCalendar(){
        calendarGrid.innerHTML = ""; //Limpiamos el calendario
        let firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();
        let daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();
        monthYear.innerText = currentDate.toLocaleString("en-US", {month:"long", year: "numeric"});

        for (let i = 0; i < firstDay; i++){
            let emptyDiv = document.createElement("div");
            emptyDiv.classList.add("day", "inactive");
            calendarGrid.appendChild(emptyDiv);
        }

        for (let day = 1; day <= daysInMonth; day++){
            let dayDiv = document.createElement("div");
            dayDiv.classList.add("day");
            dayDiv.innerHTML = day;
            if (day === 17) dayDiv.classList.add("selected");
            dayDiv.addEventListener("click", () => {
                document.querySelectorAll(".day").forEach(d => d.classList.remove("selected"));
                dayDiv.classList.add("selected");
                selectedDateElement.innerText = new Date(currentDate.getFullYear(), currentDate.getMonth(), day)
                .toLocaleDateString("en-US", {weekday: "short", month: "short", day: "numeric"});
            });
            calendarGrid.appendChild(dayDiv);
        }
     }
     
     prevMonth.addEventListener("click", () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
     });

     nextMonth.addEventListener("click", () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
     });

     renderCalendar();
    });