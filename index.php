<?php
require_once 'classe.php';
$c = new Cliente("tabela_crud", "localhost", "root", "");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Clientes</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    if (isset($_POST['nome'])) {
        //edit
        if (isset($_GET['id_up']) && !empty($_GET['id_up'])) {
            $id_upd = addslashes($_GET['id_up']);
            $nome = addslashes($_POST['nome']);
            $sobrenome = addslashes($_POST['sobrenome']);
            $email = addslashes($_POST['email']);
            $telefone = addslashes($_POST['telefone']);
            if (!empty($nome) && !empty($sobrenome) && !empty($email) && !empty($telefone)) {
                $c->atualizarDados($id_upd, $nome, $sobrenome, $email, $telefone);
                header("location: index.php");
            } 
        }

        //cadastro
        else {
            $nome = addslashes($_POST['nome']);
            $sobrenome = addslashes($_POST['sobrenome']);
            $email = addslashes($_POST['email']);
            $telefone = addslashes($_POST['telefone']);
            if (!empty($nome) && !empty($sobrenome) && !empty($email) && !empty($telefone)) {
                if (!$c->cadastrarcliente($nome, $sobrenome, $email, $telefone)) {
                ?>
                    
                    <div class="aviso">
                        <h4>
                            Email já está cadastrdo!
                        </h4>
                    </div>
                <?php
                }
            }
        }
    }
    ?>
    <?php
    if (isset($_GET['id_up'])) {
        $id_update = addslashes($_GET['id_up']);
        $res = $c->buscarDadosCliente($id_update);
    }
    ?>
    <section>
        <form method="POST">
            <h2>CADASTRAR CLIENTES</h>
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" required value="<?php if (isset($res)) {
                                                                    echo $res['nome'];
                                                                } ?>">
                <label for="sobrenome">Sobrenome</label>
                <input type="text" name="sobrenome" id="sobrenome" required value="<?php if (isset($res)) {
                                                                                echo $res['sobrenome'];
                                                                            } ?>">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required value="<?php if (isset($res)) {
                                                                        echo $res['email'];
                                                                    } ?>">
                <label for="telefone">Telefone</label>
                <input type="text" name="telefone" id="telefone" required value="<?php if (isset($res)) {
                                                                            echo $res['numero'];
                                                                        } ?>">
                <input type="submit" value="<?php if (isset($res)) {
                                                echo "Atualizar Dados";
                                            } else {
                                                echo "Cadastrar";
                                            } ?>">

        </form>
    </section>

    <section>
        <table>
            <tr>
                <td>NOME</td>
                <td>SOBRENOME</td>
                <td>EMAIL</td>
                <td colspan="3">TELEFONE</td>
            </tr>

            <?php
            $dados = $c->buscarDados();
            if (count($dados) > 0) {
                for ($i = 0; $i < count($dados); $i++) {
                    echo "<tr>";
                    foreach ($dados[$i] as $k => $v) {
                        if ($k != "id") {
                            echo "<td>" . $v . "</td>";
                        }
                    }

            ?>
                    <td>
                        <a href="index.php?id_up=<?php echo $dados[$i]['id']; ?>" class="botao">Editar</a>
                        
                    </td>

                    <td>
                        
                        <a href="index.php?id=<?php echo $dados[$i]['id']; ?>" class="botao">Excluir</a>
                    </td>
                <?php
                    echo "</tr>";
                }
            } else {
                ?>
        </table>
        <div class="aviso">
            <h4>
                Ainda não há clientes cadastrados!
            </h4>
        </div>
    <?php
            }
    ?>
    </section>
</body>

</html>

<?php
if (isset($_GET['id'])) {
    $id_cliente = addslashes($_GET['id']);
    $c->excluirCliente($id_cliente);
    header("location: index.php");
}
?>