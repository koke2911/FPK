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
            max-width: 1500px;
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
        /* Sección Nosotros con diseño elegante */
        #nosotros h2 {
            color: #264653;
            margin-bottom: 1rem;
            font-size: 2rem;
            text-align: center;
        }

        .nosotros-card {
            background-color: #f0f5f4;
            padding: 2rem;
            border-left: 6px solid #e9c46a;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            max-width: 800px;
            margin: 2rem auto 0;
        }

        .nosotros-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1);
        }

        .nosotros-card h3 {
            color: #e76f51;
            font-size: 1.5rem;
            text-align: center;
            margin-bottom: 1rem;
        }

        .nosotros-card p {
            color: #444;
            font-size: 1rem;
            line-height: 1.6;
            text-align: justify;
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


        #contacto h2 {
            color: #264653;
            margin-bottom: 1rem;
            font-size: 2rem;
            text-align: center;
        }

        #contacto form {
            max-width: 450px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        #contacto input,
        #contacto textarea {
            padding: 0.8rem;
            border: 2px solid #2a9d8f;
            border-radius: 6px;
            font-size: 1rem;
            resize: vertical;
            transition: border-color 0.3s ease;
        }

        #contacto input:focus,
        #contacto textarea:focus {
            border-color: #264653;
            outline: none;
        }

        #contacto button {
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

        #contacto button:hover,
        #contacto button:focus {
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

        /* #servicios {
            padding: 1rem 60px;
        } */

        /* Sección Servicios con tarjetas */
        #servicios h2 {
            color: #264653;
            margin-bottom: 1rem;
            font-size: 2rem;
            text-align: center;
        }

        .servicios-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .servicio-card {
            background-color: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-top: 5px solid #e76f51;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .servicio-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .servicio-card h3 {
            color: #2a9d8f;
            font-size: 1.3rem;
            margin-bottom: 0.8rem;
            text-align: center;
        }

        .servicio-card p {
            color: #444;
            font-size: 1rem;
            line-height: 1.5;
            text-align: justify;
        }



        /* Sección Misión y Visión con diseño de tarjetas */
        #mision-vision h2 {
            color: #264653;
            margin-bottom: 1rem;
            font-size: 2rem;
            text-align: center;
        }

        .mv-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .mv-card {
            background-color: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            border-left: 6px solid #2a9d8f;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .mv-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1);
        }

        .mv-card h3 {
            color: #e76f51;
            font-size: 1.3rem;
            margin-bottom: 0.8rem;
            text-align: center;
        }

        .mv-card p {
            color: #444;
            font-size: 1rem;
            line-height: 1.5;
            text-align: justify;
        }

        /* Sección Profesional a Cargo con tarjeta */


        #profesional h2 {
            color: #264653;
            margin-bottom: 1rem;
            font-size: 2rem;
            text-align: center;
        }

        .profesional-card {
            background-color: #fff;
            border-left: 6px solid #f4a261;
            border-radius: 12px;
            padding: 1rem;
            margin-top: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .profesional-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1);
        }

        .profesional-card h3 {
            color: #e76f51;
            font-size: 1.4rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .profesional-card p {
            color: #444;
            font-size: 1rem;
            line-height: 1.6;
            text-align: justify;
        }

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


        /* Responsive: menú hamburguesa para móviles */
        @media (max-width: 720px) {
            nav {
                flex-wrap: wrap;
                gap: 1rem;
            }

            ul.menu {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
                gap: 1rem;
            }

            .logo {
                font-size: 1rem;
            }

            .nav h2 {
                margin-top: 3em;
            }
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }

        @media (max-width: 1314px) {
            ul.menu {
                display: none;
                flex-direction: column;
                background-color: rgb(211, 136, 201);
                position: absolute;
                top: 60px;
                /* altura del header */
                right: 0;
                width: 200px;
                border-radius: 0 0 0 8px;
            }

            ul.menu.show {
                display: flex;
            }

            .menu-toggle {
                display: block;
            }
        }

        footer {
            position: relative;
            /* para controlar el z-index */
            z-index: 1;
        }

        .float {
            position: fixed;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
            z-index: 9999;
            /* Mucho más alto que el footer */
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s ease;
        }

        .float img {
            width: 28px;
            height: 28px;
        }

        .whatsapp {
            right: 20px;
            bottom: 80px;
            /* Un poco arriba del footer para que no tape el contenido */
            background-color: #25D366;
        }

        .whatsapp:hover {
            background-color: #1ebe5d;
        }

        .instagram {
            right: 80px;
            bottom: 80px;
            /* Igual arriba del footer */
            background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
        }

        .instagram:hover {
            opacity: 0.85;
        }

        .animated-name span {
            display: inline-block;
            font-size: 1.6rem;
            font-weight: bold;
            animation: wave 2.2s ease-in-out infinite;
        }

        /* Ondulación individual */
        @keyframes wave {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        /* Colores y retrasos */
        .f {
            color: #ff5cb8;
            animation-delay: 0s;
        }

        .o1 {
            color: #7de6f6;
            animation-delay: 0.1s;
        }

        .n {
            color: #fccc4c;
            animation-delay: 0.2s;
        }

        .o2 {
            color: #7de6f6;
            animation-delay: 0.3s;
        }

        .p {
            color: #ff854c;
            animation-delay: 0.4s;
        }

        .l {
            color: #ffda59;
            animation-delay: 0.5s;
        }

        .a {
            color: #fccc4c;
            animation-delay: 0.6s;
        }

        .y {
            color: #7de6f6;
            animation-delay: 0.7s;
        }

        .k {
            color: #7a64ff;
            animation-delay: 0.8s;
        }

        .i {
            color: #ff5cb8;
            animation-delay: 0.9s;
        }

        .d {
            color: #ff854c;
            animation-delay: 1.0s;
        }

        .s {
            color: #fccc4c;
            animation-delay: 1.1s;
        }

        @media (max-width: 414px) {
            .animated-name {
                display: none;
            }
        }
    </style>

</head>


<body>



    <header>
        <nav>
            <!-- <div class="logo" style="overflow: hidden; border-radius: 10px;">
                <img src="public/img/logo.jpeg" alt="FonoPlay Kids" width="70" height="70" style="border-radius: 50%;">
                FONOPLAY KIDS
            </div> -->
            <div class="logo" style="display: flex; align-items: center; gap: 10px;">
                <img src="public/img/logo.jpeg" alt="FonoPlay Kids" width="70" height="70" style="border-radius: 50%;">
                <div class="animated-name">
                    <span class="f">F</span><span class="o1">o</span><span class="n">n</span><span class="o2">o</span>
                    <span class="p">p</span><span class="l">l</span><span class="a">a</span><span class="y">y</span>
                    <span class="k">K</span><span class="i">i</span><span class="d">d</span><span class="s">s</span>
                </div>
            </div>

            <div class="glow"></div>
            <button class="menu-toggle" aria-label="Abrir menú">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="menu">
                <li><a href="#nosotros">Nosotros</a></li>
                <li><a href="#profesional">Profesional</a></li>
                <li><a href="#servicios">Servicios</a></li>
                <li><a href="#experiencia">Experiencia</a></li>
                <li><a href="#galeria">Galería</a></li>
                <li><a href="#contacto">Contacto</a></li>
                <li><a href="views/portal.php">Iniciar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="nosotros">
            <h2>¿Quiénes Somos?</h2>
            <div class="nosotros-card">
                <h3>🧸 Fonoplay Kids</h3>
                <p>
                    Somos un equipo profesional dedicado a la estimulación temprana y el desarrollo del lenguaje infantil.
                    Creemos en una intervención respetuosa, lúdica y basada en evidencia, trabajando de la mano con las familias para potenciar las habilidades de los niños y niñas desde sus primeros días.
                </p>
                <p>
                    Nuestro compromiso es entregar estimulación temprana de calidad directamente en el hogar, con profesionalismo, cercanía y calidez.
                    Soñamos con ser la red de estimulación más confiable y querida de Chile.
                </p>
            </div>
        </section>


        <section id="mision-vision">
            <h2>Misión y Visión</h2>
            <div class="mv-grid">
                <div class="mv-card">
                    <h3>🎯 Misión</h3>
                    <p>Acompañar a cada familia con profesionalismo, cercanía y calidez, respetando los tiempos y necesidades de cada niño o niña.</p>
                </div>
                <div class="mv-card">
                    <h3>🌟 Visión</h3>
                    <p>Ser la red de estimulación temprana a domicilio más confiable y querida de Chile, destacando por nuestro compromiso con la infancia y adaptación a cada familia.</p>
                </div>
            </div>
        </section>


        <section id="servicios">
            <h2>Servicios</h2>
            <div class="servicios-grid">
                <div class="servicio-card">
                    <h3>👶 Babysitting Profesional</h3>
                    <p>Cuidado especializado desde recién nacidos hasta edad escolar, realizado por profesionales del área de la salud y educación.</p>
                </div>
                <div class="servicio-card">
                    <h3>🎯 Talleres Personalizados</h3>
                    <p>Sesiones de estimulación temprana adaptadas al desarrollo del niño/a, con seguimiento e informes.</p>
                </div>
                <div class="servicio-card">
                    <h3>🏡 Playgroup en Casa</h3>
                    <p>Espacio educativo tipo jardín infantil llevado directamente al hogar, ideal para trabajar lenguaje y socialización.</p>
                </div>
                <div class="servicio-card">
                    <h3>🧠 Terapias Profesionales</h3>
                    <p>Intervenciones a domicilio en fonoaudiología, terapia ocupacional y kinesiología con planes personalizados.</p>
                </div>
                <div class="servicio-card">
                    <h3>👨‍👩‍👧 Coaching para Padres</h3>
                    <p>Sesiones enfocadas en entregar herramientas prácticas a madres, padres y cuidadores para el desarrollo del lenguaje en casa.</p>
                </div>
            </div>
        </section>

        <section id="profesional">
            <h2>Profesional a Cargo</h2>
            <div class="profesional-card">
                <h3>👩‍⚕️ Javiera Paola Aliaga Aliaga</h3>
                <p><strong>Fonoaudióloga titulada en la Universidad Mayor</strong>, con más de 10 años de experiencia en el cuidado infantil y 4 años de ejercicio profesional.</p>
                <p>Actualmente cursa un <strong>Diplomado en Atención Temprana</strong> en la Universidad de Chile y posee formación complementaria en educación preescolar y desarrollo infantil.</p>
            </div>
        </section>


        <section id="experiencia">
            <h2>Experiencia</h2>
            <ul>
                <li>Más de 5 años atendiendo niños con trastornos del lenguaje</li>
                <li>Atención personalizada y adaptada a cada paciente</li>
                <li>Equipo multidisciplinario y profesionales certificados</li>
                <li>Seguimiento continuo y evaluación periódica</li>
            </ul>
        </section>

        <section id="galeria">
            <h2 style="text-align: center;">Galería</h2>
            <div class="galeria-contenido">
                <!-- Aquí se cargará dinámicamente la galería con PHP -->
                <?php
                $baseDir = 'public/galery';
                $categorias = [
                    'Babysitting',
                    'Capacitaciones_',
                    'Javiera_Aliaga',
                    'Playgroup',
                    'Talleres_personalizados',
                    'Terapias'
                ];

                function mostrarImagenes($ruta, $categoria)
                {
                    $imagenes = glob($ruta . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE);
                    if (count($imagenes) === 0) return;

                    echo "<h3 style='margin-top:2em;color:#2a9d8f;text-align:center;'>$categoria</h3>";
                    echo "<div class='galeria-grid'>";
                    foreach ($imagenes as $img) {
                        echo "<div class='galeria-item'>
                        <a href='$img' data-lightbox='$categoria' data-title='$categoria'>
                            <img src='$img' alt='$categoria'>
                        </a>
                      </div>";
                    }
                    echo "</div>";
                }

                foreach ($categorias as $categoria) {
                    $ruta = $baseDir . '/' . $categoria;
                    mostrarImagenes($ruta, str_replace('_', ' ', $categoria));
                }
                ?>
            </div>
        </section>




        <section id="contacto">
            <h2>Contacto</h2>
            <form>
                <input type="text" name="txt_nombre" id="txt_nombre" placeholder="Nombre y apellido del niñ@" required />
                <input type="text" name="txt_rut" id="txt_rut" placeholder="Rut 11111111-1 del niñ@" required maxlength="10"/>
                <input type="text" name="dt_nacimiento" id="dt_nacimiento" placeholder="Nacimiento del niñ@  dd-mm-yyyy" required maxlength="10" />
                <input type="email" name="txt_email" id="txt_email" placeholder="Correo electrónico" required />
                <input type="tel" name="txt_fono" id="txt_fono" placeholder="+569 " required maxlength="8" style="width: 100%;" />
                <select class="form-control" id="cmb_region" name="cmb_region" placeholder="Región"></select>
                <select class="form-control" id="cmb_comuna" name="cmb_comuna" placeholder="comuna"></select>
                <input type="text" name="txt_sector" id="txt_sector" placeholder="Sector" required maxlength="200" />
                <button type="button" id="btn_enviar">Enviar</button>
            </form>
        </section>
    </main>

    <footer class="footer mt-auto py-3">
        <div class="container">
            <div class="row">
                <div class="col-sm-10">
                    <span class="text-muted">Copyright &copy; 2025 Fono Play Kids&nbsp;&nbsp;contacto@fonoplaykids.cl&nbsp;&nbsp;
                        <a href="https://wa.me/56941405766" target="_blank" class="text-muted" style="padding: 1em;"><i class="fab fa-whatsapp"></i> WhatsApp</a></span>
                    <a href="https://www.instagram.com/fonoplaykids/" target="_blank" class="text-muted mr-2" style="padding: 1em;"><i class="fab fa-instagram"></i> @fonoplaykids</a>
                </div>
                <div class="col-sm-2 text-right">

                </div>
            </div>
        </div>
    </footer>

    <a href="https://wa.me/56941405766" target="_blank" class="float whatsapp" aria-label="WhatsApp">
        <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp" />
    </a>

    <!-- Botón Instagram -->
    <a href="https://instagram.com/fonoplaykids" target="_blank" class="float instagram" aria-label="Instagram">
        <img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" alt="Instagram" />
    </a>


    <script>
        const btnMenu = document.querySelector('.menu-toggle');
        const menu = document.querySelector('ul.menu');
        const menuLinks = document.querySelectorAll('ul.menu li a');

        btnMenu.addEventListener('click', () => {
            menu.classList.toggle('show');
        });

        menuLinks.forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.remove('show');
            });
        });
    </script>


    <script src="public/libreries/bootstrap-4.6/jquery-3.6.0.min.js"></script>
    <script src="public/libreries/bootstrap-4.6/bootstrap.bundle.min.js"></script>
    <!-- <script type="text/javascript" src="public/libreries/vendor/datepicker/moment.min.js"></script>
    <script type="text/javascript" src="public/libreries/vendor/datepicker/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="public/libreries/vendor/datepicker/bootstrap-datetimepicker.es.js"></script> -->
    <!-- <script type="text/javascript" src="public/libreries/vendor/datatables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="public/libreries/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="public/libreries/js/dataTables.select.min.js"></script> -->

    <!-- <script type="text/javascript" src="public/libreries/vendor/datatables/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="public/libreries/js/fnReloadAjax.js"></script>
    <script type="text/javascript" src="public/libreries/vendor/datatables/dataTables.cellEdit.js"></script>
    <script type="text/javascript" src="public/libreries/vendor/datatables/fnFindCellRowNodes.js"></script> -->
    <script type="text/javascript" src="public/libreries/js/jquery-validation/dist/jquery.validate.js"></script>
    <script type="text/javascript" src="public/libreries/js/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- <script type="text/javascript" src="public/libreries/js/Multiple-Select/dist/js/bootstrap-multiselect.min.js"></script>
    <script type="text/javascript" src="public/libreries/js/Multiple-Select/dist/js/bootstrap-multiselect.min.js"></script> -->
    <script type="text/javascript" src="public/libreries/js/bootstrap-select/js/bootstrap-select.min.js"></script>


    <script type="text/javascript" src="public/js/index.js?v=1"></script>

</body>

</html>