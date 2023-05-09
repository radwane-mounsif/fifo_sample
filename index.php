<!DOCTYPE html>
<html>
<head>
	<title>SPC FIFO SYSTEM</title>
	<style>
		.container {
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			height: 100vh;
		}

		.button {
			margin: 10px;
			padding: 10px 20px;
			border: none;
			border-radius: 5px;
			font-size: 18px;
			font-weight: bold;
			cursor: pointer;
		}
	</style>
</head>
<body>
	<div class="container">
        <h1>SPC styem</h1>
		<button class="button" onclick="window.open('input_data.php', '_blank')">Sample input data</button>
		<button class="button" onclick="window.open('affichage.php', '_blank')">List of samples (not yet measured)</button>
                <button class="button" onclick="window.open('login.php', '_blank')">Sample output data/machine</button>
		<button class="button" onclick="window.open('data.php', '_blank')">ALL data</button>
		
	</div>
</body>
</html>
