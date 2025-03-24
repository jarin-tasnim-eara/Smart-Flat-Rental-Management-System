<?php
include 'dbconnect.php';

// Get flat ID from URL
$flat_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch flat details
$query = "SELECT * FROM flats WHERE id = $flat_id";
$result = mysqli_query($con, $query);
$flat = mysqli_fetch_assoc($result);

// Handle invalid IDs
if (!$flat) {
    die("Invalid flat ID");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($flat['flat_name']); ?> - Aurora Properties</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .main-image { height: 400px; object-fit: cover; }
        .gallery-image { height: 200px; object-fit: cover; }
    </style>
</head>
<body>

    <!-- Navigation Bar (Same as index.php) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">AURORA Properties</a>
            <div class="ms-auto">
                <a href="homepage.html" class="btn btn-outline-light">Login</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card">
            <!-- Main Image -->
            <img src="<?php echo $flat['room_picture']; ?>" class="card-img-top main-image" alt="Main Image">
            
            <div class="card-body">
                <h1 class="card-title"><?php echo htmlspecialchars($flat['flat_name']); ?></h1>
                <h5 class="text-muted"><?php echo htmlspecialchars($flat['location']); ?></h5>
                <h2 class="text-primary my-3">BDT <?php echo number_format($flat['rent']); ?>/month</h2>

                <!-- Details Section -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h4>Property Details</h4>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <strong>Bedrooms:</strong> <?php echo $flat['bedrooms']; ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Bathrooms:</strong> <?php echo $flat['bathrooms']; ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Size:</strong> <?php echo number_format($flat['square_feet']); ?> sq.ft
                            </li>
                        </ul>
                    </div>
                    
                    <div class="col-md-6">
             <h4>Amenities</h4>
             <div class="row">
             <?php 
              $amenities = !empty($flat['amenities']) ? json_decode($flat['amenities'], true) : [];
                if (!empty($amenities)) {
                 foreach ($amenities as $amenity): ?>
                <div class="col-6 mb-2">
                    <span class="badge bg-primary"><?php echo htmlspecialchars($amenity); ?></span>
                </div>
            <?php endforeach; 
                } else { ?>
            <div class="col-12">
                <p class="text-muted">No amenities listed</p>
            </div>
        <?php } ?>
    </div>
</div>
                </div>

                <!-- Image Gallery -->
                <h4>Gallery</h4>
                <div class="row g-3">
                    <?php 
                    $additional_images = json_decode($flat['additional_images'], true);
                    foreach ($additional_images as $img): ?>
                        <div class="col-md-4">
                            <img src="<?php echo $img; ?>" class="img-fluid gallery-image rounded">
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Contact Section -->
                <div class="mt-4 border-top pt-3">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <a href="mailto:<?php echo $flat['contact_email']; ?>" class="btn btn-primary w-100">Email Owner</a>
                        </div>
                        <div class="col-md-6">
                            <a href="tel:<?php echo $flat['contact_phone']; ?>" class="btn btn-primary w-100">Call Owner</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
