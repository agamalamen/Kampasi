function onSignIn(googleUser) {
  var profile = googleUser.getBasicProfile();
  $.ajax({
    method: 'POST',
    url: googleUrl,
    data: {fullName: profile.getName(), username: profile.getId(),
          email: profile.getEmail(), password: 'heyhey', avatar: profile.getImageUrl(), source: 'google', _token: token},
    beforeSend: function() {
      //beforesend logic
    },
    success: function(msg) {
      //success logic
      window.location.replace(msg);
    },
    error: function(msg) {
      //error logic
    }
  });
}

$(document).ready(function() {

  $('#signup-form').submit(function() {
    event.preventDefault();
    $.ajax({
      method: 'POST',
      url: url,
      data: {fullName: $('#fullName').val(), username: $('#username').val(),
            email: $('#email').val(), phone: $('#phone').val(), password: $('#password').val(), request: $('#request').val(), _token: token},
      beforeSend: function() {
        $('#signupButton').html('Loading');
      },
      success: function(msg) {
        //success logic
        //redirect to home
        window.location.replace(msg);
        //alert('')
      },
      error: function(msg) {
        //error logic
        $('#signupButton').html('Signup');
        var errors = msg.responseJSON;
        if(errors.fullName) {
          $('#fullNameError').html(errors.fullName[0]);
        } else { $('#fullNameError').html(''); }
        if(errors.username) {
          $('#usernameError').html(errors.username[0]);
        } else { $('#usernameError').html('') }
        if(errors.email) {
          $('#emailError').html(errors.email[0]);
        } else { $('#emailError').html('') }
        if(errors.phone) {
          $('#phoneError').html(errors.phone[0]);
        } else { $('#phoneError').html('') }
        if(errors.password) {
          $('#passwordError').html(errors.password[0]);
        } else { $('#passwordError').html('') }
      }
    });
  });

  $('#loginForm').submit(function(event) {
    event.preventDefault();
    if ($('#rememberMe').is(':checked')) {
      var remembered = 1;
    } else {
      var remembered = 0;
    }
    $.ajax({
      method: 'POST',
      url: url,
      data: {usernameOrEmail: $('#usernameOrEmail').val(), password: $('#password').val(), rememberMe: remembered, _token: token},
      beforeSend: function() {
        $('#loginButton').html('Loading');
      },
      success: function(msg) {
        if (msg != 0) {
          //alert(msg);
          window.location.replace(msg);
        } else {
          $('#loginButton').html('Login');
          $('#mismatchError').html('');
          $('#usernameOrEmailError').html('');
          $('#password').html('');
          $('#mismatchError').html('Your email or password are incorrect.')
          }
      },
      error: function(msg) {
        //error logic
        $('#loginButton').html('Login');
        var errors = msg.responseJSON;
        if(errors.usernameOrEmail) {
          $('#usernameOrEmailError').html(errors.usernameOrEmail[0]);
        } else { $('#userNameOrEmailError').html(''); $('#mismatchError').html(''); }
        if(errors.password) {
          $('#passwordError').html(errors.password[0]);
        } else { $('#passwordError').html(''); $('#mismatchError').html(''); }
      }
    });
  });
/*
  $('.answer-form').submit(function () {
    event.preventDefault();
    //$(this).parent().parent().parent().html('hey?');
    answerContnet = $('#answer-content', this).val();
    questionId = $('#question-id', this).val();
    $('#answer-button', this).val('answering');
    console.log(questionId);
  });
*/
  $('.answer-form').submit(function() {
    answerButton = $('#answer-button', this);
    answerContent = $('#answer-content', this);
    answerContentError = $('#answer-content-error', this);
    current = $(this);
    event.preventDefault();
    $.ajax({
      method: 'POST',
      url: answerUrl,
      data: {answerContent: $('#answer-content', this).val(), questionId: $('#question-id', this).val(), _token: answerToken},
      beforeSend: function(msg) {
        answerButton.val('answering');
      },
      success: function(msg) {
        answerButton.val('Answer');
        answerContent.val('');
        answerContentError.html('');
        current.parent().parent().parent().prepend(msg);
      },
      error: function(msg) {
        answerButton.val('Answer');
        var errors = msg.responseJSON;
        if(errors.answerContent) {
          answerContentError.html(errors.answerContent[0]);
        }
      }
    });
  });


  $('.correct-form').submit(function() {
    current = $(this);
    event.preventDefault();
    $.ajax({
      method: 'POST',
      url: correctUrl,
      data: {answerId: $('#correct-answer-id', this).val(), userId: $('#correct-user-id', this).val(), _token: correctToken},
      beforeSend: function() {
        $(this).html('loading');
        //current.parent().parent().val('hey');
      },
      success: function(msg) {
        alert('success');
      },
      error: function(msg) {
        alert('faliure')
      }
    });
  });

});
