<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

    <title>Landing Page</title>
    <script src="https://cdn.tailwindcss.com"></script>


    <!-- Custom CSS for responsiveness -->
<style>
    /* section {
        padding-top: 4rem;
        padding-bottom: 4rem;
    } */

    /* Make image and text section responsive */
    .lg\:flex-row {
        display: flex;
        flex-direction: row;
    }

    .lg\:w-2\/5 {
        width: 40%;
    }

    .lg\:w-3\/5 {
        width: 60%;
    }

    /* For smaller screens */
    @media (max-width: 1024px) {
        section {
            padding-top: 3rem;
            padding-bottom: 3rem;
        }

        .lg\:w-2\/5, .lg\:w-3\/5 {
            width: 100%; /* Stack image and text on smaller screens */
        }
    }

    @media (max-width: 768px) {
        section {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .lg\:w-2\/5, .lg\:w-3\/5 {
            width: 100%; /* Stack image and text on smaller screens */
        }
    }

    @media (max-width: 480px) {
        section {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .lg\:w-2\/5, .lg\:w-3\/5 {
            width: 100%; /* Stack image and text on smaller screens */
        }
        
    }


    /* Navbar font styling */
.text-playfair {
    font-family: 'Playfair Display', serif;
}

.font-bold {
    font-weight: bold;
}

/* Adjust any additional navbar font styling if necessary */
.navbar {
    font-family: 'Nunito Sans', sans-serif;
}


/* Font for headings */
.font-playfair {
    font-family: 'Playfair Display', serif;
}

/* Font for body text */
.font-nunito {
    font-family: 'Nunito Sans', sans-serif;
}

  /* Font for headings */
.font-playfair {
    font-family: 'Playfair Display', serif;
}

/* Font for body text */
.font-nunito {
    font-family: 'Nunito Sans', sans-serif;
}

/* Font for headings */
.font-playfair {
    font-family: 'Playfair Display', serif;
}
/* Font for headings (Playfair Display) */
.font-playfair {
    font-family: 'Playfair Display', serif;
}

/* Font for body text (Nunito Sans) */
.font-nunito {
    font-family: 'Nunito Sans', sans-serif;
}

@media (max-width: 768px) {
    .form-section {
        padding-left: 0.25rem;
        padding-right: 1rem;
    }

    .form-wrapper {
        flex-direction: column; /* Stack the form fields vertically */
        gap: 12px; /* Add space between fields */
        width: 100%; /* Full width for mobile */
    }

    .form-field {
        flex: 1; /* Ensure each field takes full width */
        margin-bottom: 1rem; /* Add margin between fields */
    }

    .form-select {
        width: 100%; /* Full width for select inputs */
        padding: 0.8rem; /* Adjust padding for mobile */
    }

    .form-button {
        width: 100%; /* Make button full width on mobile */
        padding: 1rem;
        margin-top: 1rem;
    }

}
@media (max-width: 768px) {
    /* Ensure the form stays horizontal but adjusts for small screens */
    .py-0.px-4.mt-[-20px].bg-white form {
        flex-direction: row; /* Ensure the form stays horizontal */
        flex-wrap: wrap;      /* Allow wrapping of fields when needed */
        gap: 10px;            /* Reduce the gap between fields */
    }

    /* Adjust width of form fields for mobile */
    .py-0.px-4.mt-[-20px].bg-white form .flex-1 {
        width: calc(50% - 12px); /* Adjust width to allow 2 items per row */
        margin-bottom: 10px;     /* Space between fields */
    }

    /* Make select and button elements full width on smaller screens */
    .py-0.px-4.mt-[-20px].bg-white form select,
    .py-0.px-4.mt-[-20px].bg-white form button {
        width: 100%; /* Full width for select and button elements */
        padding: 12px; /* Adjust padding for smaller devices */
    }

    /* Adjust font sizes for better readability */
    .py-0.px-4.mt-[-20px].bg-white form label {
        font-size: 14px; /* Slightly smaller font size for labels */
    }

    .py-0.px-4.mt-[-20px].bg-white form select {
        font-size: 14px; /* Adjust select dropdown font size */
    }

    /* Ensure the submit button is centered and has appropriate padding */
    .py-0.px-4.mt-[-20px].bg-white form button {
        width: 100%; /* Full width for button on small screens */
        padding: 12px; /* Adjust padding */
    }
}
@media (max-width: 360px) and (max-height: 640px) {
    /* Ensure the form stays horizontal but adjusts for small screens */
    .py-0.px-4.mt-[-20px].bg-white form {
        flex-direction: row; /* Ensure the form stays horizontal */
        flex-wrap: wrap;      /* Allow wrapping of fields when needed */
        gap: 8px;             /* Reduce the gap between fields */
    }

    /* Adjust width of form fields to allow them to fit better */
    .py-0.px-4.mt-[-20px].bg-white form .flex-1 {
        width: calc(50% - 6px); /* Adjust width to allow 2 items per row */
        margin-bottom: 8px;     /* Space between fields */
    }

    /* Make select and button elements full width on small screens */
    .py-0.px-4.mt-[-20px].bg-white form select,
    .py-0.px-4.mt-[-20px].bg-white form button {
        width: 100%; /* Full width for select and button elements */
        padding: 10px; /* Adjust padding for smaller devices */
    }

    /* Adjust font sizes for better readability */
    .py-0.px-4.mt-[-20px].bg-white form label {
        font-size: 12px; /* Smaller font size for labels */
    }

    .py-0.px-4.mt-[-20px].bg-white form select {
        font-size: 12px; /* Smaller font size for select dropdown */
    }

    /* Ensure the submit button takes the full width */
    .py-0.px-4.mt-[-20px].bg-white form button {
        width: 100%; /* Full width for button */
        padding: 10px; /* Adjust padding for the button */
    }
}

.hero-section {
  background-size: cover; /* Ensure the image covers the section */
  background-position: bottom center; /* Adjusts background to the bottom center */
  height: 45vh; /* Reduced height for desktop */
  background-attachment: scroll; /* Ensures background scrolls with the page */
  background-repeat: no-repeat; /* Prevents repeating the background image */
  background-size: 100% 100%; /* Ensures background is scaled properly */
}

/* Mobile View */
@media (max-width: 768px) {
    .hero-section {
      background-size: 509% 143%;
        background-position: center bottom;
        height: 62vh;
    }
}
/* For 360x640 size phones */
@media (max-width: 768px) {
    .hero-section {
      background-size: 509% 143%;
        background-position: center bottom;
        height: 62vh;
    }
}

/* ========================================================================= */
 /* Default horizontal layout for the form (Desktop view) */
 form {
  display: flex;
  flex-wrap: wrap; /* Allows wrapping */
  width: 100%; /* Ensure the form takes up full width */
  gap: 0.5rem; /* Space between fields */
  padding: 1.5rem; /* Increased form padding for extra height */
  margin-top: 0rem; /* Adds margin on top of the form */
  border-radius: 8px; /* Optional: Rounded corners for better design */
  max-width: 100%; /* Ensures the form doesn't exceed its parent's width */
  margin-left: auto; /* Centers the form horizontally */
  margin-right: auto; /* Centers the form horizontally */
  
  background-color: rgba(2, 0, 0, 0.3); /* Transparent white background */
  color: rgb(0, 0, 0); /* Text color inside the form is white */
}


/* Ensure text within form inputs is styled properly */
form select,
form input {
  font-size: 1rem; /* Default font size */
  padding: 0.75rem; /* Slight padding for input fields */
  border: 1px solid #ccc; /* Light border for inputs */
  border-radius: 4px; /* Slight rounding of inputs */
  background-color: #fff; /* Ensure background is white inside inputs */
}

/* Styling for each div inside the form */
form > div {
  flex: 1 1 250px; /* Increased min-width for larger screens */
  min-width: 50px; /* Prevent fields from shrinking too much */
}

.age-input {
  width: 3.8rem; /* Slightly increased width for age fields */
  text-align: center; /* Center align input text */
}

/* Mobile-specific adjustments */
@media (max-width: 768px) {
  body {
    display: flex;
    flex-direction: column;
    justify-content: flex-start; /* Keeps the form from sticking to the bottom */
    min-height: 100vh;
    margin: 0; /* Removes extra spacing */
    overflow-x: hidden; /* Prevents horizontal scrolling */
  }

  form {
    gap: 0.6rem; /* Slightly increased gap for mobile */
    margin-top: 0rem; /* Adds a bit of space from the top */
    margin-bottom: 0rem; /* Keeps some space from the bottom */
    width: 100%; /* Occupies the full width of the screen */
    padding: 1rem; /* Adds padding for usability */
    background-color: rgba(255, 255, 255, 0.7); /* White with 70% opacity for transparency */
    border-radius: 8px; /* Optional: rounded corners */
    border: 2px solid rgba(0, 0, 0, 0.5); /* Black border with 50% opacity */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Black shadow for the effect */
}



  /* Compact inputs and buttons in mobile view */
  form select,
  form input {
    font-size: 0.9rem; /* Slightly larger font size for better readability */
    padding: 0.5rem; /* Increased padding for usability */
    width: 100%; /* Full width for mobile */
    box-sizing: border-box; /* Includes padding in the width calculation */
  }

  .age-input {
    width: 100%; /* Full width for age fields on mobile */
    text-align: center; /* Center align input text */
  }

  /* Reduced width of specific fields (e.g., Religion, Mother Tongue) */
  .flex-1 {
    flex: 1 1 100%; /* Full width for all flexible items */
  }

  form button {
    font-size: 0.9rem; /* Slightly larger font size for better usability */
    padding: 0.5rem 0.8rem; /* Adjust padding */
    width: 100%; /* Full width button */
  }
}

/* Prevent zooming and scaling on mobile */
@viewport {
  width: device-width;
  initial-scale: 1.0; /* Prevents zooming */
  maximum-scale: 1.0; /* Disables pinch-zoom */
  user-scalable: no; /* Disables user zooming */
}


  /* ================== */
  /* nav bar spicfoc */
 /* Maroon color class */
 .text-maroon {
      color: #800000; /* Maroon Red */
  }


/* ======================================================================== */
/* Logo Section Styles */
.text-2xl {
    font-size: 1.5rem; /* Adjust font size for text */
}

.font-bold {
    font-weight: bold; /* Keep the bold styling */
}

.flex {
    display: flex; /* Use flexbox for alignment */
    align-items: center; /* Vertically center the items */
    justify-content: center; /* Horizontally center the items */
}

.items-center {
    align-items: center; /* Ensure logo is vertically aligned */
}

.mr-3 {
    margin-right: -2.25rem; /* Space between the logo and text */
}

.h-16 {
    height: 4rem; /* Set the logo height (adjustable) */
    width: auto; /* Ensure the aspect ratio of the logo is preserved */
}

/* Mobile-specific adjustments */
@media (max-width: 768px) {
    .text-2xl {
        font-size: 1.25rem; /* Slightly smaller font size for mobile */
    }

    .h-16 {
        height: 2rem; /* Adjust logo size for smaller screens */
    }
}

/* -------------------- */


/* Adjust the height of the navbar for better spacing */
nav {
  height: 82px; /* Increased navbar height */
  position: relative; /* Ensure mobile menu is positioned relative to navbar */
}
/* ============ */

/* Default logo size */
/* Default styles for the logo image */
/* Default styles for the logo image */
.logo-img {
  margin-right: 0.75rem; /* mr-3 equivalent */
    height: 2.75rem; /* h-7 equivalent */
    width: 105px;
}

/* Mobile-specific adjustments */
@media (max-width: 768px) {
  .logo-img {
    margin-top: 0rem; /* Adds margin to the top of the logo on mobile */
    height: 2rem; /* Adjust height to match the new size you want for mobile */
  }
}



/* Default size for desktop */
h2 {
    font-size: 1.25rem; /* Adjust to your preferred desktop size */
  }

  /* Mobile-specific adjustments */
  @media (max-width: 768px) {
    h2 {
      font-size: 1rem; /* Smaller font size for mobile */
    }
  }
  /* =============== */
/* For 360x640 size phones */
@media (max-width: 360px) and (max-height: 640px) {
  .hero-section {
    background-size: 170% 170%; /* Larger zoom effect for smaller mobile devices */
    background-position: center center; /* Centering the background */
    height: 45vh; /* Adjust height for better appearance */
  }
}

/* Mobile-specific adjustments (up to 768px) */
@media (max-width: 768px) {
  .hero-section {
    background-size: 509% 143%; /* Background zoom for mobile */
    background-position: center bottom; /* Position background bottom */
    height: 50vh; /* Reduced height for mobile */
  }
}

/* For larger viewports (desktops, tablets, etc.) */
@media (min-width: 769px) {
  .hero-section {
    background-size: cover; /* Default background size for larger screens */
    background-position: bottom center; /* Keep background at the bottom */
    height: 80vh; /* Height for desktop view */
  }
}

.hero-section {
  background-image: url('<?php echo e(asset('themeAssets/images/mainbanner_enhanced.jpg')); ?>'); /* Background image */
  background-size: cover; /* Ensure the image covers the section */
  background-position: center center; /* Center the background image */
  background-repeat: no-repeat; /* Prevent repeating the background image */
  width: 100%; /* Full width of the parent container */
  height: 60vh; /* Set height to 60% of the viewport height */
}
/* ================================ */

@media (max-width: 640px) {
    section {
        padding-left: 16px; /* Adjust padding for mobile view */
        padding-right: 16px;
    }
    .max-w-screen-xl {
        max-width: 100%; /* Ensure container is full width */
    }
    .w-full {
        width: 100% !important; /* Ensure the sections take full width on mobile */
    }
    .sm\:w-1\/4 {
        width: 100% !important; /* Override 25% width on mobile */
    }
    .mb-8 {
        margin-bottom: 0px; /* Adjust bottom margin for mobile */
    }
}
/* ====================================== */
 /* General section styling */
 @media (max-width: 767px) {
  .bg-[#A31622] {
    padding: 2rem 1.5rem; /* Add padding for mobile */
  }

  .max-w-screen-xl {
    max-width: 100%;
  }

  .grid {
    display: flex;
    flex-direction: row; /* Arrange items horizontally */
    flex-wrap: nowrap; /* Ensure no wrapping */
    overflow-x: auto; /* Allow horizontal scrolling */
    gap: 1rem; /* Add spacing between the items */
  }

  .grid > div {
    flex: 0 0 auto; /* Prevent items from shrinking or stretching */
    min-width: 200px; /* Ensure each section has a minimum width */
    box-sizing: border-box;
  }

  h3 {
    font-size: 1.25rem; /* Adjust heading size for mobile */
    margin-bottom: 0.5rem;
  }

  ul {
    padding-left: 0;
  }

  li {
    font-size: 0.875rem; /* Adjust font size for list items */
  }

  a {
    font-size: 0.875rem; /* Adjust font size for links */
  }

  .hover\:text-red-500:hover {
    color: #e53e3e; /* Adjust hover color */
  }
}

/* ====== */
@media (max-width: 767px) {
  .bg-[#A31622] {
    padding: 2rem 1.5rem; /* Add padding for mobile */
  }

  .max-w-screen-xl {
    max-width: 100%;
  }

  .grid {
    display: flex;
    flex-direction: row; /* Arrange items horizontally */
    flex-wrap: nowrap; /* Prevent wrapping */
    overflow-x: auto; /* Enable horizontal scrolling */
    gap: 1rem; /* Add spacing between the elements */
  }

  .grid > div {
    flex: 0 0 auto; /* Ensure each section has a fixed width */
    min-width: 200px; /* Set a minimum width for each section */
    box-sizing: border-box;
  }

  h3 {
    font-size: 1.25rem; /* Adjust heading size for mobile */
    margin-bottom: 0.5rem;
  }

  ul {
    padding-left: 0;
  }

 
  
  a {
    font-size: 0.875rem; /* Adjust font size for links */
  }

  .hover\:text-red-500:hover {
    color: #e53e3e; /* Adjust hover color */
  }
}
/* ============================================================ */
</style>
<style>
 /* Default Styles */
.container {
  display: flex;
  overflow: hidden;
  position: relative;
  width: 100%;
  background-color: #A31622; /* Keep the same background color */
}

.grid {
  display: grid;
  grid-template-columns: repeat(6, 1fr); /* 6 columns by default */
  gap: 16px;
}

.grid > div {
  padding: 10px;
}

/* Heading Styles */
h3 {
  font-family: 'Playfair Display', serif;
  color: white;
  margin-bottom: 0px;
  font-size: 1.25rem;
}

ul {
  font-family: 'Nunito Sans', sans-serif;
  color: white;
}

a {
  text-decoration: none;
}

a:hover {
  color: #e50914; /* Hover color for links */
}

/* Mobile View Styles */
/* Mobile View Styles */
@media (max-width: 768px) {
  .container {
    display: flex;
    flex-direction: column; /* Align items vertically */
    gap: 16px; /* Space between the rows */
  }

  .grid {
    display: grid; /* Use grid layout */
    grid-template-rows: repeat(6, 1fr); /* 6 rows */
    gap: 8px; /* Reduced gap between items */
  }

  .grid > div {
    padding: 10px 15px; /* Add padding for better spacing */
   
  }

  h3 {
    font-size: 1rem; /* Slightly smaller font size for titles */
    margin-bottom: 10px; /* Space below the title */
  }

  ul {
    padding-left: 15px; /* Adjust padding */
    margin-top: 0;
  }

  a {
    font-size: 0.9rem; /* Smaller font size for links */
  }

  /* Prevent overflow and ensure text stays within screen width */
  .grid > div {
    word-wrap: break-word; /* Wrap text if it overflows */
    overflow: hidden; /* Ensure no horizontal scroll */
    text-overflow: ellipsis; /* Add ellipsis if text overflows */
  }
}
/* ========== */


/* Mobile Adjustments */
@media (max-width: 768px) {
    .grid {
        grid-template-columns: 1fr; /* Single column layout for the grid */
    }

    /* Center the title (h3) */
    .grid h3 {
        text-align: center;
        margin-bottom: 0rem; /* Adjust space below the heading */
    }

    /* Make the ul horizontally scrollable */
    .grid ul {
        display: flex; /* Flex layout */
        padding: 0; /* Remove default padding */
        margin: 0; /* Remove default margin */
        overflow-x: auto; /* Enable horizontal scrolling */
        white-space: nowrap; /* Prevent words from breaking */
    }

    /* Ensure each li takes up no more than 25% of the container width */
    .grid ul li {
        font-size: 0.9rem; /* Smaller font size for mobile */
        display: inline-block; /* Keeps items in a row */
        width: auto; /* Let the li take its content size */
        padding: 5px 10px; /* Add padding around the text */
        text-align: center; /* Ensure text is centered inside the link */
    }

    .grid ul a {
        display: block;
        text-decoration: none; /* Remove underline */
    }
    .container {
        height: 200px; /* Set height for mobile */
    }
}
/* ================================aboutus--------------- */
.footer-section-container {
  display: flex; /* Arrange items horizontally */
  justify-content: space-between; /* Distribute the sections evenly */
  gap: 16px; /* Adjust the gap between sections */
}

.footer-section {
  width: 33%; /* Make each section take up 1/3 of the container */
  text-align: center; /* Center the content */
}

.footer-heading {
  font-size: 1.25rem; /* Adjust font size */
  font-weight: bold; /* Make the font bold */
  color: #000; /* Set text color */
  margin-bottom: 10px; /* Adjust margin as needed */
}

/* Responsive Mobile View */
@media (max-width: 767px) {
  .footer-section-container {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr; /* 3 equal columns */
    gap: 16px; /* Space between sections */
  }

  .footer-section {
    width: 100%; /* Ensure each section takes up full width on mobile */
  }
}
/* ========= */
.custom-link {
    font-size: 0.9rem; /* Default small font size */
}

@media (max-width: 767px) {
    .custom-link {
        font-size: 0.8rem; /* Smaller font size for mobile view */
    }
}
.footer-section-container {
    background-color: #f5f5dc; /* Change to your desired color */
}
/* =================== */
 /* Initially, the mobile menu is hidden */
/* Initially, the mobile menu is hidden */
#mobile-menu {
    display: none;
}

/* Show the mobile menu when the menu toggle has the "active" class */
#menu-toggle.active + #mobile-menu {
    display: block;
}

