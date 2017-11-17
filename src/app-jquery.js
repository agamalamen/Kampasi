$('document').ready(function () {

/*  $('#avatar').mouseover(function () {
    $('#avatar').attr('src', 'http://findicons.com/files/icons/1072/face_avatars/300/i04.png');
  });

  $('#avatar').mouseout(function () {
    $('#avatar').attr('src', avatar);
  });
*/

  $('select').on('change', function() {
  alert( this.value );
  })

  $('#search-button').click(function () {
    event.preventDefault();
    $('.top-navbar').attr('class', 'top-navbar hide');
    $('.search-form').attr('class', 'search-form');
    $('#search-input').focus();
  });


  $('#close-search-form').click(function () {
    $('.top-navbar').attr('class', 'top-navbar');
    $('.search-form').attr('class', 'search-form hide');
  });

  if(typeof questionDescription !== 'undefined') {
    if (questionDescription.length > 200) {
      $('#question-description').html(questionDescription.substring(0,200) + '... <a id="see-more" href="#" style="color: #27ae60">See more</a>');


      $('#see-more').click(function () {
        $('#question-description').html(questionDescription);
      });
    }
  }

  $('.question').mouseover(function() {
    $('#question-options', this).attr('class', '');
  });

  $('.question').mouseout(function() {
    $('#question-options', this).attr('class', 'hidden');
  });

  $('.delete-question').click(function() {
    $(this).parent().parent().parent().parent().parent().slideUp(1000);
  });

  $('.status-options').change(function() {
    alert($(this).attr('id'));
  });

  $('.profile-gadget').mouseover(function() {
    $('#edit-bio').attr('class', '');
    $('#edit-avatar').attr('class', '');
  });

  $('.profile-gadget').mouseout(function() {
    $('#edit-bio').attr('class', 'hidden');
    $('#edit-avatar').attr('class', 'hidden');
  });

  $("#add-people").click(function(){
        $("#more-students").slideToggle("slow");
  });

  $("#filter-results").click(function(){
      $("#statuses").slideToggle();
    });


  $('#startQuiz').click(function () {
    event.preventDefault();
    $('#soulMateContainer').attr('class', 'hidden');
    $('#firstQuestion').fadeIn(2000);

  });

  var answers = [];

  $('.firstAnswer').click(function() {
    event.preventDefault();
    answers.push($(this).attr('id'));
    $('#firstQuestion').attr('class', 'hidden');
    $('#secondQuestion').fadeIn(2000);
  });

  $('.secondAnswer').click(function() {
    event.preventDefault();
    answers.push($(this).attr('id'));
    $('#secondQuestion').attr('class', 'hidden');
    $('#thirdQuestion').fadeIn(2000);
  });

  $('.thirdAnswer').click(function() {
    event.preventDefault();
    answers.push($(this).attr('id'));
    $('#thirdQuestion').attr('class', 'hidden');
    $('#fourthQuestion').fadeIn(2000);
  });

  $('.fourthAnswer').click(function() {
    event.preventDefault();
    answers.push($(this).attr('id'));
    $('#fourthQuestion').attr('class', 'hidden');
    $('#fifthQuestion').fadeIn(2000);
  });


  $('.fifthAnswer').click(function() {
    event.preventDefault();
    answers.push($(this).attr('id'));
    $('#fifthQuestion').attr('class', 'hidden');
    $('#sixthQuestion').fadeIn(2000);
  });


  $('.sixthAnswer').click(function() {
    event.preventDefault();
    answers.push($(this).attr('id'));
    $('#sixthQuestion').attr('class', 'hidden');
    $('#seventhQuestion').fadeIn(2000);
  });


  $('.seventhAnswer').click(function() {
    event.preventDefault();
    answers.push($(this).attr('id'));
    $('#seventhQuestion').attr('class', 'hidden');
    $('#eighthQuestion').fadeIn(2000);
  });


  $('.eighthAnswer').click(function() {
    event.preventDefault();
    answers.push($(this).attr('id'));
    $('#eighthQuestion').attr('class', 'hidden');
    $('#ninthQuestion').fadeIn(2000);
  });

  $('.ninthAnswer').click(function() {
    event.preventDefault();
    answers.push($(this).attr('id'));
    $('#ninthQuestion').attr('class', 'hidden');
    $('#tenthQuestion').fadeIn(2000);
  });

  $('.tenthAnswer').click(function() {
    event.preventDefault();
    answers.push($(this).attr('id'));
    $('#tenthQuestion').attr('class', 'hidden');
    $('#elevenQuestion').fadeIn(2000);
  });

  $('.elevenAnswer').click(function() {
    event.preventDefault();
    answers.push($(this).attr('id'));
    $('#elevenQuestion').attr('class', 'hidden');
    $('#twelveQuestion').fadeIn(2000);
  });

  $('.twelveAnswer').click(function() {
    event.preventDefault();
    answers.push($(this).attr('id'));
    $('#twelveQuestion').attr('class', 'hidden');
    $('#thirteenQuestion').fadeIn(2000);
  });

  $('.thirteenAnswer').click(function() {
    event.preventDefault();
    answers.push($(this).attr('id'));
    $('#thirteenQuestion').attr('class', 'hidden');
    $('#fourteenQuestion').fadeIn(2000);
  });

  $('.fourteenAnswer').click(function() {
    event.preventDefault();
    answers.push($(this).attr('id'));
    $('#fourteenQuestion').attr('class', 'hidden');
    $('#fifteenQuestion').fadeIn(2000);
  });

  $('.fifteenAnswer').click(function() {
    event.preventDefault();
    answers.push($(this).attr('id'));
    $('#fifteenQuestion').attr('class', 'hidden');
    $('#sixteenQuestion').fadeIn(2000);
  });

  $('.sixteenAnswer').click(function() {
    event.preventDefault();
    answers.push($(this).attr('id'));
    $('#sixteenQuestion').attr('class', 'hidden');
    $('#seventeenQuestion').fadeIn(2000);
  });

  $('.seventeenAnswer').click(function() {
    event.preventDefault();
    answers.push($(this).attr('id'));
    $('#seventeenQuestion').attr('class', 'hidden');
    $('#finalQuestion').fadeIn(2000);
  });

  $('#submitSoulMate').click(function() {
    if($('#soulMateName').val() == '') {
      $('#soulMateNameError').attr('class', '');
    } else {
      var name = $('#soulMateName').val();
      window.location.replace('http://kampasi.com/community-art-project/soul-mate/post-soul-mate/' + name + '/' + answers);
    }
  });

  $('#showSoulMateResult').click(function() {
    event.preventDefault();
    $('#showSoulMateResult').attr('class', 'hidden');
    $('#soulMateImage').attr('class', 'img-rounded');

    setTimeout(function() {
      $('#soulMateImage').attr('class', 'hidden');
      $('#callToAction').attr('class', '');
    }, 5000);


  });



  $('#rahaf').hover(function() {
    $('#rahaf').attr('src', ahmed);
    $('#ahmed').attr('src', rahaf);
    $('#rahaf').attr('id', 'toChange');
    $('#ahmed').attr('id', 'rahaf');
    $('#toChange').attr('id', 'ahmed');
  });

  $('#aml').hover(function() {
    $('#aml').attr('src', ahmed);
    $('#ahmed').attr('src', aml);
    $('#aml').attr('id', 'toChange');
    $('#ahmed').attr('id', 'aml');
    $('#toChange').attr('id', 'ahmed');
  });


  $('#searchMembers').hover(function() {
    alert('hey');
  });

  $('.prepUser').hover(function() {
    alert('hey');
  });

  $("#search-members").click(function(event){
        event.preventDefault();
        $("#search-members-form").slideToggle("fast");
        $("#search-members-input").focus();
  });

  $("#search-members-form").submit(function(event){
        event.preventDefault();
  });

  $("#search-members-input").keyup(function(event){
    var str = $("#search-members-input").val();
    if (str.length == -1) {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("style-1").innerHTML = this.responseText;
            } else {
              document.getElementById("style-1").innerHTML = "<div class='text-center'><img style='' class='text-center' src="+ membersLoading +"></div>";
            }
        };
        xmlhttp.open("GET", searchMembersRoute + '?q=' + $("#search-members-input").val(), true);
        xmlhttp.send();
    }
  });

  $(".prep-default").change(function(event) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          $('#updatePrepPlaceStatus').hide();
          document.getElementById('updatePrepPlaceStatus').innerHTML = '<i class="fa fa-check-circle" aria-hidden="true" style="display:inline;"></i> Updated';
          $('#updatePrepPlaceStatus').slideDown();
        }
    };
    xmlhttp.open("GET", updatePrepPlaceRoute + '?place=' + $(this).val(), true);
    xmlhttp.send();
  });

  $("#show_detailed_report").click(function(event){
    $("#detailed_report").slideToggle("slow");
  });

  var feedback_moved = 0;
  $("#publish_feedback").mouseover(function(event){
    if(feedback_moved == 0) {
      $("#publish_feedback").animate({
          left: '250px',
          height: '+=150px',
          width: '+=200px'
      });
      $("#feedback_threads").attr('class', 'col-md-6 col-md-offset-2');
      $("#post_feedback_content").height(190);
      feedback_moved = 1;
    }
  });

  $("#post-feedback").submit(function(event){
    $('#post-feedback-button').text("Publishing...");
});

$('.count').each(function (event) {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 4000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});

});
