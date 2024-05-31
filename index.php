<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<?php
require("element/nav.php");
?>



<div class="container main-con">
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6 p-5">
            <form class="bg-white rounded p-5 signup-form">
                <h1 class="text-center bold">Sign Up</h1>

                <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" class="form-control" required="required">
                </div>

                <div class="mb-3 email_con">
                <label for="email" class="form-label">Email Id</label>
                <input type="email" id="email" class="form-control" required="required">
                <i class="fa fa-circle-notch fa-spin email_loader d-none"></i>

                </div>


                <div class="mb-3 pass_con">
                <label for="password" class="form-label">Password</label>
                <input type="text" id="password" class="form-control" required="required">
                <i class="fa fa-eye pass_icon"></i>
                </div>


                <div class="mb-4 d-flex justify-content-between">
                    <div class="form-text">Click Generate to improve Security </div>
                    <button class="btn btn-sm btn-danger pass-gen">Generate</button>
                </div>



                <div class="text-center">
                    <button class="btn btn-primary w-50" disabled="disabled">Register Now !</button>
                </div>
                <div class="msg"></div>
            </form>
            <form class="bg-white rounded p-5 activation-form d-none" autocomplete="off">
              <h1 class="text-center bold mb-4">Activate Your Account </h1>

              <div class="mb-3">
                <label for="activation_code" class="form-label">Activation Code </label>
                <input type="text" id="activation_code" class="form-control" required="required">
              </div>
              <div class="text-center">
                <button class="btn btn-primary w-50 activation_btn">Activate Now ! </button>
              </div>
              <div class="activation_msg"></div>
            </form>
      
        </div>
    </div>
</div>


<script>
  $(document).ready(function () {
    $(".pass-gen").click(function (e) {
      e.preventDefault();

      $.ajax({
        type:"POST",
        url:"php/generate_password.php",
        beforeSend:function(){
          $(".pass_icon").removeClass("fa fa-eye");
          $(".pass_icon").addClass("fa fa-circle-notch fa-spin");

        },
        success:function(response){
          $(".pass_icon").removeClass("fa fa-circle-notch fa-spin");
          $(".pass_icon").addClass("fa fa-eye");
          
          $("#password").val(response.trim());
          
        }

      })
      
    });

// sshow pasd
    $(".pass_icon").click(function(){
      if($("#password").attr("type")=="password")
      {
        $("#password").attr("type","text");
        $(this).css({color:"black"});
      }
      else
      {
        $("#password").attr("type","password");
        $(this).css({color:"#ccc"});
      }
    })

    // show loader of email id while entering email
    $("#email").on('input',function(){
      $(".email_loader").removeClass("d-none");
    })
    // check user exist in db or not 
    $("#email").on('change',function () {
  $.ajax({
    type: "POST",
    url: "php/check_user.php",
    data: {
      email: $(this).val()
    },
    success: function(response) {
      $(".email_loader").removeClass("fa fa-circle-notch fa-spin");
      if(response.trim()=="notfound")
      {
        $(".email_loader").removeClass("fa fa-times-circle");
        $(".email_loader").addClass("fa fa-check-circle");
        $(".email_loader").css({color:"green"});
        $(".btn-primary").removeAttr("disabled");
      }
      else
      {
        $(".email_loader").removeClass("fa fa-check-circle");
        $(".email_loader").addClass("fa fa-times-circle");
        $(".email_loader").css({color:"red"});
        $(".btn-primary").attr("disabled","disabled");
      }
      
    }
  })
});


// sign up form coding 

$(".signup-form").submit(function(e) {
  e.preventDefault();
  $.ajax({
    type:"POST",
    url:"php/register.php",
    data:{
      username:$("#username").val(),
      email:$("#email").val(),
      password:$("#password").val()
    },
    beforeSend:function(){
     $(".btn-primary").html("Please wait......");
     $(".btn-primary").attr("disabled", "disabled");

    },
    success:function(response){
      $(".btn-primary").html("Register Now");
     $(".btn-primary").removeAttr("disabled");
      if(response.trim()=="success")
      {
        var div=document.createElement("DIV");
        div.className="alert alert-success mt-3";
        div.innerHTML="Register Success !";
        $(".msg").append(div);

        setTimeout(function(){
          $(".msg").html("");
        
          $(".signup-form").addClass("d-none");
          $(".activation-form").removeClass("d-none");
        },3000);

      }
      else if(response.trim()=="usermatch")
      {
        var div=document.createElement("DIV");
        div.className="alert alert-warning mt-3";
        div.innerHTML="User already Exist !";
        $(".msg").append(div);

        setTimeout(function(){
          $(".msg").html("");
          $(".signup-form").trigger('reset');
        },3000);
      }

      else
      {
        var div=document.createElement("DIV");
        div.className="alert alert-danger mt-3";
        div.innerHTML="Registration failed  !";
        $(".msg").append(div);

        setTimeout(function(){
          $(".msg").html("");
          $(".signup-form").trigger('reset');
        },3000);

      }
    }
  });

  
})

$(".activation-form").submit(function (e) {
  e.preventDefault();
  $.ajax({
    type:"POST",
    url:"php/check_activation_code.php",
    data:{
      email:$("#email").val(),
      atc:$("#activation_code").val()
    },
    beforeSend: function(){
      $(".activation_code").html("Checking Activation Code....");
      $(".activation_code").attr("disabled","disabled");
    },
    success:function(response)
    {
      $(".aactivation_code").html("Activate Now !");
      $(".activation_code").removeAttr("disabled");
      if(response.trim()=="active")
      {
        var div=document.createElement("DIV");
        div.className="alert alert-success mt-3";
        div.innerHTML="Account Activated !";
        $(".activation_msg").append(div);

        setTimeout(function(){
          $(".activation_msg").html("");
          window.location="login.php";
        },3000);
      }
      else
      {
        var div=document.createElement("DIV");
        div.className="alert alert-danger mt-3";
        div.innerHTML=response;
        $(".activation_msg").append(div);

        setTimeout(function(){
          $(".activation_msg").html("");
         
        },3000);
      }
    }
  })
  
})


    
  })
</script>
</body>
</html>