/* Show the hamburger icon on mobile view */
@media (max-width: 1024px) {
    .menu-toggle {
        display: block;
        font-size: 30px; /* Adjust the size of the hamburger icon */
        margin-left: 10px; /* Add margin to the left of the button */
        margin-right: 10px; /* Add margin to the right of the button */
    }

    /* Hide the desktop menu */
    .lg\\:flex {
        display: none;
    }

    /* Display the mobile menu */
    .mobile-menu {
        display: block;
        margin-left: 10px; /* Add left margin */
        margin-right: 10px; /* Add right margin */
    }

    /* Adjust the padding of mobile menu */
    .mobile-menu a {
        padding: 10px 0;
    }
}

/* Hide the hamburger icon on desktop view */
@media (min-width: 1025px) {
    .menu-toggle {
        display: none;
    }

    /* Show the desktop menu */
    .lg\\:flex {
        display: flex;
    }
    
    /* Style the desktop links */
    .menu-link {
        margin-left: 10px;
        margin-right: 10px;
    }
}


</style>

    
</head>
<body class="bg-gray-100">
<!-- Navbar -->
<nav class="bg-white shadow-md py- 9 flex justify-between">
  <div class="text-2xl font-bold flex items-center">
    <img src="<?php echo e(asset('themeAssets/images/logo.svg')); ?>" alt="Bright Matrimony Logo" class="mr-3 logo-img" style="height: 4rem; margin-top: 0rem; margin-left: 12px;">
  </div>
  
  <div>
    <!-- Menu Icon for Mobile -->
    <div class="lg:hidden">
        <button id="menu-toggle" class="menu-toggle">
            &#9776; <!-- Hamburger Icon -->
        </button>
    </div>

    <!-- Navigation Links (Desktop) -->
    <div class="lg:flex hidden">
        <!-- Login Link -->
        <a href="/login" class="menu-link">
            Login
        </a>

      <!-- Support Link -->
