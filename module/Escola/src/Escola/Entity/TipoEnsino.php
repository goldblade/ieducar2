<?php
/**
 * Created by PhpStorm.
 * User: eduardojunior
 * Date: 21/12/15
 * Time: 16:16
 */
namespace Escola\Entity;

use Core\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

/**
 * Entidade TipoEnsino
 *
 * @author Eduardo Junior <ej@calangodev.com.br>
 * @category Entidade
 * @subpackage TipoEnsino
 * @version 0.1
 * @example Class TipoEnsino
 * @copyright Copyright (c) 2015 CalangoDev (http://www.calangodev.com.br)
 *
 * @ORM\Entity
 * @ORM\Table(name="escola_tipoensino")
 * @ORM\HasLifecycleCallbacks
 */
class TipoEnsino extends Entity
{
    /**
     * @var Int $id
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var String $nome Nome do tipo de ensino
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $nome;

    /**
     * @var DateTime $dataCadastro Data de cadastro
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $dataCadastro;

    /**
     * @var Boolean $ativo
     *
     * @ORM\Column(type="boolean")
     */
    protected $ativo = true;

    /**
     * Função para gerar o timestamp para o atributo dataCadastro, é executada antes de salvar os dados no banco
     * @access  public
     * @return  void
     * @ORM\PrePersist
     */
    public function timestamp()
    {
        if (is_null($this->getDataCadastro())) $this->setDataCadastro(new \DateTime());
    }

    /**
     * getters and setters
     */

    public function getId()
    {
        return $this->id;
    }


    public function getDataCadastro()
    {
        return $this->dataCadastro;
    }

    public function setDataCadastro($dataCadastro)
    {
        $this->dataCadastro = $this->valid('dataCadastro', $dataCadastro);
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $this->valid('nome', $nome);
    }

    public function getAtivo()
    {
        return $this->ativo;
    }

    public function setAtivo($ativo)
    {
        $this->ativo = $this->valid('ativo', $ativo);
    }


    /**
     * @var Zend\InputFilter\InputFilter $inputFilter;
     */
    protected $inputFilter;

    /**
     * Configura os filtros dos campos da entidade
     * @return Zend\InputFilter\InputFilter
     */
    public function getInputFilter()
    {

        if (!$this->inputFilter){
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name' => 'id',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'nome',
                'required' => true,
                'filters'	=>	array(
                    array('name'	=>	'StripTags'),
                    array('name'	=>	'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 255,
                        ),
                    ),
                ),
            )));


            $inputFilter->add($factory->createInput(array(
                'name' => 'ativo',
                'required' => false,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            )));

            $this->inputFilter = $inputFilter;

        }

        return $this->inputFilter;
    }

}