<!DOCTYPE html>
<html>
<head>
    <title>SPC FIFO SYSTEM</title>
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }
        
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .button {
            margin: 10px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            background-color: #005293;
            color: #fff;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #002d5f;
        }
    </style>
</head>
<body>
    <div style="background-color: #03234b;">
        <div style="float: right; margin: 10px 10px 20px 20px;">
            <img src="epu2qqrv.png" alt="ST">
        </div>
        <div style="background-color: #03234b; margin: 0; overflow-x: hidden; overflow-y: auto; padding: 0;">
            <h1 style="color: white; text-align: center;">SPC SYSTEM</h1>
        </div>
    </div>
    
    <div class="container">
        <button class="button" onclick="window.open('input_data.php', '_blank')">Sample Input Data</button>
        <button class="button" onclick="window.open('affichage.php', '_blank')">List of Samples (Not Yet Measured)</button>
        <button class="button" onclick="window.open('login.php', '_blank')">Sample Output Data/Machine</button>
        <button class="button" onclick="window.open('time.php', '_blank')">check machine time status</button>
        <button class="button" onclick="window.open('data.php', '_blank')">All Data</button>
    </div>
</body>
</html>
