<form method="post">
    <input name="nome" placeholder="Seu nome">
    <button>Enviar</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"];
    echo "Olá $nome";
}
