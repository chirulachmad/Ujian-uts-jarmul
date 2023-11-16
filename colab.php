<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Project</title>
    <style>
        /* CSS untuk styling */
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 50px;
        }

        label {
            font-size: 16px;
            margin-top: 20px;
            display: block;
        }

        select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 24px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 5px;
            transition-duration: 0.4s;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <label for="projectSelect">Pilih Proyek:</label>
        <select id="projectSelect">
            <option value="radio.php">Proyek Radio</option>
            <option value="image_converted.php">Proyek Konverter Gambar</option>
        </select>
        <br><br>
        <button onclick="openProject()">Buka Proyek</button>
    </div>

    <script>
        function openProject() {
            const projectSelect = document.getElementById('projectSelect');
            const selectedProject = projectSelect.value;
            window.location.href = selectedProject;
        }
    </script>
</body>

</html>
