<?php
session_start();
if(empty($_SESSION['user']))
{
    header("Location:login.php");
    
}
require("php/db.php");


$user_email=$_SESSION['user'];
$user_sql="SELECT * FROM users WHERE email='$user_email'";
$user_res=$db->query($user_sql);

$user_data=$user_res->fetch_assoc();
$user_name=$user_data['full_name'];
$total_storage=$user_data['storage'];
$used_storage=$user_data['used_storage'];
$per=round(($used_storage*100)/$total_storage,2);
$user_id=$user_data['id'];
$tf="user_".$user_id;

$free_storage=$total_storage-$used_storage;



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
   
    <script src="js/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .main-container{
            width: 100%;
            height: 100vh;

        }
        .left{
            width: 17%;
            height: 100%;
            background-color: #080429;
        }
        .right{
            width: 83%;
            height: 100%;
            overflow: auto;
            
        }
        .profile_pic{
            width: 100px;
            height: 100px;
            border-radius: 100%;
            border: 4px solid white;
        }
        .line{
            background-color: #fff;
            width: 100%;
        }
        .storage{
            width: 80%;
        }
        .thumb{
            width: 75px;
            height: 75px;
        }
        .my_menu{
            list-style: none;
            padding: 0;
            margin: 0;
            width: 100%;

        }
        .my_menu li{
            width: 100%;
            padding: 10px;
            color: #fff;
            padding-left: 40px;
        }
        .my_menu li:hover{
            background-color: #fff;
            color: #080429;
            cursor: pointer;
        }
        .msg{
            width: 100%;
            height: 100vh;
            background-color: rgba(0,0,0,0.7);
           position: fixed;
           top: 0;
           left: 0;
           display: flex;
           justify-content: center;
           align-items: center;
           z-index: 1000000;
        }

        /*  text responsive (later)  */
        .my_menu {
    l    ist-style: none;
          padding: 0;
          margin: 0;
          width: 100%;
          display: flex;
          flex-wrap: wrap; /* Allow menu items to wrap to the next line if necessary */
      }

      .my_menu li {
          flex: 1 1 50%; /* Adjust the width of each menu item */
          padding: 10px;
          text-align: center; /* Center align text */
          box-sizing: border-box; /* Ensure padding is included in width */
      }

      @media (min-width: 768px) {
          .my_menu li {
              flex: 1 1 33.33%; /* Adjust the width of each menu item for larger screens */
          }
      }

    </style>
</head>
<body>
    <div class="main-container d-flex">
        <div class="left">


        <div class="d-flex justify-content-center align-items-center flex-column pt-5">
            <div class="profile_pic d-flex justify-content-center align-items-center">
                <i class="fa fa-user fs-1 text-white" ></i>
            </div>
            <span class="text-white fs-4 mt-3"><?php  echo $user_name;?></span>
            <hr class="line">
            <button class="btn btn-light rounded-pill upload"><i class="fa fa-upload"></i>Upload File</button>
            <div class="progress storage mt-3 d-none u_pro">
                <div class="progress-bar bg-primary upload_p" style="width:0%"></div>
            </div>
            <div class="upload_msg"></div>
            <hr class="line">
            <ul class="my_menu">
                <li class="menu" p_link="my_files">My File</li>
                <li class="menu" p_link="f_files">Favourite File</li>
                <li class="menu" p_link="buy_storag">Buy Storage</li>
            </ul>

            <hr class="line">


            <span class="text-white">STORAGE</span>
            <div class="progress storage">
                <div class="progress-bar bg-primary pb" style="width:<?php echo $per; ?>"></div>
            </div>
            <span class="text-white"><span class="us"><?php echo $used_storage; ?></span >MB /<?php echo $total_storage;  ?>MB </span>

            <a href="php/logout.php" class="btn btn-light mt-3">Logout</a>
        </div>

        </div>

        <div class="right">
        <nav class="navbar navbar-light bg-light p-3 shadow-sm sticky-top">
         <div class="container-fluid">
           
        <form class="d-flex ms-auto search_frm">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="search1">
        <button class="btn btn-outline-primary" type="submit">Search</button>
    </form>
  </div>
</nav>
<div class="containt p-4">
    
</div>


</div>
</div>

<div class="msg d-none">

