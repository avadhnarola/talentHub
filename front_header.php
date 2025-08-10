<!doctype php>
<php class="no-js" lang="zxx">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Education</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- <link rel="manifest" href="site.webmanifest"> -->
        <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
        <!-- Place favicon.ico in the root directory -->

        <!-- CSS here -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/owl.carousel.min.css">
        <link rel="stylesheet" href="css/magnific-popup.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/themify-icons.css">
        <link rel="stylesheet" href="css/nice-select.css">
        <link rel="stylesheet" href="css/flaticon.css">
        <link rel="stylesheet" href="css/gijgo.css">
        <link rel="stylesheet" href="css/animate.css">
        <link rel="stylesheet" href="css/slicknav.css">
        <link rel="stylesheet" href="css/style.css">
        <!-- <link rel="stylesheet" href="css/responsive.css"> -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="path/to/owl.carousel.min.js"></script>

    </head>

    <body>
        <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

        <!-- header-start -->
        <header>
            <div class="header-area ">
                <div class="header-top_area">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="header_top_wrap d-flex justify-content-between align-items-center">
                                    <div class="text_wrap">
                                        <p><span>+880166 253 232</span> <span>info@domain.com</span></p>
                                    </div>
                                    <div class="text_wrap">
                                        <p><a href="#"> <i class="ti-user"></i> Login</a> <a href="#">Register</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="sticky-header" class="main-header-area">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="header_wrap d-flex justify-content-between align-items-center">
                                    <div class="header_left">
                                        <div class="logo">
                                            <a href="index.php">
                                                <img src="img/logo.png" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="header_right d-flex align-items-center">
                                        <div class="main-menu  d-none d-lg-block">
                                            <nav>
                                                <ul id="navigation">
                                                    <li><a href="index.php">home</a></li>
                                                    <li><a href="Courses.php">Courses</a></li>
                                                    <li><a href="Admissions.php">Admissions</a></li>
                                                    <li><a href="#">Event <i class="ti-angle-down"></i></a>
                                                        <ul class="submenu">
                                                            <li><a href="Event.php">Event </a></li>
                                                            <li><a href="event_details.php">Event Details</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="contact.php">Contact</a></li>
                                                </ul>
                                            </nav>
                                        </div>
                                        <div class="Appointment">
                                            <div class="book_btn d-none d-lg-block">
                                                <a href="#course" class="scroll-link">Apply Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mobile_menu d-block d-lg-none"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- header-end -->

        <script>
            $(document).ready(function () {
                $(".scroll-link").on("click", function (e) {
                    e.preventDefault();
                    var target = $(this).attr("href");
                    $("html, body").animate({
                        scrollTop: $(target).offset().top - 100 // adjust offset for fixed header
                    }, 800);
                });
            });
        </script>