<?php
include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$hotel_id = $_GET['id'];
$hotel_sql = "SELECT * FROM hotels WHERE id = $hotel_id";
$hotel_result = $conn->query($hotel_sql);
$hotel = $hotel_result->fetch_assoc();

$rooms_sql = "SELECT * FROM rooms WHERE hotel_id = $hotel_id";
$rooms_result = $conn->query($rooms_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $hotel['name']; ?> - Hilton</title>
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
        .hotel-hero {
            height: 400px;
            position: relative;
            color: white;
            display: flex;
            align-items: flex-end;
            padding-bottom: 50px;
        }
        .hotel-hero::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: url('<?php echo $hotel['image_url']; ?>');
            background-size: cover;
            background-position: center;
            filter: brightness(0.6);
            z-index: -1;
        }
        .hero-content h1 {
            font-size: 48px;
            margin: 0;
        }
        .hero-content p {
            font-size: 20px;
            margin: 10px 0 0;
        }
        .content-section {
            background: white;
            margin: -30px auto 50px;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            position: relative;
        }
        .section-header {
            border-bottom: 2px solid #eee;
            margin-bottom: 30px;
            padding-bottom: 20px;
        }
        .rooms-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        .room-card {
            border: 1px solid #eee;
            border-radius: 8px;
            overflow: hidden;
            transition: box-shadow 0.3s;
        }
        .room-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .room-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .room-info {
            padding: 20px;
        }
        .room-info h3 {
            margin: 0 0 10px;
            color: var(--primary);
        }
        .room-price {
            font-size: 24px;
            font-weight: bold;
            color: var(--dark);
            margin: 10px 0;
        }
        .btn-book {
            display: block;
            background-color: var(--secondary);
            color: white;
            padding: 12px;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin-top: 15px;
        }
        .btn-book:hover {
            background-color: var(--primary);
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

<div class="hotel-hero">
    <div class="container hero-content">
        <h1><?php echo $hotel['name']; ?></h1>
        <p>📍 <?php echo $hotel['location']; ?></p>
    </div>
</div>

<div class="container content-section">
    <div class="section-header">
        <h2>About this Hotel</h2>
        <p><?php echo $hotel['description']; ?></p>
        <p><strong>Amenities:</strong> <?php echo $hotel['amenities']; ?></p>
    </div>

    <h2>Available Rooms</h2>
    <div class="rooms-list">
        <?php
        if ($rooms_result->num_rows > 0) {
            while($room = $rooms_result->fetch_assoc()) {
                echo '<div class="room-card">';
                echo '<img src="' . $room["image_url"] . '" alt="' . $room["room_type"] . '">';
                echo '<div class="room-info">';
                echo '<h3>' . $room["room_type"] . '</h3>';
                echo '<p>' . $room["description"] . '</p>';
                echo '<p>Capacity: ' . $room["capacity"] . ' Person(s)</p>';
                echo '<div class="room-price">$' . $room["price"] . ' / night</div>';
                echo '<a href="booking.php?room_id=' . $room["id"] . '" class="btn-book">Book Now</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "No rooms available.";
        }
        ?>
    </div>
</div>

</body>
</html>
