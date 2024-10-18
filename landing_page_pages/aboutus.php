<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">

    <!--Bootsrap CSS--><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../src/css/index.css">
    <link rel="stylesheet" href="aboutus.css">
    <link rel="stylesheet" href="../src/css/nav_active.css">

    <!-- CORE CSS-->
    <link href="../src/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="../src/css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">

    <title>About us</title>

</head>
<body>
  <!-- Start Page Loading -->
  <div id="loader-wrapper">
      <div id="loader"></div>        
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
  </div>
  <!-- End Page Loading -->
<div class="landing-page">
        <header>
        <div class="container">
  <a href="#" class="logo">A Household Profiling System for <b>
    <span class="red1">A</span><span class="green1">L</span><span class="blue1">S</span>
  </b></a>
  <ul class="links">
    <li><a href="../index.php">Home</a></li>
    <li><a href="aboutus.php" class="active">About Us</a></li>
    <li><a href="#" id="get-started">Get Started</a></li>
  </ul>
</div>

        </header>
        <div class="content">
          <div class="container">
            <div class="info">
              <h1>About Us: Empowering Out-of-School Youth in Barangay Tankulan</h1>
              <p>This web-based household profiling system is the culmination of our capstone project, a collaborative effort by Bimbo Villaganas, Evelyn Secuya, Jaylah Binayao, and Jessa Abarquez.  Our project, initiated on July 14, 2024, focuses on empowering out-of-school youth in Barangay Tankulan, Manolo Fortich, Bukidnon, by providing a comprehensive and accessible platform for household profiling.</p>


              <div class="about">
              <h2>Our Vision:</h2>
              <p>We envision a future where out-of-school youth in Barangay Tankulan have the tools and resources to navigate their educational and economic opportunities. This system will serve as a catalyst for informed decision-making, empowering both individuals and the community to create a brighter future.</p>
              </div>

              <div class="about">
              <h2>Our Mission:</h2>
              <p>Our mission is to develop a user-friendly, data-driven platform that facilitates the creation and analysis of household profiles for out-of-school youth in Barangay Tankulan. This platform will provide valuable insights into the unique needs and challenges faced by these individuals, enabling targeted interventions and support from local organizations and government agencies.</p>
              </div>

              <div class="about">
              <h2>Our Approach:</h2>
              <p>We are committed to a collaborative and iterative development process. Through extensive research, user feedback, and close collaboration with community leaders and stakeholders in Barangay Tankulan, we aim to create a system that is both effective and relevant to the specific needs of the community.</p>
              </div>
              
              <div class="about">
  <h2>Our Team:</h2>
  <div class="team-members">
    <div class="team-member">
      <img src="images/bimbo.png" alt="Bimbo Villaganas">
      <p>Bimbo Villaganas</p>
    </div>
    <div class="team-member">
      <img src="images/evelyn.png" alt="Evelyn Secuya">
      <p>Evelyn Secuya</p>
    </div>
    <div class="team-member">
      <img src="images/jaylah.png" alt="Jaylah Binayao">
      <p>Jaylah Binayao</p>
    </div>
    <div class="team-member">
      <img src="images/jessa.png" alt="Jessa Abarquez">
      <p>Jessa Abarquez</p>
    </div>
  </div>
  <p>Our team brings together a diverse range of skills and expertise in software development, data analysis, and community engagement. We are passionate about leveraging our knowledge and abilities to create a positive impact on the lives of out-of-school youth in Barangay Tankulan.</p>
</div>

              
              <div class="about">
                <h2>Our Commitment:</h2>
              <p>We are dedicated to the success of this project and its potential to empower out-of-school youth in Barangay Tankulan. We believe that by providing them with the resources and information they need, we can help them achieve their full potential and contribute meaningfully to their community.</p>
              </div>
              

                  <button class="button-link" data-bs-toggle="modal" data-bs-target="#termsModal">Get Started</button>
            </div>
              <div class="image">
              <img src="../assets/images/alslanding.jpg">
            </div>
          </div>
        </div>
      </div>
      
    
    <!-- Modal for Terms and Conditions -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Please read and accept our terms and conditions to proceed.</p>
                <p><strong>Summary of Terms and Conditions:</strong></p>
                <p>
                    1. You must provide accurate information.<br>
                    2. You agree to follow the guidelines set forth.<br>
                    3. Your data will be used for profiling purposes only. You agree not to share, disclose, or distribute any data or information obtained from the ALS Household Profiling System to any third parties without prior written consent from ALS.
                </p>
                <p><a href="#" id="readMore" data-bs-toggle="modal" data-bs-target="#fullTermsModal">Read More</a></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="acceptTerms">Accept</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Full Terms and Conditions -->
<div class="modal fade" id="fullTermsModal" tabindex="-1" aria-labelledby="fullTermsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fullTermsModalLabel">Full Terms and Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h2>1. Acceptance of Terms</h2>
                <p>By accessing and using the ALS Household Information System, you agree to comply with and be bound by these Terms and Conditions. If you do not agree with any part of these terms, you must not use the system.</p>

                <h2>2. Changes to Terms</h2>
                <p>We reserve the right to modify these Terms and Conditions at any time. Any changes will be effective immediately upon posting on this page. Your continued use of the system after any changes signifies your acceptance of the new terms.</p>

                <h2>3. Use of Service</h2>
                <p>Your data will be used for profiling purposes only. You agree not to share, disclose, or distribute any data or information obtained from the ALS Household Profiling System to any third parties without prior written consent from ALS. Any unauthorized sharing of data may result in the termination of your access to the service.</p>

                <h2>4. User Responsibilities</h2>
                <p>As a user, you are responsible for maintaining the confidentiality of your account information and for all activities that occur under your account. You agree to notify us immediately of any unauthorized use of your account or any other breach of security.</p>

                <h2>5. Data Privacy</h2>
                <p>Your personal information will be collected, stored, and used in accordance with the Republic Act No. 10173, also known as the Data Privacy Act of 2012. We are committed to protecting your privacy and ensuring the security of your data.</p>

                <h2>6. Limitation of Liability</h2>
                <p>The ALS Household Information System shall not be liable for any direct, indirect, incidental, special, or consequential damages that may result from the use or inability to use the system, even if we have been advised of the possibility of such damages.</p>

                <h2>7. Governing Law</h2>
                <p>These Terms and Conditions shall be governed by and construed in accordance with the laws of the Republic of the Philippines. Any disputes arising in connection with these terms shall be subject to the exclusive jurisdiction of the courts of the Philippines.</p>

                <h2>8. Contact Information</h2>
                <p>If you have any questions about these Terms and Conditions, please contact us at <a href="mailto:hanz46228@gmail.com">hanz46228@gmail.com</a>.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</body>
<script>
        // JavaScript to handle Terms acceptance
        document.getElementById('acceptTerms').addEventListener('click', function() {
            // Close the modal
            var modal = bootstrap.Modal.getInstance(document.getElementById('termsModal'));
            modal.hide();

            // Redirect to the login page
            window.location.href = '../login.php';
        });

        // Prevent the default link behavior for Get Started
        document.getElementById('get-started').addEventListener('click', function(event) {
            event.preventDefault();
            // Show the terms modal
            var termsModal = new bootstrap.Modal(document.getElementById('termsModal'));
            termsModal.show();
        });
    </script>
<!--Bootsrap js-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- jQuery Library -->
<script type="text/javascript" src="../src/js/plugins/jquery-1.11.2.min.js"></script>  
<!--materialize js-->
<script type="text/javascript" src="../src/js/materialize.min.js"></script>
<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="../src/js/plugins.min.js"></script>
</html>