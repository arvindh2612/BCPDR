<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Vendor Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: #1e1e2f;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #eee;
    }
    nav.navbar {
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.4);
      background-color: #141423 !important;
    }
    .container {
      max-width: 1200px;
    }
    h1.page-title {
      font-weight: 800;
      color: #f8f9fa;
      margin: 2rem 0 3rem;
      text-align: center;
      letter-spacing: 1.2px;
      text-transform: uppercase;
      user-select: none;
    }
    .section-title {
      font-weight: 700;
      font-size: 1.6rem;
      margin: 2rem 0 1.2rem;
      position: relative;
      padding-bottom: 0.3rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #ddd;
      user-select: none;
    }
    .section-title::after {
      content: '';
      position: absolute;
      width: 60px;
      height: 3px;
      background: #4e8cff;
      left: 0;
      bottom: 0;
      border-radius: 2px;
    }
    .section {
      padding: 1.5rem 1rem;
      border-radius: 12px;
      margin-bottom: 3rem;
      box-shadow: 0 6px 20px rgb(0 0 0 / 0.8);
    }
    .section.masters {
      background: linear-gradient(135deg, #141c3a, #273259);
    }
    .section.repositories {
      background: linear-gradient(135deg, #1b2e1b, #2f4f2f);
    }
    .card {
      background: #2c2c3ecc;
      border: none;
      border-radius: 15px;
      box-shadow: 0 6px 18px rgb(0 0 0 / 0.8);
      transition: all 0.3s ease;
      color: #eee;
      font-weight: 600;
      cursor: pointer;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 1.3rem;
      text-align: center;
    }
    .card:hover {
      background: #f8f9fa;
      color: #222;
      box-shadow: 0 12px 25px rgb(78 140 255 / 0.8);
      transform: translateY(-6px) scale(1.05);
      text-decoration: none;
    }
    .card h5 {
      margin: 0;
      font-size: 1.1rem;
      letter-spacing: 0.7px;
    }
    a.text-decoration-none:hover {
      text-decoration: none;
    }
    @media (max-width: 576px) {
      .section {
        padding: 1rem;
      }
      .card h5 {
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand fs-4" href="#">FINPRO TECHNOLOGIES</a>
    <a href="../A_panel/login.php" class="btn btn-danger">Logout</a>
  </div>
</nav>

<div class="container py-4">

  <h1 class="page-title">Vendor Dashboard</h1>

  <!-- Masters Section -->
  <section class="section masters">
    <h4 class="section-title">Masters</h4>
    <div class="row g-4">
     
      <div class="col-6 col-md-3">
        <a href="../Employee_access/E_location_list.php" class="text-decoration-none">
          <div class="card">
            <h5>Location Master</h5>
          </div>
        </a>
      </div>
      <div class="col-6 col-md-3">
        <a href="V_vendor_category_list.php" class="text-decoration-none">
          <div class="card">
            <h5>Vendor Category Master</h5>
          </div>
        </a>
      </div>
      <div class="col-6 col-md-3">
        <a href="../Employee_access/E_city_master_list.php" class="text-decoration-none">
          <div class="card">
            <h5>City Master</h5>
          </div>
        </a>
      </div>
      <div class="col-6 col-md-3">
        <a href="../Employee_access/E_state_master_list.php" class="text-decoration-none">
          <div class="card">
            <h5>State Master</h5>
          </div>
        </a>
      </div>
    </div>
  </section>
 <!-- Repository Section -->
  <section class="section repositories">
    <h4 class="section-title">Repositories</h4>
    <div class="row g-4">
      <div class="col-6 col-md-4 col-lg-3">
        <a href="../Asset_class_master/add_asset_class.php" class="text-decoration-none">
          <div class="card">
            <h5>Asset Class Repository</h5>
          </div>
        </a>
      </div>
      <div class="col-6 col-md-4 col-lg-3">
        <a href="../Asset_master/add_asset_master.php" class="text-decoration-none">
          <div class="card">
            <h5>Asset Repository</h5>
          </div>
        </a>
      </div>
      
 </div>
  </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
