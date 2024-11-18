<?php
$apiKey = 'e51b5a98955fbe018f47858c18886894';

$host = 'localhost';
$dbname = 'lab8';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Ошибка подключения к базе данных: ' . $conn->connect_error);
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderNumber = $_POST['orderNumber'];
    $weight = (float)$_POST['weight'];
    $cityRef = $_POST['city'];
    $deliveryType = $_POST['deliveryType'];
    $locationRef = $_POST['location'];

    if (empty($orderNumber) || $weight <= 0 || empty($cityRef) || empty($deliveryType) || empty($locationRef)) {
        $message = 'Помилка: Всі поля мають бути заповнені!';
    } else {
        $stmt = $conn->prepare("INSERT INTO orders (order_number, weight, city_ref, delivery_type, location_ref) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdsss", $orderNumber, $weight, $cityRef, $deliveryType, $locationRef);

        if ($stmt->execute()) {
            $message = 'Замовлення успішно збережено!';
        } else {
            $message = 'Помилка збереження замовлення: ' . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформлення замовлення</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }
        h1 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }
        form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        select, input, button {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            color: green;
            font-size: 16px;
            text-align: center;
        }
        .message.error {
            color: red;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Оформлення замовлення</h1>
    <?php if (!empty($message)): ?>
        <p class="message <?php echo strpos($message, 'Помилка') !== false ? 'error' : ''; ?>">
            <?php echo $message; ?>
        </p>
    <?php endif; ?>
    <form method="POST" action="">
        <label>
            Номер замовлення:
            <input type="text" name="orderNumber" required>
        </label>
        <label>
            Вага замовлення (кг):
            <input type="number" name="weight" step="0.1" required>
        </label>
        <label>
            Місто доставки:
            <select name="city" id="city" required>
                <option value="">Оберіть місто</option>
            </select>
        </label>
        <label>
            Тип доставки:
            <select name="deliveryType" id="deliveryType" required>
                <option value="">Оберіть тип доставки</option>
                <option value="branch">Відділення</option>
                <option value="postamat">Поштомат</option>
            </select>
        </label>
        <label>
            Відділення/Поштомат:
            <select name="location" id="location" required>
                <option value="">Оберіть відділення або поштомат</option>
            </select>
        </label>
        <button type="submit">Зберегти замовлення</button>
    </form>
</div>

<script>
    const apiKey = '<?php echo $apiKey; ?>';

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
                const citySelect = document.getElementById('city');
                data.data.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.Ref;
                    option.textContent = city.Description;
                    citySelect.appendChild(option);
                });
            }
        });

    document.getElementById('deliveryType').addEventListener('change', function () {
        const cityRef = document.getElementById('city').value;
        const deliveryType = this.value;
        const endpoint = deliveryType === 'branch' ? 'getWarehouses' : 'getPostOffices';

        fetch('https://api.novaposhta.ua/v2.0/json/', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                apiKey: apiKey,
                modelName: 'AddressGeneral',
                calledMethod: endpoint,
                methodProperties: { CityRef: cityRef }
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const locationSelect = document.getElementById('location');
                    locationSelect.innerHTML = '<option value="">Оберіть відділення або поштомат</option>';
                    data.data.forEach(location => {
                        const option = document.createElement('option');
                        option.value = location.Ref;
                        option.textContent = location.Description;
                        locationSelect.appendChild(option);
                    });
                }
            });
    });
</script>
</body>
</html>
