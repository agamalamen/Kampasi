@extends('layouts.app')
@section('title') Find out your ALAian soulmate @endsection

@section('content')
  <style>
    body {
      background-color: #3498db;
    }

    .btn-lg {
      background-color: #2980b9;
    }

    .btn-lg:hover {
      background-color: #3498db;
    }

    .btn-lg:active {
      background-color: #3498db;
    }

    .btn-lg:focus {
      background-color: #3498db;
    }

  </style>

  <div class="container" style="padding-top: 15%">
    <div class="row">

      <div class="col-sm-8 col-sm-offset-2 text-center" id="soulMateContainer">
        <h1 style="font-family: lato;">Are you ready to know your ALAian soulmate?</h1>
        <a href="#" id="startQuiz" style="margin-top: 20px;" class="text-center btn btn-primary btn-lg">Start quiz</a>
      </div><!-- .col-sm-8 -->

      <div class="col-sm-8 col-sm-offset-2" style="display: none;" id="firstQuestion">
        <h1 style="font-family: lato;" class="text-center">1. If you get to be a Disney character? what character will you choose?</h1>
        <div class="row">
          <div class="col-sm-4">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg firstAnswer" id=1>Snow white</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg firstAnswer" id=2>Aladdin</a>
          </div><!-- .col-sm-4 -->
          <div class="col-sm-4 col-sm-offset-4" style="text-align: right;">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg firstAnswer" id=3>Peter Pan</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg firstAnswer" id=4>Simba</a>
          </div><!--.col-sm-4 -->
        </div><!-- .row -->
      </div><!-- .col-sm-8 -->

      <div class="col-sm-8 col-sm-offset-2" style="display: none;" id="secondQuestion">
        <h1 style="font-family: lato;" class="text-center">2. If you get to visit one place in California? where would you go?</h1>
        <div class="row">
          <div class="col-sm-4">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg secondAnswer" id=1>Silicon valley</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg secondAnswer" id=2>Hollywood</a>
          </div><!-- .col-sm-4 -->
          <div class="col-sm-4 col-sm-offset-4" style="text-align: right;">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg secondAnswer" id=3>Disneyland</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg secondAnswer" id=4>Sea World</a>
          </div><!--.col-sm-4 -->
        </div><!-- .row -->
      </div><!-- .col-sm-8 -->

      <div class="col-sm-8 col-sm-offset-2" style="display: none;" id="thirdQuestion">
        <h1 style="font-family: lato;" class="text-center">3. If you were to be a superhero? which one will you choose?</h1>
        <div class="row">
          <div class="col-sm-4">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg thirdAnswer" id=1>Spiderman</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg thirdAnswer" id=2>Hulk</a>
          </div><!-- .col-sm-4 -->
          <div class="col-sm-4 col-sm-offset-4" style="text-align: right;">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg thirdAnswer" id=3>Batman</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg thirdAnswer" id=4>Superman</a>
          </div><!--.col-sm-4 -->
        </div><!-- .row -->
      </div><!-- .col-sm-8 -->

      <div class="col-sm-8 col-sm-offset-2" style="display: none;" id="fourthQuestion">
        <h1 style="font-family: lato;" class="text-center">4. What kind of food do you prefer?</h1>
        <div class="row">
          <div class="col-sm-4">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg fourthAnswer" id=1>Italian food</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg fourthAnswer" id=2>American fast food</a>
          </div><!-- .col-sm-4 -->
          <div class="col-sm-4 col-sm-offset-4" style="text-align: right;">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg fourthAnswer" id=3>African food</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg fourthAnswer" id=4>Asian food</a>
          </div><!--.col-sm-4 -->
        </div><!-- .row -->
      </div><!-- .col-sm-8 -->

      <div class="col-sm-8 col-sm-offset-2" style="display: none;" id="fifthQuestion">
        <h1 style="font-family: lato;" class="text-center">5. I you were to stay in this age period for your entire life? Which one would you chose?</h1>
        <div class="row">
          <div class="col-sm-4">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg fifthAnswer" id=1>Childhood</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg fifthAnswer" id=2>Adolescence</a>
          </div><!-- .col-sm-4 -->
          <div class="col-sm-4 col-sm-offset-4" style="text-align: right;">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg fourthAnswer" id=3>Adulthood</a>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg fourthAnswer" id=4>Old age</a>
          </div><!--.col-sm-4 -->
        </div><!-- .row -->
      </div><!-- .col-sm-8 -->

      <div class="col-sm-8 col-sm-offset-2" style="display: none;" id="sixthQuestion">
        <h1 style="font-family: lato;" class="text-center">6. If the year gets to be only one season, which one would you choose?</h1>
        <div class="row">
          <div class="col-sm-4">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg sixthAnswer" id=1>Winter</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg sixthAnswer" id=2>Autumn</a>
          </div><!-- .col-sm-4 -->
          <div class="col-sm-4 col-sm-offset-4" style="text-align: right;">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg sixthAnswer" id=3>Spring</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg sixthAnswer" id=4>Summer</a>
          </div><!--.col-sm-4 -->
        </div><!-- .row -->
      </div><!-- .col-sm-8 -->

      <div class="col-sm-8 col-sm-offset-2" style="display: none;" id="seventhQuestion">
        <h1 style="font-family: lato;" class="text-center">7. If you get to meet one of these celebrities? Who will you choose?</h1>
        <div class="row">
          <div class="col-sm-4">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg seventhAnswer" id=1>Cristiano Ronaldo</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg seventhAnswer" id=2>Nelson Mandela</a>
          </div><!-- .col-sm-4 -->
          <div class="col-sm-4 col-sm-offset-4" style="text-align: right;">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg seventhAnswer" id=3>Beyonce</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg seventhAnswer" id=4>Steve Jobs</a>
          </div><!--.col-sm-4 -->
        </div><!-- .row -->
      </div><!-- .col-sm-8 -->

      <div class="col-sm-8 col-sm-offset-2" style="display: none;" id="eighthQuestion">
        <h1 style="font-family: lato;" class="text-center">8. What continent you would like to visit? (Besides Africa)</h1>
        <div class="row">
          <div class="col-sm-4">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg eighthAnswer" id=1>Asia</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg eighthAnswer" id=2>Europe</a>
          </div><!-- .col-sm-4 -->
          <div class="col-sm-4 col-sm-offset-4" style="text-align: right;">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg eighthAnswer" id=3>America</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg eighthAnswer" id=4>Australia</a>
          </div><!--.col-sm-4 -->
        </div><!-- .row -->
      </div><!-- .col-sm-8 -->

      <div class="col-sm-8 col-sm-offset-2" style="display: none;" id="ninthQuestion">
        <h1 style="font-family: lato;" class="text-center">9. If you get to do one activity of these for your entire life, Which one will you choose?</h1>
        <div class="row">
          <div class="col-sm-4">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg ninthAnswer" id=1>Music</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg ninthAnswer" id=2>Sleeping</a>
          </div><!-- .col-sm-4 -->
          <div class="col-sm-4 col-sm-offset-4" style="text-align: right;">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg ninthAnswer" id=3>Watching TV</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg ninthAnswer" id=4>Reading</a>
          </div><!--.col-sm-4 -->
        </div><!-- .row -->
      </div><!-- .col-sm-8 -->

      <div class="col-sm-8 col-sm-offset-2" style="display: none;" id="tenthQuestion">
        <h1 style="font-family: lato;" class="text-center">10. If you were to allow one of these things, Which one will you choose?</h1>
        <div class="row">
          <div class="col-sm-4">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg tenthAnswer" id=1>PDA</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg tenthAnswer" id=2>Not wearing uniforms</a>
          </div><!-- .col-sm-4 -->
          <div class="col-sm-4 col-sm-offset-4" style="text-align: right;">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg tenthAnswer" id=3>Not Preping</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg tenthAnswer" id=4>Sushi in the menu</a>
          </div><!--.col-sm-4 -->
        </div><!-- .row -->
      </div><!-- .col-sm-8 -->

      <div class="col-sm-8 col-sm-offset-2" style="display: none;" id="elevenQuestion">
        <h1 style="font-family: lato;" class="text-center">11. If you were to be a superhero? which one will you choose?</h1>
        <div class="row">
          <div class="col-sm-4">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg elevenAnswer" id=1>Swimming</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg elevenAnswer" id=2>Soccer</a>
          </div><!-- .col-sm-4 -->
          <div class="col-sm-4 col-sm-offset-4" style="text-align: right;">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg elevenAnswer" id=3>Basketball</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg elevenAnswer" id=4>I hate sports</a>
          </div><!--.col-sm-4 -->
        </div><!-- .row -->
      </div><!-- .col-sm-8 -->

      <div class="col-sm-8 col-sm-offset-2" style="display: none;" id="twelveQuestion">
        <h1 style="font-family: lato;" class="text-center">12. See the future or change the past?</h1>
        <div class="row">
          <div class="col-sm-4">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg twelveAnswer" id=1>See the future</a>
          </div><!-- .col-sm-4 -->
          <div class="col-sm-4 col-sm-offset-4" style="text-align: right;">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg twelveAnswer" id=3>Change the past</a>
          </div><!--.col-sm-4 -->
        </div><!-- .row -->
      </div><!-- .col-sm-8 -->

      <div class="col-sm-8 col-sm-offset-2" style="display: none;" id="thirteenQuestion">
        <h1 style="font-family: lato;" class="text-center">13. Be rich and useless or poor and impactful?</h1>
        <div class="row">
          <div class="col-sm-4">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg thirteenAnswer" id=1>Rich and useless</a>
          </div><!-- .col-sm-4 -->
          <div class="col-sm-4 col-sm-offset-4" style="text-align: right;">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg thirteenAnswer" id=3>Poor and impactful</a>
          </div><!--.col-sm-4 -->
        </div><!-- .row -->
      </div><!-- .col-sm-8 -->

      <div class="col-sm-8 col-sm-offset-2" style="display: none;" id="fourteenQuestion">
        <h1 style="font-family: lato;" class="text-center">14. If you get to have only one of these skills, which one will you choose?</h1>
        <div class="row">
          <div class="col-sm-4">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg fourteenAnswer" id=1>Public speaking</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg fourteenAnswer" id=2>Persuasive writing</a>
          </div><!-- .col-sm-4 -->
          <div class="col-sm-4 col-sm-offset-4" style="text-align: right;">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg fourteenAnswer" id=3>Coding skills</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg fourteenAnswer" id=4>Social skills</a>
          </div><!--.col-sm-4 -->
        </div><!-- .row -->
      </div><!-- .col-sm-8 -->

      <div class="col-sm-8 col-sm-offset-2" style="display: none;" id="fifteenQuestion">
        <h1 style="font-family: lato;" class="text-center">15. If you were to have a super power? which one will you choose?</h1>
        <div class="row">
          <div class="col-sm-4">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg fifteenAnswer" id=1>Being invisible</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg fifteenAnswer" id=2>Flying</a>
          </div><!-- .col-sm-4 -->
          <div class="col-sm-4 col-sm-offset-4" style="text-align: right;">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg fifteenAnswer" id=3>Reading people's minds</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg fifteenAnswer" id=4>Superhuman strength</a>
          </div><!--.col-sm-4 -->
        </div><!-- .row -->
      </div><!-- .col-sm-8 -->

      <div class="col-sm-8 col-sm-offset-2" style="display: none;" id="sixteenQuestion">
        <h1 style="font-family: lato;" class="text-center">16. Which sport of these you like the most?</h1>
        <div class="row">
          <div class="col-sm-4">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg sixteenAnswer" id=1>Soccer</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg sixteenAnswer" id=2>Basketball</a>
          </div><!-- .col-sm-4 -->
          <div class="col-sm-4 col-sm-offset-4" style="text-align: right;">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg sixteenAnswer" id=3>Swimming</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg sixteenAnswer" id=4>I hate sports</a>
          </div><!--.col-sm-4 -->
        </div><!-- .row -->
      </div><!-- .col-sm-8 -->

      <div class="col-sm-8 col-sm-offset-2" style="display: none;" id="seventeenQuestion">
        <h1 style="font-family: lato;" class="text-center">17. If you were to be one of these animals? which one will you choose?</h1>
        <div class="row">
          <div class="col-sm-4">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg seventeenAnswer" id=1>Lion</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg seventeenAnswer" id=2>Koala</a>
          </div><!-- .col-sm-4 -->
          <div class="col-sm-4 col-sm-offset-4" style="text-align: right;">
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg seventeenAnswer" id=3>Penguin</a><br>
            <a href="#" style="margin-top: 20px;" class="btn btn-primary btn-lg seventeenAnswer" id=4>Dinosaur</a>
          </div><!--.col-sm-4 -->
        </div><!-- .row -->
      </div><!-- .col-sm-8 -->

      <div class="col-sm-8 col-sm-offset-2" style="display: none;" id="finalQuestion">
        <h1 style="font-family: lato;" class="text-center">What is your name?</h1>
        <div class="row">
          <div class="col-sm-8 col-sm-offset-2 text-center">
            <input type="text" style="color: #333" id="soulMateName" class="input-lg btn-block" placeholder="What is your name">
            <p class="hidden" style="color: #c0392b;" id="soulMateNameError">Please enter your name</p>
            <a href="#" id="submitSoulMate" style="margin-top: 20px;" class="btn btn-primary btn-lg">Submit</a>
          </div><!-- .col-sm-8 -->
        </div><!-- .row -->
      </div><!-- .col-sm-8 -->

    </div><!-- .row -->
  </div><!-- .container -->
@endsection
