<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hilton Hotels & Resorts</title>
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
            margin: 0;
            padding: 0;
            background-color: var(--light);
            color: var(--dark);
        }
        header {
            background-color: var(--primary);
            color: white;
            padding: 20px 0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
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
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: 500;
        }
        .hero {
            background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
            height: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }
        .search-box {
            background: white;
            padding: 30px;
            border-radius: 8px;
            display: flex;
            gap: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            flex-wrap: wrap;
            justify-content: center;
        }
        .search-box input, .search-box select {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 200px;
        }
        .search-box button {
            background-color: var(--secondary);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }
        .search-box button:hover {
            background-color: var(--primary);
        }
        .section-title {
            text-align: center;
            margin: 50px 0 30px;
            font-size: 32px;
            color: var(--primary);
        }
        .hotels-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }
        .hotel-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .hotel-card:hover {
            transform: translateY(-5px);
        }
        .hotel-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .hotel-info {
            padding: 20px;
        }
        .hotel-info h3 {
            margin: 0 0 10px;
            color: var(--primary);
        }
        .hotel-info p {
            color: #666;
            margin-bottom: 15px;
        }
        .rating {
            color: #f39c12;
            font-weight: bold;
        }
        .btn {
            display: inline-block;
            background-color: var(--primary);
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: var(--secondary);
        }
        footer {
            background-color: var(--dark);
            color: white;
            text-align: center;
            padding: 30px 0;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<header>
    <div class="container">
        <nav>
            <div class="logo">Hilton</div>
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="listings.php">Hotels</a>
                <a href="#">Offers</a>
                <a href="#">My Trips</a>
            </div>
        </nav>
    </div>
</header>

<div class="hero">
    <div class="container">
        <h1>Stay with us, stay inspired.</h1>
        <form action="listings.php" method="GET" class="search-box">
            <input type="text" name="location" placeholder="Where are you going?" required>
            <input type="date" name="check_in" required>
            <input type="date" name="check_out" required>
            <button type="submit">Find a Hotel</button>
        </form>
    </div>
</div>

<div class="container">
    <h2 class="section-title">Featured Destinations</h2>
    <div class="hotels-grid">
        <?php
        $sql = "SELECT * FROM hotels LIMIT 3";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="hotel-card">';
                echo '<img src="' . $row["image_url"] . '" alt="' . $row["name"] . '">';
                echo '<div class="hotel-info">';
                echo '<h3>' . $row["name"] . '</h3>';
                echo '<p>' . $row["location"] . '</p>';
                echo '<div class="rating">★ ' . $row["rating"] . '</div>';
                echo '<p>' . substr($row["description"], 0, 100) . '...</p>';
                echo '<a href="details.php?id=' . $row["id"] . '" class="btn">View Rooms</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "No hotels found.";
        }
        ?>
    </div>
</div>

<footer>
    <div class="container">
        <p>&copy; 2026 Hilton Hotels Clone. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
