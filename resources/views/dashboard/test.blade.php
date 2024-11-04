<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users - Warehouse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" type="text/css" >
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="{{ asset('js/index.js') }}"></script>

</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
      <header id="home">
        <nav class="navbar">
          <div class="logo">PT.BERANDA</div>
          
          <ul class="nav_items" id="nav_links">
              <li><a href="#home">home</a></li>
              <li><a href="#aboutus">about</a></li>
              <li><a href="#services">services</a></li>
              <li><a href="#footer">contact</a></li>
          </ul>

          <div class="nav_btns">
              <a href="{{ url('/login') }}" class="btnsignin">Sign In</a>
              <a href="{{ url('/signup') }}" class="btnsignup">Sign Up</a>
          </div>
      </nav>
      <section class="main">
        <!-- <video autoplay loop muted play-incline class="back-video"> <source src="Background.mp4" type="video/mp4">
        </video> -->
         <div class="left">
         <h1>PT.BERANDA</h1>
         <p>"Menggerakkan bisnis Anda dengan solusi logistik yang cepat, andal, dan efisien, karena kesuksesan Anda adalah prioritas kami."
         </p>
      <div class="btnmain">
      <a href="{{ url('/login') }}" class="btnmain1">Explore More</a>
      <!-- <button class="btnmain2">Explore More</button> -->
      <!-- <a href="{{ url('/dashboard') }}" class="btnmain2">Start Tracking</a> -->
      </div>
         </div>
      <div class="right">
        <img src="{{ asset('/images/warehouse2.png') }}" alt="">
      </div>
      </section>
      </header>
      <section class="about us" id="aboutus">
        <div class="head">
          <h3 class="sub_heading">About Us</h3>
          <p class="para">
            Selamat datang di SIGAP, mitra terpercaya dalam menyediakan solusi logistik yang efisien dan inovatif. Sejak didirikan, kami berkomitmen untuk membantu bisnis Anda bergerak lebih cepat, lebih jauh, dan lebih aman. Dengan jaringan distribusi yang luas dan tim profesional yang berpengalaman, kami siap menjadi bagian dari perjalanan kesuksesan Anda.
          </p>
          <h1 class="heading">Solusi untuk kebutuhan bisnis anda</h1>
        </div>
      <div class="boxes">
            <div class="box">
                <i class='bx bxs-package'></i>
                <h4>solusi pengiriman</h4>
        <p>dengan solusi rantai pasokan yang ditingkatkan akan mempercepat bisnis Anda
            sekaligus meningkatkan efisiensi
        </p>
            </div>
            <div class="box">
                <i class='bx bx-dock-left' ></i>
                <h4>simpanan semua dokumen</h4>
                <p>kami menyediakan penyimpanan cloud untuk menyimpan semua dokumen Anda.
                    Jangan khawatir kehilangan dokumen pengiriman apapun
                </p>
            </div>
            <div class="box">
                <i class='bx bxs-check-shield' ></i>
                <h4>aman dan andal</h4>
                <p>pantau semua logistik dalam genggaman Anda. Logistik Anda aman,
                   Anda bisa tidur tanpa khawatir lagi
                </p>
            </div>
        </div>
     </section>
     <!-- Service -->
     <section class="service" id="services">
      <div class="head_1">
          <h3 class="sub_heading">Product</h3>
          <h1 class="heading">everything is ready to <br>transport</h1>
          <!-- <p class="para">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa ab nobis provident, voluptates dolor voluptas fugiat. Delectus nihil magnam quam, similique doloremque tempore sit fuga, ducimus quaerat, nemo cumque dicta?</p> -->
      </div>
      
      <section class="product">
        <h2 class="product-category">Our Product</h2>
        <button class="pre-btn"><i class='bx bxs-left-arrow'></i></button>
        <button class="nxt-btn"><i class='bx bxs-right-arrow'></i></button>
        
        <div class="product-container">
            <!-- First Product Card -->
            <div class="product-card">
                <div class="product-image">
                    <span class="discount-tag">20% Off</span>
                    <img src="{{ asset('/images/pngflow.com-1.png') }}" class="product-thumb" alt="Product Image">
                    <button class="card-btn">Add to Cart</button>
                </div>
                <div class="product-info">
                    <h2 class="product-brand">Brand</h2>
                    <p class="product-desc">A short product description</p>
                    <span class="price">Rp. 50.000</span>
                </div>
            </div>
    
            <!-- Second Product Card -->
            <div class="product-card">
                <div class="product-image">
                    <span class="discount-tag">20% Off</span>
                    <img src="{{ asset('/images/tepung.jpg') }}" class="product-thumb" alt="Product Image">
                    <button class="card-btn">Add to Cart</button>
                </div>
                <div class="product-info">
                    <h2 class="product-brand">Brand</h2>
                    <p class="product-desc">A short product description</p>
                    <span class="price">Rp. 50.000</span>
                </div>
            </div>
    
            <!-- Third Product Card -->
            <div class="product-card">
                <div class="product-image">
                    <span class="discount-tag">20% Off</span>
                    <img src="{{ asset('/images/gula.jpeg') }}" class="product-thumb" alt="Product Image">
                    <button class="card-btn">Add to Cart</button>
                </div>
                <div class="product-info">
                    <h2 class="product-brand">Brand</h2>
                    <p class="product-desc">A short product description</p>
                    <span class="price">Rp. 50.000</span>
                </div>
            </div>

            <div class="product-card">
                <div class="product-image">
                    <span class="discount-tag">20% Off</span>
                    <img src="pngflow.com-1.png" class="product-thumb" alt="Product Image">
                    <button class="card-btn">Add to Cart</button>
                </div>
                <div class="product-info">
                    <h2 class="product-brand">Brand</h2>
                    <p class="product-desc">A short product description</p>
                    <span class="price">Rp. 50.000</span>
                </div>
            </div>
            <div class="product-card">
                <div class="product-image">
                    <span class="discount-tag">20% Off</span>
                    <img src="pngflow.com-1.png" class="product-thumb" alt="Product Image">
                    <button class="card-btn">Add to Cart</button>
                </div>
                <div class="product-info">
                    <h2 class="product-brand">Brand</h2>
                    <p class="product-desc">A short product description</p>
                    <span class="price">Rp. 50.000</span>
                </div>
            </div>

        </div>
    </section>
