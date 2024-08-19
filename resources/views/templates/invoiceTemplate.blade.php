<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        /* Add your invoice styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Invoice #12345</h1>
    <p>Date: 2024-08-19</p>
    <p>Customer: John Doe</p>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Item 1</td>
                <td>2</td>
                <td>$50.00</td>
                <td>$100.00</td>
            </tr>
            <tr>
                <td>Item 2</td>
                <td>1</td>
                <td>$150.00</td>
                <td>$150.00</td>
            </tr>
            <tr>
                <td>Item 3</td>
                <td>3</td>
                <td>$30.00</td>
                <td>$90.00</td>
            </tr>
            <tr>
                <td>Item 4</td>
                <td>4</td>
                <td>$25.00</td>
                <td>$100.00</td>
            </tr>
            <tr>
                <td>Item 5</td>
                <td>2</td>
                <td>$200.00</td>
                <td>$400.00</td>
            </tr>
        </tbody>
    </table>

    <p>Total Amount: $840.00</p>
</body>
</html>
