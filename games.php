<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Gaming Site</title>

    <!-- core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/owl.carousel.min.css" rel="stylesheet">
    <link href="css/icomoon.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-icon-144x144.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-icon-114x114.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-icon-72x72.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-icon-57x57.png">
    
    <script type="text/javascript" src="../../Scripts/fsm.js"></script>
    <script type="text/javascript" src="../../Scripts/jquery-1.4.4.js"></script>
    <script type="text/javascript" src="../../Scripts/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="../../Scripts/jquery-ui.js"></script>
    <script type="text/javascript" src="../../Scripts/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../../Scripts/jquery.timers.js"></script>
    
    <style type="text/css">
        html
        {
            background-color: Black;
        }
        span
        {
            padding: 0px;
            margin: 0px;
        }
        .screen
        {
            margin-left: 10%;
            margin-right: 10%;
            position: relative;
        }

        .centerPanel
        {
            width: 500px;
            left: 50%;
            margin-top: -100px;
            margin-left: -250px;
            position: relative;
        }

        .board
        {
            width: 262px;
            left: 50%;
            margin-left: -131px;
            position: relative;
            background-image: -webkit-gradient(linear, left top, right bottom, color-stop(0.0, #222), color-stop(0.5, #111), color-stop(1.0, #222));
            float: left;
            opacity: 0.0;
            visibility: hidden;
        }
        
        .scorePanel
        {
            font-family: Showcard Gothic;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            color: Gray;
            position: relative;
            display: block;
            float: right;
            opacity: 0.0;
            visibility: hidden;
        }
        
        root
        {
            display: block;
        }
        
        .colorChip
        {
            position: relative;
            float: left;
            width: 20px;
            height: 20px;
            margin: 2px;
            border-style: solid;
            border-width: 1px;
            border-color: #333333;
        }
        
        .clear
        {
            clear: both;
        }
        
        .clearfix
        {
            display: inline-block;
        }
        
        .clearfix:after, .container:after
        {
            clear: both;
            content: ".";
            display: block;
            height: 0;
            visibility: hidden;
        }
        
        * html .clearfix
        {
            height: 0%;
        }
        .clearfix
        {
            display: block;
        }
        
        .title
        {
            top: 428px;
            font-family: Arial Narrow;
            font-size: 40px;
            font-weight: bold;
            text-align: center;
            color: Gray;
            width: 300px;
            left: 50%;
            margin-left: -130px;
            position: relative;
            display: block;
        }

        #gamePaused
        {
            top: 300px;
            visibility: hidden;            
            text-decoration: blink;
            font-family: Lucida Sans;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            color: Orange;
            width: 500px;
            left: 40%;
            margin-left: -100px;
            position: fixed;
            display: block;           
        }
        
        #gameOver
        {
            top: 300px;
            visibility: hidden;            
            text-decoration: blink;
            font-family: Lucida Sans;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            color: Orange;
            width: 500px;
            left: 40%;
            margin-left: -100px;
            position: fixed;
            display: block;           
        }

        .subTitle
        {
            font-family: Lucida Sans;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            color: Gray;
            width: 400px;
            left: 65%;
            margin-left: -200px;
            position: relative;
            display: block;
        }
        
        .image
        {
            overflow: hidden;
            margin: 0px 0px 0px 0px;
        }
        
        .bob
        {
            vertical-align: middle;
        }
        
        .press
        {
            text-decoration: blink;
            font-family: Lucida Sans;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            color: Orange;
            width: 400px;
            left: 40%;
            margin-left: -130px;
            position: relative;
            display: block;           
        }        
    </style>
    <script type="text/javascript">

        //Finite State Machine for JavaScript
        //by Anthony Blackshaw
        //http: //antsdev.wordpress.com/2008/06/18/a-simple-js-finite-state-machine/

        var gameState = new FSM("intro");

        gameState.add_transition("play", "intro", changeIntroToPlaying, "playing");        
        gameState.add_transition("pause", "playing", changePlayingToPaused, "paused");
        gameState.add_transition("continue", "paused", changePausedToPlaying, "playing");
        gameState.add_transition("end", "playing", changePlayingToGameOver, "gameOver");
        gameState.add_transition("showIntro", "gameOver", changeGameOverToIntro, "intro");

        function changeIntroToPlaying() {
            initializeBoard();
            $('.subTitle').css('visibility', 'hidden');
            $('.press').css('visibility', 'hidden');

            $('.title').animate({
                top: 0
            }, 1000, 'swing', function () {
                // Animation complete.
                $('.scorePanel').animate({
                    opacity: 1.0
                }, 1000, 'swing', function () {
                    $('.scorePanel').css('visibility', 'visible');
                });

                $('.board').animate({
                    opacity: 1.0
                }, 1000, 'swing', function () {
                    $('.board').css('visibility', 'visible');
                });
            });
        }

        function changePlayingToPaused () {
            $('#gamePaused').css('visibility', 'visible');
        }

        function changePausedToPlaying() {
            $('#gamePaused').css('visibility', 'hidden');
        }

        function changePlayingToGameOver () {
            $('#gameOver').css('visibility', 'visible');
        }

        function changeGameOverToIntro() {
            $('#gameOver').css('visibility', 'hidden');

            $('.scorePanel').animate({
                opacity: 0.0
            }, 1000, 'swing', function () {
                $('.scorePanel').css('visibility', 'hidden');
            });

            $('.board').animate({
                opacity: 0.0
            }, 1000, 'swing', function () {
                // Animation complete.
                $('.board').css('visibility', 'hidden');
                $('.title').animate({
                    top: 200
                }, 1000, 'swing', function () {
                    // Animation complete.
                    $('.subTitle').css('visibility', 'visible');
                    $('.press').css('visibility', 'visible');
                });
            });
        }

        $(function () {
            createCells();
            setImages();
            showSplashScreen();
            initializeBoard();
            setTimer();
        });

        function createCells() {
            for (var row = 0; row < 16; row++) {
                for (var col = 0; col < 10; col++) {
                    var divId = 'cell_' + row + '_' + col;
                    var imgId = 'img_' + row + '_' + col;
                    var divTag = '<div id="' + divId + '" name="brick" class="colorChip clearfix"></div>';
                    $(divTag).appendTo('.board');
                }
                $('<div class="clear">').appendTo('.board');
                $('</div>').appendTo('.board');
            }

            for (var row = 0; row < 2; row++) {
                for (var col = 0; col < 4; col++) {
                    var divId = 'next_' + row + '_' + col;
                    var imgId = 'nextImg_' + row + '_' + col;
                    var divTag = '<div id="' + divId + '" name="brick" class="colorChip clearfix"></div>';
                    $(divTag).appendTo('#divNext');
                }
                $('<div class="clear">').appendTo('#divNext');
                $('</div>').appendTo('#divNext');
            }
        }

        function setImages() {
            $('img[class="image"]').each(function (idx, el) {
                $('#' + el.id).attr('src', '../../Content/images/None.png');
            });
        }

        function showSplashScreen() {
            $('.subTitle').css('visibility', 'hidden');
            $('.press').css('visibility', 'hidden');
            $('.title').animate({
                top: 200
            }, 1000, 'swing', function () {
                // Animation complete.
                $('.subTitle').css('visibility', 'visible');
                $('.press').css('visibility', 'visible');
            });
        }

        function setTimer() {
            $(document).everyTime(1000, function (i) {

                $.ajax({
                    type: "GET",
                    url: "Tick",
                    cache: false,
                    dataType: "json",
                    error: function (xhr, status, error) {
                        //                        alert(xhr.status);
                    },
                    success: function (json) {
                    }
                });
            });

            $(document).everyTime(200, function (i) {

                if (gameState.current_state == 'playing') {

                    $.ajax({
                        type: "GET",
                        url: "GetBoard",
                        cache: false,
                        //                    data: {},
                        dataType: "json",
                        error: function (xhr, status, error) {
                            // you may need to handle me if the json is invalid
                            // this is the ajax object
                            //                        alert(xhr.status);
                            //                        alert(error);
                        },
                        success: function (json) {

                            if (json.IsGameOver) {
                                gameState.process('end');
                            }
                            else {
                                $('#divScore').text(json.Score);
                                $('#divHiScore').text(json.HiScore);
                                $('#divLines').text(json.Lines);
                                $('#divLevel').text(json.Level);

                                $.each(json.Bricks, function (i, val) {
                                    //                                    $('#img_' + val.Row + '_' + val.Col).attr('src', '../../Content/images/' + val.Color + '.png');
                                    $('#cell_' + val.Row + '_' + val.Col).css('background-image', '-webkit-gradient(linear, left top, right bottom, color-stop(0.0, ' + val.Color + '), color-stop(1.0, rgba(0, 0, 0, 0.0)))');
                                    $('#cell_' + val.Row + '_' + val.Col).css('border-color', val.Color);
                                });

                                for (var row = 0; row < 2; row++) {
                                    for (var col = 0; col < 4; col++) {
                                        $('#next_' + row + '_' + col).css('background-image', '-webkit-gradient(linear, left top, right bottom, color-stop(0.0, #000), color-stop(1.0, #000))');
                                        $('#next_' + row + '_' + col).css('border-color', '#333');
                                    }
                                }

                                $.each(json.Next, function (i, val) {
                                    $('#next_' + val.Row + '_' + val.Col).css('background-image', '-webkit-gradient(linear, left top, right bottom, color-stop(0.0, ' + val.Color + '), color-stop(1.0, rgba(0, 0, 0, 0.0)))');
                                    $('#next_' + val.Row + '_' + val.Col).css('border-color', val.Color);
                                });
                            }
                        }
                    });
                }
            });

            $(document).keydown(function (event) {
                switch (event.keyCode) {
                    case 32: //space
                        if (gameState.current_state == 'intro')
                            gameState.process('play');
                        else if (gameState.current_state == 'paused')
                            gameState.process('continue');
                        else if (gameState.current_state == 'gameOver')
                            gameState.process('showIntro');
                        else
                            gameState.process('pause');
                        break;
                    case 37: //left
                        if (gameState.current_state == 'playing')
                            moveLeft();
                        break;
                    case 38: //up
                        if (gameState.current_state == 'playing')
                            moveUp();
                        break;
                    case 39: //right
                        if (gameState.current_state == 'playing')
                            moveRight();
                        break;
                    case 40: //down
                        if (gameState.current_state == 'playing')
                            moveDown();
                        break;
                }
            });
        }

        function moveLeft() {
            $.ajax({
                type: "GET",
                url: "MoveLeft",
                cache: false,
                dataType: "json",
                error: function (xhr, status, error) {
                    //                    alert(xhr.status);
                },
                success: function (json) {
                }
            });
        }

        function moveRight() {
            $.ajax({
                type: "GET",
                url: "MoveRight",
                cache: false,
                dataType: "json",
                error: function (xhr, status, error) {
                    //                    alert(xhr.status);
                },
                success: function (json) {
                }
            });
        }

        function moveUp() {
            $.ajax({
                type: "GET",
                url: "MoveUp",
                cache: false,
                dataType: "json",
                error: function (xhr, status, error) {
                    //                    alert(xhr.status);
                },
                success: function (json) {
                }
            });
        }

        function moveDown() {
            $.ajax({
                type: "GET",
                url: "MoveDown",
                cache: false,
                dataType: "json",
                error: function (xhr, status, error) {
                    //                    alert(xhr.status);
                },
                success: function (json) {
                }
            });
        }

        function initializeBoard() {
            $.ajax({
                type: "GET",
                url: "InitializeBoard",
                cache: false,
                dataType: "json",
                error: function (xhr, status, error) {
                                        alert(xhr.status);
                },
                success: function (json) {
                }
            });
        }
    </script>
</head>
<!--/head-->


<body>

    <header id="header">
        <!--<div class="top-bar">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <div class="top-number">
                            <p><i class="fa fa-phone-square"></i> +0123 456 70 90</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="social">
                            <ul class="social-share">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                                <li><a href="#"><i class="fa fa-skype"></i></a></li>
                            </ul>
                            <div class="search">
                                <form role="form">
                                    <input type="text" class="search-form" autocomplete="off" placeholder="Search">
                                    <i class="fa fa-search"></i>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.container-->
        <!--</div>
        <!--/.top-bar-->

        <nav class="navbar navbar-inverse" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"><img src="images/logo.png" alt="logo"></a>
                </div>

                <div class="collapse navbar-collapse navbar-right">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index.php">Home</a></li>
                        <li><a href="games.php">Games</a></li>
                        <li><a href="ranking.php">Ranking</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Services <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="contact-us.php">Contact Us</a></li>
                                <li><a href="blog-item.php">Blog Single</a></li>
                                <li><a href="pricing.php">Pricing</a></li>
                            </ul>
                        </li>
                        <li><a href="about-us.php">About Us</a></li>
                        <li class="login"><a href="login.php">Log in</a></li>
                        <li class="signup"><a href="signup.php">Sign up</a></li>
                    </ul>
                </div>
            </div>
            <!--/.container-->
        </nav>
        <!--/nav-->
        
    </header><!--/header-->


    <div class="page-title" style="background-image: url(images/page-title.png)">
        <h1>Games</h1>
    </div>
    
    
    
    
    <!--<section id="services" class="service-item">
        <div class="container">
            <div class="center fadeInDown">
                <h2>Our Service</h2>
                <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut <br> et dolore magna aliqua. Ut enim ad minim veniam</p>
            </div>

            <div class="row">

                <div class="col-sm-6 col-md-4">
                    <div class="media services-wrap fadeInDown">
                        <div class="pull-left">
                            <img class="img-responsive" src="images/services/ux.svg">
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading">UI/UX Design</h3>
                            <p>Hydroderm is the highly desired anti-aging cream on</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4">
                    <div class="media services-wrap fadeInDown">
                        <div class="pull-left">
                            <img class="img-responsive" src="images/services/web.svg">
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading">Web Design</h3>
                            <p>Hydroderm is the highly desired anti-aging cream on</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4">
                    <div class="media services-wrap fadeInDown">
                        <div class="pull-left">
                            <img class="img-responsive" src="images/services/motion.svg">
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading">Motion Graphics</h3>
                            <p>Hydroderm is the highly desired anti-aging cream on</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4">
                    <div class="media services-wrap fadeInDown">
                        <div class="pull-left">
                            <img class="img-responsive" src="images/services/mobile-ui.svg">
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading">Mobile UI/UX</h3>
                            <p>Hydroderm is the highly desired anti-aging cream on</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4">
                    <div class="media services-wrap fadeInDown">
                        <div class="pull-left">
                            <img class="img-responsive" src="images/services/web-app.svg">
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading">Web Applications</h3>
                            <p>Hydroderm is the highly desired anti-aging cream on</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4">
                    <div class="media services-wrap fadeInDown">
                        <div class="pull-left">
                            <img class="img-responsive" src="images/services/mobile-ui.svg">
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading">SEO Marketing</h3>
                            <p>Hydroderm is the highly desired anti-aging cream on</p>
                        </div>
                    </div>
                </div>

            </div>
            <!--/.row-->
        <!--</div>
        <!--/.container-->
    <!--</section>
    <!--/#services-->


    <section id="recent-works">
        <div class="container">
            <div class="center fadeInDown">
                <h2>Recent Works</h2>
                <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut <br> et dolore magna aliqua. Ut enim ad minim veniam</p>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4 single-work">
                    <div class="recent-work-wrap">
                        <img class="img-responsive" src="images/portfolio/game9.jpeg" alt="">
                        <div class="overlay">
                            <div class="recent-work-inner">
                                <a class="preview" href="images/portfolio/game9.jpeg" rel="prettyPhoto"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-4 single-work">
                    <div class="recent-work-wrap">
                        <img class="img-responsive" src="images/portfolio/game2.jpg" alt="">
                        <div class="overlay">
                            <div class="recent-work-inner">
                                <a class="preview" href="images/portfolio/game2.jpg" rel="prettyPhoto"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-4 single-work">
                    <div class="recent-work-wrap">
                        <img class="img-responsive" src="images/portfolio/game3.jpg" alt="">
                        <div class="overlay">
                            <div class="recent-work-inner">
                                <a class="preview" href="images/portfolio/game3.jpg" rel="prettyPhoto"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-4 single-work">
                    <div class="recent-work-wrap">
                        <img class="img-responsive" src="images/portfolio/game10.jpg" alt="">
                        <div class="overlay">
                            <div class="recent-work-inner">
                                <a class="preview" href="images/portfolio/game10.jpg" rel="prettyPhoto"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-4 single-work">
                    <div class="recent-work-wrap">
                        <img class="img-responsive" src="images/portfolio/game7.jpg" alt="">
                        <div class="overlay">
                            <div class="recent-work-inner">
                                <a class="preview" href="images/portfolio/game7.jpg" rel="prettyPhoto"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-4 single-work">
                    <div class="recent-work-wrap">
                        <img class="img-responsive" src="images/portfolio/game8.jpg" alt="">
                        <div class="overlay">
                            <div class="recent-work-inner">
                                <a class="preview" href="images/portfolio/game8.jpg" rel="prettyPhoto"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.row-->
            <div class="clearfix text-center">
                <br>
                <br>
                <a href="#" class="btn btn-primary">Show More</a>
            </div>
        </div>
        <!--/.container-->
    </section>
    
    
    
    <section>
        <br />
    <div class="screen">
        <div id="title" class="title">
            <img src="../../Content/images/Title.png" />
            <div class="subTitle">
                <img src="../../Content/images/Bob.png" class="bob"/></div>
            <br />
            <div class="press">Press SPACE to start game!</div>
        </div>
        <div class="centerPanel">
            <div class="board">
            </div>
            <div class="scorePanel">
                <div>
                    Score</div>
                    <div id="divScore" class="scoreText">000000</div>
                    <br />
                <div>
                    HiScore</div>
                    <div id="divHiScore" class="scoreText">000000</div>
                    <br />
                <div>
                    Lines</div>
                    <div id="divLines" class="scoreText">0</div>
                    <br />
                <div>
                    Level</div>
                    <div id="divLevel" class="scoreText">0</div>
                    <br />
                <div>
                    Next</div>
                    <div id="divNext" class="scoreText"></div>
                    
            </div>
        </div>
        <div id="gamePaused">
            GAME PAUSED<br />Press SPACE to continue!</div>
        </div>
        <div id="gameOver">
            GAME OVER<br />Press SPACE to restart!
        </div>
    
    
    </section>
    
    
    <section id="testimonial">
        <div class="container">
            <div class="center fadeInDown">
                <h2>Testimonials</h2>
                <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut <br> et dolore magna aliqua. Ut enim ad minim veniam</p>
            </div>
            <div class="testimonial-slider owl-carousel">
                <div class="single-slide">
                    <div class="slide-img">
                        <img src="images/client1.jpg" alt="">
                    </div>
                    <div class="content">
                        <img src="images/review.png" alt="">
                        <p>If you are looking at blank cassettes on the web, you may be very confused at the difference in price.</p>
                        <h4>- Charlotte Daniels</h4>
                    </div>
                </div>
                <div class="single-slide">
                    <div class="slide-img">
                        <img src="images/client2.jpg" alt="">
                    </div>
                    <div class="content">
                        <img src="images/review.png" alt="">
                        <p>If you are looking at blank cassettes on the web, you may be very confused at the difference in price.</p>
                        <h4>- Charlotte Daniels</h4>
                    </div>
                </div>
                <div class="single-slide">
                    <div class="slide-img">
                        <img src="images/client3.jpg" alt="">
                    </div>
                    <div class="content">
                        <img src="images/review.png" alt="">
                        <p>If you are looking at blank cassettes on the web, you may be very confused at the difference in price.</p>
                        <h4>- Charlotte Daniels</h4>
                    </div>
                </div>
                <div class="single-slide">
                    <div class="slide-img">
                        <img src="images/client2.jpg" alt="">
                    </div>
                    <div class="content">
                        <img src="images/review.png" alt="">
                        <p>If you are looking at blank cassettes on the web, you may be very confused at the difference in price.</p>
                        <h4>- Charlotte Daniels</h4>
                    </div>
                </div>
                <div class="single-slide">
                    <div class="slide-img">
                        <img src="images/client1.jpg" alt="">
                    </div>
                    <div class="content">
                        <img src="images/review.png" alt="">
                        <p>If you are looking at blank cassettes on the web, you may be very confused at the difference in price.</p>
                        <h4>- Charlotte Daniels</h4>
                    </div>
                </div>
                <div class="single-slide">
                    <div class="slide-img">
                        <img src="images/client3.jpg" alt="">
                    </div>
                    <div class="content">
                        <img src="images/review.png" alt="">
                        <p>If you are looking at blank cassettes on the web, you may be very confused at the difference in price.</p>
                        <h4>- Charlotte Daniels</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!--<section id="partner">
        <div class="container">
            <div class="center fadeInDown">
                <h2>Our Partners</h2>
                <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut <br> et dolore magna aliqua. Ut enim ad minim veniam</p>
            </div>

            <div class="partners">
                <ul>
                    <li>
                        <a href="#"><img class="img-responsive fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms" src="images/partners/brand-1.png"></a>
                    </li>
                    <li>
                        <a href="#"><img class="img-responsive fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms" src="images/partners/brand-2.png"></a>
                    </li>
                    <li>
                        <a href="#"><img class="img-responsive fadeInDown" data-wow-duration="1000ms" data-wow-delay="900ms" src="images/partners/brand-3.png"></a>
                    </li>
                    <li>
                        <a href="#"><img class="img-responsive fadeInDown" data-wow-duration="1000ms" data-wow-delay="1200ms" src="images/partners/brand-4.png"></a>
                    </li>
                    <li>
                        <a href="#"><img class="img-responsive fadeInDown" data-wow-duration="1000ms" data-wow-delay="1500ms" src="images/partners/brand-5.png"></a>
                    </li>
                </ul>
            </div>
        </div>
        <!--/.container-->
    <!--</section>
    <!--/#partner-->


    <!--<section id="bottom">
        <div class="container fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
            <div class="row">
                <div class="col-md-2">
                    <a href="#" class="footer-logo">
                        <img src="images/logo-black.png" alt="logo">
                    </a>
                </div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <div class="widget">
                                <h3>Company</h3>
                                <ul>
                                    <li><a href="#">About us</a></li>
                                    <li><a href="#">We are hiring</a></li>
                                    <li><a href="#">Meet the team</a></li>
                                    <li><a href="#">Copyright</a></li>
                                    <li><a href="#">Terms of use</a></li>
                                    <li><a href="#">Privacy policy</a></li>
                                    <li><a href="#">Contact us</a></li>
                                </ul>
                            </div>
                        </div>
                        <!--/.col-md-3-->

                        <!--<div class="col-md-3 col-sm-6">
                            <div class="widget">
                                <h3>Support</h3>
                                <ul>
                                    <li><a href="#">Faq</a></li>
                                    <li><a href="#">Blog</a></li>
                                    <li><a href="#">Forum</a></li>
                                    <li><a href="#">Documentation</a></li>
                                    <li><a href="#">Refund policy</a></li>
                                    <li><a href="#">Ticket system</a></li>
                                    <li><a href="#">Billing system</a></li>
                                </ul>
                            </div>
                        </div>
                        <!--/.col-md-3-->

                        <!--<div class="col-md-3 col-sm-6">
                            <div class="widget">
                                <h3>Developers</h3>
                                <ul>
                                    <li><a href="#">Web Development</a></li>
                                    <li><a href="#">SEO Marketing</a></li>
                                    <li><a href="#">Theme</a></li>
                                    <li><a href="#">Development</a></li>
                                    <li><a href="#">Email Marketing</a></li>
                                    <li><a href="#">Plugin Development</a></li>
                                    <li><a href="#">Article Writing</a></li>
                                </ul>
                            </div>
                        </div>
                        <!--/.col-md-3-->

                        <!--<div class="col-md-3 col-sm-6">
                            <div class="widget">
                                <h3>Our Partners</h3>
                                <ul>
                                    <li><a href="#">Adipisicing Elit</a></li>
                                    <li><a href="#">Eiusmod</a></li>
                                    <li><a href="#">Tempor</a></li>
                                    <li><a href="#">Veniam</a></li>
                                    <li><a href="#">Exercitation</a></li>
                                    <li><a href="#">Ullamco</a></li>
                                    <li><a href="#">Laboris</a></li>
                                </ul>
                            </div>
                        </div>
                        <!--/.col-md-3-->
                    <!--</div>
                </div>


            </div>
        </div>
    </section>
    <!--/#bottom-->

    <footer id="footer" class="midnight-blue">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    &copy; 2019 <a target="_blank" href="http://shapebootstrap.net/" title="Free Twitter Bootstrap WordPress Themes and HTML templates">GemuGaming</a>. All Rights Reserved.
                </div>
                <!--<div class="col-sm-6">
                    <ul class="pull-right">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Faq</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>-->
            </div>
        </div>
    </footer>
    <!--/#footer-->

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
