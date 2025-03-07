<?php
/**
 * Created by PhpStorm.
 * User: eduardojunior
 * Date: 16/01/16
 * Time: 20:04
 */
namespace Escola\Entity;

use Core\Entity\Entity;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entidade RedeEnsino
 *
 * @author Eduardo Junior <ej@calangodev.com.br>
 * @category Entidade
 * @subpackage RedeEnsino
 * @version 0.1
 * @copyright (c) 2016 CalangoDev (http://www.calangodev.com.br)
 *
 * @ORM\Entity
 * @ORM\Table(name="escola_rede_ensino")
 */
class RedeEnsino extends Entity
{
    /**
     * @var int $id
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $nome
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $nome;

    /**
     * @var int $instituicao
     *
     * @ORM\ManyToOne(targetEntity="Escola\Entity\Instituicao", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    protected $instituicao;

    /**
     * @var boolean $ativo
     *
     * @ORM\Column(type="boolean")
     */
    protected $ativo = true;

    /**
     * getters and setters
     */
    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $this->valid('nome', $nome);
    }

    public function getInstituicao()
    {
        return $this->instituicao;
    }

    public function setInstituicao(\Escola\Entity\Instituicao $instituicao)
    {
        $this->instituicao = $this->valid('instituicao', $instituicao);
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
     * @var Zend\InputFilter\InputFilter $inputFilter
     */
    protected $inputFilter;

    /**
     * Configura os filtros da entidade
     *
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
                    array('name' => 'Int')
                )
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
                    array('name' => 'Int')
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'instituicao',
                'required' => true,
            )));

            $this->inputFilter = $inputFilter;

        }

        return $this->inputFilter;

    }

}