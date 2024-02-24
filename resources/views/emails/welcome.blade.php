<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
    <!--[if mso]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <style>
        td, th, div, p, a, h1, h2, h3, h4, h5, h6 {
            font-family: "Segoe UI", sans-serif;
            mso-line-height-rule: exactly;
        }
    </style>
    <![endif]-->
    <title>Default email title</title>
    <link
        href="https://fonts.googleapis.com/css?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700"
        rel="stylesheet" media="screen">
    <style>
        td * {
            text-align: center;
            color: #606060 !important;
        }

        .hover-underline:hover {
            text-decoration: underline !important;
        }

        .title {
            color: #01097a !important;
            font-weight: bolder;
            font-size: 25px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes ping {

            75%,
            100% {
                transform: scale(2);
                opacity: 0;
            }
        }

        @keyframes pulse {
            50% {
                opacity: .5;
            }
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(-25%);
                animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
            }

            50% {
                transform: none;
                animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
            }
        }

        @media (max-width: 600px) {
            .sm-leading-32 {
                line-height: 32px !important;
            }

            .sm-px-24 {
                padding-left: 24px !important;
                padding-right: 24px !important;
            }

            .sm-py-32 {
                padding-top: 32px !important;
                padding-bottom: 32px !important;
            }

            .sm-w-full {
                width: 100% !important;
            }
        }
    </style>
</head>

<body
    style="margin: 0; padding: 0; width: 100%; word-break: break-word; -webkit-font-smoothing: antialiased; --bg-opacity: 1; background-color: #eceff1; background-color: rgba(236, 239, 241, var(--bg-opacity));">
