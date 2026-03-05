<?php
include 'db.php';

$location = isset($_GET['location']) ? $_GET['location'] : '';
$check_in = isset($_GET['check_in']) ? $_GET['check_in'] : '';
$check_out = isset($_GET['check_out']) ? $_GET['check_out'] : '';

$sql = "SELECT * FROM hotels WHERE location LIKE '%$location%'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Listings - Hilton</title>
    <style>
        :root {
            --primary: #002c5f;
            --secondary: #0077c8;
            --accent: #d4a373;
            --light: #f8f9fa;
            --dark: #343a40;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light);
            margin: 0;
            color: var(--dark);
        }
        header {
            background-color: var(--primary);
            color: white;
            padding: 15px 0;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: white;
            text-decoration: none;
        }
        .main-content {
            padding: 40px 0;
            display: flex;
            gap: 30px;
        }
        .filters {
            width: 250px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            height: fit-content;
        }
        .filters h3 {
            margin-top: 0;
            border-bottom: 2px solid var(--accent);
            padding-bottom: 10px;
        }
        .filter-group {
            margin-bottom: 20px;
        }
        .filter-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        .results {
            flex: 1;
        }
        .hotel-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            display: flex;
            transition: transform 0.2s;
        }
        .hotel-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .hotel-card img {
            width: 300px;
            object-fit: cover;
        }
        .hotel-info {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .hotel-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .hotel-title h2 {
            margin: 0 0 5px;
            color: var(--primary);
        }
        .hotel-location {
            color: #666;
            font-size: 0.9em;
        }
        .hotel-rating {
            background: var(--primary);
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
        }
        .amenities {
            margin: 15px 0;
            color: #555;
            font-size: 0.9em;
        }
        .price-area {
            text-align: right;
        }
        .price {
            font-size: 24px;
            font-weight: bold;
            color: var(--dark);
        }
        .btn {
            display: inline-block;
            background-color: var(--secondary);
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 500;
            margin-top: 5px;
        }
        .btn:hover {
            background-color: var(--primary);
        }
        @media (max-width: 768px) {
            .main-content {
                flex-direction: column;
            }
            .filters {
                width: 100%;
            }
            .hotel-card {
                flex-direction: column;
            }
            .hotel-card img {
                width: 100%;
                height: 200px;
            }
        }
    </style>
</head>
<body>

<header>
    <div class="container">
        <nav>
            <a href="index.php" class="logo">Hilton</a>
        </nav>
    </div>
</header>

<div class="container main-content">
    <aside class="filters">
        <h3>Filters</h3>
        <div class="filter-group">
            <label>Price Range</label>
            <input type="range" min="100" max="1000">
        </div>
        <div class="filter-group">
            <label>Star Rating</label>
            <select>
                <option>Any</option>
                <option>5 Stars</option>
                <option>4 Stars</option>
                <option>3 Stars</option>
            </select>
        </div>
        <button class="btn" style="width: 100%">Apply Filters</button>
    </aside>

    <main class="results">
        <h2><?php echo $result->num_rows; ?> Hotels found in "<?php echo htmlspecialchars($location); ?>"</h2>
        
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Get starting price
                $hotel_id = $row['id'];
                $price_sql = "SELECT MIN(price) as min_price FROM rooms WHERE hotel_id = $hotel_id";
                $price_res = $conn->query($price_sql);
                $price_row = $price_res->fetch_assoc();
                $start_price = $price_row['min_price'];

                echo '<div class="hotel-card">';
                echo '<img src="' . $row["image_url"] . '" alt="' . $row["name"] . '">';
                echo '<div class="hotel-info">';
                echo '<div class="hotel-header">';
                echo '<div class="hotel-title">';
                echo '<h2>' . $row["name"] . '</h2>';
                echo '<div class="hotel-location">📍 ' . $row["location"] . '</div>';
                echo '</div>';
                echo '<div class="hotel-rating">' . $row["rating"] . ' ★</div>';
                echo '</div>';
                echo '<div class="amenities">' . $row["amenities"] . '</div>';
                echo '<div class="price-area">';
                echo '<div class="price">From $' . $start_price . '</div>';
                echo '<a href="details.php?id=' . $row["id"] . '" class="btn">View Rooms</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "<p>No hotels found matching your criteria.</p>";
        }
        ?>
    </main>
</div>

</body>
</html>
