CREATE TABLE IF NOT EXISTS hotels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    description TEXT,
    rating DECIMAL(2,1),
    image_url VARCHAR(255),
    amenities TEXT
);

CREATE TABLE IF NOT EXISTS rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hotel_id INT,
    room_type VARCHAR(50),
    price DECIMAL(10,2),
    capacity INT,
    description TEXT,
    image_url VARCHAR(255),
    FOREIGN KEY (hotel_id) REFERENCES hotels(id)
);

CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_id INT,
    user_name VARCHAR(100),
    user_email VARCHAR(100),
    check_in DATE,
    check_out DATE,
    total_price DECIMAL(10,2),
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (room_id) REFERENCES rooms(id)
);

-- Insert dummy data
INSERT INTO hotels (name, location, description, rating, image_url, amenities) VALUES
('Hilton Garden Inn', 'New York', 'Experience luxury in the heart of NYC.', 4.8, 'https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80', 'Free Wi-Fi, Pool, Gym, Spa'),
('Hilton Los Angeles', 'Los Angeles', 'Relaxation and comfort in sunny LA.', 4.5, 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80', 'Free Wi-Fi, Pool, Beach Access'),
('Hilton Chicago', 'Chicago', 'Iconic hotel with stunning views of the city.', 4.7, 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80', 'Free Wi-Fi, Gym, Conference Center'),
('Hilton Miami Downtown', 'Miami', 'Modern hotel near the best attractions.', 4.6, 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80', 'Free Wi-Fi, Pool, Rooftop Bar');

INSERT INTO rooms (hotel_id, room_type, price, capacity, description, image_url) VALUES
(1, 'King Room', 250.00, 2, 'Spacious room with a King-sized bed.', 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'),
(1, 'Double Queen', 280.00, 4, 'Two Queen beds, perfect for families.', 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'),
(2, 'Ocean View Suite', 350.00, 2, 'Suite with a breathtaking view of the ocean.', 'https://images.unsplash.com/photo-1590490360182-c33d57733427?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'),
(3, 'Executive Suite', 400.00, 2, 'Luxury suite with executive lounge access.', 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'),
(4, 'Standard Room', 180.00, 2, 'Comfortable room with all amenities.', 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