<a href="<?php echo e(url('/support')); ?>" class="menu-link">
  Support
</a>

      
    </div>

    <!-- Mobile Menu (Hidden by default) -->
    <div id="mobile-menu" class="lg:hidden hidden text-white py-4">
      <!-- Login Button (Mobile) -->
      <a href="/login" class="font-bold mx-4 text-lg flex items-center bg-black text-white px-3 py-1 rounded-lg hover:bg-gray-800 transition-colors mb-3">
        <i class="fas fa-sign-in-alt mr-2"></i> Login
      </a>
 <!-- Support Button (Mobile) -->
<a href="<?php echo e(url('/support')); ?>" class="font-bold mx-4 text-lg flex items-center bg-black text-white px-3 py-1 rounded-lg hover:bg-gray-800 transition-colors">
  <i class="fas fa-headset mr-2"></i> Support
</a>

    </div>
    
    
   
</div>

<script>
 document.getElementById('menu-toggle').addEventListener('click', function() {
    // Toggle the active class to show the mobile menu
    this.classList.toggle('active');
    
    // Toggle the visibility of the mobile menu
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenu.style.display === 'block') {
        mobileMenu.style.display = 'none';
    } else {
        mobileMenu.style.display = 'block';
    }
});
</script>

  <!-- Mobile Menu (Hidden by default) -->
 <!-- Mobile Menu (Hidden by default) -->


