$(document).ready(function () {
   var signUpBtn = $('#submit-signup');
   var loginBtn = $('#submit-login');
   var errorDiv = $('.error-div');

   $('#signupForm').validate({
       rules : {
           name : {
               required : true,
               minlength : 8
           },
           email : {
               required : true,
               email : true
           },
           password : {
               required : true,
               minlength : 8
           },
           cPassword : {
               required : true,
               equalTo: '#password'
           },
           type : {
               required : true
           }
       },
       messages : {
           name : {
               required : "kindly enter your name",
               minlength : "should be more than 8 characters"
           },
           email : "kindly enter a valid email",
           password : {
               required : "kindly enter your password",
               minlength : "should be more than 8 characters"
           },
           cPassword : {
               required : "kindly re-enter your password",
               equalTo : "passwords do not match"
           },
           type : "Kindly select user type"
       },
       submitHandler : submitSignUp
   });

    function submitSignUp() {
        var data = $('#signupForm').serialize();
        var btnHtml = 'Sign Up';
      $.ajax({
          url : 'submit-signup.php',
          type: 'get',
          data : data,
          beforeSend : function () {
              signUpBtn.html('<span class="fa fa-spin fa-spinner"></span> validating...').attr('disabled','disabled');
              errorDiv.html('').fadeOut();
          },
          success : function (data) {
              signUpBtn.html(btnHtml).removeAttr('disabled');
              if(data === 'success'){
                  errorDiv.fadeIn(1000, function () {
                      errorDiv.html('<div class="alert alert-success"><span class="fa fa-check"></span> User registered! Kindly wait as page reloads</div>');
                  });
                  setTimeout(function () {
                      window.location.href="dashboard.php"
                  }, 1500);
              }
              else if(data === 'noData'){
                  errorDiv.fadeIn(1000, function () {
                      errorDiv.html('<div class="alert alert-danger"><span class="fa fa-exclamation-triangle"></span> Input all form fields</div>');
                  })
              }
              else if(data === 'noMatch'){
                  errorDiv.fadeIn(1000, function () {
                      errorDiv.html('<div class="alert alert-danger"><span class="fa fa-exclamation-triangle"></span> Passwords do not match</div>');
                  })
              }
              else if(data === 'error'){
                  errorDiv.fadeIn(1000, function () {
                      errorDiv.html('<div class="alert alert-danger"><span class="fa fa-exclamation-triangle"></span> An error occurred please try again later</div>');
                  })
              }
              else{
                  errorDiv.fadeIn(1000, function () {
                      errorDiv.html('<div class="alert alert-danger"><span class="fa fa-exclamation-triangle"></span> Unknown error, kindly try again</div>');
                  })
              }
          }
      })  
    }

    $('#loginForm').validate({
        rules : {
            email : {
                required : true,
                email : true
            },
            password : {
                required : true,
                minlength : 8
            }
        },
        messages : {

            email : "kindly enter a valid email",
            password : {
                required : "kindly enter your password",
                minlength : "should be more than 8 characters"
            }
        },
        submitHandler : submitLogin
    });

    function submitLogin() {
        var data = $('#loginForm').serialize();
        var btnHtml = 'Login';
        $.ajax({
            url : 'submit-login.php',
            type: 'get',
            data : data,
            beforeSend : function () {
                loginBtn.html('<span class="fa fa-spin fa-spinner"></span> validating...').attr('disabled','disabled');
                errorDiv.html('').fadeOut();
            },
            success : function (data) {
                loginBtn.html(btnHtml).removeAttr('disabled');
                if(data === 'success'){
                    errorDiv.fadeIn(1000, function () {
                        errorDiv.html('<div class="alert alert-success"><span class="fa fa-check"></span> Login successful! Kindly wait as page reloads</div>');
                    });
                    setTimeout(function () {
                        window.location.href="dashboard.php"
                    }, 1500);
                }
                else if(data === 'noData'){
                    errorDiv.fadeIn(1000, function () {
                        errorDiv.html('<div class="alert alert-danger"><span class="fa fa-exclamation-triangle"></span> Input all form fields</div>');
                    })
                }
                else if(data === 'error'){
                    errorDiv.fadeIn(1000, function () {
                        errorDiv.html('<div class="alert alert-danger"><span class="fa fa-exclamation-triangle"></span> An error occurred please try again later</div>');
                    })
                }
                else if(data === 'noUser'){
                    errorDiv.fadeIn(1000, function () {
                        errorDiv.html('<div class="alert alert-danger"><span class="fa fa-exclamation-triangle"></span> Email and password combination incorrect</div>');
                    })
                }
                else{
                    errorDiv.fadeIn(1000, function () {
                        errorDiv.html('<div class="alert alert-danger"><span class="fa fa-exclamation-triangle"></span> Unknown error, kindly try again</div>');
                    })
                }
            }
        })
    }
});