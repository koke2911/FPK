<?php
// session_start();
// require_once('../config/database.php');

// $conn = new mysqli($servername, $username, $password, $dbname);

$id = $_GET['id'];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play Kids</title>
    <link rel="stylesheet" href="public/libreries/bootstrap-4.6/bootstrap.min.css">
    <link rel="stylesheet" href="public/libreries/vendor/datepicker/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="public/libreries/vendor/datatables/dataTables.cellEdit.css">
    <link href="public/libreries/js/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
    <!-- <link rel="stylesheet" href="public/css/style.css"> -->
    <script src="public/libreries/js/fontawesome.all.js" crossorigin="anonymous"></script>
    <style>
        /* Reset básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f9fafb;
            color: #222;
            line-height: 1.6;
            scroll-behavior: smooth;
        }

        /* Menú fijo */
        header {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: rgb(211, 136, 201);
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
            z-index: 999;
        }

        nav {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
        }

        .logo {
            font-weight: 700;
            font-size: 1.5rem;
            color: #fff;
            letter-spacing: 1px;
            user-select: none;
        }

        ul.menu {
            list-style: none;
            display: flex;
            gap: 2rem;
        }

        ul.menu li a {
            color: #e9f1f0;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            padding: 0.3rem 0.5rem;
            transition: background-color 0.3s ease, color 0.3s ease;
            border-radius: 4px;
        }

        ul.menu li a:hover,
        ul.menu li a:focus {
            background-color: #e9f1f0;
            color: #2a9d8f;
            outline: none;
        }

        /* Secciones */
        section {
            padding: 120px 2rem 60px;
            /* padding-top para evitar estar bajo el header fijo */
            max-width: 900px;
            margin: 0 auto;
        }

        /* Sección Nosotros */
        #nosotros h2 {
            color: #264653;
            margin-bottom: 1rem;
            font-size: 2rem;
            text-align: center;
        }

        #nosotros p {
            font-size: 1.1rem;
            color: #444;
            text-align: center;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.5;
        }

        /* Sección Experiencia */
        #experiencia h2 {
            color: #264653;
            margin-bottom: 1rem;
            font-size: 2rem;
            text-align: center;
        }

        #experiencia ul {
            list-style: none;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            padding: 0;
        }

        #experiencia ul li {
            background-color: #e0f2f1;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
            font-size: 1.1rem;
            color: #00695c;
            text-align: center;
            font-weight: 600;
        }

        /* Sección Contacto */
        #Formulario h2 {
            color: #264653;
            margin-bottom: 1rem;
            font-size: 2rem;
            text-align: center;
        }

        #Formulario form {
            max-width: 450px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        #Formulario input,
        #Formulario textarea {
            padding: 0.8rem;
            border: 2px solid #2a9d8f;
            border-radius: 6px;
            font-size: 1rem;
            resize: vertical;
            transition: border-color 0.3s ease;
        }

        #Formulario input:focus,
        #Formulario textarea:focus {
            border-color: #264653;
            outline: none;
        }

        #Formulario button {
            background-color: #2a9d8f;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            padding: 0.8rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #Formulario button:hover,
        #Formulario button:focus {
            background-color: #1e6b66;
            outline: none;
        }

        /* Sección Iniciar Sesión */
        #login {
            padding-top: 150px;
            max-width: 400px;
            margin: 0 auto 60px;
            background-color: #f0f5f4;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgb(0 0 0 / 0.1);
            padding: 2rem;
        }

        #login h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #264653;
            font-size: 2rem;
        }

        #login form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        #login input {
            padding: 0.8rem;
            font-size: 1rem;
            border: 2px solid #2a9d8f;
            border-radius: 6px;
            transition: border-color 0.3s ease;
        }

        #login input:focus {
            border-color: #264653;
            outline: none;
        }

        #login button {
            background-color: #2a9d8f;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            padding: 0.8rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #login button:hover,
        #login button:focus {
            background-color: #1e6b66;
            outline: none;
        }

        /* Responsive: menú hamburguesa para móviles */
        @media (max-width: 720px) {
            nav {
                /* font-size: 1; */
                /* flex-wrap: wrap; */
                gap: 1rem;
            }

            .logo {
                font-size: 1rem;
            }

            ul.menu {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
                gap: 1rem;
            }

            .footer {
                font-size: 0.8em;
            }

            h2 {
                margin-top: 2em;
            }
        }
    </style>

</head>