</nav>


<section class="hero-section" style="background-image: url('<?php echo e(asset('themeAssets/images/mainbanner_enhanced.jpg')); ?>'); ">
  <!-- Content goes here (e.g., heading, buttons, etc.) -->
</section>


<body class="bg-gray-100 flex items-center justify-center min-h-screen">
<form class="w-full max-w-6xl p-6">    <!-- Looking For and Age From/To in the same row -->
    <div class="flex flex-row gap-4">
      <div class="flex flex-col flex-1">
        <label for="looking_for" class="text-xs text-gray-700 font-medium">Looking For</label>
        <select id="looking_for" name="looking_for" class="border border-gray-300 rounded-lg px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="">Select</option>
          <option value="bride">Bride</option>
          <option value="groom">Groom</option>
        </select>
      </div>
  
      <div class="flex flex-col flex-1">
        <label for="age_from" class="text-xs text-gray-700 font-medium">Age From</label>
        <input type="number" id="age_from" name="age_from" placeholder="From" class="age-input border border-gray-300 rounded-lg px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>
  
      <div class="flex flex-col flex-1">
        <label for="age_to" class="text-xs text-gray-700 font-medium">Age To</label>
        <input type="number" id="age_to" name="age_to" placeholder="To" class="age-input border border-gray-300 rounded-lg px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>
    </div>
  
    <!-- Religion and Mother Tongue in the same row -->
    <div class="flex flex-row gap-4">
      <div class="flex flex-col flex-1">
        <label for="religion" class="text-xs text-gray-700 font-medium">Religion</label>
        <select id="religion" name="religion" class="border border-gray-300 rounded-lg px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="">Select</option>
          <option value="hindu">Hindu</option>
          <option value="muslim">Muslim</option>
          <option value="christian">Christian</option>
          <option value="other">Other</option>
        </select>
      </div>
  
      <div class="flex flex-col flex-1">
        <label for="mother_tongue" class="text-xs text-gray-700 font-medium">Mother Tongue</label>
        <select id="mother_tongue" name="mother_tongue" class="border border-gray-300 rounded-lg px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="">Select</option>
          <option value="english">English</option>
          <option value="hindi">Hindi</option>
          <option value="tamil">Tamil</option>
          <option value="other">Other</option>
        </select>
      </div>
    </div>
  
    <!-- Submit Button -->
    <div class="flex items-center justify-center row-break">
      <button type="submit" href="/register" class="bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-2 text-xs rounded-lg font-semibold shadow-md hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 transition-all">
        Lets Begin!
      </button>
    </div>
  </form>
  
