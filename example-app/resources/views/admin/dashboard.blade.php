<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <title>Dashboard</title>
</head>
<body>
<div class="menu">
    <ul>
        <li class="profile">
            <div class="img-box">
                <img src="https://i.postimg.cc/SxbYPS5c/userimg.webp" alt="image">
            </div>
            <h2>user</h2>
        </li>
        <li>
            <a href="/adminDashboard" class="active">
                <i class="fas fa-home"></i>
                <p>dashboard</p>
            </a>
        </li>
        <li>
            <a href="/adminGetUsers">
                <i class="fas fa-user-group"></i>
                <p>clients</p>
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fas fa-table"></i>
                <p>products</p>
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fas fa-chart-pie"></i>
                <p>charts</p>
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fas fa-pen"></i>
                <p>posts</p>
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fas fa-star"></i>
                <p>favorite</p>
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fas fa-cog"></i>
                <p>settings</p>
            </a>
        </li>
        <li class="log-out">
            <a href="#">
                <i class="fas fa-sign-out"></i>
                <p>Log Out</p>
            </a>
        </li>
    </ul>

</div>


<div class="content">
    <div class="title-info">
        <p>dashboard</p>
        <i class="fas fa-chart-bar"></i>
    </div>
    <div class="data-info">
        <div class="box">
            <i class="fas fa-user"></i>
            <div class="data">
                <p>user</p>
                <span>100</span>
            </div>
        </div>
        <div class="box">
            <i class="fas fa-pen"></i>
            <div class="data">
                <p>posts</p>
                <span>101</span>
            </div>
        </div>
        <div class="box">
            <i class="fas fa-table"></i>
            <div class="data">
                <p>product</p>
                <span>102</span>
            </div>
        </div>
        <div class="box">
            <i class="fas fa-dollar"></i>
            <div class="data">
                <p>revenue</p>
                <span>$100</span>
            </div>
        </div>

    </div>
    <div class="title-info">
        <p>products</p>
        <i class="fas fa-table"></i>
    </div>
    <table>
        <thead>
        <tr>
            <th>prpduct</th>
            <th>price</th>
            <th>count</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>tv</td>
            <td><span class="price">$100</span></td>
            <td><span class="count">30</span></td>
        </tr>
        <tr>
            <td>phone</td>
            <td><span class="price">$150</span></td>
            <td><span class="count">30</span></td>
        </tr>
        <tr>
            <td>charger</td>
            <td><span class="price">$10</span></td>
            <td><span class="count">30</span></td>
        </tr>
        <tr>
            <td>laptop</td>
            <td><span class="price">$350</span></td>
            <td><span class="count">70</span></td>
        </tr>
        <tr>
            <td>keyboard</td>
            <td><span class="price">$20</span></td>
            <td><span class="count">70</span></td>
        </tr>
        <tr>
            <td>mouse</td>
            <td><span class="price">$5</span></td>
            <td><span class="count">70</span></td>
        </tr>
        <tr>
            <td>mic</td>
            <td><span class="price">$50</span></td>
            <td><span class="count">70</span></td>
        </tr>
        </tbody>
    </table>

</div>


</body>
</html>

<style>
    *{
        padding: 0;
        margin: 0;
        color: white;
        font-family: sans-serif;
    }
    body{
        background-color:#001;
        display: flex;

    }
    .profile{
        display: flex;
        align-items: center;
        gap: 30px;
    }
    .profile h2{
        font-size: 20px;
        text-transform: capitalize;
    }
    .img-box{
        width: 50px;
        height: 50px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid white;
        flex-shrink: 0;
    }
    .img-box img{
        width: 100%;
    }

    .menu{
        background-color: #123;
        width: 60px;
        height: 100vh;
        padding: 20px;
        overflow: hidden;
        transition: 0.5s;
    }
    .menu:hover{
        width: 260px;
    }
    ul{
        list-style: none;
        position: relative;
        height: 95%;
    }
    ul li a{
        display: block;
        text-decoration: none;
        padding: 10px;
        margin: 10px 0;
        border-radius: 8px;
        display: flex;
        gap: 40px;
        align-items: center;
        transition: 0.5s;

    }
    ul li a:hover, .active , .box:hover, td:hover{
        background-color: #ffffff55;
    }
    .log-out{
        position: absolute;
        bottom: 0;
        width: 100%;

    }
    .log-out a{
        background-color:#a00 ;
    }
    ul li a i{
        font-size: 30px;
    }
    .content{
        width: 100%;
        margin: 10px;
    }
    .title-info{
        background-color: #0481ff;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-radius: 8px;
        margin: 10px 0;
    }
    .data-info{
        display:flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;

    }
    .box{
        background-color: #123;
        height: 150px;
        flex-basis: 150px;
        flex-grow: 1;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: space-around;

    }

    .box i{
        font-size:40px
    }
    .box .data{
        text-align: center;
    }

    .box .data span{
        font-size: 30px;
    }
    table{
        width: 100%;
        text-align: center;
        border-spacing: 8px;

    }
    th,td{
        background-color: #123;
        height: 40px;
        border-radius: 8px;
    }
    th{
        background-color: #0481ff;
    }
    .price , .count{
        padding: 6px;
        border-radius: 6px;
    }
    .price{
        background-color: green;
    }
    .count{
        background-color: gold;
        color: black;
    }

</style>
