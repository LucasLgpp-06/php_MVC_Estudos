<?php

/**
 * A camada model é responsável por transportar os dados da Controller até a DAO e vice-versa.
 * Também é atribuído a Model a validação dos dados da View e controle de acesso aos métodos
 * da DAO.
 */
class PessoaModel
{

    /**
     * Declaração das propriedades conforme campos da tabela no banco de dados.
     */
    public $id, $nome, $cpf, $data_nascimento;

    /**
     * Propriedade que armazenará o array retornado da DAO com a listagem das pessoas.
     */
    public $rows;

    /**
     * Declaração do método save que chamará a DAO para gravar no banco de dados
     * o model preenchido.
     */
    public function save()
    {
        include 'DAO/PessoaDAO.php';

        // Instância do objeto e conexão no banco de dados via construtor
        $dao = new PessoaDAO();

        // Verificando se a propriedade id foi preenchida no model
        if(empty($this->id))
        {
            // Chamando o método insert que recebe o próprio objeto model
            // já preenchido
            $dao->insert($this);
        } else
        {

            $dao->update($this); // Como existe um id, passando o model para ser atualizado.
        }
    
    }

    /**
     * Método que encapsula a chamada a DAO e que abastecerá a propriedade rows;
     * Esse método é importante pois como a model é "vista" na View a propriedade
     * $rows será acessada e possibilitará listar os registros vindos do banco de dados
     */
    public function getAllRows()
    {
        include 'DAO/PessoaDAO.php';

        // Instância do objeto e conexão no banco de dados via construtor
        $dao = new PessoaDAO();

        // Abastecimento da propriedade $rows com as "linhas" vindas do MySQL
        // via camada DAO.
        $this->rows = $dao->select();

    }

    /**
     * Método que encapsula o acesso ao método selectById da camada DAO
     * O método recebe um parâmetro do tipo inteiro que é o id do registro
     * a ser recuperado do MySQL, via camada DAO.
     */
    public function getById(int $id)
    {
        include 'DAO/PessoaDAO.php';

        $dao = new PessoaDAO();

        $obj = $dao->selectById($id);// Obtendo um model preenchido da camada DAO

        return ($obj) ? $obj : new PessoaModel();
        //codigo acima foi usado com operador ternario
        // e é uma alternativa ao código de baixo

        /*
        if($obj)
        {
            return $obj;
        } else {
            return new PessoaModel();
        }
        */

    }

    /**
     * Método que encapsula o acesso a DAO do método delete.
     * O método recebe um parâmetro do tipo inteiro que é o id do registro
     * que será excluido da tabela no MySQL, via camada DAO.
     */
    public function delete(int $id)
    {
        include 'DAO/PessoaDAO.php';

        $dao = new PessoaDAO();

        $dao->delete($id);

    }

}