</body>



    <!-- Responsive Three-Column Section with Circular Images -->

    <section class="py-8 px-4" style="background-color: #f9f0f0;"> <!-- Reduced padding on the section -->
      <div class="max-w-screen-xl mx-auto text-center">
          <h2 class="text-2xl font-bold mb-6 text-gray-800 font-playfair">Trusted Premium Matrimony Service for Your Perfect Match.</h2> <!-- Reduced font size for heading -->
          <div class="mb-4">
              <img src="<?php echo e(asset('themeAssets/images/title-border.svg')); ?>" alt="Title Border" class="mx-auto w-full max-w-[50%] h-auto"> <!-- Reduced width of title border -->
          </div>
          
          <!-- Flexbox Wrapper for Services -->
          <div class="flex flex-col md:flex-row justify-between gap-1"> <!-- Reduced gap between boxes -->
              <!-- Service 1 -->
              <div class="flex flex-col items-center bg-white p-2 rounded-lg shadow-lg border border-gray-300 w-full md:w-1/4 mb-2 h-[12%]"> <!-- Reduced padding, margin, and height -->
                  <img src="<?php echo e(asset('themeAssets/images/feature-01.svg')); ?>" alt="Service 1" class="w-10 h-10 rounded-full object-cover mb-2 border-4 border-beige"> <!-- Reduced image size -->
                  <h3 class="text-base font-semibold mb-1 text-gray-800 font-playfair">100% Confidential</h3> <!-- Reduced font size -->
                  <p class="text-gray-700 mb-1 font-nunito text-xs">With 100% confidentiality, your personal information and conversations remain private, allowing you to connect securely and comfortably.</p> <!-- Reduced text size -->
              </div>
  
              <!-- Service 2 -->
              <div class="flex flex-col items-center bg-white p-2 rounded-lg shadow-lg border border-gray-300 w-full md:w-1/4 mb-2 h-[12%]"> <!-- Reduced padding, margin, and height -->
                  <img src="<?php echo e(asset('themeAssets/images/feature-02.svg')); ?>" alt="Service 2" class="w-10 h-10 rounded-full object-cover mb-2 border-4 border-beige"> <!-- Reduced image size -->
                  <h3 class="text-base font-semibold mb-1 text-gray-800 font-playfair">Verified Profiles</h3> <!-- Reduced font size -->
                  <p class="text-gray-700 mb-1 font-nunito text-xs">Our verified profiles ensure that every user is genuine, helping you connect with real individuals for meaningful relationships.</p> <!-- Reduced text size -->
              </div>
  
              <!-- Service 3 -->
              <div class="flex flex-col items-center bg-white p-2 rounded-lg shadow-lg border border-gray-300 w-full md:w-1/4 mb-2 h-[12%]"> <!-- Reduced padding, margin, and height -->
                  <img src="<?php echo e(asset('themeAssets/images/feature-03.svg')); ?>" alt="Service 3" class="w-10 h-10 rounded-full object-cover mb-2 border-4 border-beige"> <!-- Reduced image size -->
                  <h3 class="text-base font-semibold mb-1 text-gray-800 font-playfair">Advanced Search Filters</h3> <!-- Reduced font size -->
                  <p class="text-gray-700 mb-1 font-nunito text-xs">Our advanced search filters allow you to customize your search criteria, making it easier to find your ideal match quickly and efficiently.</p> <!-- Reduced text size -->
              </div>
          </div>
      </div>
  </section>
  
    
    <section class="py-4 px-8 bg-[#f5f5dc]">
        <div class="max-w-screen-xl mx-auto text-center">
            <!-- Title Border Image -->
            <div class="mb-4">
                <img src="<?php echo e(asset('themeAssets/images/title-border.svg')); ?>" alt="Title Border" class="mx-auto w-full max-w-[50%] h-auto">
            </div>
            
            <!-- Text (Below Image) -->
            <!-- Text (Below Image) -->
