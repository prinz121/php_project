<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prinz Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: Georgia, 'Times New Roman', Times, serif;
            overflow-y: scroll;
  scrollbar-width: 0;
  overflow-x: hidden;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            color: #2b2b2b;
            background-color: #2b2b2b;
            scroll-behavior: smooth;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        }
        body::-webkit-scrollbar{
  display: none;
}
        header {
            background: linear-gradient(120deg, #1a1d23, #3a3f4b);
            color: white;
            text-align: center;
            padding: 100px 20px;
            position: relative;
            overflow: hidden;
        }
        header h1 span {
            color: #ffd700;
        }
        header a.btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #ffd700;
            color: #333;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        header a.btn:hover {
            background: #333;
            color: #ffd700;
            transform: scale(1.1);
        }
        nav {
            background: #333;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 10px 0;
            display: flex;
            justify-content: center;
        }
        nav ul li {
            margin: 0 15px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }
        nav ul li a:hover {
            color: #ffd700;
        }
        section {
            padding: 50px 20px;
            text-align: center;
            background: white;
            margin: 20px auto;
            max-width: 1200px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            animation: fadeIn 1s ease-in-out forwards;
        }
        .projects {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .project-card {
            background: #aaa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 300px;
        }
        .project-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        footer {
            background: black;
            color: white;
            text-align: center;
            padding: 1px;
            position: relative;
            bottom: 0;
            width: 100%;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @media (max-width: 768px) {
            .projects {
                flex-direction: column;
                align-items: center;
                background-color: #2b2b2b;
                font-family: 'Courier New', Courier, monospace;
            }
            .project-card {
                width: 90%;
                background-color: #1a1d23;
                color: #f4f4f4
            }
        }
        .back-btn {
    position: absolute;
    top: 20px;
    left: 20px;
}

.back-btn a {
    text-decoration: none;
    background: #333;
    color: #f1c40f;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    display: inline-block;
    box-shadow: 0 0 6px #f1c40f;
    transition: background-color 0.3s ease;
}

.back-btn a:hover {
    background: #d4ac0d;
    color: #121212;
    box-shadow: 0 0 10px #d4ac0d;
}
footer {
      background-color: #1a1d23;
      color: #ccc;
      padding: 20px;
      text-align: center;
      font-size: 14px;
      margin-top: 50px;
    }

    footer a {
      color: #f1c40f;
      text-decoration: none;
      margin: 0 10px;
    }


    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="back-btn">
                <a href="index.php">←</a>
            </div></div>
        <div class="hero">
            <h1>Hello, I'm <span>Prinz</span></h1>
            <p>Welcome to my personal portfolio website!</p>
            <a href="#about" class="btn">Discover More</a>
        </div>
    </header>
    <nav>
        <ul>
            <li><a href="#about">About</a></li>
            <li><a href="#project">Favorite</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </nav>
    <section id="about" style="background-color:  white; ">
        <h2>About Me</h2>
        <p>Hi, I'm Prinz, a passionate entrepreneur driven by innovation and global connectivity. My mission is to bridge the gap in mobile technology accessibility, delivering top-quality phone worldwide.</p>
    </section>
    <section id="project">
        <h2>Favorite</h2>
        <div class="projects">
            <div class="project-card">
                <h3>FOOD</h3>
                
                   <br> Fried Chicken
                   <br>  Shanghai
                   <br>  Chocolate
                
                </div>
            <div class="project-card">
                <h3>MOVIE</h3>
                
                    <br>Fast & Furious
                    <br>Avengers
                    <br>Avatar
                
            </div>
            <div class="project-card">
                <h3>MUSIC</h3>
                
                    <br>Moon
                    <br>Sun
                    <br>Land
                
            </div>
        </div>
    </section>
    <section id="contact" style="background-color: white;">
        <h2>Contact Me</h2>
        <p>Email: <a href="mailto:prinzlopez123@gmail.com">prinzlopez123@gmail.com</a></p>
        <p>Phone: 09123456789</p>
    </section>
    <footer><p>&copy; <?php echo date("Y"); ?> Tecno Zone. All rights reserved.</p>
  <p><a href="index">Home</a> | <a href="about.html">About</a> | <a href="upload13.php">Admin</a></p>
</footer>
</body>
</html>
