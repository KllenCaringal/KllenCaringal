<?php
include 'db.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $sql = "INSERT INTO products (name, description, price, quantity, create_at) 
            VALUES ('$name', '$description', '$price', '$quantity', NOW())";

    if ($conn->query($sql) === TRUE) {
        header("Location: " . $_SERVER['PHP_SELF']); 
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product</title>
</head>
<body>
    <h1>Add New Item</h1>
    <form action="" method="POST">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>

        <label for="description">Description:</label><br>
        <input type="text" id="description" name="description" required><br>

        <label for="price">Price:</label><br>
        <input type="number" id="price" name="price" required><br>

        <label for="quantity">Quantity:</label><br>
        <input type="number" id="quantity" name="quantity" required><br>

        <input type="submit" name="submit" value="Submit">
    </form>

    <h2>Item List</h2>
    <table border="1">
    <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
    </thead>
    <tbody>
    <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['description']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['quantity']}</td>
                        <td>{$row['create_at']}</td>
                        <td>{$row['update_at']}</td>
                        <td>
                            <form action='update.php' method='GET' style='display:inline;'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <button type='submit'>Update</button>
                            </form>
                            <form action='delete.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <button type='submit'>Delete</button>
                            </form>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No records found</td></tr>";
        }
    ?>
    </tbody>
    </table>
</body>
</html>
