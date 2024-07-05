
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale 1.0">
        <meta http-equiv="X-UA Compatible" content="IE-edge">
        <title>Teste de envio de arquivos</title>
        <link rel="stylesheet" href="login.css">
        <link rel="shotcuts icon" href="imagens/logo.jpg">
    </head>

    <body>
        <header>
             <nav class="menu">
                    <input type="checkbox" class="menu-faketrigger">
                    <div class="menu-lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <ul>
                        <li class="login"><a href="#">Login</a></li>
                        <li><a href="Cadastro.php">Cadastrar</a></li>
                    </ul>
            </nav>
            <h1>Teste de envio de arquivos ao banco de dados</h1>
        </header>

        <section>
            <?php
                /*Variável que ira pegar os dados passados pelo usuário,
                através de um filtro do tipo array */
                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            ?>

         <?php
                /*Antes de instanciar o banco de dados e chamar o metodo de 
                login, vamos verificar se todos os campos do formulário 
                foram preenchidos */
                if(!empty($dados['email']) && !empty($dados['senha'])){

                    include 'BancoDados.php';

                    $banco = new BancoDados();

                    $banco->login($dados);
                }
            ?>
            <!--Formulário que tem como referencia ele mesmo-->
            <form action="<?php $_SERVER['PHP_SELF']?>" method="post">

                <label for="email">Email:</label>
                <input type="text" name="email" required class="input-email" autocomplete="off"><br>

                <label for="senha">Senha:</label>
                <input type="password" name="senha" required class="input-email" autocomplete="off"><br>

                <input type="submit" value="Entrar" class="botao-entrar">
            </form>
        </section>
    </body>
</html>