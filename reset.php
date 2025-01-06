<?php 
    $appTitle = "";
    $favicon = '&#8801;';
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $favicon . '  Database Resettor' ?></title>
    <style>
        h5{
            margin-bottom: 0.1rem;
        }
        pre.log-1 {
            font-family: monospace;
            border: 1px solid #ccc;
            padding: 10px;
            white-space: pre-wrap;
            overflow-x: auto;
            overflow-y: auto;
            max-height: 54vh; /* Set a maximum height for the log */
        }
        pre.log-2 {
            font-family: monospace;
            border: 1px solid #ccc;
            padding: 10px;
            white-space: pre-wrap;
            overflow-x: auto;
            overflow-y: scroll;
            max-height: 54vh; /* Set a maximum height for the log */
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var logContainer = document.querySelector('.log-2');
            logContainer.scrollTop = logContainer.scrollHeight; // Scroll to the bottom of the log
        });
    </script>
</head>
<body>
    <h1>DATABASE RESETTOR</h1>
    <div class="1st-log-container">
        <pre class="log-1"><?php
            // Read the .env file and parse it into an array
            $envFile = __DIR__ . '/.env';
            $envData = file_get_contents($envFile);
            $envVariables = [];

            // Parse each line of the .env file
            $lines = explode("\n", $envData);
            foreach ($lines as $line) {
                $line = trim($line);

                // Display log
                if (!empty($line) && strpos($line, '=') !== false) {
                    list($key, $value) = explode('=', $line, 2);
                    $key = trim($key);
                    $value = trim($value); // Trim the value to remove leading and trailing spaces

                    $envVariables[$key] = $value;
                    $envVariables[$key] = str_replace('"', '', $value);

                    if ($key == "DB_CONNECTION" || $key == "DB_HOST" || $key == "DB_PORT" || $key == "DB_DATABASE" || $key == "DB_USERNAME" || $key == "DB_PASSWORD") {
                        echo "$key = $value\n";
                    }
                }
            }
            ?>
        </pre>
    </div>

    <div class="2nd-log-container">
       <h5>Logs: <br></h5> 
        <pre class="log-2"><?php
            $servername = $envVariables['DB_HOST'];
            $username = $envVariables['DB_USERNAME'];
            $password = $envVariables['DB_PASSWORD'];
            $dbname = $envVariables['DB_DATABASE'];

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $conn->query("SET FOREIGN_KEY_CHECKS=0");

            $tablesResult = $conn->query("SHOW TABLES");
            $tables = [];
            while ($row = $tablesResult->fetch_row()) {
                $tables[] = $row[0];
            }

            foreach ($tables as $table) {
                $conn->query("DROP TABLE IF EXISTS `$table`");

                echo "Dropped table: $table\n";
                if (count($tables) === 0) {
                    echo "Database cleared :)";
                }
            }

            $conn->query("SET FOREIGN_KEY_CHECKS=1");

            $conn->close();

            if (count($tables) === 0) {
                echo "Database empty";
            }
        ?></pre>
    </div>
</body>
</html>