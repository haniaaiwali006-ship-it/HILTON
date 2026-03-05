<?php
include 'db.php';

$room_id = '';
$message = '';
$room = null;

if (isset($_GET['room_id'])) {
    $room_id = $_GET['room_id'];
    $sql = "SELECT r.*, h.name as hotel_name FROM rooms r JOIN hotels h ON r.hotel_id = h.id WHERE r.id = $room_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $room = $result->fetch_assoc();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_id = $_POST['room_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    // Calculate total price
    $date1 = date_create($check_in);
    $date2 = date_create($check_out);
    $diff = date_diff($date1, $date2);
    $days = $diff->format("%a");
    
    // Fetch room price again to be safe
    $room_res = $conn->query("SELECT price FROM rooms WHERE id = $room_id");
    $room_data = $room_res->fetch_assoc();
    $total_price = $room_data['price'] * $days;

    $stmt = $conn->prepare("INSERT INTO bookings (room_id, user_name, user_email, check_in, check_out, total_price) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssd", $room_id, $name, $email, $check_in, $check_out, $total_price);

    if ($stmt->execute()) {
        $message = "Booking confirmed! Total Price: $" . $total_price;
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Room - Hilton</title>
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
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .booking-container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 400px;
            max-width: 90%;
        }
        .booking-container h2 {
            margin-top: 0;
            color: var(--primary);
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .btn-submit {
            width: 100%;
            background-color: var(--secondary);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
        }
        .btn-submit:hover {
            background-color: var(--primary);
        }
        .message {
            text-align: center;
            padding: 20px;
            background: #d4edda;
            color: #155724;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .room-summary {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 0.9em;
        }
        .home-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: var(--secondary);
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="booking-container">
    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
        <a href="index.php" class="home-link">Return to Home</a>
    <?php elseif ($room): ?>
        <h2>Confirm Booking</h2>
        <div class="room-summary">
            <strong>Hotel:</strong> <?php echo $room['hotel_name']; ?><br>
            <strong>Room:</strong> <?php echo $room['room_type']; ?><br>
            <strong>Price:</strong> $<?php echo $room['price']; ?> / night
        </div>
        <form method="POST" action="">
            <input type="hidden" name="room_id" value="<?php echo $room['id']; ?>">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Check-in Date</label>
                <input type="date" name="check_in" required>
            </div>
            <div class="form-group">
                <label>Check-out Date</label>
                <input type="date" name="check_out" required>
            </div>
            <button type="submit" class="btn-submit">Complete Reservation</button>
        </form>
    <?php else: ?>
        <p>Invalid room selection. <a href="index.php">Go back</a></p>
    <?php endif; ?>
</div>

</body>
</html>
