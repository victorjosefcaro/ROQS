<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ROQS - Restaurant Ordering and Queuing System</title>

    <style>
        /* Reset some default browser styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Apply a modern background with a moving gradient */
        body {
            background: #ffffff;
            background-size: 400% 400%;
            animation: gradientAnimation 20s linear infinite;
            font-family: "Catamaran", sans-serif;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 100vh;
        }

        /* Center the content vertically and horizontally */
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex: 1;
            padding: 1rem;
        }

        h1 {
            margin-top: 5rem;
        }

        .container label {
            margin: 1rem;
        }

        form input {
            width: 30%;
            height: 2rem;
            text-align: center;
        }

        .name1 {
            margin-top: 5rem;
            padding-bottom: 5rem;
        }

        .yourName {
            font-size: 2rem;
        }

        #cName {
            padding: 1rem;
            font-size: 1.2rem;
            text-align: center;
        }

        /* Style the logo */
        .logo {
            max-width: 30%;
            max-height: 30vh;
            height: auto;
            margin-bottom: 10px;
        }

            /* Style the "Get Started" button */
            .btn {
                background-color: #333;
                color: #fff;
                padding: 0.7rem 1.5rem;
                text-decoration: none;
                border: none;
                border-radius: 5px;
                font-size: 1.5rem;
                margin: 1.5rem auto; /* Center the button horizontally */
                transition: background-color 0.3s, transform 0.2s;
                max-width: 200px; /* Set a specific maximum width for the button */
                width: auto; /* Allow it to adjust its width based on content */
                height: 3rem;
            }

            /* Add hover effect */
            .btn:hover {
                background-color: #444;
                transform: scale(1.05);
            }

        /* Style the button on mobile view */
        @media (max-width: 768px) {
            .btn {
                padding: 0.7rem 1.5rem;
                font-size: 1.5rem;
            }

            /* Set a specific max-width for the logo on mobile view */
            .logo {
                max-width: 60%;
            }
        }

        /* Gradient animation for the background */
        @keyframes gradientAnimation {
            0% {
                background-position: 100% 0%;
            }
            100% {
                background-position: 0% 100%;
            }
        }

        /* Style the copyright notice */
        .copyright {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 1rem 0;
        }   

        /* Add space between the button and copyright */
        .spacer {
            height: 2rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="logo1.png" alt="ROQS Logo" class="logo" />
    </div>
    <a href="index.php" class="btn">Get Started</a>
    <!-- Add the spacer with the .spacer class -->
    <div class="spacer"></div>
    <footer class="copyright">
        &copy; 2023 ROQS - Restaurant Ordering and Queuing System. All rights reserved.
    </footer>
</body>
</html>
