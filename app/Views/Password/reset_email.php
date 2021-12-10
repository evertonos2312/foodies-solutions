<head>
    <meta charset="UTF-8">
    <title>Pizza Planet</title>
    <meta name="Robots" Content="noindex, nofollow">
    <style type="text/css">
        p {
            padding: 0;
            margin: 0px 0px 2em;
            font-size: 15pt;
            color: #222;
            line-height: 30px;
            font-weight: 400;
            font-family: 'Roboto', Arial, sans-serif;
        }

        a {
            color: #156AE7;
            text-decoration: none;
            font-weight: 500;
        }

        a:hover {
            color: #000;
        }

        .bg-white {
            font-weight: normal;
            font-family: 'Montserrat-Bold';
            color: #FFFFFF;
            align-self: center;
        }

        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: local('Roboto'), local('Roboto-Regular'), url(https://fonts.gstatic.com/s/roboto/v20/KFOmCnqEu92Fr1Mu4mxK.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: local('Roboto Light'), local('Roboto-Light'), url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmSU5fBBc4.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
    </style>
</head>

<body bgcolor="#f6f6f6" leftmargin="0" topmargin="0" marginwidth="0">
<table id="Table_01" width="100%" align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#f4f4f4">
    <tr>
        <td>
            <!-- Header -->
            <table width="600" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <span>&nbsp;</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>&nbsp;</span>
                    </td>
                </tr>
            </table>
            <table width="600" align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: #990100
                ;">
                <tr>
                    <td width="50"></td>
                    <td>
                        <br>
                        <img src="<?php echo base_url()?>/src/assets/img/logo.png" alt="logo" /> <span class="bg-white">Pizza Planet</span>
                        <br>
                    </td>
                    <td width="50"></td>
                </tr>
            </table>
            <!-- Body -->
            <table width="600" align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
                <tr>
                    <td colspan="7"><span>&nbsp;</span></td>
                </tr>
                <tr>
                    <td colspan="7"><span>&nbsp;</span></td>
                </tr>
                <tr>
                    <td colspan="7"><span>&nbsp;</span></td>
                </tr>
                <tr>
                    <td colspan="7"><span>&nbsp;</span></td>
                </tr>
                <tr>
                    <td colspan="7"><span>&nbsp;</span></td>
                </tr>
                <tr>
                    <td width="50"></td>
                    <td>
                        <p style="color: #990100;">Olá, <?php echo strtok($pedido['usuario']['nome']," ")?>!</p>
                        <p><a href="<?php echo site_url('password/reset/'.$token); ?>" target="_blank">Clique aqui</a> para redefinir sua senha.</p>



                        <br><br>
                        <p><a href="<?php echo site_url()?>" target="_blank"><strong>pizza-planet.fun</strong></a><p>
                        <br><br>
                        <p style="font-weight: bold">Qualquer eventual problema, por gentileza entre em contato com a nossa equipe.</p>

                    </td>
                    <td width="50"></td>
                </tr>
                <tr>
                    <td colspan="7"><span>&nbsp;</span></td>
                </tr>
                <tr>
                    <td colspan="7"><span>&nbsp;</span></td>
                </tr>
                <tr>
                    <td colspan="7"><span>&nbsp;</span></td>
                </tr>
                <tr>
                    <td colspan="7"><span>&nbsp;</span></td>
                </tr>
            </table>
            <!-- Footer -->

            <table width="600" align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#000">
                <tr>
                    <td width="210"></td>
                    <td>
                        <br>
                        <img style="display: block; margin: 10px;"
                             src="<?php echo base_url()?>/assets/admin/images/pizza-planet.png"
                             style="display:block; width: 100px;" border="0" alt="Facebook" width="150">
                        <br> <br>
                    </td>
                    <td width="200"></td>
                </tr>
            </table>
            <table width="350" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td><span>&nbsp;</span></td>
                </tr>
                <tr>
                    <td><span>&nbsp;</span></td>
                </tr>
                <tr>
                    <td><span>&nbsp;</span></td>
                </tr>
                <tr>
                    <td><span>&nbsp;</span></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

</html>