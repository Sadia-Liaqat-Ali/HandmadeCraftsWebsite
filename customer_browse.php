<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Browse Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f3e6ff; }
    .container { background: white; padding: 30px; margin-top: 40px; border-radius: 15px; box-shadow: 0 0 25px rgba(106, 13, 173, 0.2); }
    h3 { color: #6a0dad; text-align: center; margin-bottom: 30px; font-weight: bold; }
    .card { background-color: #6a0dad; color: white; border: none; position: relative; overflow: hidden; transition: transform 0.3s ease; }
    .card:hover { transform: scale(1.02); box-shadow: 0 5px 20px rgba(106, 13, 173, 0.3); }
    .card img { border-radius: 10px 10px 0 0; width: 100%; height: 200px; object-fit: cover; }
    .category-label { position: absolute; top: 10px; left: 10px; background-color: rgba(255,255,255,0.85); color: #6a0dad; font-weight: bold; padding: 5px 10px; border-radius: 20px; font-size: 14px; }
    .btn-custom { margin-top: 5px; transition: 0.3s ease-in-out; }
    .btn-custom:hover { transform: scale(1.05); box-shadow: 0 4px 12px rgba(255, 255, 255, 0.3); }
    .btn-light.btn-custom { background-color: white; color: #6a0dad; font-weight: bold; border: 2px solid #6a0dad; }
    .btn-light.btn-custom:hover { background-color: #6a0dad; color: white; }
    .btn-outline-light.btn-custom { border: 2px solid #ff69b4; color: #ff69b4; font-weight: bold; }
    .btn-outline-light.btn-custom:hover { background-color: #ff69b4; color: white; }
    .btn-group .btn { width: 48%; }
    .filter-form input, .filter-form select { margin-bottom: 10px; }
  </style>
</head>
<body>

<?php include 'user_navbar.php'; ?>

<div class="container">
  <h3>Browse Handmade Products</h3>

  <form method="GET" class="row filter-form">
    <div class="col-md-3">
      <input type="text" name="search" class="form-control" placeholder="Search by name, artisan or category">
    </div>
    <div class="col-md-2">
      <input type="number" name="min_price" class="form-control" placeholder="Min Price">
    </div>
    <div class="col-md-2">
      <input type="number" name="max_price" class="form-control" placeholder="Max Price">
    </div>
    <div class="col-md-2">
      <select name="availability" class="form-control">
        <option value="">All</option>
        <option value="1">In Stock</option>
        <option value="0">Out of Stock</option>
      </select>
    </div>
    <div class="col-md-3">
      <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
    </div>
  </form>

  <div class="row mt-4">
    <?php
    $query = "
      SELECT product.*, artisan.name AS artisan_name 
      FROM product 
      LEFT JOIN artisan ON product.saller_id = artisan.id 
      WHERE product.status = 'Approved'
    ";

    // Apply search filters
    if (!empty($_GET['search'])) {
      $search = $conn->real_escape_string($_GET['search']);
      $query .= " AND (
        product.name LIKE '%$search%' 
        OR product.category LIKE '%$search%' 
        OR artisan.name LIKE '%$search%'
      )";
    }

    if (!empty($_GET['min_price'])) {
      $query .= " AND product.price >= " . intval($_GET['min_price']);
    }

    if (!empty($_GET['max_price'])) {
      $query .= " AND product.price <= " . intval($_GET['max_price']);
    }

    if (isset($_GET['availability']) && $_GET['availability'] !== "") {
      $stockCheck = $_GET['availability'] == "1" ? "> 0" : "= 0";
      $query .= " AND product.stock $stockCheck";
    }

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        ?>
        <div class="col-md-4 mb-4">
          <div class="card">
            <div class="category-label"><?php echo htmlspecialchars($row['category']); ?></div>
            <img src="uploads/<?php echo $row['image']; ?>" class="card-img-top">
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
              <p class="card-text">
                Rs. <?php echo $row['price']; ?> | Stock: <?php echo $row['stock']; ?><br>
                Artisan: <strong><?php echo htmlspecialchars($row['artisan_name']); ?></strong>
              </p>

              <div class="btn-group d-flex">
                <a href="product_page.php?id=<?php echo $row['id']; ?>" class="btn btn-light btn-custom">View</a>
                <form method="POST" action="wishlist.php" class="w-100 ms-2">
                  <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                  <button type="submit" name="add_to_wishlist" class="btn btn-outline-light btn-custom">❤ Wishlist</button>
                </form>
              </div>

              <form method="POST" action="cart.php">
                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
                <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                <input type="number" name="quantity" value="1" min="1" max="<?php echo $row['stock']; ?>" class="form-control mt-2" required>
                <button type="submit" name="add_to_cart" class="btn btn-success w-100 btn-custom">Add to Cart</button>
              </form>
            </div>
          </div>
        </div>
        <?php
      }
    } else {
      echo "<p class='text-center text-muted'>No approved products found matching your filters.</p>";
    }
    ?>
  </div>
</div>

</body>
</html>