<!-- Routes -->
  <section class="route" id="route">
    <div class="head_1">
       <h3 class="sub_heading">what we provide</h3>
       <h1 class="heading">deliver your logistics safely <br>and quickly</h1>
    </div>

    <div class="boxes_1">
       <div class="box_1">
          <span><i class="ri-price-tag-3-fill"></i></span>
          <h4>competitive pricing</h4>
       </div>
       <div class="box_1">
          <span><i class="ri-money-rupee-circle-fill"></i></span>
          <h4>customer servives</h4>
       </div>
       <div class="box_1">
          <span><i class="ri-bank-card-fill"></i></span>
          <h4>most flexible payment plans</h4>
       </div>
       <div class="box_1">
          <span><i class="ri-ship-2-fill"></i></span>
          <h4>ocean frieghting service</h4>
       </div>
       <div class="box_1">
          <span><i class="ri-customer-service-2-fill"></i></span>
          <h4>roadside assistance 24/7</h4>
       </div>
       <img src="" alt="">
  </div>
 </section>
 <footer>
    <div class="footer_container" id="footer">
        <div class="footer_col">
            <h4>Perusahaan</h4>
            <ul>
                <li><a href="#">Tentang Kami</a></li>
                <li><a href="#">Layanan</a></li>
                <li><a href="#">Karir</a></li>
                <li><a href="#">Kontak</a></li>
            </ul>
        </div>
        <div class="footer_col">
            <h4>Layanan</h4>
            <ul>
                <li><a href="#">Pengiriman Domestik</a></li>
                <li><a href="#">Pengiriman Internasional</a></li>
                <li><a href="#">Manajemen Logistik</a></li>
                <li><a href="#">Penyimpanan</a></li>
            </ul>
        </div>
        <div class="footer_col">
            <h4>Hubungi Kami</h4>
            <p>Gedung Nani Kampus C UNAIR, Indonesia</p>
            <p>Email: SIGAP@perusahaanlogistik.com</p>
            <p>Telepon: (021) 999-99987</p>
        </div>
        <div class="footer_col">
            <h4>Ikuti Kami</h4>
            <div class="social_links">
                <a href="#"><i class='bx bxl-facebook'></i></a>
                <a href="#"><i class='bx bxl-twitter'></i></a>
                <a href="#"><i class='bx bxl-instagram'></i></a>
                <a href="#"><i class='bx bxl-linkedin'></i></a>
                <a href="#"><i class='bx bxl-tiktok'></i></a>
                <a href="#"><i class='bx bxl-whatsapp' ></i></a>
            </div>
        </div>
    </div>
    <div class="footer_bottom">
        <p>&copy; SIGAP. Semua Hak Dilindungi.</p>
    </div>
</footer>
      <script src="https://unpkg.com/scrollreveal"></script>
      <script src="{{ asset('js/index.js') }}" ></script>

</script>

</body>
</html>
