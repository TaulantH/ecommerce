<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title>Hero</title>
    <style>
        
        .hero{
            width:100%;
            height:91vh;
            position: relative;
        }
        .imgLeft{
            position: absolute;
            width:50%;
            height:100%;
            background-image: url(https://images.pexels.com/photos/17865804/pexels-photo-17865804/free-photo-of-frau-baume-stehen-stuhl.jpeg?auto=compress&cs=tinysrgb&w=800);
            background-size: cover;
            background-repeat: no-repeat;
            background-position:center;
        }
        .imgRight{
            position:absolute;
            left:50%;
            width:50%;
            height:100%;
            background-image: url(https://images.pexels.com/photos/15126137/pexels-photo-15126137/free-photo-of-fashion-mann-gehen-feld.jpeg?auto=compress&cs=tinysrgb&w=800);
            background-size: cover;
            background-repeat: no-repeat;
            background-position:center;
        }
        .containerHero{
            position:absolute;
            left:50%;
            top: 50%;
            transform: translate(-50%, -50%);
            /* height: 30vh; */
            width: 40vw;
            background: #403D39;
        }
        .containerBorder{
            height:95%;
            margin: 1%;
            border: 1px solid #EB5E28;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items:center;
            
        }
        .containerBorder h1{
            color: #CCC5B9;
            font-size: 70px;
            margin: 0px 5px 0px 5px
        }
        .name{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items:center;
            padding-bottom: 10px
        }
        .welcome{
            display: flex;
            justify-content: center;
            align-items:center;
            text-align:center;
        }
        .text{
            color: #CCC5B9;
            font-size: 30px;
            border-top: 1px solid #EB5E28;
            /* padding-top: 10px; */
            /* padding-bottom: 10px */
            margin: 0px
            
        }
        @media(max-width: 567px){
            .containerHero{
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="hero">
        <div class="imgLeft">
        </div>
        <div class="imgRight">
        </div>
        <div class="containerHero">
            <div class="containerBorder">
                <div class="name">
                    <div class="welcome"><h1>Welcome to</h1></div>
                    <h1>Stylespot</h1> 
                    </div>
                
                <p class="text">Your Fashion-Hotspot!</p>
            </div>
            
        </div>
    </div>
</body>
</html>
