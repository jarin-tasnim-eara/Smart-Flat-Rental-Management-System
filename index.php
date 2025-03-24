<?php
include 'dbconnect.php'; // Ensure database connection

// Get search input
$search_area = isset($_GET['search_area']) ? trim($_GET['search_area']) : '';
$minRent = isset($_GET['min_rent']) ? $_GET['min_rent'] : "";
$maxRent = isset($_GET['max_rent']) ? $_GET['max_rent'] : "";

$query = "SELECT * FROM flats WHERE 1=1";
if (!empty($search_area)) {
    $search_area = mysqli_real_escape_string($con, $search_area);
    $query .= " AND location LIKE '%$search_area%'";
}
if (!empty($minRent)) {
    $query .= " AND rent >= $minRent";
}
if (!empty($maxRent)) {
    $query .= " AND rent <= $maxRent";
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
        body {
            background-image: url('https://images.unsplash.com/photo-1564937494144-59898c6afbd2?q=80&w=1523&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
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

        <!-- Search and Filter Form -->
        <form method="GET" action="">
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search_area" placeholder="Search by area" value="<?php echo htmlspecialchars($search_area); ?>">
                </div>
                <div class="col-md-3">
                    <input type="number" class="form-control" name="min_rent" placeholder="Min Rent" value="<?php echo $minRent; ?>">
                </div>
                <div class="col-md-3">
                    <input type="number" class="form-control" name="max_rent" placeholder="Max Rent" value="<?php echo $maxRent; ?>">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" type="submit">Filter</button>
                </div>
            </div>
        </form>

        <div class="row">
            <?php 
            if (mysqli_num_rows($result) > 0) { // Check if rows exist
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="col-md-4">
                        <div class="card flat-card">
                            <img src="<?php echo $row['room_picture']; ?>" class="card-img-top" alt="Flat Image">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['flat_name']; ?></h5>
                                <p class="card-text"><?php echo $row['location']; ?> | BDT <?php echo number_format($row['rent']); ?></p>
                                <p><?php echo substr($row['description'], 0, 70); ?></p>
                                <a href="flat_details.php?id=<?php echo $row['id']; ?>" class="btn btn-info w-100 mt-2">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php } 
            } else { ?>
                <p class="text-center text-danger">No flats found.</p>
            <?php } ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