<h2 class="text-2xl font-bold text-gray-800 mb-2 font-playfair" style="line-height: 1.4;">
  Why Choose Us
</h2>
<h2 class="text-lg font-light text-gray-800 font-playfair" style="line-height: 1.4;">
  "Discover true connections built on trust, safety, and lasting compatibility."
</h2>



        </div>
    </section>
    

<!-- Why Choose Us Section -->
<!-- Why Choose Us Section -->
<section class="py-6 px-6" style="background-color:#f9f0f0;">
  <div class="max-w-screen-xl mx-auto flex flex-col lg:flex-row justify-between items-center gap-4">
      <!-- Image (Left Side) -->
      <div class="flex-1 w-full lg:w-2/5">
          <img src="<?php echo e(asset('themeAssets/images/chose.png')); ?>" alt="Why Choose Us" class="w-56 h-40 object-cover rounded-md mx-auto">
      </div>

      <!-- Text (Right Side) -->
      <div class="flex-1 w-full lg:w-3/5">
        <!-- Heading -->
       

        <!-- Subheading -->
       
    
        <!-- List -->
        <ul class="list-disc pl-5 text-black text-sm text-center lg:text-left" 
            style="font-family: 'Nunito Sans', sans-serif; font-weight: 400;">
          <li><strong>Personalized Matches.</strong></li>
          <li><strong>Verified Profiles.</strong></li>
          <li><strong>Privacy & Security.</strong></li>
          <li><strong>Reliable Matches.</strong></li>
        </ul>
      </div>
  </div>
