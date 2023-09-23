<?php
// Establish database connection
require_once "../db_connect.php";
session_start();

if (isset($_SESSION['user'])) {
    header("Location: ../index.php");
}
if (!isset($_SESSION['user']) && !isset($_SESSION['adm'])) {
    header("Location: ../login.php");
}

// Get filter parameters if provided
$filterMonth = isset($_GET['month']) ? $_GET['month'] : null;
$filterCategory = isset($_GET['category']) ? $_GET['category'] : null;

// Initialize totalSales and totalOrders to 0
$totalSales = 0;
$totalOrders = 0;

// Query for total sales amount without filters
$queryTotalSales = "
    SELECT SUM(o.quantity * (p.price - p.price * COALESCE(d.discount, 0) / 100)) AS total_sales
    FROM orders o
    JOIN products p ON o.fk_product = p.ID
    LEFT JOIN discounts d ON p.fk_category = d.fk_category
";
$resultTotalSales = mysqli_query($connect, $queryTotalSales);

if ($resultTotalSales) {
    $rowTotalSales = mysqli_fetch_assoc($resultTotalSales);
    $totalSales = $rowTotalSales['total_sales'];
} else {
    echo "Error executing total sales query: " . mysqli_error($connect);
}

// Query for total number of orders without filters
$queryTotalOrders = "
    SELECT SUM(o.quantity) AS total_orders
    FROM orders o
";

$resultTotalOrders = mysqli_query($connect, $queryTotalOrders);

if ($resultTotalOrders) {
    $rowTotalOrders = mysqli_fetch_assoc($resultTotalOrders);
    $totalOrders = $rowTotalOrders['total_orders'];
} else {
    $totalOrders = "N/A";
}

// Query to fetch categories from the database
$queryCategories = "SELECT ID, category FROM categories";
$resultCategories = mysqli_query($connect, $queryCategories);
$categories = array();

$categoryNames = array(); // Initialize an empty array for category names

if ($resultCategories) {
    while ($rowCategory = mysqli_fetch_assoc($resultCategories)) {
        $categories[$rowCategory['ID']] = $rowCategory['category'];
        $categoryNames[$rowCategory['ID']] = $rowCategory['category']; // Store category names in the array
    }
} else {
    echo "Error fetching categories: " . mysqli_error($connect);
}

// Query for top sold products with filters
$filterConditions = "";

if ($filterMonth) {
    $filterConditions .= " AND MONTH(pc.purchase_date) = $filterMonth";
}
if ($filterCategory) {
    $filterConditions .= " AND p.fk_category = $filterCategory";
}

// Query for top sold products with filters
$queryTopProducts = "
    SELECT 
        p.name AS product_name,
        p.price AS product_price,
        SUM(o.quantity) AS total_quantity,
        SUM(pc.total_amount) AS total_sale_amount,
        COALESCE(d.discount, 0) AS discount_percentage
    FROM 
        orders o
    JOIN 
        products p ON o.fk_product = p.ID
    LEFT JOIN 
        discounts d ON p.fk_category = d.fk_category
    LEFT JOIN
        purchases pc ON o.fk_purchase = pc.ID
    WHERE 1 $filterConditions
    GROUP BY p.name
";

$resultTopProducts = mysqli_query($connect, $queryTopProducts);

if (!$resultTopProducts) {
    echo "Error executing top products query: " . mysqli_error($connect);
    exit; // Stop the script execution
}

$monthNames = array(
    1 => 'January',
    2 => 'February',
    3 => 'March',
    4 => 'April',
    5 => 'May',
    6 => 'June',
    7 => 'July',
    8 => 'August',
    9 => 'September',
    10 => 'October',
    11 => 'November',
    12 => 'December',
);

// Close database connection
mysqli_close($connect);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Statistics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        .box {
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-bottom: 20px;
}

.box-title {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 10px;
}

.box-content {
    font-size: 24px;
    margin: 0;
}

    </style>

</head>
<body>
<?php include_once "../components/navbarAdmin.php"
    ?>
