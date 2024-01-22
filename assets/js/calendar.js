$(() => {
    const calendar_locations = $(".location").toArray();
    calendar_locations.forEach(location => {
        // console.log(location.innerText)
        get_weather(location.innerText)
            .then(r => {})
    })

    const x = document.getElementById("left_element")
    if (window.screen.width < 468){
        x.innerHTML = "2023 stat.";
    }
})

/**
 * This function requires the name of the city,
 * and it will set the proper divs with the proper information
 * obtained through Open Weather Map API.
 * @param city
 * @returns {Promise<void>}
 */
const get_weather = async city => {
    city = city.replace(" ", "+")
    fetch(`http://api.openweathermap.org/geo/1.0/direct?q=${city}&limit=1&appid=${API_KEY}`)
        .then(response => response.json())
        .then(json => {
            // console.log(json)
            const lat = json[0]["lat"];
            const lon = json[0]["lon"];

            fetch(`https://api.openweathermap.org/data/3.0/onecall?lat=${lat}&lon=${lon}&appid=${API_KEY}`)
                .then(response => response.json())
                .then(json => {
                    // console.log(json)

                    // create a new Date object with the current date and time
                    const date = new Date();

                    // use the toLocaleString() method to display the date in different timezones
                    const localTime = date.toLocaleString(navigator.language, {
                        hour: '2-digit',
                        minute: '2-digit',
                        timeZone: json.timezone
                    });
                    // console.log(navigator.language + "\n" + localTime + " " + city + " " + json.timezone)

                    const weather = json.current.weather[0];
                    const temp = Math.round((json.current.temp - 273.15) * 10) / 10;
                    const img = `<img src='https://openweathermap.org/img/wn/${weather.icon}.png' alt="Weather icon">`;
                    $(`#curr-weather-${city.replace("+", "-")}-main`).html(`<strong>${weather.description.charAt(0).toUpperCase() + weather.description.slice(1)}</strong>`);
                    $(`#curr-weather-${city.replace("+", "-")}-icon`).html(`${img}`);
                    $(`#curr-weather-${city.replace("+", "-")}-temp`).html(`${temp} °C`);
                    $(`#curr-weather-${city.replace("+", "-")}-time`).html(`<strong>${localTime}</strong>`);
                })
                .catch(err => console.log(err))
        })
        .catch(err => console.log(err))
}

function responsive(id) {
    if (window.screen.width < 576) {
        $(`#responsive${id}`).removeClass('responsive');
        $(`#img-responsive${id}`).removeClass('img-responsive');
    }
}