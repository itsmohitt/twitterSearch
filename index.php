<?php
/**
 * Created by PhpStorm.
 * User: bunny
 * Date: 22/08/17
 * Time: 5:28 PM
 */
require_once "twitteroauth-master/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;


if (isset($_GET['q']) && !empty($_GET['q'])) {
    $query = $_GET['q'];
    $homePage = false;

    require('twitterKey.php');

    $conn = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
    $conn->setTimeouts(10, 15);
    $search = $conn->get("search/tweets", ["q" => $query,"count"=>10]);
    //echo print_r($search);
} else {
    $homePage = true;
}



?>
<html>
<head>
    <title>Twitter Search</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="css/main.css" rel="stylesheet"/>
</head>
<body>
<div class="container">

    <div class="row">
        <?php if ($homePage == true) { ?>
            <div class=" jumbotron col-md-12"
                 style="color:white;background: url('./images/meteor.jpg');background-size: cover">
                <h1 class=" text-center text-success ">Twitter Search</h1>

            </div>
            <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                <hr class="colorgraph">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-md-offset-3">
                        <a type="submit" href="#search" class="btn btn-lg btn-success btn-block">Start Search</a>
                    </div>
                </div>
                <hr class="colorgraph">
            </div>
        <?php } else {
            ?>
                <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">


                    <hr class="colorgraph">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-md-offset-3">
                            <a type="submit" href="#search" class="btn btn-lg btn-success btn-block">Search More</a>
                        </div>
                    </div>
                    <hr class="colorgraph">


            </div>
                </div>

            <div class="panel">

                <div class="panel-body">
                    <h1> > <?php echo $query; ?></h1>
                    <hr/>
                    <ul class="timeline">
                        <?php

                        foreach ($search->statuses as $tweet) {
                       // echo json_encode($tweet, JSON_PRETTY_PRINT);
                           ?>

                            <li>
                                <div class="timeline-badge">11<i class="fa fa-twitter"></i></div>
                                <div class="timeline-panel">
                                    <div class="media">
                                        <div class="media-left">
                                            <img src="<?php echo $tweet->user->profile_image_url; ?>" class="media-object img-circle" style="width:60px">
                                        </div>
                                        <div class="media-body">
                                            <h4 class="media-heading">
                                                <a target="_blank" href="https://www.twitter.com/<?php echo $tweet->user->screen_name; ?>"><?php echo $tweet->user->name; ?>
                                                </a>
                                                <small>&nbsp;&nbsp;@<a target="_blank" href="https://www.twitter.com/<?php echo $tweet->user->screen_name; ?>"><?php echo $tweet->user->screen_name; ?>
                                                    </a>
                                                </small>
                                            </h4>
                                            <p>
                                                <small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?php echo $tweet->created_at; ?>
                                                    via Twitter
                                                </small>
                                            </p>
                                            <p><?php echo preg_replace("/#([^@ 
                                            ]*)/", "<a target=\"_new\" href=\"index.php?q=$1\">#$1</a>", $tweet->text); ?></p>
                                            <hr/>
                                            <div class="row" style="text-align:center">
                                                <div class="col-md-6">Retweet : <?php echo $tweet->retweet_count; ?></div>
                                                <div class="col-md-6">Favaorite :<?php echo $tweet->favorite_count; ?></div>

                                            </div>


                                        </div>
                                    </div>

                                </div>
                            </li>
                        <?php
                        }
                        ?>

                    </ul>
                </div>
            </div>
            <?php
        } ?>
    </div>

</div>


<div id="search">
    <button type="button" class="close">×</button>
    <form action="#">
        <input type="search" name="q" value="" placeholder="type keyword(s) here"/>
        <input type="submit" class="btn btn-primary btn-lg" value="Search Twitter"/>
    </form>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
<script>
    $(function () {
        $('a[href="#search"]').on('click', function (event) {
            event.preventDefault();
            $('#search').addClass('open');
            $('#search > form > input[type="search"]').focus();
        });

        $('#search, #search button.close').on('click keyup', function (event) {
            if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
                $(this).removeClass('open');
            }
        });

    });
</script>
</html>
