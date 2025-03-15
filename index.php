<?php
include 'dbconnect.php'; // Ensure database connection

// Get search input
$search_area = isset($_GET['search_area']) ? trim($_GET['search_area']) : '';

$query = "SELECT * FROM flats";
if (!empty($search_area)) {
    $search_area = mysqli_real_escape_string($con, $search_area);
    $query .= " WHERE location LIKE '%$search_area%'";
}
$query .= " ORDER BY id DESC";

$result = mysqli_query($con, $query);

if (!$result) {
    die("Database Query Failed: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Flat Rental</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .flat-card { margin-bottom: 20px; }
        .flat-card img { width: 100%; height: 200px; object-fit: cover; }
        .additional-images img { width: 100px; height: 100px; object-fit: cover; margin: 5px; }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">AURORA Properties</a>
            <div class="ms-auto">
                <a href="homepage.html" class="btn btn-outline-light">Login</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center">Find Your Perfect Flat</h2>

        <!-- Search Bar -->
        <form method="GET" action="">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="search_area" placeholder="Search by area" value="<?php echo htmlspecialchars($search_area); ?>">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>

        <div class="row">
            <?php 
            if (mysqli_num_rows($result) > 0) { // Check if rows exist
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="col-md-4">
                        <div class="card flat-card">
                            <!-- Main Image -->
                            <img src="<?php echo $row['room_picture']; ?>" class="card-img-top" alt="Flat Image">

                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['flat_name']; ?></h5>
                                <p class="card-text"><?php echo $row['location']; ?> | BDT <?php echo number_format($row['rent']); ?></p>
                                <p><?php echo substr($row['description'], 0, 70); ?></p>

                                <!-- Additional Images (Initially Hidden) -->
                                <?php 
                                $additional_images = json_decode($row['additional_images'], true);
                                if (!empty($additional_images) && is_array($additional_images)) { ?>
                                    <div class="additional-images mt-2" id="images-<?php echo $row['id']; ?>" style="display: none;">
                                        <strong>More Images:</strong>
                                        <div class="d-flex flex-wrap">
                                            <?php foreach ($additional_images as $img) { ?>
                                                <img src="<?php echo $img; ?>" class="img-thumbnail">
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                
                                <!-- View Details Button -->
                                <button class="btn btn-info w-100 mt-2" onclick="toggleImages(<?php echo $row['id']; ?>)">View Details</button>
                                <a class="btn btn-primary w-100 mt-2" href="homepage.html">Email</a>
                                <a class="btn btn-primary w-100 mt-2" href="homepage.html">Call</a>
                            </div>
                        </div>
                    </div>
                <?php } 
            } else { ?>
                <p class="text-center text-danger">No flats found.</p>
            <?php } ?>
        </div>
    </div>

    <!-- JavaScript to Toggle Additional Images -->
    <script>
        function toggleImages(flatId) {
            var imagesDiv = document.getElementById("images-" + flatId);
            if (imagesDiv) {
                imagesDiv.style.display = imagesDiv.style.display === "none" ? "block" : "none";
            }
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
