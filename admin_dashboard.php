<?php
session_start();

require_once 'database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<h2>Access denied. Admins only.</h2>";
    exit;
}

$query = "SELECT * FROM users";
$result = mysqli_query($connect, $query);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

$query1 = "SELECT * FROM products";
$result1= mysqli_query($connect, $query1);
$rows1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="CSS/admin.css">
</head>
<body>
    <h2 class="title-admin">Welcome, Admin <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
    <a href="logout.php" class="logout">Log Out</a>

    <div id="adminActions">
        <button id="displayAllUser">Display users</button>
        <button id="addUser">Adding new user</button>
        <button id="displayProducts">Display Products</button>
        <button id="addProduct">Add product</button>
    </div>

    <div id="allUser">
       <?php if (count($rows) > 0): ?>
            <table border="1" style="margin: 20px auto; color: white; border-collapse: collapse;">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Edit</th>
                </tr>
                <?php for ($i = 0; $i < count($rows); $i++): ?>
                    <tr>
                        <td><?= htmlspecialchars($rows[$i]['name']) ?></td>
                        <td><?= htmlspecialchars($rows[$i]['email']) ?></td>
                        <td>
                            <a href="edit-user.php?id=<?= urlencode($rows[$i]['ID']) ?>" class="edit-btn">Edit</a>
                            <form method="POST" action="delete-user.php" class="delete-form" onsubmit="return deleteUser(event, this);">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($rows[$i]['ID']) ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endfor; ?>
            </table>
        <?php else: ?>
            <p style="text-align:center; color:gray;">No users found in the database.</p>
        <?php endif; ?>
    </div>

    <div id="addNewUser">
        <form method="POST" action="add-user.php">
        <input type="text" name="name" placeholder="Enter name for a new user" required>
        <input type="email" name="email" placeholder="Enter email for a new user" required>
        <input type="password" name="password" placeholder="Enter password for a new user" required>
        <input type="text" name="role" placeholder="Enter role for a new user" value="user" readonly>
        <button type="submit" id="submitBtn">Add User</button>
        </form>
    </div>

    <div id="allProducts">
        <?php if (count($rows1) > 0): ?>
            <table border="1" style="margin: 20px auto; color: white; border-collapse: collapse;">
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Release_date</th>
                    <th>image_url</th>
                    <th>Actions</th>
                </tr>

                <?php for ($i = 0; $i < count($rows1); $i++): ?>
                    <tr>
                        <td><?= htmlspecialchars($rows1[$i]['name']) ?></td>
                        <td><?= htmlspecialchars($rows1[$i]['category']) ?></td>
                        <td><?= htmlspecialchars($rows1[$i]['description']) ?></td>
                        <td><?= htmlspecialchars($rows1[$i]['brand']) ?></td>
                        <td><?= htmlspecialchars($rows1[$i]['price']) ?></td>
                        <td><?= htmlspecialchars($rows1[$i]['stock']) ?></td>
                        <td><?= htmlspecialchars($rows1[$i]['release_date']) ?></td>
                        <td><?= htmlspecialchars($rows1[$i]['image_url']) ?></td>
                        <td>
                            <form method="POST" action="delete-product.php" class="delete-form"
                                  onsubmit="return confirm('Delete this product?');">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($rows1[$i]['id']) ?>">
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endfor; ?>
            </table>
        <?php else: ?>
            <p style="text-align:center; color:gray;">No products found in the database.</p>
        <?php endif; ?>
    </div>

    <div id="addNewProduct">
        <form method="POST" action="add-product.php">
            <input type="text" name="name" placeholder="Product name" required>
            <input type="text" name="category" placeholder="Category" required>
            <input type="text" name="description" placeholder="Description" required>
            <input type="text" name="brand" placeholder="Brand" required>
            <input type="number" step="0.01" name="price" placeholder="Price" required>
            <input type="number" name="stock" placeholder="Stock" required>
            <input type="date" name="release_date" required>
            <input type="text" name="image_url" placeholder="image url (or path)" required>
            <button type="submit" id="saveProductBtn">Save</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="JS/delete-user.js"></script>
    <script src="JS/displayBtn.js"></script>
</body>
</html>
