<?php
class Cliente
{
    private $pdo;
    public function __construct($dbname, $host, $user, $senha)
    {
        try {
            $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host, $user, $senha);
        } catch (PDOException $e) {
            echo "Erro com o banco de dados: " . $e->getMessage();
            exit();
        } 
        catch (Exception $e) {
            echo "Erro generico: " . $e->getMessage();
            exit();
        }
    }


    public function buscarDados() {
        $res = array();
        $cmd = $this->pdo->query("SELECT * FROM clientes ORDER BY nome");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function cadastrarCliente($nome, $sobrenome, $email, $telefone) {
        $cmd = $this->pdo->prepare("SELECT id FROM clientes WHERE email = :e");
        $cmd->bindValue(":e", $email);
        $cmd->execute();
        if($cmd->rowCount() > 0 ) {
            return false;
        }else {
            $cmd = $this->pdo->prepare("INSERT INTO clientes (nome, sobrenome, email, numero) VALUES (:n, :snome, :e, :t)");
            $cmd->bindValue(":n", $nome);
            $cmd->bindValue("snome", $sobrenome);
            $cmd->bindValue(":e", $email);
            $cmd->bindValue(":t", $telefone);
            $cmd->execute();
            return true;
        }
    } 

    public function excluirCliente($id) {
        $cmd = $this->pdo->prepare("DELETE FROM clientes WHERE id = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }

    public function buscarDadosCliente($id) {
        $res = array();
        $cmd = $this->pdo->prepare("SELECT * FROM clientes WHERE id = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    public function atualizarDados($id, $nome, $sobrenome, $email, $telefone) {
        $cmd = $this->pdo->prepare("UPDATE clientes SET nome = :n, sobrenome = :snome, email = :e, numero = :t WHERE id = :id");
        $cmd->bindValue(":n", $nome);
        $cmd->bindValue(":snome", $sobrenome);
        $cmd->bindValue(":e", $email);
        $cmd->bindValue(":t", $telefone);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        
    }
}
?>