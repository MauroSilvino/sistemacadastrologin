<?php
require_once 'db_connect.php';

session_start();

if(isset($_POST['btn-rg'])):
    $erros = array();
    $nome = mysqli_escape_string($connect, $_POST['nome']);
    $email = mysqli_escape_string($connect, $_POST['email']);
    $senharg = mysqli_escape_string($connect, $_POST['senharg']);
    $senharg = md5($senharg);

    if(empty($email) or empty($senharg)):
        $erros[] = "O campo email/senha precisa ser preenchido";
    else:
        $sql = "INSERT INTO Usuarios (nome, login, senha) VALUES ('$nome', '$email', '$senharg')";
        $resultado = mysqli_query($connect, $sql);
    endif;
endif;

if(isset($_POST['btn-entrar'])):
    $erros = array();
    $login = mysqli_escape_string($connect, $_POST['login']);
    $senha = mysqli_escape_string($connect, $_POST['senha']);

    if(empty($login) or empty($senha)):
        $erros[] = " O campo login/senha precisa ser preenchido ";
    
    else:
        $sql = "SELECT login FROM Usuarios WHERE login = '$login'";
        $resultado = mysqli_query($connect, $sql);

        if( mysqli_num_rows($resultado) > 0): 

            $senha = md5($senha);
            $sql = "SELECT * FROM Usuarios WHERE login = '$login' AND senha = '$senha'";
            $resultado = mysqli_query($connect, $sql);
            
                if(mysqli_num_rows($resultado) == 1):
                    $dados = mysqli_fetch_array($resultado);
                    mysqli_close($connect);
                    $_SESSION['logado'] = true;
                    $_SESSION['id_usuario'] = $dados['id'];
                    header('Location: home.php');

                else:
                    $erros[] = "<li> Usuário ou senha não conferem </li>";

                endif;
        else:
            $erros[]= "<li> Usuário inexistente </li>";
    
        endif;
    endif;
endif;

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="content first-content">
            <div class="first-column">
                <h2 class="title title-primary">welcome back!</h2>
                <p class="description description-primary">To keep connected with us</p>
                <p class="description description-primary">please login with your personal info</p>
                <button id="signin" class="btn btn-primary">sign in</button>
            </div>    
            <div class="second-column">
                <h2 class="title title-second">create account</h2>
                <div class="social-media">
                    <ul class="list-social-media">
                        <a class="link-social-media" href="#">
                            <li class="item-social-media">
                                <i class="fab fa-facebook-f"></i>        
                            </li>
                        </a>
                        <a class="link-social-media" href="#">
                            <li class="item-social-media">
                                <i class="fab fa-google-plus-g"></i>
                            </li>
                        </a>
                        <a class="link-social-media" href="#">
                            <li class="item-social-media">
                                <i class="fab fa-linkedin-in"></i>
                            </li>
                        </a>
                    </ul>
                </div><!-- social media -->
                <p class="description description-second">or use your email for registration:</p>
                <?php
                if(!empty($erros)):
                    foreach($erros as $erro):
                        echo $erro;
                    endforeach;
                endif;
                ?>
                <form class="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <label class="label-input" for="">
                        <i class="far fa-user icon-modify"></i>
                        <input type="text" name="nome"placeholder="Name">
                    </label>
                    
                    <label class="label-input" for="">
                        <i class="far fa-envelope icon-modify"></i>
                        <input type="email" name="email" placeholder="Email">
                    </label>
                    
                    <label class="label-input" for="">
                        <i class="fas fa-lock icon-modify"></i>
                        <input type="password" name="senharg" placeholder="Password">
                    </label>
                    
                    
                    <button name="btn-rg" class="btn btn-second">sign up</button>        
                </form>
            </div><!-- second column -->
        </div><!-- first content -->
        <div class="content second-content">
            <div class="first-column">
                <h2 class="title title-primary">hello, friend!</h2>
                <p class="description description-primary">Enter your personal details</p>
                <p class="description description-primary">and start journey with us</p>
                <button id="signup" class="btn btn-primary">sign up</button>
            </div>
            <div class="second-column">
                <h2 class="title title-second">sign in to developer</h2>
                <div class="social-media">
                    <ul class="list-social-media">
                        <a class="link-social-media" href="#">
                            <li class="item-social-media">
                                <i class="fab fa-facebook-f"></i>
                            </li>
                        </a>
                        <a class="link-social-media" href="#">
                            <li class="item-social-media">
                                <i class="fab fa-google-plus-g"></i>
                            </li>
                        </a>
                        <a class="link-social-media" href="#">
                            <li class="item-social-media">
                                <i class="fab fa-linkedin-in"></i>
                            </li>
                        </a>
                    </ul>
                </div><!-- social media -->
                <p class="description description-second">or use your email account:</p>

                <?php
                if(!empty($erros)):
                    foreach($erros as $erro):
                        echo $erro;
                    endforeach;
                endif;
                ?>

                <form class="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                
                    <label class="label-input" for="">
                        <i class="far fa-envelope icon-modify"></i>
                        <input name="login" type="text" placeholder="Email">
                    </label>
                
                    <label class="label-input" for="">
                        <i class="fas fa-lock icon-modify"></i>
                        <input name="senha" type="password" placeholder="Password">
                    </label>
                
                    <a class="password" href="#">forgot your password?</a>
                    <button name="btn-entrar" class="btn btn-second">sign in</button>
                </form>
            </div><!-- second column -->
        </div><!-- second-content -->
    </div>
    <script src="js/app.js"></script>
</body>
</html>