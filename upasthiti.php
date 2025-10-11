<?php
// upasthiti.php
?>
<!DOCTYPE html>
<html lang="mr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>उपस्थिती - हरिमंदिर</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Segoe UI", sans-serif;
    }

    body {
      background: #fff8e1;
      color: #3e2723;
      line-height: 1.6;
    }

    header {
      background: linear-gradient(90deg, #ff9800, #f57c00);
      color: white;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    header h1 {
      font-size: 1.8rem;
    }

    nav ul {
      list-style: none;
      display: flex;
      gap: 25px;
    }

    nav ul li a {
      color: white;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s;
    }

    nav ul li a:hover {
      color: #fffde7;
    }

    .title {
      text-align: center;
      padding: 30px 10px;
      font-size: 2rem;
      font-weight: bold;
      color: #e65100;
    }

    .branches {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
      max-width: 1000px;
      margin: auto;
      padding: 20px;
    }

    .branch-card {
      background: #fff3e0;
      border: 2px solid #ffe0b2;
      border-radius: 12px;
      text-align: center;
      padding: 20px;
      cursor: pointer;
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .branch-card:hover {
      transform: translateY(-5px);
      background: #ffe0b2;
      box-shadow: 0 6px 12px rgba(0,0,0,0.2);
    }

    .branch-card h3 {
      color: #d84315;
      font-size: 1.2rem;
    }

    footer {
      background: #ef6c00;
      color: white;
      text-align: center;
      padding: 20px 10px;
      margin-top: 30px;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header>
    <h1>हरिमंदिर</h1>
    <nav>
      <ul>
        <li><a href="index.php">मुख्यपृष्ठ</a></li>
        <li><a href="upasthiti.php">उपस्थिती</a></li>
        <li><a href="suchna.php">सूचना</a></li>
        <li><a href="shikvani.php">शिक्षवणी</a></li>
      </ul>
    </nav>
  </header>

  <!-- Title -->
  <div class="title">शाखा निवडा</div>

  <!-- Branch Cards -->
  <section class="branches">
    <?php
    $branches = [
      "शाखा १", "शाखा २", "शाखा ३", "शाखा ४", "शाखा ५", "शाखा ६",
      "शाखा ७", "शाखा ८", "शाखा ९", "शाखा १०", "शाखा ११", "शाखा १२", "शाखा १३"
    ];
    foreach ($branches as $index => $branch) {
      echo "<div class='branch-card' onclick=\"window.location.href='login.php?branch=".($index+1)."'\">";
      echo "<h3>$branch</h3>";
      echo "</div>";
    }
    ?>
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; <?php echo date("Y"); ?> हरिमंदिर. सर्व हक्क राखीव.</p>
  </footer>

</body>
</html>