<div class="container">
        <h1 class="mt-4">Sales Statistics</h1>
        <div class="row">
    <div class="col-md-6">
        <div class="box">
            <p class="box-title">Total Sales Amount</p>
            <p class="box-content">$<?php echo number_format($totalSales, 2); ?></p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box">
            <p class="box-title">Total Sales</p>
            <p class="box-content"><?php echo $totalOrders; ?></p>
        </div>
    </div>
</div>
<h2>Top Sold Products</h2>
<form class="row g-3 align-items-center" action="" method="get">
    <div class="col-md-4">
        <label for="month" class="form-label">Filter by Month:</label>
        <select name="month" id="month" class="form-select">
            <option value="">All Months</option>
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
    </div>
    <div class="col-md-4">
            <label for="category" class="form-label">Filter by Category:</label>
            <select name="category" id="category" class="form-select">
                <option value="">All Categories</option>
                <?php
                foreach ($categories as $categoryId => $categoryName) {
                    echo "<option value='$categoryId'>$categoryName</option>";
                }
                ?>
            </select>
    </div><div class="col">
            <button type="submit" class="btn btn-primary">Apply Filters</button>
</div>
        </form>
        <div class="box" style="margin: 20px;">

    <table class="table">
    <thead>
    <tr>
        <th>Product Name</th>
        <th>Price</th>
        <th>Sale Amount With Discount</th>
        <th>Quantity Sold</th>
        <th>Total Price</th> 
    </tr>
</thead>
        <tbody>
        <?php


        $totalSalesFilteredCategory = 0;
        $totalSalesFilteredMonth = 0;
        $totalOrdersFilteredCategory = 0; // Initialize total orders for filtered category
        $totalOrdersFilteredMonth = 0;    // Initialize total orders for filtered month
        
        while ($rowTopProducts = mysqli_fetch_assoc($resultTopProducts)) {
            $productPrice = $rowTopProducts['product_price'];
            $discountPercentage = $rowTopProducts['discount_percentage'];
            $totalQuantity = $rowTopProducts['total_quantity'];
            $totalSaleAmount = $rowTopProducts['total_sale_amount'];
        
            $saleAmount = $productPrice - ($productPrice * ($discountPercentage / 100));
        
            $totalPrice = $totalQuantity * $saleAmount; // Calculate the total price
        
            if ($filterCategory) {
                $totalSalesFilteredCategory += $totalPrice; // Accumulate total price instead of total sale amount
                $totalOrdersFilteredCategory++; // Increment total orders for filtered category
            }
        
            if ($filterMonth) {
                $totalSalesFilteredMonth += $totalPrice;
                $totalOrdersFilteredMonth++;    // Increment total orders for filtered month
            }
        
            echo "<tr>";
            echo "<td>{$rowTopProducts['product_name']}</td>";
            echo "<td>{$productPrice}€</td>";
            echo "<td>" . number_format($saleAmount, 2) . "€</td>";
            echo "<td>{$totalQuantity}</td>";
            echo "<td>" . number_format($totalPrice, 2) . "€</td>"; // Display the total price
            echo "</tr>";
        }
        // Display the filtered sales and total orders for the category and month
        if ($filterCategory) {
            echo "<p>Total Sales for Category {$categoryNames[$filterCategory]}: " . number_format($totalSalesFilteredCategory, 2) . "€</p>";
            echo "<p>Total Orders for Category {$categoryNames[$filterCategory]}: $totalOrdersFilteredCategory</p>";
        }
        
        if ($filterMonth) {
            echo "<p>Total Sales for Month {$monthNames[$filterMonth]}: " . number_format($totalSalesFilteredMonth, 2) . "€</p>";
            echo "<p>Total Orders for Month {$monthNames[$filterMonth]}: $totalOrdersFilteredMonth</p>";
        }
        
        ?>
        </tbody>
    </table>
        </div>
        
        <a href="../products/home.php" class="btn btn-secondary">Back to Products</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