<body>

    <header>
        <nav>
            <div class="logo" style="overflow: hidden; border-radius: 10px;">
                <img src="public/img/logo.jpeg" alt="FonoPlay Kids" width="70" height="70" style="border-radius: 50%;">
                FONOPLAY KIDS
            </div>
            <ul class="menu">
                <li><a href="https://www.instagram.com/fonoplaykids/" target="_blank"><i class="fab fa-instagram" style="font-size: 2rem; margin-right: 0.5rem;"></i></a></li>
                <li><a href="https://wa.me/56941405766" target="_blank"><i class="fab fa-whatsapp" style="font-size: 2rem;"></i></a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="Formulario">
            <h2>Formulario para Lista de Espera</h2>
            <p style="text-align: justify;">Llenando este formulario te aseguras de guardar un cupo en nuestra lista de espera, en el equipo <strong><i>Fono Play kids</i></strong> nos preocupamos por ti y tu familia, por lo que implementamos los mejores protocolos para asegurar una atención de calidad a nuestros clientes. <strong>Una vez que registres la información te enviaremos un correo con los detalles y pasos a seguir.</strong></p>
            <form>
                <input type="hidden" name="id" id="id" placeholder="ID" value="<?php echo $id; ?>" />
                <input type="text" name="txt_nombre" id="txt_nombre" placeholder="Nombre del niño o niña" required disabled />
                <input type="text" name="txt_edad" id="txt_edad" placeholder="Edad del niño o niña" required maxlength="10" disabled />
                <input type="text" name="txt_rut" id="txt_rut" placeholder="RUT del niño o niña" required disabled />
                <input type="text" name="txt_direccion" style="border-color:red;" id="txt_direccion" placeholder="Dirección completa" required maxlength="150" />
                <input type="text" name="txt_nombre_adulto" style="border-color:red;" id="txt_nombre_adulto" placeholder="Nombre del adulto responsable" required maxlength="150" />
                <select class="form-control" id="cmb_servicio" name="cmb_servicio" placeholder="Servicio"></select>
                <input type="tel" name="txt_fono" id="txt_fono" placeholder="Teléfono de contacto +569" required maxlength="8" />
                <input type="email" name="txt_email" id="txt_email" placeholder="Correo electrónico" required disabled />


                <button type="button" id="btn_enviar">Solicitar Cupo</button>
            </form>
        </section>


    </main>


    <script src="public/libreries/bootstrap-4.6/jquery-3.6.0.min.js"></script>
    <script src="public/libreries/bootstrap-4.6/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="public/libreries/vendor/datepicker/moment.min.js"></script>
    <script type="text/javascript" src="public/libreries/vendor/datepicker/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="public/libreries/vendor/datepicker/bootstrap-datetimepicker.es.js"></script>
    <script type="text/javascript" src="public/libreries/vendor/datatables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="public/libreries/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="public/libreries/js/dataTables.select.min.js"></script>

    <script type="text/javascript" src="public/libreries/vendor/datatables/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="public/libreries/js/fnReloadAjax.js"></script>
    <script type="text/javascript" src="public/libreries/vendor/datatables/dataTables.cellEdit.js"></script>
    <script type="text/javascript" src="public/libreries/vendor/datatables/fnFindCellRowNodes.js"></script>
    <script type="text/javascript" src="public/libreries/js/jquery-validation/dist/jquery.validate.js"></script>
    <script type="text/javascript" src="public/libreries/js/sweetalert2/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="public/libreries/js/Multiple-Select/dist/js/bootstrap-multiselect.min.js"></script>
    <script type="text/javascript" src="public/libreries/js/Multiple-Select/dist/js/bootstrap-multiselect.min.js"></script>
    <script type="text/javascript" src="public/libreries/js/bootstrap-select/js/bootstrap-select.min.js"></script>


    <script type="text/javascript" src="public/js/valida_solicitud.js?v=1"></script>

</body>

<footer class="footer mt-auto py-3">
    <div class="container">
        <div class="row">
            <div class="col-sm-10">
                <span class="text-muted">Copyright &copy; 2025 Fono Play Kids - contacto@fonoplaykids.cl - +569 41405766</span>
            </div>
            <div class="col-sm-2 text-right">
                <a href="https://www.instagram.com/fonoplaykids/" target="_blank" class="text-muted mr-2"><i class="fab fa-instagram"></i> @fonoplaykids</a>
            </div>
        </div>
    </div>
</footer>

</html>