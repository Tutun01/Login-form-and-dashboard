<?php
session_start();

require_once 'database.php';
require_once 'vendor/autoload.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
$email = $_SESSION['email'];
$pageTitle = 'Homepage';

$sql= "SELECT * FROM products";
$result = $connect->query($sql); 

$query = "SELECT * FROM products ORDER BY id DESC LIMIT 2";
$result1 = $connect->query($query); 

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiUrl = $_ENV['API_URL'];
$apiKey = $_ENV['API_KEY'];

$url = $apiUrl . "&apiKey=" . $apiKey;

$ch = curl_init($url);

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_HTTPHEADER => [
        'User-Agent: Mozilla/5.0',
        'Accept: application/json'
    ]
]);

$response = curl_exec($ch);

if ($response === false) {
    die('cURL error: ' . curl_error($ch));
}

curl_close($ch);

$data = json_decode($response, true);
$articles = $data['articles'] ?? [];

$cacheDir = __DIR__ . '/cache';
$cacheFile = $cacheDir . '/news.json';
$cacheTime = 300;

if (!is_dir($cacheDir)) {
    mkdir($cacheDir, 0755, true);
}

if (file_exists($cacheFile) && time() - filemtime($cacheFile) < $cacheTime) {
    $data = json_decode(file_get_contents($cacheFile), true);
} else {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_HTTPHEADER => [
            'User-Agent: Mozilla/5.0',
            'Accept: application/json'
        ]
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    if ($response !== false) {
        file_put_contents($cacheFile, $response);
        $data = json_decode($response, true);
    } else {
        $data = [];
    }
}

$articles = $data['articles'] ?? [];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home Page</title>
   <link rel="stylesheet" href="CSS/homepage.css">
   <link rel="stylesheet" href="CSS/navbar.css">
   <link rel="stylesheet" href="CSS/footer.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>


<?php include 'navbar.php'; ?>

<div class="banner">
  <div class="banner-inner">

    <div class="banner-content">
      <h2 class="marquee-title">PC MARKET</h2>
      <p class="marquee-subtitle">High-performance PC components at competitive prices</p>
      <p class="slogan">Your PC. Your Rules.</p>
      <a href="shop.php" class="cta">Shop now</a>
    </div>

    <div class="banner-visual">
    </div>

  </div>
</div>
        
    <section>
        <h2>Hello, <?= htmlspecialchars($email) ?>!</h2>
        <p>Welcome back! Continue building your custom PC or explore new hardware.</p>
        <a href="logout.php" class="logout">Log Out</a>
    </section>

    <section>
        <h2>Tech Blog</h2>
        <div class="slider-container">
            <button class="slide-btn prev">&#10094;</button>
            <div class="slider">
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "
                        <div class='blog-card'>
                            <img src='" . htmlspecialchars($row['image_url']) . "' alt='Product image'>
                            <h3>" . htmlspecialchars($row['name']) . "</h3>
                            <p>" . htmlspecialchars($row['description']) . "</p>
                            <p><strong>Price:</strong> $" . number_format($row['price'], 2) . "</p>
                            <p><strong>In stock:</strong> " . $row['stock'] . "</p>
                            <a href='single_product.php?id=" . $row['id'] . "' class='buyBtn'>Buy Now</a>
                        </div>
                        ";
                    }
                } else {
                    echo "<p>No products available.</p>";
                }
                ?>
            </div>
            <button class="slide-btn next">&#10095;</button>
        </div>
    </section>

    <section>
        <h2>Last added</h2>
        <div class="slider-container">

            <div class="slider">
                <?php
                if (!$result1->num_rows > 0) {
                    echo "<p>No products available.</p>";
                } else {
                   while ($row = $result1->fetch_assoc()) {
                        echo "
                        <div class='blog-card'>
                            <img src='" . htmlspecialchars($row['image_url']) . "' alt='Product image'>
                            <h3>" . htmlspecialchars($row['name']) . "</h3>
                            <p>" . htmlspecialchars($row['description']) . "</p>
                            <p><strong>Price:</strong> $" . number_format($row['price'], 2) . "</p>
                            <p><strong>In stock:</strong> " . $row['stock'] . "</p>
                            <a href='single_product.php?id=" . $row['id'] . "' class='buyBtn'>Buy Now</a>
                        </div>
                        ";
                    }
                }
                ?>
            </div>
        </div>
    </section>

        <section>
        <h2>Tech blogs</h2>
        <div class="slider-container">

           <div class="slider">
                <?php
                if (!empty($data['articles'])) {
                    foreach ($data['articles'] as $article) {

                         $image = !empty($article['urlToImage'])
                            ? htmlspecialchars($article['urlToImage'])
                            : 'images/default-blog.jpg';

                        echo "
                        <div class='blog-card'>
                            <img src='{$image}'  alt='" . htmlspecialchars($article['title']) . "' class='blog-image'>
                            <h3>" . htmlspecialchars($article['title']) . "</h3>
                            <p>" . htmlspecialchars($article['description']) . "</p>
                            <a href='" . htmlspecialchars($article['url']) . "' target='_blank' class='Read_more'>
                                Read more
                            </a>
                        </div>
                        ";
                    }
                } else {
                    echo "<p>No tech blogs available.</p>";
                }
                ?>
            </div>
        
        </div>
    </section>

 <script src="JS/slider.js"></script>

    <?php include 'footer.php'; ?>
</body>
</html>

<?php
$connect->close();
?>
