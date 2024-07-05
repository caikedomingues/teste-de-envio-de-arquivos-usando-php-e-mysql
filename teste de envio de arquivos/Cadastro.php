

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale 1.0">
        <meta http-equiv="X-UA Compatible" content="IE-edge">
        <title>Teste de envio de arquivos</title>
        <link rel="stylesheet" href="cadastro.css">
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
                        <li><a href="index.php">Login</a></li>
                        <li class="cadastro"><a href="#">Cadastrar</a></li>
                    </ul>
            </nav>
            <h1>Teste de envio de arquivos ao banco de dados</h1>
        </header>

        <section>
            <?php 

                /*Variável que irá pegar os dados passados pelo usuário */
                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

                /*Variável uqe ira coletar os dados do arquivo escolhido pelo
                usuário, a variável tera como valor inicial nulo */
                $fotos = $_FILES['fotos']??null;
                
            ?>
            <!--Formulário que ira fazer referência a ele mesmo-->
            <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
                
                <label for="email">Email:</label>
                <input type="text" name="email" required autocomplete="off" class="input-email"><br>

                <label for="senha">Senha:</label>
                <input type="text" name="senha" required autocomplete="off" class="input-email"><br>

                <label for="fotos">Foto de perfil</label>
                <!--input que ira receber o arquivo escolhido pelo usuário-->
                <input type="file" name="fotos" required autocomplete="off" ><br>

                <input type="submit" value="Cadastrar" class="botao-entrar">
            </form>

            <?php
            
                if(!empty($dados['email']) && !empty($dados['senha'])){

                    include 'BancoDados.php';

                    $banco = new BancoDados();

                    $banco->cadastrar($dados, $fotos);
                }
            ?>
        </section>
    </body>
</html>