</div>

<script>
    $(document).ready(function() {
        $(".upload").click(function () {
            var input=document.createElement("INPUT");
            input.setAttribute("type","file");
            input.click();
            input.onchange=function(){
                $(".u_pro").removeClass("d-none");
                var file=new FormData();
                file.append("data",input.files[0]);

                var file_size=Math.floor(input.files[0].size/1024/1024);

                
                var free_storage=<?php echo $free_storage; ?>;
                if(file_size<free_storage)
                {

                
                $.ajax({
                    type:"POST",
                    url:"php/upload.php",
                    data:file,
                    processData:false,
                    contentType:false,
                    cache:false,
                    xhr:function(){
                        var request=new XMLHttpRequest();
                        request.upload.onprogress=function(e){
                        var loaded=(e.loaded/1024/1024).toFixed(2);
                        var total=(e.total/1024/1024).toFixed(2);
                        var upload_per=((loaded*100)/total).toFixed(0);
                        $(".upload_p").css("width",upload_per+"%");
                        $(".upload_p").html(upload_per+"%");

                        }
                        return request;
                    },
                    success:function(response){
                    var obj=  JSON.parse(response);
                    $(".u_pro").addClass("d-none");
                    if(obj.msg=="file upload successfully")
                    {

                        var new_per=(obj.used_storage)*100/<?php echo $total_storage; ?>;
                        $(".us").html(obj.used_storage);
                        $(".pb").css("width",new_per+"%");


                        var div=document.createElement("DIV");
                        div.className="alert alert-success mt-3";
                        div.innerHTML=obj.msg;
                        $(".upload_msg").append(div);

                        setTimeout(function(){
                        $(".upload_msg").html("");
                        $(".upload_p").css("width","0%");
                        $(".upload_p").html("");

         
                        },3000);


                    }
                    else{
                        var div=document.createElement("DIV");
                        div.className="alert alert-danger mt-3";
                        div.innerHTML=obj.msg;
                        $(".upload_msg").append(div);

                        setTimeout(function(){
                        $(".upload_msg").html("");
                        $(".upload_p").css("width","0%");
                        $(".upload_p").html("");

         
                        },3000);
                        
                    }
                    }
                })
            }
            else{
                var div=document.createElement("DIV");
                        div.className="alert alert-danger mt-3";
                        div.innerHTML="File size too large , kindly purchase more storage ";
                        $(".upload_msg").append(div);

                        setTimeout(function(){
                        $(".upload_msg").html("");
                        $(".upload_p").css("width","0%");
                        $(".upload_p").html("");
                        $(".u_pro").addClass("d-none");

         
                        },3000);


            }
            }
            
        });

        $(".menu").each(function () {
            $(this).click(function () {
                var page_link=$(this).attr("p_link");
                $.ajax({
                    type:"POST",
                    url:"php/pages/"+page_link+".php",
                    beforeSend:function(){
                       var div=document.createElement("DIV");
                       $(div).addClass("alert alert-success fs-2");
                       $(div).html("<i class='fas fa-spinner fa-spin'></i> Loading...");
                       $(".msg").html(div);
                       $(".msg").removeClass("d-none");

                    },
                    success:function(response){
                        $(".msg").addClass("d-none");
                        $(".containt").html(response);
                    }
                })
                
                
            })
            
        })
        // function my_files(){
        //     if("// echo $p_status;?>" == "activate"){
        //         $('[p_link="my_files"]').click();
        //     }
        //     else
        //     {
        //         $('[p_link="buy_storage"]').click();
                
        //     }
        // }



        $(".search_frm").submit(function (e) {
            e.preventDefault();
            var query=$("#search1").val();
            $.ajax({
                    type:"POST",
                    url:"php/pages/search.php",
                    data:{
                        query:query
                    },
                    beforeSend:function(){
                       var div=document.createElement("DIV");
                       $(div).addClass("alert alert-success fs-2");
                       $(div).html("<i class='fas fa-spinner fa-spin'></i> Loading...");
                       $(".msg").html(div);
                       $(".msg").removeClass("d-none");

                    },
                    success:function(response){
                        $(".msg").addClass("d-none");
                        $(".containt").html(response);
                    }
                })
            
        })
        
    })
</script>
</body>
</html>