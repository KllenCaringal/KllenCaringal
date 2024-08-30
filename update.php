<?php
include 'db.php';

// Handle form submission for updating the product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Update the product in the database
    $sql = "UPDATE products SET
                name = '$name',
                description = '$description',
                price = '$price',
                quantity = '$quantity',
                update_at = NOW()  -- Automatically set the current date and time
            WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");  // Redirect to the main page on success
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else if (isset($_GET['id'])) {
    // Fetch the product details based on the ID from the URL
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();  // Get the product data
    } else {
        echo "No record found!";
        exit;
    }
} else {
    echo "Invalid request!";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Product</title>
</head>
<body>
    <h1>Update Item</h1>
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required><br>

        <label for="description">Description:</label><br>
        <input type="text" id="description" name="description" value="<?php echo $row['description']; ?>" required><br>

        <label for="price">Price:</label><br>
        <input type="number" id="price" name="price" value="<?php echo $row['price']; ?>" required><br>

        <label for="quantity">Quantity:</label><br>
        <input type="number" id="quantity" name="quantity" value="<?php echo $row['quantity']; ?>" required><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>
