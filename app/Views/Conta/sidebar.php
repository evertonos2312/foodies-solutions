<link href="{$app_url}src/assets/css/conta.css" type="text/css" rel="stylesheet" />
<div id="mySidebar" class="sidebar">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="{$app_url}conta">Meus pedidos</a>
    <a href="{$app_url}conta/show">Meus dados</a>
    <a href="{$app_url}conta/editarsenha">Alterar senha</a>
    <a href="{$app_url}login/logout">Sair</a>

</div>

<div id="main">
    <button class="openbtn" onclick="openNav()">&#9776; Menu</button>
</div>


<script>
    /* Set the width of the sidebar to 250px and the left margin of the page content to 250px */
    function openNav() {
        document.getElementById("mySidebar").style.width = "250px";
        document.getElementById("main").style.marginLeft = "250px";
    }

    /* Set the width of the sidebar to 0 and the left margin of the page content to 0 */
    function closeNav() {
        document.getElementById("mySidebar").style.width = "0";
        document.getElementById("main").style.marginLeft = "0";
    }
</script>