<div style="display: none;">Default email preheader</div>
<div role="article" aria-roledescription="email" aria-label="Default email title" lang="en">
    <table style="font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif; width: 100%;" width="100%"
           cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center"
                style="--bg-opacity: 1; background-color: #eceff1; background-color: rgba(236, 239, 241, var(--bg-opacity)); font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif;"
                bgcolor="rgba(236, 239, 241, var(--bg-opacity))">
                <table class="sm-w-full" style="font-family: 'Montserrat',Arial,sans-serif; width: 600px;" width="600"
                       cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td class="sm-py-32 sm-px-24"
                            style="font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif; padding: 48px; text-align: center;background:#01097a;"
                            align="center">
                            <h1 style="color:white;">Bienvenido a</h1>
                            <img src="{{url('logo.png')}}" width="155" alt="Tripnow"
                                 style="border: 0; max-width: 100%; line-height: 100%; vertical-align: middle;">
                        </td>
                    </tr>
                    <tr>
                        <td align="center" class="sm-px-24" style="font-family: 'Montserrat',Arial,sans-serif;">
                            <table style="font-family: 'Montserrat',Arial,sans-serif; width: 100%;" width="100%"
                                   cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td class="sm-px-24"
                                        style="--bg-opacity: 1; background-color: #ffffff; background-color: rgba(255, 255, 255, var(--bg-opacity)); border-radius: 4px; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif; font-size: 14px; line-height: 24px; padding: 48px; text-align: left; --text-opacity: 1; color: #626262; color: rgba(98, 98, 98, var(--text-opacity));"
                                        bgcolor="rgba(255, 255, 255, var(--bg-opacity))" align="left">
                                        <p class="sm-leading-32"
                                           style="font-weight:500; font-size: 20px; margin: 0 0 24px; --text-opacity: 1; color: #263238; color: rgba(38, 50, 56, var(--text-opacity));">
                                            Te damos la bienvenida a la familia Tripnow.mx
                                        </p>

                                        <p class="sm-leading-32 title">
                                            Comencemos esta gran aventura
                                        </p>
                                        {{--<a href="https://1.envato.market/vuexy_admin">
                                            <img src="images/item.jpg" width="500" alt="Vuexy Admin" style="border: 0; max-width: 100%; line-height: 100%; vertical-align: middle;">
                                        </a>--}}

                                        <table>
                                            <tr>
                                                <td style="vertical-align: top;">
                                                    <img src="{{asset('mails/icons/icon-1.png')}}"
                                                         style="width: 60px;margin-right: 10px;">
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <p class="sm-leading-32 title"
                                                       style="text-align: left;margin-bottom: 0; margin-top:0;">
                                                        Te Asesoramos
                                                    </p>
                                                    <p style="text-align: justify;">
                                                        Más de 9 años y miles de viajeros felices nos respaldan.
                                                        Somos expertos en convertir sueños en vacaciones
                                                        increíbles
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: top;">
                                                    <img src="{{asset('mails/icons/icon-2.png')}}"
                                                         style="width: 60px;margin-right: 10px;">
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <p class="sm-leading-32 title"
                                                       style="text-align: left;margin-bottom: 0; margin-top:0;">
                                                        Reserva y Ahorra
                                                    </p>
                                                    <p style="text-align: justify;">
                                                        Encuentras descuentos y ofertas diarias exclusivas
                                                        para el servicio o destino que requieras. Visita nuestro
                                                        sitio web oficial y descúbrelas.
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: top;">
                                                    <img src="{{asset('mails/icons/icon-3.png')}}"
                                                         style="width: 60px;margin-right: 10px;">
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <p class="sm-leading-32 title"
                                                       style="text-align: left;margin-bottom: 0; margin-top:0;">
                                                        A Donde Quieras
                                                    </p>
                                                    <p style="text-align: justify;">
                                                        Reserva tu alojamiento, vuelos, paquetes, tours,
                                                        circuitos, cruceros y más, a los mejores destinos
                                                        nacionales e internacionales.
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>

                                        <p class="sm-leading-32 title">
                                            ¡Vive, Viaja, Visita, Ahora es Cuando!
                                        </p>

                                        <p style="font-size: 18px;font-weight: bold;">
                                            Estamos para atenderte con cualquier duda
                                        </p>

                                        <table>
                                            <tr>
                                                <td style="vertical-align: top;">
                                                    <img src="{{asset('mails/icons/icon-4.png')}}"
                                                         style="width: 60px;margin-right: 10px;">
                                                </td>
                                                <td>
                                                    <p style="margin:0;text-align: left">México: 800 953 0983</p>
                                                    <p style="margin:0;text-align: left">Internacional: +52 998 690 0437</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>


                                        <p style="margin: 24px 0;">

                                            ¡Saludos desde la central de reservaciones tripnow.mx!
                                            <br>
                                            Hemos guardado tu información correctamente para procesar tu reserva.
                                            <br>
                                            El equipo de reservaciones de Tripnow.mx
                                            <br>
                                            servicioalcliente@tripnow.mx
                                            <br>
                                            Teléfono 800 953 09 83
                                            <br>
                                            WhatsApp Web Departamento de Reservaciones 998 830 61 91
                                            <br>
                                            Cotizaciones 998 241 05 98
                                        </p>
                                        <table style="font-family: 'Montserrat',Arial,sans-serif; width: 100%;"
                                               width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                            <tr>
                                                <td style="font-family: 'Montserrat',Arial,sans-serif; padding-top: 32px; padding-bottom: 32px;">
                                                    <div
                                                        style="--bg-opacity: 1; background-color: #eceff1; background-color: rgba(236, 239, 241, var(--bg-opacity)); height: 1px; line-height: 1px;">
                                                        &zwnj;
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="font-family: 'Montserrat',Arial,sans-serif; height: 20px;"
                                        height="20"></td>
                                </tr>
                                {{--<tr>
                                    <td style="font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif; font-size: 12px; padding-left: 48px; padding-right: 48px; --text-opacity: 1; color: #eceff1; color: rgba(236, 239, 241, var(--text-opacity));">
                                        <p align="center" style="cursor: default; margin-bottom: 16px;">
                                            <a href="https://www.facebook.com/pixinvents" style="--text-opacity: 1; color: #263238; color: rgba(38, 50, 56, var(--text-opacity)); text-decoration: none;"><img src="images/facebook.png" width="17" alt="Facebook" style="border: 0; max-width: 100%; line-height: 100%; vertical-align: middle; margin-right: 12px;"></a>
                                            &bull;
                                            <a href="https://twitter.com/pixinvents" style="--text-opacity: 1; color: #263238; color: rgba(38, 50, 56, var(--text-opacity)); text-decoration: none;"><img src="images/twitter.png" width="17" alt="Twitter" style="border: 0; max-width: 100%; line-height: 100%; vertical-align: middle; margin-right: 12px;"></a>
                                            &bull;
                                            <a href="https://www.instagram.com/pixinvents" style="--text-opacity: 1; color: #263238; color: rgba(38, 50, 56, var(--text-opacity)); text-decoration: none;"><img src="images/instagram.png" width="17" alt="Instagram" style="border: 0; max-width: 100%; line-height: 100%; vertical-align: middle; margin-right: 12px;"></a>
                                        </p>
                                        <p style="--text-opacity: 1; color: #263238; color: rgba(38, 50, 56, var(--text-opacity));">
                                            Use of our service and website is subject to our
                                            <a href="https://pixinvent.com/" class="hover-underline" style="--text-opacity: 1; color: #7367f0; color: rgba(115, 103, 240, var(--text-opacity)); text-decoration: none;">Terms of Use</a> and
                                            <a href="https://pixinvent.com/" class="hover-underline" style="--text-opacity: 1; color: #7367f0; color: rgba(115, 103, 240, var(--text-opacity)); text-decoration: none;">Privacy Policy</a>.
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-family: 'Montserrat',Arial,sans-serif; height: 16px;" height="16"></td>
                                </tr>--}}
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>

</html>
