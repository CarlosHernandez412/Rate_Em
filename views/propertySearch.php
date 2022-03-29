<html>
<title>propertySearch</title>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="style.css" rel="stylesheet">
    <style>
      html, body, h1, h2, h3, h4, h5 {font-family: "Open Sans", sans-serif}

      /*CSS Theme Color Generataed */
      .w3-theme-l5 {color:#000 !important; background-color:#eff7fb !important}
      .w3-theme-l4 {color:#000 !important; background-color:#cae4f3 !important}
      .w3-theme-l3 {color:#000 !important; background-color:#95cae6 !important}
      .w3-theme-l2 {color:#fff !important; background-color:#60afda !important}
      .w3-theme-l1 {color:#fff !important; background-color:#2f94ca !important}
      .w3-theme-d1 {color:#fff !important; background-color:#1f6286 !important}
      .w3-theme-d2 {color:#fff !important; background-color:#1c5777 !important}
      .w3-theme-d3 {color:#fff !important; background-color:#184c68 !important}
      .w3-theme-d4 {color:#fff !important; background-color:#154159 !important}
      .w3-theme-d5 {color:#fff !important; background-color:#11364a !important}

      .w3-theme-light {color:#000 !important; background-color:#eff7fb !important}
      .w3-theme-dark {color:#fff !important; background-color:#11364a !important}
      .w3-theme-action {color:#fff !important; background-color:#11364a !important}

      .w3-theme {color:#fff !important; background-color:#236c93 !important}
      .w3-text-theme {color:#236c93 !important}
      .w3-border-theme {border-color:#236c93 !important}

      .w3-hover-theme:hover {color:#fff !important; background-color:#236c93 !important}
      .w3-hover-text-theme:hover {color:#236c93 !important}
      .w3-hover-border-theme:hover {border-color:#236c93 !important}
</style>
<body class="w3-theme-l3">
   <!-- Navbar -->
  <div class="w3-top">
    <div class="w3-bar w3-top w3-left-align w3-large" style="background-color: #E5F2FF;">
      <div class="w3-bar-item w3-hide-small"><img src="../images/myicon.png" height="45px"></div>
      <a href="../views/home.php" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Home</a>
      <a href="../views/choose.html" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Register</a>
      <a href="../views/login.html" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Login</a>
      <a href="../views/aboutus.html" class="w3-bar-item w3-button w3-hide-small w3-hover-white">About Us</a>
      <a href="../views/contact.html" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Contact</a>
    </div>
  </div>
   <!-- Search Bar/filter -->
  <div style="position: relative; left: 0px; top: 55px; max-width: 200px">
  <section class="container" aria-label="filters">
    <form class="search-form" role="search" method="post">
      <input required type="text" autocomplete="off" placeholder="Enter Zip Code" name="zipcode" value="" maxlength="5">
    </form> 
  </div>
  <!-- Home Type Selection -->
  <div class="dropdown" style="position: fixed; left: 200px; top: 55px">
  <button class="dropbtn" onclick="myFunction('Home Type')">Home Type</button>
  <div id="myDropdown" class="dropdown-content">
        <!-- Bedroom Selection -->
        <!--<div tabindex="-1" style="position: relative" for="bedrooms">-->
        <legend>Home Type</legend>  
          <input type="checkbox" onClick="toggle(this)"/>Select All</legend><br>
          <input type="checkbox" id="houses" name="homeType" value="">
          <label for="houses">Houses</label><br>
          <input type="checkbox" id="apartments" name="homeType" value="">
          <label for="apartments">Apartments</label><br>
          <input type="checkbox" id="condos" name="homeType" value="">
          <label for="condos">Condos</label><br>
          <input type="checkbox" id="studios" name="homeType" value="">
          <label for="studio">Studios</label><br>
          <input type="checkbox" id="trailers" name="homeType" value="">
          <label for="trailers">Trailers</label><br>
          <button class="btn" id="btn-search" type="submit" name="filter">Done</button> 
    </div>    
  </div>
  <!-- End of Home Type Selection -->
  <!-- Beds Selection -->
  <div class="dropdown" style="position: fixed; left: 310px; top: 55px">
  <button class="dropbtn" onclick="myFunction('Beds & Baths')">Beds & Baths</button>
  <div id="myDropdown" class="dropdown-content">
        <!-- Bedroom Selection -->
        <!--<div tabindex="-1" style="position: relative" for="bedrooms">-->
        <fieldset class="bed-filter">
        <legend>Bedrooms</legend>  
        <div name="beds-option" class="buttonStyle" role="group">
          <button aria-pressed="false" class="buttonStyle" onclick="filterSelection('any')"> Any </button>
          <button aria-pressed="false" class="buttonStyle" onclick="filterSelection('1+')"> 1+ </button>
          <button aria-pressed="false" class="buttonStyle" onclick="filterSelection('2+')"> 2+ </button>
          <button aria-pressed="false" class="buttonStyle" onclick="filterSelection('3+')"> 3+ </button>
          <button aria-pressed="false" class="buttonStyle" onclick="filterSelection('4+')"> 4+ </button>
        </div>
        </fieldset>
        <!-- Bathroom Selection -->
        <fieldset>
        <legend>Bathrooms</legend>  
        <div name="beds-option" class="buttonStyle" role="group">
          <button aria-pressed="false" class="buttonStyle" onclick="filterSelection('any')"> Any </button>
          <button aria-pressed="false" class="buttonStyle" onclick="filterSelection('1+')"> 1+ </button>
          <button aria-pressed="false" class="buttonStyle" onclick="filterSelection('2+')"> 2+ </button>
          <button aria-pressed="false" class="buttonStyle" onclick="filterSelection('3+')"> 3+ </button>
          <button aria-pressed="false" class="buttonStyle" onclick="filterSelection('4+')"> 4+ </button>
        </div>
        </fieldset>
        <button class="btn" id="btn-search" type="submit" name="filter">Done</button> 
    </div>    
  </div>
  <!-- End of Beds Selection -->
  <!-- Price Selection -->
  <div class="dropdown" style="position: fixed; left: 435px; top: 55px">
  <button class="dropbtn" onclick="myFunction('Price')">Price</button>
  <div id="myDropdown" class="dropdown-content">
    <fieldset class="price-filter">
      <legend>Price Range</legend>  
        <div name="price-option" class="buttonStyle" role="group">
        <div>
          <label for="price-option-min">
            <div>
              <input id="price-option-min" type="tel" placeholder="Min" 
                aria-owns="min-options">
            </div>
          </label>
          <span>-</span>
          <label for="price-option-max">
            <div>
              <input id="price-option-max" type="tel" placeholder="Max" 
                aria-owns="max-options">
            </div>
          </label>
        </div>
        </div>
    </fieldset>
    <button class="btn" id="btn-search" type="submit" name="filter">Done</button> 
    <!-- End of price selection -->
  </section>

<script>
function toggle(source) {
  checkboxes = document.getElementsByName('homeType');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>
</div>
 <!-- Section for map -->
  <div class="split left">
    <div class="w3-center" style="background-color: #E5F2FF; color: black">
    </div>
  </div>
  <!-- Section for results -->
</body>
</html>