</section>


<head>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Nunito+Sans:wght@400&display=swap" rel="stylesheet">
</head>

<div>
  <div>
      <!-- Company Section -->
      <div class="footer-section-container">
        <!-- Company Section -->
        <div class="footer-section">
          <h3 class="footer-heading">Company</h3>
          <ul class="text-black">
            <li><a href="/about-us" class="custom-link">About Us</a></li>
            <li><a href="/contact-us" class="custom-link">Contact Us</a></li>
          </ul>
        </div>
      
        <!-- Privacy Section -->
        <div class="footer-section">
          <h3 class="footer-heading">Privacy</h3>
          <ul class="text-black">
            <li><a href="/terms-of-use" class="custom-link">Terms of Use</a></li>
            <li><a href="/privacy-policy" class="custom-link">Privacy Policy</a></li>
            <li><a href="/marriage-blog" class="custom-link">Marriage Blog</a></li>
          </ul>
        </div>
      
        <!-- Help Section -->
        <div class="footer-section">
          <h3 class="footer-heading">Help</h3>
          <ul class="text-black">
            <li><a href="tel:+919909808976" class="custom-link">+91 9909808976</a></li>
            <li><a href="/support-desk" class="custom-link">Support Desk</a></li>
          </ul>
        </div>
      </div>
</div>

      



<section class="py-1 px-6" style="background-color: #fcfcfc; height: 1px;">
    <div class="max-w-screen-xl mx-auto text-center">
    </div>
</section>



