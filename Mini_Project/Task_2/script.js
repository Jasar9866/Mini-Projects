$(document).ready(function () {
  // Fetch the list of countries and make it as dropdown list.
  $.ajax({
    url: "https://restcountries.com/v3.1/all",
    method: "GET",
    success: function (data) {
      const countrySelect = $("#countrySelect");
      data.forEach(function (country) {
        countrySelect.append(new Option(country.name.common, country.cca2));
      });
    },
  });

  // Handle country selection.
  $("#countrySelect").on("change", function () {
    const countryCode = $(this).val();
    fetchCountryInfo(countryCode);
  });

  // Fetch and display country information.
  function fetchCountryInfo(countryCode) {
    $.ajax({
      url: `https://restcountries.com/v3.1/alpha/${countryCode}`,
      method: "GET",
      success: function (data) {
        const countryInfo = $("#countryInfo");
        countryInfo.empty();

        const country = data[0];

        countryInfo.append(
          `<img src="${country.flags.png}" alt="Flag" width="150">`
        );
        countryInfo.append(
          `<p><strong>Country Official Name:</strong> ${country.name.official}</p>`
        );
        countryInfo.append(
          `<p><strong>Capital City:</strong> ${country.capital}</p>`
        );
        countryInfo.append(`<p><strong>Region:</strong> ${country.region}</p>`);
        countryInfo.append(
          `<p><strong>Subregion:</strong> ${country.subregion}</p>`
        );

        const currencies = [];
        for (const currencyCode in country.currencies) {
          currencies.push(
            `${currencyCode} (${country.currencies[currencyCode].name})`
          );
        }
        countryInfo.append(
          `<p><strong>Currencies:</strong> ${currencies.join(", ")}</p>`
        );

        countryInfo.append(
          `<p><strong>Country Code:</strong> ${country.cca2}</p>`
        );
        countryInfo.append(
          `<p><strong>Population:</strong> ${country.population}</p>`
        );
        countryInfo.append(`<p><strong>Area:</strong> ${country.area} km²</p>`);
        countryInfo.append(
          `<p><strong>Borders:</strong> ${country.borders.join(", ")}</p>`
        );

        // Add Google Map.
        const googleMapContainer = $(
          '<div id="googleMap" style="height: 300px;"></div>'
        );
        countryInfo.append(googleMapContainer);

        const map = new google.maps.Map(googleMapContainer[0], {
          center: { lat: country.latlng[0], lng: country.latlng[1] },
          zoom: 5,
        });

        new google.maps.Marker({
          position: { lat: country.latlng[0], lng: country.latlng[1] },
          map: map,
        });
      },
    });
  }
});
