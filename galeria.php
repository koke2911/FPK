<?php
$baseDir = 'public/galery';
$categorias = [
    'babysitting',
    'Capacitaciones_',
    'Javiera_Aliaga',
    'playgroup',
    'Talleres_personalizados',
    'terapias'
];

function mostrarImagenes($ruta, $categoria)
{
    $imagenes = glob($ruta . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
    if (count($imagenes) === 0) return;

    echo "<h3 style='margin-top:2em;color:#2a9d8f;text-align:center;'>$categoria</h3>";
    echo "<div class='galeria-grid'>";
    foreach ($imagenes as $img) {
        echo "<div class='galeria-item'><img src='$img' alt='$categoria'></div>";
    }
    echo "</div>";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Galería Fonoplay Kids</title>
    <link rel="stylesheet" href="public/libreries/bootstrap-4.6/bootstrap.min.css">
    <style>
        .galeria-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            padding: 1rem;
        }

        .galeria-item {
            width: 100%;
            height: 200px;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .galeria-item:hover {
            transform: scale(1.02);
        }

        .galeria-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.3s ease;
        }

        .galeria-item img:hover {
            transform: scale(1.05);
        }


        h2 {
            text-align: center;
            margin-top: 2rem;
            font-size: 2rem;
            color: #264653;
        }

        body {
            background: #f9fafb;
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body>
    <h2>Galería Fonoplay Kids</h2>
    <?php
    foreach ($categorias as $categoria) {
        $ruta = $baseDir . '/' . $categoria;
        mostrarImagenes($ruta, str_replace('_', ' ', $categoria));
    }
    ?>
</body>

<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script> -->

</html>