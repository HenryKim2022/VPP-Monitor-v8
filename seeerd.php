<?php
$appTitle = "";
$appDescb = "DB ERD-Generator by Henry.K";
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

        .container{
            margin-left: 2rem;
            margin-right: 2rem;
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
    <h1 class="container"><?= $appDescb ?></h1>
        <div class="first-log-container container">
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

    <div class="third-log-container container">
        <!-- JointJS dependencies -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
        <!-- JointJS library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jointjs/3.5.1/joint.min.js"></script>

        <script>
            function fetchTableData() {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'get_erd_data.php', true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                        var responseData = JSON.parse(xhr.responseText);
                        generateERD(responseData.tables, responseData.relationships);
                    }
                };
                xhr.send();
            }

            function generateERD(tablesData, relationshipsData) {
                var graph = new joint.dia.Graph();

                var canvas = document.querySelector('.third-log-container');
                var paperContainer = document.createElement('div');
                paperContainer.style.width = '100%';
                paperContainer.style.height = '500vh';
                canvas.appendChild(paperContainer);

                var paper = new joint.dia.Paper({
                    el: paperContainer,
                    model: graph,
                    width: '100%',
                    height: '500vh',
                    gridSize: 10,
                    drawGrid: true,
                    background: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    interactive: {
                        zoom: true,
                        touch: false
                    },
                    async: true
                });

                var jointShapes = {};
                tablesData.forEach(function(tableData, index) {
                    var rect = tableData.shape;
                    var x = (index % 5) * 200 + 100;
                    var y = Math.floor(index / 5) * 150 + 100;

                    rect.position = {
                        x: x,
                        y: y
                    };

                    var labelLines = tableData.shape.attrs.label.text.split('\n');
                    var labelHeight = labelLines.length * 16;

                    rect.size = {
                        width: labelLines.reduce((maxWidth, line) => Math.max(maxWidth, line.length * 8), 0) + 8,
                        height: 8 + labelHeight
                    };

                    var jointShape = new joint.shapes.standard.Rectangle({
                        position: rect.position,
                        size: rect.size,
                        attrs: {
                            body: rect.attrs.body,
                            label: {
                                text: rect.attrs.label.text,
                                fill: rect.attrs.label.fill,
                                'font-size': rect.attrs.label.fontSize,
                                'font-weight': rect.attrs.label.fontWeight,
                                'ref-y': '1%',
                                'y-alignment': 'middle',
                                'pointer-events': 'none'
                            }
                        }
                    });

                    graph.addCell(jointShape);
                    jointShapes[tableData.id] = jointShape;
                });


                paper.on('scale', function(scale) {
                    graph.getCells().forEach(function(cell) {
                        if (cell.isElement()) {
                            var label = cell.findView(paper).findBySelector('text');
                            var labelFontSize = parseInt(label.attr('font-size'), 10);
                            label.attr('transform', 'scale(' + (1 / scale.sx) + ')');
                            label.attr('y', labelFontSize / (2 * scale.sx));
                        }
                    });
                });



                relationshipsData.forEach(function(relationship) {
                    var sourceTable = relationship.TABLE_NAME;
                    var targetTable = relationship.REFERENCED_TABLE_NAME;

                    if (jointShapes[sourceTable] && jointShapes[targetTable]) {
                        var sourceShape = jointShapes[sourceTable];
                        var targetShape = jointShapes[targetTable];

                        var link = new joint.dia.Link({
                            source: {
                                id: sourceShape.id
                            },
                            target: {
                                id: targetShape.id
                            },
                            smooth: true,
                            attrs: {
                                '.connection': {
                                    'stroke': 'red',
                                    'fill': 'transparent',
                                    'stroke-width': 2
                                }
                            }
                        });

                        link.attr('.connection-wrap/fill', 'none');

                        link.addTo(graph);
                    }
                });

                var zoomInButton = document.createElement('button');
                zoomInButton.innerText = '+';
                zoomInButton.onclick = function() {
                    paper.scale(paper.scale().sx + 0.2, paper.scale().sy + 0.2);
                };

                var zoomOutButton = document.createElement('button');
                zoomOutButton.innerText = '-';
                zoomOutButton.onclick = function() {
                    paper.scale(paper.scale().sx - 0.2, paper.scale().sy - 0.2);
                };

                var zoomContainer = document.createElement('div');
                zoomContainer.appendChild(zoomInButton);
                zoomContainer.appendChild(zoomOutButton);

                var zoomWrapper = document.createElement('div');
                zoomWrapper.appendChild(zoomContainer);
                canvas.appendChild(zoomWrapper);


            }

            fetchTableData();
        </script>
    </div>

</body>

</html>
