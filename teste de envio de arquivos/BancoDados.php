


<?php

    Class BancoDados{


        private function conexao(){

            try{

                /*Dentro da instância, vamos colocar o código padrão, o nome do servidor, a porta do mysql, 
                o nome do banco de dados, o usuário e a senha. */
                $conexao = new PDO('mysql:host=localhost;port=3306;dbname=testedeenviodearquivos','root','');

                /*Retorno da conexão */
                return $conexao;

            }catch(PDOException $erro){ 

                /*Caso a conexão falhe, o sistema ira informar o usuário com uma mensagem  */
                echo "<script>alert('Não foi possivel se conectar ao banco de dados')</script>";
            }
        }


        /*Metodo que ira cadastrar as informações passadas pelo usuário,
        o metodo recebera 2 parametros, o primeiro será referente aos dados
        passados pelo usuário e o segundo será sobre o arquivo escolhido */
        public function cadastrar(array $dados, array $fotos){

            /*chamada do metodo que se conecta ao banco de dados */
            $conexao = $this->conexao();

            /*Variável que ira percorrer o banco de dados em busca das informações do email
            passado pelo usuário */
            $selecao_sql = $conexao->query("SELECT * FROM pessoas WHERE email='".$dados['email']."'");

            /*Após a seleção. o sistema ira contar a quantidade de linhas encontradas */
            $quantidade_linhas = $selecao_sql->rowCount();

            /*Se ele encontrar algum registro, ele não ira inserir os dados
            e irá informar ao usuário a existencia do registro */
            if($quantidade_linhas > 0){

                echo "<script>alert('Esse usuário já existe no sistema')</script>";

            }else{

                /*Caso não exista nenhum registro ele ira informar que os dados foram
                cadastrados */
                echo "<script>alert('Usuário inserido com sucesso')</script>";

                /*O sistema ira criptografar as senhas usando o password_hash, que
                recebe 2 parametros, a senha passada pelo usuário e o tipo de criptografia
                (no nosso caso será a criptografia padrão) */
                $senha_criptografada = password_hash($dados['senha'], PASSWORD_DEFAULT);

                /*Na parte dos arquivos, vamos primeiro criar uma variável que ira armazenar o caminho
                da pasta que contém as fotos */
                /*Como vamos armazenar o caminho das imagens, vamos passar como parametro no array
                fotos o name, pois, dessa maneira, ele ira armazenar o caminho da pasta */
                $destino_fotos = "fotos/".$fotos['name'];

                /*Após preparar o caminho, temos que mover o arquivo da pasta temporaria do servidor
                para a pasta que ira conter as fotos. Para realizar essa ação, vamos usar o metodo
                move_upload_file que recebe 2 parametros, a pasta origem e a pasta que ira receber
                os dados do arquivo */
                move_uploaded_file($fotos["tmp_name"], $destino_fotos);

                /*Após prepara todos os arquivos, vamos dar o comando sql que ira inserir os dados no banco de dados */
                $comando_sql = $conexao->query("INSERT INTO pessoas(email, senha, arquivo) VALUES('".$dados['email']."', '".$senha_criptografada."', '".$destino_fotos."')");
            }

        }


        /*metodo que será responsável por verificar se os dados existem para retornar as informações do usuário */
        public function login(array $dados){

            /*Variável que ira se conectar ao banco de dados */
           $conexao = $this->conexao();

           /*variável que ira percorrer o banco de dados em busca das informações referentes
           ao email informado */
           $selecao_sql = $conexao->query("SELECT * FROM pessoas WHERE email = '".$dados['email']."'");

           /*Ira contar a quantidade de linhas encontradas */
           $quantidade_linhas = $selecao_sql->rowCount();

           /*Se o sistema encontrar o email informado ele ira verificar se a senha existe no banco
           de dados */
           if($quantidade_linhas > 0){

                /*Antes de verificar vamos transformar a posição das colunas
                em um array associativos (que ira possibilitar encontrarmos as colunas
                através dos nomes criados para elas) */
                $resultado = $selecao_sql->fetch(PDO::FETCH_ASSOC);

                /*Como as senhas são criptografadas, temos que usar o metodo
                password_verify para verificar se a senha informada condiz com a
                senha informada no momento do cadastro. O metodo ira receber como
                parametro a senha informada e o array com nome da coluna que contém as 
                senhas armazenadas */
                if(password_verify($dados['senha'], $resultado['senha'])){

                    /*se todos os dados existirem, o sistema ira informar ao usuário que o
                    registro foi encontrado */
                    echo "<script> alert('Usuário encontrado')</script>"; 

                    /*O sistema ira buscar a foto escolhida pelo usuário */
                    $comando_sql = $conexao->query("SELECT arquivo FROM pessoas WHERE email='".$dados['email']."'");

                    foreach($comando_sql as $dado){

                        /*o sistema ira imprimir a foto na tela */
                        echo "<img src='".$dado['arquivo']."' alt='foto de perfil' class='imagem-perfil'>";
                    }
                }

           }else{

                    /*Caso o usuário não seja encontrado, o sistema informara o usuário e apresentará
                    uma foto padrão */
                    echo "<script>alert('Usuário não encontrado')</script>";

                    echo '<img src="imagens/perfil.png" alt="foto de perfil" class="imagem-perfil">';

                }

        }
    }
?>