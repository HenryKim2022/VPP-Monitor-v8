<?php
$appTitle = "";
$appDescb = "DB FK-Finder by Henry.K";
$favicon = '&#8801;';
?>

<!DOCTYPE html>
<html>

<head>
    <title><?= '  ' . $appTitle ?></title>
    <style>
        h5 {
            margin-bottom: 0.1rem;
        }

        pre.log-1 {
            font-family: monospace;
            border: 1px solid #ccc;
            padding: 10px;
            white-space: pre-wrap;
            overflow-x: auto;
            overflow-y: auto;
            max-height: 54vh;
            /* Set a maximum height for the log */
        }

        pre.log-2 {
            font-family: monospace;
            border: 1px solid #ccc;
            padding: 10px;
            white-space: pre-wrap;
            overflow-x: auto;
            overflow-y: scroll;
            max-height: 54vh;
            /* Set a maximum height for the log */
        }
    </style>

    <!-- DataTables BS5 -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css">
    <!-- DataTables Buttons -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

    <style>
        .second-log-container {
            overflow-x: auto;
        }

        #foreign-keys-table {
            width: 100%;
        }

        #foreign-keys-table th {
            background-color: #f8f9fa;
        }

        #foreign-keys-table th,
        #foreign-keys-table td {
            padding: 10px;
            text-align: center;
        }

        .number {
            font-weight: bold;
        }

        #foreign-keys-table thead th {
            background-color: #1a1b1c;
            color: #f8f9fa;
        }


        #foreign-keys-table tbody tr:nth-child(odd) {
            background-color: #cfdae5;
        }

        #foreign-keys-table tbody tr:nth-child(even) {
            background-color: #ffffff;
        }
    </style>

    <style>
        .dataTables_length {
            margin-right: 22px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination li a {
            display: block;
            padding: 5px 10px;
            background-color: #f8f9fa;
            color: #000;
            text-decoration: none;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .pagination li.active a {
            background-color: #007bff;
            color: #fff;
        }

        .pagination li.disabled a {
            pointer-events: none;
            opacity: 0.5;
        }

        .pagination li a:hover {
            background-color: #ccc;
        }
    </style>


    <!-- ------------------------------------------------------------------------------------------------------------------- -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jszip/dist/jszip.min.js"></script>
    <!-- ------------------------------------------------------------------------------------------------------------------- -->
    <script src="https://cdn.jsdelivr.net/npm/datatables.net-buttons-dt@2.0.0/js/buttons.dataTables.min.js"></script>

    <!-- JS DATATABLES: INIT & SETTINGS -->
    <script>
        $(document).ready(function() {
            $('#foreign-keys-table').DataTable({
                "paging": true,
                "searching": true,
                "lengthMenu": [10, 25, 50, 100, 200, 500],

                dom: '<"top"lfB>rt<"bottom"ip><"clear">',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print',
                    {
                        extend: 'print',
                        customize: function(win) {
                            $(win.document.head).find('link[rel="icon"]').remove();
                            $(win.document.head).find('title').remove();
                            $(win.document.head).find('title').text('');
                            $(win.document.body).find('footer').remove();
                        }
                    },
                ]
            });
        });
    </script>
    <!-- ENDOF: JS DATATABLES - INIT & SETTINGS -->


</head>

<body>
    <h1><?= $appDescb ?></h1>
    <div class="first-log-container">
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
                                        if ($key == "DB_CONNECTION") {
                                            $value = trim($value);
                                        }
                                        echo "$key = $value\n";
                                    }
                                }
                            }

                            // $servername = $envVariables['DB_HOST'];
                            // $username = $envVariables['DB_USERNAME'];
                            // $password = $envVariables['DB_PASSWORD'];
                            // $dbname = $envVariables['DB_DATABASE'];

                            // $conn = new mysqli($servername, $username, $password, $dbname);
                            ?>
        </pre>
    </div>

    <div class="second-log-container">
        <table id="foreign-keys-table" class="table table-striped table-responsive table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Table Name</th>
                    <th>Table Attributes</th>
                    <th>The FK in Attributes</th>
                    <th>Related Table Name</th>
                    <th>Related Table Attributes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = $envVariables['DB_HOST'];
                $username = $envVariables['DB_USERNAME'];
                $password = $envVariables['DB_PASSWORD'];
                $dbname = $envVariables['DB_DATABASE'];

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                function getTableAttributes($conn, $table)
                {
                    $attributes = [];
                    $result = $conn->query("SHOW COLUMNS FROM `$table`");
                    while ($row = $result->fetch_assoc()) {
                        $attributes[] = $row['Field'] . ' (' . $row['Type'] . ')';
                    }
                    return $attributes;
                }

                function getTableRows($conn, $table)
                {
                    $attributes = getTableAttributes($conn, $table);
                    $data = [];
                    $result = $conn->query("SELECT * FROM `$table`");
                    while ($row = $result->fetch_assoc()) {
                        $rowData = [];
                        foreach ($attributes as $attribute) {
                            $rowData[] = $row[$attribute];
                        }
                        $data[] = $rowData;
                    }
                    return $data;
                }

                $tables = [];
                $result = $conn->query("SHOW TABLES");
                while ($row = $result->fetch_row()) {
                    $tables[] = $row[0];
                }

                $count = 1;
                foreach ($tables as $table) {
                    $result = $conn->query("SHOW CREATE TABLE `$table`");
                    $row = $result->fetch_row();
                    $createTableQuery = $row[1];

                    preg_match_all('/FOREIGN KEY \(`(.*?)`\) REFERENCES `(.*?)` \(`(.*?)`\)/', $createTableQuery, $matches, PREG_SET_ORDER);

                    foreach ($matches as $match) {
                        $columnName = $match[1];
                        $referencedTable = $match[2];
                        $referencedColumn = $match[3];

                        $tableAttributes = getTableAttributes($conn, $table);
                        $referencedTableAttributes = getTableAttributes($conn, $referencedTable);

                        echo '<tr>';
                        echo '<td class="number">' . $count . '</td>';
                        echo '<td>' . $table . '</td>';
                        echo '<td>' . implode("<br>", $tableAttributes) . '</td>';
                        echo '<td>' . $columnName . '</td>';
                        echo '<td>' . $referencedTable . '</td>';
                        echo '<td>' . implode("<br>", $referencedTableAttributes) . '</td>';
                        echo '</tr>';

                        $count++;
                    }
                }

                $conn->close();

                if (count($tables) === 0) {
                    echo '<tr><td colspan="6">Database empty</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>


</body>

</html>