<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BagKat Konek</title>
    <style>
        #loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background-color: #e0f7e0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        #loading-text {
            font-size: 24px;
            margin-top: 20px;
            color: #2e7d32;
        }

        .spinner {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #2e7d32;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div id="loading-screen">
        <div class="spinner"></div>
        <div id="loading-text">Redirecting...</div>
    </div>

    <script>
        function checkForBackNavigation() {
            if (performance.navigation.type === 2) {
                window.location.href = 'php/home.php';
            }
        }

        window.onload = function() {
            checkForBackNavigation();

            setTimeout(function() {
                window.location.href = 'php/home.php';
            }, 3000);
        };

        window.addEventListener('popstate', function(event) {
            checkForBackNavigation();
        });
    </script>
</body>

</html>
