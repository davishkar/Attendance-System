<?php
// index.php
?>
<!DOCTYPE html>
<html lang="mr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>हरिमंदिर - बालोपासना</title>
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
      font-weight: bold;
      letter-spacing: 1px;
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
      font-size: 1rem;
      transition: color 0.3s, transform 0.2s;
    }

    nav ul li a:hover {
      color: #fffde7;
      transform: scale(1.05);
    }

    .hero {
      background: linear-gradient(90deg, #ebe8e5ff, #ebe8e5ff);
      text-align: center;
      padding: 70px 20px;
      color: #4e342e;
      background-blend-mode: lighten;
    }

    .hero h2 {
      font-size: 2.4rem;
      margin-bottom: 20px;
      color: #bf360c;
      text-shadow: 1px 1px 3px rgba(255, 255, 255, 0.8);
    }

    .hero p {
      max-width: 750px;
      margin: auto;
      font-size: 1.2rem;
      color: #4e342e;
      background: rgba(255, 248, 225, 0.8);
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 25px;
      padding: 50px 20px;
      max-width: 1100px;
      margin: auto;
    }

    .card {
      background: #fff3e0;
      padding: 25px;
      border-radius: 16px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.15);
      transition: transform 0.3s, box-shadow 0.3s;
      text-align: center;
      border: 2px solid #ffe0b2;
      cursor: pointer;
    }

    .card:hover {
      transform: translateY(-6px);
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
      background: #ffe0b2;
    }

    .card h3 {
      margin-bottom: 12px;
      color: #e65100;
      font-size: 1.4rem;
    }

    .card p {
      color: #4e342e;
      font-size: 1rem;
    }

    footer {
      background: #ef6c00;
      color: white;
      text-align: center;
      padding: 20px 10px;
      margin-top: 30px;
      box-shadow: 0 -2px 6px rgba(0,0,0,0.2);
    }

    footer p {
      margin: 6px 0;
      font-size: 0.95rem;
    }

    @media (max-width: 600px) {
      header {
        flex-direction: column;
        text-align: center;
      }
      nav ul {
        flex-direction: column;
        gap: 10px;
        margin-top: 10px;
      }
      .hero h2 {
        font-size: 2rem;
      }
      .hero p {
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header>
    <h1>श्रीहरिमंदिर</h1>
    <nav>
      <ul>
        <li><a href="index.php">मुख्यपृष्ठ</a></li>
        <li><a href="upasthiti.php">उपस्थिती</a></li>
        <li><a href="suchna.php">सूचना</a></li>
        <li><a href="shikvani.php">शिक्षवणी</a></li>
      </ul>
    </nav>
  </header>

  <!-- Hero / Introduction -->
  <section class="hero">
    <h2>बालोपासना परिचय</h2>
    <p>
      बालोपासना ही लहान मुलांसाठीची एक संस्कारपर पद्धत आहे जिच्यामध्ये मुलांच्या मनावर 
      भक्ती, सद्गुण, शिस्त आणि समाजकार्यासाठीची जाणीव निर्माण केली जाते. मंदिरे ही 
      केवळ उपासनेची जागा नसून ती संस्कारांचे केंद्र असतात. येथे मुलांना प्रार्थना, 
      भजने, श्लोक व विविध सांस्कृतिक कार्यक्रमांच्या माध्यमातून संस्कार दिले जातात.
      ही प्रक्रिया मुलांमध्ये भक्तीची बीजे पेरते आणि त्यांना जीवनातील योग्य मार्गावर 
      नेते.
    </p>
  </section>

  <!-- Cards -->
  <section class="cards">
    <div class="card" onclick="window.location.href='upasthiti.php'">
      <h3>उपस्थिती</h3>
      <p>विद्यार्थ्यांची उपस्थिती सहज नोंदवण्यासाठीची सोय येथे उपलब्ध आहे.</p>
    </div>
    <div class="card" onclick="window.location.href='suchna.php'">
      <h3>सूचना</h3>
      <p>सर्व महत्वाच्या सूचना, कार्यक्रमाची माहिती आणि दैनंदिन अपडेट्स येथे पाहता येतील.</p>
    </div>
    <div class="card" onclick="window.location.href='shikvani.php'">
      <h3>शिक्षवणी</h3>
      <p>भजन, कीर्तन, श्लोक आणि प्रेरणादायी शिक्षण सामग्री यासाठीचा विभाग.</p>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; <?php echo date("Y"); ?> हरिमंदिर. सर्व हक्क राखीव.</p>
    <p>सेवा, भक्ती आणि संस्कार यांच्यासाठी विकसित केलेले.</p>
  </footer>

</body>
</html>
