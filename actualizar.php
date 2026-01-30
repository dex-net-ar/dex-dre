<?php
// Configuración de cantidad máxima de registros en el historial
$max_historial = 5; // Cambia este valor para ajustar el límite
$historial = array_slice($historial, 0, 5);
// Configuración de credenciales

$apikey = 'L0MH80T0uphNVD1L5mLM60aEIjLTn6qb';
$apisecret = 'ExpOiHDq5o7jBXgfL9sWvmsppiWYEQj1';

$canales = [
	[
		'uuid' => 'Q40T',
		'nombre' => 'Turbina 1'
	],
	[
		'uuid' => 'NBG2',
		'nombre' => 'Turbina 2'
	]
];


/*

$apikey = 'jlCllO4kExY3sEEA';
$apisecret = 'L551wIjhwQKQROId';

$canales = [
    [
        'uuid' => 'KRNG',
        'nombre' => 'Turbina 1'
    ],
    [
        'uuid' => 'BIEV',
        'nombre' => 'Turbina 2'
    ]
];

*/


$resultados = [];
$turbina1 = null;
$turbina2 = null;

foreach ($canales as $canal) {
    $uuid = $canal['uuid'];
    $nombre = $canal['nombre'];
    $url = "https://api.reactor.com.ar/v1/channels?uuid={$uuid}&command=status&apikey={$apikey}&apisecret={$apisecret}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if (isset($data['status']['code']) && $data['status']['code'] == '200' && isset($data['channel'])) {
        $estado = [
            'uuid' => $data['channel']['uuid'],
            'nombre' => $nombre,
            'value' => $data['channel']['value'],
            'online' => $data['channel']['online'],
            'url' => $url
        ];
        echo "URL de consulta:\n$url\n";
        echo "Contenido a guardar en estados.txt (parcial):\n" . json_encode($estado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
        $resultados[] = $estado;
        if ($nombre === 'Turbina 1') $turbina1 = $data['channel']['value'];
        if ($nombre === 'Turbina 2') $turbina2 = $data['channel']['value'];
    } else {
        $decoded_response = json_decode($response, true);
        $error = [
            'nombre' => $nombre,
            'uuid' => $uuid,
            'error' => $data['status']['message'] ?? 'Error desconocido',
            'code' => $data['status']['code'] ?? 'N/A',
            'http_code' => $http_code,
            'curl_error' => $curl_error,
            'response' => $decoded_response ? $decoded_response : $response,
            'url' => $url
        ];
        echo "URL de consulta:\n$url\n";
        echo "Contenido a guardar en estados.txt (parcial):\n" . json_encode($error, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
        $resultados[] = $error;
        if ($nombre === 'Turbina 1') $turbina1 = null;
        if ($nombre === 'Turbina 2') $turbina2 = null;
    }
}




// Calcular nivel según los valores de response.channel.value de los dos canales filtrados
$nivel = 0;
if (count($canales_filtrados) === 2) {
    // Asegurarse de que el primer canal sea Turbina 1 y el segundo Turbina 2
    $turbinas = [null, null];
    foreach ($canales_filtrados as $canal) {
        if (isset($canal['nombre']) && $canal['nombre'] === 'Turbina 1') {
            $turbinas[0] = isset($canal['response']['channel']['value']) ? (string)$canal['response']['channel']['value'] : null;
        } elseif (isset($canal['nombre']) && $canal['nombre'] === 'Turbina 2') {
            $turbinas[1] = isset($canal['response']['channel']['value']) ? (string)$canal['response']['channel']['value'] : null;
        }
    }
    $v1 = $turbinas[0];
    $v2 = $turbinas[1];
    // Log temporal para depuración
    error_log("DEBUG nivel: v1=$v1, v2=$v2");
    if ($v1 === '1' && $v2 === '1') {
        $nivel = 100;
    } elseif (($v1 === '1' && $v2 === '0') || ($v1 === '0' && $v2 === '1')) {
        $nivel = 50;
    } else {
        $nivel = 0;
    }
}



// Excluir el nodo del canal 'Boton' y reindexar
$canales_filtrados = array_values(array_filter($resultados, function ($canal) {
    return isset($canal['nombre']) && $canal['nombre'] !== 'Boton';
}));

// Inicializar valores por defecto
$estado_canal_1 = null;
$estado_canal_2 = null;

// Asignar los estados de los canales según el nombre
foreach ($canales_filtrados as $canal) {
    if (isset($canal['nombre']) && $canal['nombre'] === 'Turbina 1') {
        $estado_canal_1 = isset($canal['response']['channel']['value']) ? (string)$canal['response']['channel']['value'] : null;
    } elseif (isset($canal['nombre']) && $canal['nombre'] === 'Turbina 2') {
        $estado_canal_2 = isset($canal['response']['channel']['value']) ? (string)$canal['response']['channel']['value'] : null;
    }
}

// Calcular nivel según los valores de los canales
$nivel = 0;
if ($estado_canal_1 !== null && $estado_canal_2 !== null) {
    if ($estado_canal_1 === '1' && $estado_canal_2 === '1') {
        $nivel = 100;
    } elseif (($estado_canal_1 === '1' && $estado_canal_2 === '0') || ($estado_canal_1 === '0' && $estado_canal_2 === '1')) {
        $nivel = 50;
    } else {
        $nivel = 0;
    }
}



// Leer historial anterior si existe
$historial = [];
$estadosFile = __DIR__ . '/estados.txt';
if (file_exists($estadosFile)) {
    $jsonPrevio = file_get_contents($estadosFile);
    $datosPrevios = json_decode($jsonPrevio, true);
    if (isset($datosPrevios['historial']) && is_array($datosPrevios['historial'])) {
        $historial = $datosPrevios['historial'];
    }
    // Solo agregar si el caudal cambió respecto al registro más reciente (primer elemento)
    $ultimo = isset($historial[0]) ? $historial[0] : null;
    if (!isset($ultimo['caudal']) || $ultimo['caudal'] !== $nivel) {
        // Si ya hay $max_historial registros, eliminar el último antes de agregar el nuevo
        if (count($historial) >= $max_historial) {
            array_pop($historial);
        }
        $dt = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
        array_unshift($historial, [
            'hora' => $dt->format('d/m/y - H:i'),
            'caudal' => $nivel
        ]);
    }
} else {
    // Primer registro
    $dt = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
    array_unshift($historial, [
        'hora' => $dt->format('d/m/y - H:i'),
        'caudal' => $nivel
    ]);
}



$dt_actual = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
 $salida = [
    'hora_actual' => $dt_actual->format('H:i d/m/y'),
    'turbina_1' => $estado_canal_1,
    'turbina_2' => $estado_canal_2,
    'caudal_actual' => $nivel,
    'historial' => $historial
];

$json = json_encode($salida, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo "\nContenido final a guardar en estados.txt:\n$json\n";
file_put_contents(__DIR__ . '/estados.txt', $json);
echo "\nEstados guardados en estados.txt\n";