<section class="py-8 px-6 bg-[#A31622]" style="font-family: 'Nunito Sans', sans-serif;">
  <div class="max-w-screen-xl mx-auto">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-6">
          <!-- Match by Cities -->
          <div>
            <h3 class="text-lg font-semibold text-white mb-2" style="font-family: 'Playfair Display', serif;">Match by Cities</h3>
            <ul class="space-y-1 text-white" style="font-family: 'Nunito Sans', sans-serif;">
                <li><a href="/register" class="hover:text-red-500">Mumbai</a></li>
                <li><a href="/register" class="hover:text-red-500">Pune</a></li>
                <li><a href="/register" class="hover:text-red-500">Delhi</a></li>
                <li><a href="/register" class="hover:text-red-500">Ahmedabad</a></li>
                <li><a href="/register" class="hover:text-red-500">Bangalore</a></li>
                <li><a href="/register" class="hover:text-red-500">Chennai</a></li>
                <li><a href="/register" class="hover:text-red-500">Kolkata</a></li>
            </ul>
        </div>
        

          <!-- Caste -->
          <div>
            <h3 class="text-lg font-semibold text-white mb-2" style="font-family: 'Playfair Display', serif;">Caste</h3>
            <ul class="space-y-1 text-white" style="font-family: 'Nunito Sans', sans-serif;">
                <li><a href="/register" class="hover:text-red-500">General</a></li>
                <li><a href="/register" class="hover:text-red-500">OBC</a></li>
                <li><a href="/register" class="hover:text-red-500">SC</a></li>
                <li><a href="/register" class="hover:text-red-500">ST</a></li>
                <li><a href="/register" class="hover:text-red-500">Brahmin</a></li>
                <li><a href="/register" class="hover:text-red-500">Rajput</a></li>
                <li><a href="/register" class="hover:text-red-500">Yadav</a></li>
            </ul>
        </div>
        

          <!-- State -->
          <div>
              <h3 class="text-lg font-semibold text-white mb-2" style="font-family: 'Playfair Display', serif;">State</h3>
              <ul class="space-y-1 text-white" style="font-family: 'Nunito Sans', sans-serif;">
                  <li><a href="/register" class="hover:text-red-500">Andhra Pradesh</a></li>
                  <li><a href="/register" class="hover:text-red-500">Bihar</a></li>
                  <li><a href="/register" class="hover:text-red-500">Gujarat</a></li>
                  <li><a href="/register" class="hover:text-red-500">Karnataka</a></li>
                  
              </ul>
          </div>

          <!-- Community -->
          <div>
            <h3 class="text-lg font-semibold text-white mb-2" style="font-family: 'Playfair Display', serif;">Community</h3>
            <ul class="space-y-1 text-white" style="font-family: 'Nunito Sans', sans-serif;">
                <li><a href="/register" class="hover:text-red-500">Brahmins</a></li>
                <li><a href="/register" class="hover:text-red-500">Rajputs</a></li>
                <li><a href="/register" class="hover:text-red-500">Yadavs</a></li>
                <li><a href="/register" class="hover:text-red-500">Dalits</a></li>
                <li><a href="/register" class="hover:text-red-500">Jats</a></li>
                <li><a href="/register" class="hover:text-red-500">Kurmis</a></li>
                <li><a href="/register" class="hover:text-red-500">Baniyas</a></li>
            </ul>
        </div>
        

          <!-- Marital Status -->
          <div>
              <h3 class="text-lg font-semibold text-white mb-2" style="font-family: 'Playfair Display', serif;">Marital Status</h3>
              <ul class="space-y-1 text-white" style="font-family: 'Nunito Sans', sans-serif;">
                  <li><a href="/register" class="hover:text-red-500">Single</a></li>
                  <li><a href="/register" class="hover:text-red-500">Married</a></li>
                  <li><a href="/register" class="hover:text-red-500">Divorced</a></li>
                  <li><a href="/register" class="hover:text-red-500">Widowed</a></li>
                
              </ul>
          </div>

          <!-- International Shaadi -->
          <div>
              <h3 class="text-lg font-semibold text-white mb-2" style="font-family: 'Playfair Display', serif;">Non Resident Indians
              </h3>
              <ul class="space-y-1 text-white" style="font-family: 'Nunito Sans', sans-serif;">
                  <li><a href="/register" class="hover:text-red-500">Australia</a></li>
                  <li><a href="/register" class="hover:text-red-500">Singapore</a></li>
                  <li><a href="/register" class="hover:text-red-500">Malaysia</a></li>
                  <li><a href="/register" class="hover:text-red-500">UAE</a></li>
              </ul>
          </div>
      </div>
  </div>
</section>
<!-- Footer Section -->
<section class="bg-[#A31622] text-white py-4">
  <div class="max-w-screen-xl mx-auto text-center">
      <p class="text-sm">© 2025 Bright Matrimonial. All Rights Reserved.</p>
  </div>
</section>



</body>
</html>
<?php /**PATH D:\Users\Sania\matrimonial\bright-metromonial\resources\views/theme/firstpage.blade.php ENDPATH**/ ?>