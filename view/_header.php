<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        header {
            background-color: #f7b705; 
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .name {
            font-family: Arial, sans-serif;
            font-size: 25px;
            margin-right: 10px;
            font-weight: bold;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        
        nav ul li {
            display: inline;
            margin-right: 20px;
        }
        
        nav ul li a {
            color: #fff;
            text-decoration: none;
        }
        
        nav ul li a:hover {
            text-decoration: underline;
        }
        
        footer {
            background-color: #f8f9fa;
            color: #333;
            text-align: center;
            padding: 10px 0;
        }
        .logo {
            font-family: 'Brush Script MT'; /* Postavljanje fonta */
            font-size: 50px; /* Postavljanje veličine fonta */
            color: #fff; /* Boja teksta */
        }

        table {
            width: calc(100% - 30px); /* Smanjuje širinu tablice za 20 piksela */
            margin: 0 auto; /* Centrira tablicu */
        }

        .expense-description {
            text-align: left;
            font-size: 14px;
        }

        .expense-ime {
            text-align: left;
            font-size: 18px;
            font-weight: bold;
        }

        .expense-euro {
            text-align: right;
            font-size: 24px;
            font-weight: bold;
        }

        .overview-ime{
            text-align: left;
            font-size: 18px;
        }

        .logout-btn {
            background-color: #ff7f0e; 
            color: #fff; 
            padding: 7px 15px; /* Velicina paddinga */
            border: none; /* Uklanja granicu */
            border-radius: 4px; /* Zaobljeni rubovi */
            cursor: pointer; 
            font-size: 10px; 
            text-transform: uppercase; 
            text-decoration: none; 
        }

        .logout-btn:hover {
            background-color: #ff9f43; 
        }
        
        ul {
            margin: 0;
            padding: 0;
            list-style-type: none; /* Uklanja točkice */
        }
        

    </style>
</head>
<body>
    <header>
        <div class="logo">
            Balance
        </div>
        <nav>
            <ul>
                
                <li><a href="balance.php?rt=overview">Overview <?php echo $korisnik_overview; ?></a></li>
                <li><a href="balance.php?rt=expenses">Expenses</a></li>
                <li><a href="balance.php?rt=newexpense">New expense</a></li>
                <li><a href="balance.php?rt=settleup">Settle up!</a></li>
            </ul>
        </nav>

        <div class="name">
            <?php
                if(isset($_SESSION['user']))
                    echo 'Hello, '. $_SESSION['user'] . '!';
                else if(isset($_COOKIE['user']))
                    echo 'Hello, '. $_COOKIE['user'] . '!';
            ?>
        </div>
        <form id="logout" action="logout.php" method="post">
            <button type="submit" form="logout" class="logout-btn"> Logout</button>
        </form>

    </header>

