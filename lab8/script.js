document.addEventListener('DOMContentLoaded', function () {
    const citySelect = document.getElementById('city');
    const deliveryTypeSelect = document.getElementById('deliveryType');
    const locationSelect = document.getElementById('location');
    const weightInput = document.getElementById('weight');
    const form = document.getElementById('orderForm');
    const message = document.getElementById('message');

    const apiKey = 'e51b5a98955fbe018f47858c18886894'; // Новый API-ключ

    // Подгружаем города из API
    fetch('https://api.novaposhta.ua/v2.0/json/', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            apiKey: apiKey,
            modelName: 'Address',
            calledMethod: 'getCities',
            methodProperties: {}
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                data.data.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.Ref;
                    option.textContent = city.Description;
                    citySelect.appendChild(option);
                });
            }
        });

    deliveryTypeSelect.addEventListener('change', function () {
        const selectedCity = citySelect.value;
        const selectedType = deliveryTypeSelect.value;

        if (selectedCity && selectedType) {
            const weight = parseFloat(weightInput.value);

            fetch('https://api.novaposhta.ua/v2.0/json/', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    apiKey: apiKey,
                    modelName: 'AddressGeneral',
                    calledMethod: selectedType === 'branch' ? 'getWarehouses' : 'getPostOffices',
                    methodProperties: {
                        CityRef: selectedCity
                    }
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        locationSelect.innerHTML = '<option value="">Оберіть відділення або поштомат</option>';
                        data.data.forEach(location => {
                            const option = document.createElement('option');
                            option.value = location.Ref;
                            option.textContent = location.Description;
                            locationSelect.appendChild(option);
                        });
                    }
                });
        }
    });

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        const formData = new FormData(form);

        fetch('saveOrder.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                message.textContent = data; // Отображаем ответ от сервера
                form.reset();
            })
            .catch(error => {
                message.textContent = 'Помилка при створенні замовлення.';
            });
    });
});
